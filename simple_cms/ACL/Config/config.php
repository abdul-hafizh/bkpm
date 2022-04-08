<?php

return [
    'name' => 'ACL',
    'slug' => 'acl',
    'namespace' => 'SimpleCMS\ACL\\',
    'hide_routes' => [
        'simple_cms.acl.backend.role.destroy',
        'simple_cms.acl.backend.role.delete'
    ],
    'user_social_media' => [
        'facebook' => [
            'name'  => 'Facebook',
            'url'   => ''
        ],
        'twitter' => [
            'name'  => 'Twitter',
            'url'   => ''
        ],
        'instagram' => [
            'name'  => 'Instagram',
            'url'   => ''
        ],
        'linkedin' => [
            'name'  => 'LinkedIn',
            'url'   => ''
        ]
    ],
    'auth_social_media' => [
        'facebook' => [
            'client_id'     => env('SOCIAL_MEDIA_FACEBOOK_ID'),
            'client_secret' => env('SOCIAL_MEDIA_FACEBOOK_SECRET'),
            'redirect'      => env('SOCIAL_MEDIA_FACEBOOK_URL'),
            'icon'          => 'fab fa-facebook-f'
        ],

        'twitter' => [
            'client_id'     => env('SOCIAL_MEDIA_TWITTER_ID'),
            'client_secret' => env('SOCIAL_MEDIA_TWITTER_SECRET'),
            'redirect'      => env('SOCIAL_MEDIA_TWITTER_URL'),
            'icon'          => 'fab fa-twitter'
        ],

        'google' => [
            'client_id'     => env('SOCIAL_MEDIA_GOOGLE_ID'),
            'client_secret' => env('SOCIAL_MEDIA_GOOGLE_SECRET'),
            'redirect'      => env('SOCIAL_MEDIA_GOOGLE_URL'),
            'icon'          => 'fab fa-google'
        ],

        'instagram' => [
            'client_id'     => env('SOCIAL_MEDIA_INSTAGRAM_ID'),
            'client_secret' => env('SOCIAL_MEDIA_INSTAGRAM_SECRET'),
            'redirect'      => env('SOCIAL_MEDIA_INSTAGRAM_URL'),
            'icon'          => 'fab fa-instagram'
        ],

        'linkedin' => [
            'client_id'     => env('SOCIAL_MEDIA_LINKEDIN_ID'),
            'client_secret' => env('SOCIAL_MEDIA_LINKEDIN_SECRET'),
            'redirect'      => env('SOCIAL_MEDIA_LINKEDIN_URL'),
            'icon'          => 'fab fa-linkedin-in'
        ],

        'github' => [
            'client_id'     => env('SOCIAL_MEDIA_GITHUB_ID'),
            'client_secret' => env('SOCIAL_MEDIA_GITHUB_SECRET'),
            'redirect'      => env('SOCIAL_MEDIA_GITHUB_URL'),
            'icon'          => 'fab fa-github'
        ],

        'gitlab' => [
            'client_id'     => env('SOCIAL_MEDIA_GITLAB_ID'),
            'client_secret' => env('SOCIAL_MEDIA_GITLAB_SECRET'),
            'redirect'      => env('SOCIAL_MEDIA_GITLAB_URL'),
            'icon'          => 'fab fa-gitlab'
        ],

        'bitbucket' => [
            'client_id'     => env('SOCIAL_MEDIA_BITBUCKET_ID'),
            'client_secret' => env('SOCIAL_MEDIA_BITBUCKET_SECRET'),
            'redirect'      => env('SOCIAL_MEDIA_BITBUCKET_URL'),
            'icon'          => 'fab fa-bitbucket'
        ]
    ]
];
