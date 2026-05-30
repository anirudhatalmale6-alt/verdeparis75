<?php

namespace Database\Seeders;

use App\Models\HomepageSection;
use App\Models\LegalPage;
use App\Models\Service;
use App\Models\Setting;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DefaultSeeder extends Seeder
{
    public function run(): void
    {
        User::firstOrCreate(
            ['email' => 'admin@verdeparis75.com'],
            [
                'name' => 'Administrateur',
                'password' => Hash::make('VerdeParis2026!'),
            ]
        );

        $settings = [
            ['key' => 'site_name', 'value' => 'VERDE PARIS 75', 'type' => 'text', 'group' => 'general', 'label' => 'Nom du site'],
            ['key' => 'site_tagline', 'value' => 'Etude et travaux Batiment, VRD & Espaces verts', 'type' => 'text', 'group' => 'general', 'label' => 'Slogan'],
            ['key' => 'logo', 'value' => null, 'type' => 'image', 'group' => 'general', 'label' => 'Logo'],
            ['key' => 'favicon', 'value' => null, 'type' => 'image', 'group' => 'general', 'label' => 'Favicon'],

            ['key' => 'address', 'value' => 'Charenton-le-Pont, Ile-de-France', 'type' => 'text', 'group' => 'contact', 'label' => 'Adresse'],
            ['key' => 'phone', 'value' => '+33 1 00 00 00 00', 'type' => 'text', 'group' => 'contact', 'label' => 'Telephone'],
            ['key' => 'email', 'value' => 'contact@verdeparis75.com', 'type' => 'text', 'group' => 'contact', 'label' => 'Email'],
            ['key' => 'map_embed', 'value' => '', 'type' => 'textarea', 'group' => 'contact', 'label' => 'Code iframe Google Maps'],

            ['key' => 'facebook', 'value' => '', 'type' => 'text', 'group' => 'social', 'label' => 'Facebook URL'],
            ['key' => 'instagram', 'value' => '', 'type' => 'text', 'group' => 'social', 'label' => 'Instagram URL'],
            ['key' => 'linkedin', 'value' => '', 'type' => 'text', 'group' => 'social', 'label' => 'LinkedIn URL'],
            ['key' => 'twitter', 'value' => '', 'type' => 'text', 'group' => 'social', 'label' => 'Twitter/X URL'],

            ['key' => 'footer_text', 'value' => 'Etude et Travaux Batiment, VRD, Assainissement et Espaces Verts en Ile-de-France.', 'type' => 'textarea', 'group' => 'footer', 'label' => 'Texte du pied de page'],
            ['key' => 'footer_copyright', 'value' => '© 2026 VERDE PARIS 75 — Tous droits reserves.', 'type' => 'text', 'group' => 'footer', 'label' => 'Copyright'],
        ];

        foreach ($settings as $s) {
            Setting::updateOrCreate(['key' => $s['key']], $s);
        }

        $sections = [
            [
                'section_key' => 'hero',
                'title' => 'VERDE PARIS 75',
                'subtitle' => 'Etudes et Travaux Batiment, VRD & Espaces Verts',
                'content' => 'Installee a Charenton-le-Pont depuis 2014, VERDE PARIS 75 accompagne les projets publics et prives : VRD, assainissement, terrassement, reseaux divers, mobilier urbain et espaces verts.',
                'button_text' => 'Demander un devis',
                'button_url' => '/contact',
                'sort_order' => 1,
            ],
            [
                'section_key' => 'about',
                'title' => 'Votre partenaire VRD & Espaces Verts',
                'subtitle' => 'Depuis 2014 a Charenton-le-Pont',
                'content' => 'VERDE PARIS 75 est specialisee dans l\'etude et la realisation de travaux de voiries et reseaux divers, ainsi que dans la creation et l\'entretien des espaces verts. Nos equipes disposent d\'un parc d\'engins et de moyens techniques adaptes pour assurer la bonne execution des travaux, dans le respect des normes et de la securite.',
                'button_text' => 'Voir nos realisations',
                'button_url' => '/realisations',
                'sort_order' => 2,
            ],
            [
                'section_key' => 'services_preview',
                'title' => 'Nos Services',
                'subtitle' => 'Des prestations completes pour vos projets VRD, batiment et espaces verts',
                'sort_order' => 3,
            ],
            [
                'section_key' => 'projects_preview',
                'title' => 'Nos Realisations',
                'subtitle' => 'Photos et videos de nos chantiers',
                'button_text' => 'Voir toutes nos realisations',
                'button_url' => '/realisations',
                'sort_order' => 4,
            ],
            [
                'section_key' => 'testimonials',
                'title' => 'Ce que disent nos clients',
                'subtitle' => 'La satisfaction de nos clients est notre meilleure recompense',
                'sort_order' => 5,
            ],
            [
                'section_key' => 'cta',
                'title' => 'Un projet VRD ou espaces verts ?',
                'subtitle' => 'Demandez une etude ou un rendez-vous pour vos travaux',
                'button_text' => 'Demander un devis',
                'button_url' => '/contact',
                'sort_order' => 6,
            ],
            [
                'section_key' => 'stats',
                'title' => 'VERDE PARIS 75 en chiffres',
                'extra_data' => [
                    ['value' => '2014', 'label' => 'Depuis', 'icon' => 'calendar-check'],
                    ['value' => '8', 'label' => 'Domaines metier', 'icon' => 'briefcase'],
                    ['value' => '100%', 'label' => 'Administrable', 'icon' => 'gear'],
                    ['value' => 'IDF', 'label' => 'Zone d\'intervention', 'icon' => 'geo-alt'],
                ],
                'sort_order' => 7,
            ],
        ];

        foreach ($sections as $s) {
            HomepageSection::updateOrCreate(['section_key' => $s['section_key']], $s);
        }

        $services = [
            ['title' => 'Etudes', 'slug' => 'etudes', 'description' => 'Releves terrain, plans AutoCAD/Covadis, DOE et recolement.', 'icon' => 'pencil-square', 'sort_order' => 1, 'is_active' => true],
            ['title' => 'Demolition', 'slug' => 'demolition', 'description' => 'Depose de revetements, reseaux et enrobes, y compris sous-section 4.', 'icon' => 'hammer', 'sort_order' => 2, 'is_active' => true],
            ['title' => 'Terrassements secondaires', 'slug' => 'terrassements-secondaires', 'description' => 'Grande masse, fouilles, bassins, noues et tranchees.', 'icon' => 'truck', 'sort_order' => 3, 'is_active' => true],
            ['title' => 'Revetements', 'slug' => 'revetements', 'description' => 'Enrobes, bordures, trottoirs, beton desactive, paves.', 'icon' => 'bricks', 'sort_order' => 4, 'is_active' => true],
            ['title' => 'Reseau assainissement', 'slug' => 'reseau-assainissement', 'description' => 'Reseaux EU/EV/EP, regards, bassins, stations et raccordements.', 'icon' => 'water', 'sort_order' => 5, 'is_active' => true],
            ['title' => 'Reseaux VRD', 'slug' => 'reseaux-vrd', 'description' => 'AEP, incendie, CFO/CFA, gaz, eclairage et chambres de tirage.', 'icon' => 'diagram-3', 'sort_order' => 6, 'is_active' => true],
            ['title' => 'Mobilier urbain', 'slug' => 'mobilier-urbain', 'description' => 'Bornes, bancs, corbeilles, aires de jeux, signalisation.', 'icon' => 'signpost-2', 'sort_order' => 7, 'is_active' => true],
            ['title' => 'Espaces verts', 'slug' => 'espaces-verts', 'description' => 'Creation, entretien, elagage, abattage, arrosage automatique.', 'icon' => 'tree', 'sort_order' => 8, 'is_active' => true],
        ];

        foreach ($services as $s) {
            Service::updateOrCreate(['slug' => $s['slug']], $s);
        }

        $legalPages = [
            [
                'title' => 'Mentions legales',
                'slug' => 'mentions-legales',
                'content' => '<h2>Mentions legales</h2><p>Conformement aux dispositions des Articles 6-III et 19 de la Loi n°2004-575 du 21 juin 2004 pour la Confiance dans l\'economie numerique, dite L.C.E.N., il est porte a la connaissance des utilisateurs et visiteurs du site les informations suivantes :</p><p><strong>Editeur du site :</strong> VERDE PARIS 75</p><p><strong>Adresse :</strong> Charenton-le-Pont, Ile-de-France</p><p><strong>Hebergeur :</strong> OVH - 2 Rue Kellermann, 59100 Roubaix, France</p>',
            ],
            [
                'title' => 'Politique de confidentialite',
                'slug' => 'politique-confidentialite',
                'content' => '<h2>Politique de confidentialite</h2><p>La presente politique de confidentialite definit et vous informe de la maniere dont VERDE PARIS 75 utilise et protege les informations que vous nous transmettez.</p><h3>Collecte des donnees</h3><p>Nous collectons les informations que vous nous fournissez volontairement via notre formulaire de contact : nom, email, telephone, message.</p><h3>Utilisation des donnees</h3><p>Les donnees collectees sont utilisees uniquement pour repondre a vos demandes et ne sont jamais transmises a des tiers.</p>',
            ],
            [
                'title' => 'Conditions generales d\'utilisation',
                'slug' => 'conditions-utilisation',
                'content' => '<h2>Conditions generales d\'utilisation</h2><p>L\'utilisation du site verdeparis75.com implique l\'acceptation pleine et entiere des conditions generales d\'utilisation decrites ci-apres.</p><h3>Propriete intellectuelle</h3><p>L\'ensemble des contenus presents sur ce site (textes, images, videos) sont la propriete exclusive de VERDE PARIS 75 ou de ses partenaires.</p>',
            ],
        ];

        foreach ($legalPages as $p) {
            LegalPage::updateOrCreate(['slug' => $p['slug']], $p);
        }
    }
}
