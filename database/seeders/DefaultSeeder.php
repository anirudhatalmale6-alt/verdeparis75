<?php

namespace Database\Seeders;

use App\Models\HomepageSection;
use App\Models\LegalPage;
use App\Models\Setting;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DefaultSeeder extends Seeder
{
    public function run(): void
    {
        // Admin user
        User::firstOrCreate(
            ['email' => 'admin@verdeparis75.com'],
            [
                'name' => 'Administrateur',
                'password' => Hash::make('VerdeParis2026!'),
            ]
        );

        // General settings
        $settings = [
            // General
            ['key' => 'site_name', 'value' => 'VerdeParis75', 'type' => 'text', 'group' => 'general', 'label' => 'Nom du site'],
            ['key' => 'site_tagline', 'value' => 'Amenagement paysager et espaces verts a Paris', 'type' => 'text', 'group' => 'general', 'label' => 'Slogan'],
            ['key' => 'logo', 'value' => null, 'type' => 'image', 'group' => 'general', 'label' => 'Logo'],
            ['key' => 'favicon', 'value' => null, 'type' => 'image', 'group' => 'general', 'label' => 'Favicon'],

            // Contact
            ['key' => 'address', 'value' => 'Paris, France', 'type' => 'text', 'group' => 'contact', 'label' => 'Adresse'],
            ['key' => 'phone', 'value' => '+33 1 00 00 00 00', 'type' => 'text', 'group' => 'contact', 'label' => 'Telephone'],
            ['key' => 'email', 'value' => 'contact@verdeparis75.com', 'type' => 'text', 'group' => 'contact', 'label' => 'Email'],
            ['key' => 'map_embed', 'value' => '', 'type' => 'textarea', 'group' => 'contact', 'label' => 'Code iframe Google Maps'],

            // Social
            ['key' => 'facebook', 'value' => '', 'type' => 'text', 'group' => 'social', 'label' => 'Facebook URL'],
            ['key' => 'instagram', 'value' => '', 'type' => 'text', 'group' => 'social', 'label' => 'Instagram URL'],
            ['key' => 'linkedin', 'value' => '', 'type' => 'text', 'group' => 'social', 'label' => 'LinkedIn URL'],
            ['key' => 'twitter', 'value' => '', 'type' => 'text', 'group' => 'social', 'label' => 'Twitter/X URL'],

            // Footer
            ['key' => 'footer_text', 'value' => 'Specialistes en amenagement paysager, entretien de jardins et creation d\'espaces verts a Paris et en Ile-de-France.', 'type' => 'textarea', 'group' => 'footer', 'label' => 'Texte du pied de page'],
            ['key' => 'footer_copyright', 'value' => '© 2026 VerdeParis75. Tous droits reserves.', 'type' => 'text', 'group' => 'footer', 'label' => 'Copyright'],
        ];

        foreach ($settings as $s) {
            Setting::firstOrCreate(['key' => $s['key']], $s);
        }

        // Homepage sections
        $sections = [
            [
                'section_key' => 'hero',
                'title' => 'Transformez vos espaces verts',
                'subtitle' => 'Amenagement paysager professionnel a Paris et en Ile-de-France',
                'button_text' => 'Decouvrir nos services',
                'button_url' => '/services',
                'sort_order' => 1,
            ],
            [
                'section_key' => 'about',
                'title' => 'A propos de VerdeParis75',
                'subtitle' => 'Votre partenaire en espaces verts',
                'content' => 'Avec des annees d\'experience dans l\'amenagement paysager, VerdeParis75 cree des espaces verts uniques et durables. Notre equipe de professionnels passionnes met son expertise a votre service pour transformer vos exterieurs en veritables havres de paix.',
                'button_text' => 'En savoir plus',
                'button_url' => '/contact',
                'sort_order' => 2,
            ],
            [
                'section_key' => 'services_preview',
                'title' => 'Nos Services',
                'subtitle' => 'Des solutions completes pour vos espaces verts',
                'sort_order' => 3,
            ],
            [
                'section_key' => 'projects_preview',
                'title' => 'Nos Realisations',
                'subtitle' => 'Decouvrez nos dernieres creations',
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
                'title' => 'Pret a transformer votre espace ?',
                'subtitle' => 'Contactez-nous pour un devis gratuit et sans engagement',
                'button_text' => 'Demander un devis',
                'button_url' => '/contact',
                'sort_order' => 6,
            ],
            [
                'section_key' => 'stats',
                'title' => 'VerdeParis75 en chiffres',
                'extra_data' => [
                    ['value' => '15+', 'label' => 'Annees d\'experience'],
                    ['value' => '500+', 'label' => 'Projets realises'],
                    ['value' => '300+', 'label' => 'Clients satisfaits'],
                    ['value' => '100%', 'label' => 'Engagement qualite'],
                ],
                'sort_order' => 7,
            ],
        ];

        foreach ($sections as $s) {
            HomepageSection::firstOrCreate(['section_key' => $s['section_key']], $s);
        }

        // Legal pages
        $legalPages = [
            [
                'title' => 'Mentions legales',
                'slug' => 'mentions-legales',
                'content' => '<h2>Mentions legales</h2><p>Conformement aux dispositions des Articles 6-III et 19 de la Loi n°2004-575 du 21 juin 2004 pour la Confiance dans l\'economie numerique, dite L.C.E.N., il est porte a la connaissance des utilisateurs et visiteurs du site les informations suivantes :</p><p><strong>Editeur du site :</strong> VerdeParis75</p><p><strong>Hebergeur :</strong> OVH - 2 Rue Kellermann, 59100 Roubaix, France</p>',
            ],
            [
                'title' => 'Politique de confidentialite',
                'slug' => 'politique-confidentialite',
                'content' => '<h2>Politique de confidentialite</h2><p>La presente politique de confidentialite definit et vous informe de la maniere dont VerdeParis75 utilise et protege les informations que vous nous transmettez.</p><h3>Collecte des donnees</h3><p>Nous collectons les informations que vous nous fournissez volontairement via notre formulaire de contact : nom, email, telephone, message.</p><h3>Utilisation des donnees</h3><p>Les donnees collectees sont utilisees uniquement pour repondre a vos demandes et ne sont jamais transmises a des tiers.</p>',
            ],
            [
                'title' => 'Conditions generales d\'utilisation',
                'slug' => 'conditions-utilisation',
                'content' => '<h2>Conditions generales d\'utilisation</h2><p>L\'utilisation du site verdeparis75.com implique l\'acceptation pleine et entiere des conditions generales d\'utilisation decrites ci-apres.</p><h3>Propriete intellectuelle</h3><p>L\'ensemble des contenus presents sur ce site (textes, images, videos) sont la propriete exclusive de VerdeParis75 ou de ses partenaires.</p>',
            ],
        ];

        foreach ($legalPages as $p) {
            LegalPage::firstOrCreate(['slug' => $p['slug']], $p);
        }
    }
}
