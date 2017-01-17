<?php
return [
    'name' => "BJZ Blog",
    'title' => 'BenjaminJZi Blog',
    'subtitle' => '境由心转 知行合一',
    'description' => '看看',
    'author' => 'BenjaminJZi',
    'page_image' => 'home-bg.jpg',
    'posts_per_page' => 10,
    'rss_size' => 25,
    'contact_email' => env('MAIL_FROM'),
    'uploads' => [
        'storage' => 'local',
        'webpath' => '/uploads/',
    ],
];