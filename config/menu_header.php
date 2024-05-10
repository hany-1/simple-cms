<?php

return [
    'items' => [
        [
            'title' => 'Dashboard',
            'page' => 'admin.home',
            'page-group' => 'admin.home',
            'new-tab' => false,
        ],
        [
            'title' => 'Posts',
            'page-group' => 'admin.posts',
            'page' => 'admin.posts.index',
            'new-tab' => false,
        ],
        [
            'title' => 'Pages',
            'page-group' => 'admin.pages',
            'page' => 'admin.pages.index',
            'new-tab' => false,
        ],
        [
            'title' => 'Terms',
            'page-group' => 'admin.categories',
            'page' => null,
            'new-tab' => false,
            'submenu' => [
                [
                    'title' => 'Category',
                    'page-group' => 'admin.categories',
                    'page' => 'admin.categories.index',
                    'new-tab' => false,
                ],
                [
                    'title' => 'Tag',
                    'page-group' => 'admin.tags',
                    'page' => 'admin.tags.index',
                    'new-tab' => false,
                ]
            ]
        ],
        [
            'title' => 'Users',
            'page-group' => 'admin.users',
            'page' => 'admin.users.index',
            'new-tab' => false,
        ],
    ],
];
