<?php

return [
    'title' => 'Website Content',
    'navigation_label' => 'Overview',
    'subtitle' => 'Manage the articles, FAQs, gallery, and testimonials published across the public website.',
    'empty_value' => 'Not set',

    'command' => [
        'eyebrow' => 'Content desk',
        'heading' => 'Website publishing control',
        'description' => 'Keep public pages current with a clear view of published articles, active help content, visual proof, and hidden items that need review.',
    ],

    'summary' => [
        'label' => 'Website content summary',
        'published' => [
            'label' => 'Published articles',
            'description' => 'Visible on the public news section.',
        ],
        'drafts' => [
            'label' => 'Draft articles',
            'description' => 'Waiting for editorial completion.',
        ],
        'faqs' => [
            'label' => 'Active FAQs',
            'description' => ':total total questions in the knowledge base.',
        ],
        'proof' => [
            'label' => 'Visible proof',
            'description' => 'Gallery media and testimonials live on site.',
        ],
    ],

    'quick_links' => [
        'heading' => 'Content workspaces',
        'description' => 'Move directly into the public content areas that shape the customer experience.',
        'empty' => 'No content workspaces are available for your role.',
        'articles' => [
            'label' => 'Articles',
            'description' => 'Review news, bilingual copy, publishing status, and SEO.',
        ],
        'faqs' => [
            'label' => 'FAQs',
            'description' => 'Maintain customer answers and display order.',
        ],
        'gallery' => [
            'label' => 'Gallery',
            'description' => 'Curate agency imagery and visual categories.',
        ],
        'testimonials' => [
            'label' => 'Testimonials',
            'description' => 'Manage customer stories and rating visibility.',
        ],
    ],

    'modules' => [
        'heading' => 'Publishing workload',
        'description' => 'Visible items compared with the full content inventory.',
        'metric' => ':visible of :total visible on site',
        'articles' => [
            'label' => 'Articles',
        ],
        'faqs' => [
            'label' => 'FAQs',
        ],
        'gallery' => [
            'label' => 'Gallery media',
        ],
        'testimonials' => [
            'label' => 'Testimonials',
        ],
    ],

    'latest_articles' => [
        'heading' => 'Latest articles',
        'description' => 'Recent editorial updates and their publishing state.',
        'empty' => 'No articles have been created yet.',
    ],

    'attention' => [
        'heading' => 'Attention queue',
        'description' => 'Draft and hidden content that may need review before it can support the public site.',
        'empty' => 'No content is waiting for attention.',
        'draft_articles' => [
            'label' => 'Draft articles',
            'description' => 'Articles still waiting for publication.',
        ],
        'inactive_faqs' => [
            'label' => 'Inactive FAQs',
            'description' => 'Questions hidden from the public help flow.',
        ],
        'hidden_gallery' => [
            'label' => 'Hidden gallery',
            'description' => 'Media items currently removed from public display.',
        ],
        'hidden_testimonials' => [
            'label' => 'Hidden testimonials',
            'description' => 'Customer stories currently hidden from the website.',
        ],
    ],

    'statuses' => [
        'unknown' => 'Unknown',
        'article' => [
            'draft' => 'Draft',
            'published' => 'Published',
            'archived' => 'Archived',
        ],
    ],
];
