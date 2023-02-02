<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Name of route
    |--------------------------------------------------------------------------
    |
    | Enter the routes name to enable dynamic imagecache manipulation.
    | This handle will define the first part of the URI:
    |
    | {route}/{template}/{filename}
    |
    | Examples: "images", "img/cache"
    |
    */

    'route' => 'cache',

    /*
    |--------------------------------------------------------------------------
    | Storage paths
    |--------------------------------------------------------------------------
    |
    | The following paths will be searched for the image filename, submitted
    | by URI.
    |
    | Define as many directories as you like.
    |
    */

    'paths' => [
        public_path('storage')
    ],

    /*
    |--------------------------------------------------------------------------
    | Manipulation templates
    |--------------------------------------------------------------------------
    |
    | Here you may specify your own manipulation filter templates.
    | The keys of this array will define which templates
    | are available in the URI:
    |
    | {route}/{template}/{filename}
    |
    | The values of this array will define which filter class
    | will be applied, by its fully qualified name.
    |
    */

    'templates' => [
        '80x80' => App\Support\ImageFilters\Thumb80X80::class,
        '193x243' => App\Support\ImageFilters\Thumb193X243::class,
        '226x286' => App\Support\ImageFilters\Thumb226X286::class,
        '285x285' => App\Support\ImageFilters\Thumb285X285::class,
        '285x360' => App\Support\ImageFilters\Thumb285X360::class,
        '354x540' => App\Support\ImageFilters\Thumb354X540::class,
        '457x684' => App\Support\ImageFilters\Thumb457X684::class,
        '588x180' => App\Support\ImageFilters\Thumb588X180::class,
        '895x400' => App\Support\ImageFilters\Thumb895X400::class,
        // this is a route to original image w/o watermarks. It is named that way so that no one would not find the route by accident
        '6f726967696e616c' => App\Support\ImageFilters\ThumbOriginal::class,
        // full size is an original image w/ watermarks
        'full-size' => App\Support\ImageFilters\ThumbOriginalWithWatermark::class,
    ],

    /*
    |--------------------------------------------------------------------------
    | Image Cache Lifetime
    |--------------------------------------------------------------------------
    |
    | Lifetime in minutes of the images handled by the imagecache route.
    |
    */

    'lifetime' => 43200,

];
