 <?php

return  [ 
    'pannels' => [
        [
            'color' => 'primary',
            'icon' => 'envelope',
            'model' => \App\Models\Contact::class,
            'name' => 'back/admin.new-messages',
            'url' => 'contact',
            'total' => 'back/admin.messages',
        ],
        [
            'color' => 'green',
            'icon' => 'user',
            'model' => \App\Models\User::class,
            'name' => 'back/admin.new-registers',
            'url' => 'user/sort',
            'total' => 'back/admin.users',
        ],
//        [
//            'color' => 'yellow',
//            'icon' => 'pencil',
//            'model' => \App\Models\Post::class,
//            'name' => 'back/admin.new-posts',
//            'url' => 'blog',
//        ],
        [
            'color' => 'blue',
            'icon' => 'pencil',
            'model' => \App\Models\ShopItem::class,
            'name' => 'back/admin.new-shop_item',
            'url' => 'shop/back',
            'total' => 'back/admin.shop_items',
        ],
        [
            'color' => 'red',
            'icon' => 'comment',
            'model' => \App\Models\Comment::class,
            'name' => 'back/admin.new-comments',
            'url' => 'comment',
            'total' => 'back/admin.comments',
        ],
    ],
];