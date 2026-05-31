<?php

return [
    'site_name' => 'VERDE PARIS 75',
    'domain' => 'https://verdeparis75.com',
    'default_locale' => 'fr',
    'company' => [
        'name' => 'VERDE PARIS 75',
        'description' => 'Travaux de voirie, assainissement, reseaux divers, terrassement et maconnerie en Ile-de-France.',
        'address' => '5 TER Rue des Frenes, 91160 Ballainvilliers',
        'phone' => '',
        'email' => '',
        'siret' => '',
        'area_served' => ['Paris', 'Essonne', 'Ile-de-France', 'Hauts-de-Seine', 'Val-de-Marne', 'Seine-et-Marne', 'Yvelines'],
    ],
    'robots' => [
        'allow_index' => true,
        'disallow' => ['/admin', '/login', '/register', '/storage/private'],
    ],
];
