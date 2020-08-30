<?php
$accesscontrol['admin'] = [
    [
        'name' => 'Dữ liệu nền',
        'url' => '',
        'class-icon' => '',
        'submenu' => [
            [
                'name' => 'DS Quận (HCM)',
                'url' => '/admin/list-district',
                'submenu' => null
            ],
            [
                'name' => 'DS Thành Viên',
                'url' => '/admin/list-user',
                'submenu' => null
            ],
            [
                'name' => 'DS Đối Tác',
                'url' => '/admin/list-partner',
                'submenu' => null
            ],
            [
                'name' => 'DS Quyền',
                'url' => '/admin/list-role',
                'submenu' => null
            ],
            [
                'name' => 'DS Loại Dự Án',
                'url' => '/admin/list-apartment-type',
                'submenu' => null
            ],
            [
                'name' => 'DS Loại Phòng',
                'url' => '/admin/list-room-type',
                'submenu' => null
            ],
            [
                'name' => 'DS Giá',
                'url' => '/admin/list-price',
                'submenu' => null
            ],
            [
                'name' => 'DS # (Tag)',
                'url' => '/admin/list-tag',
                'submenu' => null
            ],
        ]
    ],
    [
        'name' => 'Dự Án',
        'url' => '#',
        'class-icon' => null,
        'submenu' => [

            [
                'name' => 'Phân quận',
                'url' => '/admin/list-user-district',
                'class-icon' => ''
            ],
            [
                'name' => 'DS (thẻ)*',
                'url' => '/admin/list-apartment',
                'class-icon' => ''
            ],
            [
                'name' => 'DS địa chỉ tòa nhà (bảng) *',
                'url' => '/admin/list-apartment-like-base',
                'class-icon' => ''
            ]
            
        ]
    ],
    [
        'name' => 'Văn bản',
        'url' => '/admin/list-document',
        'class-icon' => null,
        'submenu' => null
    ],
    [
        'name' => 'Hướng Dẫn',
        'url' => '/admin/list-guild',
        'class-icon' => null,
        'submenu' => null
    ],
    [
        'name' => 'Đăng xuất',
        'url' => '/admin/logout',
        'class-icon' => null,
        'submenu' => null
    ],

];

$accesscontrol['product-manager'] = [
    [
        'name' => 'Dữ liệu nền (QLDA)',
        'url' => '',
        'class-icon' => '',
        'submenu' => [
            [
                'name' => 'DS Quận (HCM)',
                'url' => '/admin/list-district',
                'submenu' => null
            ],
            [
                'name' => 'DS Thành Viên',
                'url' => '/admin/list-user',
                'submenu' => null
            ],
            [
                'name' => 'DS Đối Tác',
                'url' => '/admin/list-partner',
                'submenu' => null
            ],
            [
                'name' => 'DS Quyền Thành Viên',
                'url' => '/admin/list-role',
                'submenu' => null
            ],
            [
                'name' => 'DS Loại Dự Án',
                'url' => '/admin/list-apartment-type',
                'submenu' => null
            ],
            [
                'name' => 'DS Loại Phòng',
                'url' => '/admin/list-room-type',
                'submenu' => null
            ],
            [
                'name' => 'DS Giá',
                'url' => '/admin/list-price',
                'submenu' => null
            ],
            [
                'name' => 'DS # (Tag)',
                'url' => '/admin/list-tag',
                'submenu' => null
            ],
        ]
    ],
    [
        'name' => 'Dự Án',
        'url' => '',
        'submenu' => [
            [
                'name' => '<div class="text-primary"> DS Dự Án (thẻ) </div>',
                'url' => '/admin/list-apartment',
                'class-icon' => ''
            ],
            [
                'name' => '<div class="text-danger"> DS Dự Án (bảng) </div>',
                'url' => '/admin/list-apartment-like-base',
                'class-icon' => ''
            ]
        ]
    ],
    [
        'name' => 'Google Drive',
        'url' => '/admin/list-google',
        'submenu' => null
    ]
];

$accesscontrol['human-resource'] = [
    [
        'name' => 'Tòa nhà',
        'url' => '/admin/helloA',
        'class-icon' => null,
        'submenu' => null
    ],
    [
        'name' => 'Phòng',
        'url' => '/admin/helloA',
        'submenu' => [
            [
                'name' => 'F1',
                'url' => '/admin/helloA1',
                'submenu' => null
            ],
            [
                'name' => 'F2',
                'url' => '/admin/helloA2',
                'submenu' => null
            ],
        ]
    ],
];

$accesscontrol['consultant'] = [
    [
        'name' => 'Dự Án',
        'url' => '/admin/list-apartment',
        'submenu' => null
    ],
    [
        'name' => 'Google Drive',
        'url' => '/admin/list-google',
        'submenu' => null
    ],
];



$config['accesscontrol'] = $accesscontrol;
?>

