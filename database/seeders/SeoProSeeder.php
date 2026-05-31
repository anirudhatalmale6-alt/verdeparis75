<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\SeoPage;

class SeoProSeeder extends Seeder
{
    public function run(): void
    {
        $pages = [
            [
                'title' => 'Terrassement a Paris',
                'slug' => 'terrassement-paris',
                'seo_title' => 'Entreprise de terrassement a Paris | VERDE PARIS 75',
                'meta_description' => 'VERDE PARIS 75 realise vos travaux de terrassement a Paris : preparation de terrain, fouilles, evacuation, remblaiement et finition professionnelle.',
                'h1' => 'Entreprise de terrassement a Paris',
                'keywords' => ['terrassement Paris', 'entreprise terrassement Paris', 'travaux terrassement 75'],
            ],
            [
                'title' => 'Terrassement en Essonne',
                'slug' => 'terrassement-essonne',
                'seo_title' => 'Terrassement Essonne 91 | VERDE PARIS 75',
                'meta_description' => 'Entreprise de terrassement en Essonne pour particuliers, professionnels et chantiers VRD : preparation terrain, reseaux, voirie et maconnerie exterieure.',
                'h1' => 'Travaux de terrassement en Essonne 91',
                'keywords' => ['terrassement Essonne', 'terrassement 91', 'VRD Essonne'],
            ],
            [
                'title' => 'Assainissement a Paris',
                'slug' => 'assainissement-paris',
                'seo_title' => 'Assainissement Paris | Reseaux eaux usees et eaux pluviales',
                'meta_description' => 'VERDE PARIS 75 intervient pour les travaux d\'assainissement a Paris : pose de canalisations, raccordement, evacuation eaux usees et eaux pluviales.',
                'h1' => 'Travaux d\'assainissement a Paris',
                'keywords' => ['assainissement Paris', 'reseau eaux usees Paris', 'canalisation Paris'],
            ],
            [
                'title' => 'VRD en Ile-de-France',
                'slug' => 'vrd-ile-de-france',
                'seo_title' => 'VRD Ile-de-France | Voirie et Reseaux Divers',
                'meta_description' => 'Specialiste VRD en Ile-de-France : voirie, reseaux divers, tranchees, raccordements, assainissement et preparation des acces chantier.',
                'h1' => 'Entreprise VRD en Ile-de-France',
                'keywords' => ['VRD Ile-de-France', 'voirie reseaux divers', 'entreprise VRD Paris'],
            ],
            [
                'title' => 'Maconnerie exterieure Paris',
                'slug' => 'maconnerie-exterieure-paris',
                'seo_title' => 'Maconnerie exterieure Paris | VERDE PARIS 75',
                'meta_description' => 'Travaux de maconnerie exterieure a Paris et en Ile-de-France : murets, bordures, dallage, acces, reprises et finitions de chantier.',
                'h1' => 'Maconnerie exterieure a Paris',
                'keywords' => ['maconnerie exterieure Paris', 'muret Paris', 'dallage exterieur Paris'],
            ],
        ];

        foreach ($pages as $p) {
            $p['sections'] = [
                ['title' => 'Une intervention professionnelle', 'content' => 'VERDE PARIS 75 accompagne les particuliers, entreprises et collectivites pour des travaux propres, organises et adaptes aux contraintes du terrain.'],
                ['title' => 'Nos prestations', 'content' => 'Terrassement, evacuation, tranchees techniques, pose de reseaux, assainissement, voirie, remblaiement et maconnerie exterieure.'],
                ['title' => 'Demander un devis', 'content' => 'Contactez VERDE PARIS 75 pour etudier votre chantier et obtenir une estimation adaptee a votre projet.'],
            ];

            SeoPage::updateOrCreate(
                ['slug' => $p['slug']],
                $p + ['locale' => 'fr', 'is_indexable' => true, 'is_active' => true]
            );
        }
    }
}
