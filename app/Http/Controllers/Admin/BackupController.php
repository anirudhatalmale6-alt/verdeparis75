<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AdminLog;
use App\Models\Backup;
use Illuminate\Support\Facades\Process;
use Illuminate\Support\Facades\Storage;

class BackupController extends Controller
{
    /**
     * Display a listing of backups.
     */
    public function index()
    {
        $backups = Backup::latest()->paginate(15);

        return view('admin.backups.index', compact('backups'));
    }

    /**
     * Create a new database backup using mysqldump.
     */
    public function create()
    {
        $dbHost = config('database.connections.mysql.host');
        $dbPort = config('database.connections.mysql.port', '3306');
        $dbName = config('database.connections.mysql.database');
        $dbUser = config('database.connections.mysql.username');
        $dbPass = config('database.connections.mysql.password');

        $filename = 'backup_' . date('Y-m-d_His') . '.sql';
        $backupDir = storage_path('app/backups');

        // Ensure backup directory exists
        if (!is_dir($backupDir)) {
            mkdir($backupDir, 0755, true);
        }

        $filePath = $backupDir . '/' . $filename;

        // Build mysqldump command
        $command = sprintf(
            'mysqldump --host=%s --port=%s --user=%s --password=%s %s > %s 2>&1',
            escapeshellarg($dbHost),
            escapeshellarg($dbPort),
            escapeshellarg($dbUser),
            escapeshellarg($dbPass),
            escapeshellarg($dbName),
            escapeshellarg($filePath)
        );

        $result = Process::run($command);

        if ($result->successful() && file_exists($filePath)) {
            $fileSize = filesize($filePath);

            $backup = Backup::create([
                'filename' => $filename,
                'type' => 'database',
                'size' => $fileSize,
                'status' => 'completed',
                'notes' => 'Sauvegarde automatique de la base de données.',
            ]);

            AdminLog::log('created', $backup, [
                'filename' => $filename,
                'size' => $fileSize,
            ]);

            return redirect()->route('admin.backups.index')
                ->with('success', 'Sauvegarde créée avec succès.');
        }

        // Backup failed — clean up partial file
        if (file_exists($filePath)) {
            unlink($filePath);
        }

        $backup = Backup::create([
            'filename' => $filename,
            'type' => 'database',
            'size' => 0,
            'status' => 'failed',
            'notes' => 'Échec: ' . $result->errorOutput(),
        ]);

        AdminLog::log('failed', $backup, [
            'error' => $result->errorOutput(),
        ]);

        return redirect()->route('admin.backups.index')
            ->with('error', 'Échec de la sauvegarde. Vérifiez les logs.');
    }

    /**
     * Download a backup file.
     */
    public function download(Backup $backup)
    {
        $filePath = storage_path('app/backups/' . $backup->filename);

        if (!file_exists($filePath)) {
            return redirect()->route('admin.backups.index')
                ->with('error', 'Fichier de sauvegarde introuvable.');
        }

        return response()->download($filePath, $backup->filename);
    }

    /**
     * Remove the specified backup.
     */
    public function destroy(Backup $backup)
    {
        // Delete the backup file
        $filePath = storage_path('app/backups/' . $backup->filename);
        if (file_exists($filePath)) {
            unlink($filePath);
        }

        AdminLog::log('deleted', $backup, [
            'filename' => $backup->filename,
        ]);

        $backup->delete();

        return redirect()->route('admin.backups.index')
            ->with('success', 'Sauvegarde supprimée avec succès.');
    }
}
