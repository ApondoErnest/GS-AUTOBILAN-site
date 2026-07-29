<?php

return [
    'title' => 'Contenu du site',
    'navigation_label' => 'Vue générale',
    'subtitle' => 'Gérez les articles, FAQ, galerie et témoignages publiés sur le site public.',
    'empty_value' => 'Non renseigné',

    'command' => [
        'eyebrow' => 'Bureau contenu',
        'heading' => 'Pilotage éditorial du site',
        'description' => 'Gardez les pages publiques à jour avec une vue claire des articles publiés, contenus d’aide actifs, preuves visuelles et éléments masqués à revoir.',
    ],

    'summary' => [
        'label' => 'Résumé du contenu du site',
        'published' => [
            'label' => 'Articles publiés',
            'description' => 'Visibles dans les actualités publiques.',
        ],
        'drafts' => [
            'label' => 'Articles brouillons',
            'description' => 'En attente de finalisation éditoriale.',
        ],
        'faqs' => [
            'label' => 'FAQ actives',
            'description' => ':total questions au total dans la base d’aide.',
        ],
        'proof' => [
            'label' => 'Preuves visibles',
            'description' => 'Médias galerie et témoignages en ligne.',
        ],
    ],

    'quick_links' => [
        'heading' => 'Espaces contenu',
        'description' => 'Accédez directement aux zones de contenu public qui structurent l’expérience client.',
        'empty' => 'Aucun espace contenu n’est disponible pour votre rôle.',
        'articles' => [
            'label' => 'Articles',
            'description' => 'Revoyez les actualités, textes bilingues, statuts et SEO.',
        ],
        'faqs' => [
            'label' => 'FAQ',
            'description' => 'Maintenez les réponses clients et l’ordre d’affichage.',
        ],
        'gallery' => [
            'label' => 'Galerie',
            'description' => 'Organisez les images d’agence et leurs catégories.',
        ],
        'testimonials' => [
            'label' => 'Témoignages',
            'description' => 'Gérez les avis clients et leur visibilité.',
        ],
    ],

    'modules' => [
        'heading' => 'Charge de publication',
        'description' => 'Éléments visibles comparés à l’inventaire complet du contenu.',
        'metric' => ':visible sur :total visibles sur le site',
        'articles' => [
            'label' => 'Articles',
        ],
        'faqs' => [
            'label' => 'FAQ',
        ],
        'gallery' => [
            'label' => 'Médias galerie',
        ],
        'testimonials' => [
            'label' => 'Témoignages',
        ],
    ],

    'latest_articles' => [
        'heading' => 'Derniers articles',
        'description' => 'Mises à jour éditoriales récentes et leur état de publication.',
        'empty' => 'Aucun article n’a encore été créé.',
    ],

    'attention' => [
        'heading' => 'File d’attention',
        'description' => 'Contenus brouillons ou masqués à revoir avant de soutenir le site public.',
        'empty' => 'Aucun contenu n’est en attente d’attention.',
        'draft_articles' => [
            'label' => 'Articles brouillons',
            'description' => 'Articles encore en attente de publication.',
        ],
        'inactive_faqs' => [
            'label' => 'FAQ inactives',
            'description' => 'Questions masquées du parcours d’aide public.',
        ],
        'hidden_gallery' => [
            'label' => 'Galerie masquée',
            'description' => 'Médias actuellement retirés de l’affichage public.',
        ],
        'hidden_testimonials' => [
            'label' => 'Témoignages masqués',
            'description' => 'Avis clients actuellement masqués du site.',
        ],
    ],

    'statuses' => [
        'unknown' => 'Inconnu',
        'article' => [
            'draft' => 'Brouillon',
            'published' => 'Publié',
            'archived' => 'Archivé',
        ],
    ],
];
