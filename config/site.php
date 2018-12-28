<?php

return [

    'langs' => [
        1 => 'en',
        2 => 'vi'
    ],
    'list-lang' => [
        1 => 'English',
        2 => 'Vietnamese'
    ],
    'default-image' => 'images/default.jpg',
    'workspace' => [
        'image' => 'public/workspace/',
        'display-image' => 'storage/workspace/'
    ],
    'location' => [
        'image' => 'public/location/',
        'display-image' => 'storage/location/'
    ],
    'user' => [
        'image' => 'public/user/',
        'display-image' => 'storage/user/'
    ],
    'diagram' => [
        'image' => 'public/diagram/',
        'display-image' => 'storage/diagram/'
    ],
    'workspace' => [
        'image' => 'public/workspace/',
        'display-image' => 'storage/workspace/'
    ],
    'disable' => 0,
    'active' => 1,
    'partime' => 0,
    'fulltime' => 1,
    'static' => 'images/',
    'shift' => [
        'off' => 0,
        'all' => 1,
        'morning' => 2,
        'afternoon' => 3,
    ],
    'permission' => [
        'trainee' => 0,
        'trainer' => 1,
        'admin' => 2,
    ],
    'prepend' => 0,
    'none_type' => 2,
    'paginate_user' => 15,
    'calendar' => [
        'default-color' => '"m-fc-event--primary"',
        'off-color' => '"m-fc-event--danger"',
        'fulltime-color' => '"m-fc-event--success"',
        'afternoon-color' => '"m-fc-event--warning"',

    ],
    'analystic' => [
        'default-color' => 'm-fc-event--primary',
        'total-color' => 'm-fc-event--info',
        'fulltime-color' => 'm-fc-event--success',
        'afternoon-color' => 'm-fc-event--warning',

    ],
    'default_location' => '0',
    'shift_filter' => [
        0 => 'All',
        1 => 'Fulltime',
        2 => 'Morning',
        3 => 'Afternoon',
    ],
    'allow_register' => 1,
    'disallow_register' => 0,
    'default_img_map_target' => [
        '_blank' => '_blank',
        '_parent' => '_parent',
        '_self' => '_self',
        '_top' => '_top',
    ],
    'default_img_map_shape' => [
        'rect' => 'rect',
        'poly' => 'poly',
        'circle' => 'circle',
    ],
    'default' => [
        'usable' => 1,
        'unusable' => 0,
    ],
    'last_work_day_of_week' => 'Friday',
    'disable_seat' => 2
];
