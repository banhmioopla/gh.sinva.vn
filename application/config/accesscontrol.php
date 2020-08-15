<?php
$accesscontrol['admin'] = [
    [
        'name' => 'Dữ liệu nền',
        'url' => '/admin/list-apartment',
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
                'url' => '/admin/list-user',
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
        'name' => 'Hình ảnh',
        'url' => '/admin/list-image',
        'class-icon' => null,
        'submenu' => null
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

];

$accesscontrol['product-manager'] = [
    [
        'name' => 'Tòa nhà',
        'url' => '/admin/helloA',
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
        'name' => 'Kho Ảnh',
        'url' => '/admin/helloA',
        'submenu' => null
    ],
    [
        'name' => 'Lịch Làm',
        'url' => '/admin/helloA',
        'submenu' => null
    ],
    [
        'name' => 'Tài Khoản',
        'url' => '/admin/helloA',
        'submenu' => [
            [
                'name' => 'Đổi mật khẩu',
                'url' => '/admin/helloA1',
                'submenu' => null
            ],
            [
                'name' => 'Lịch Làm',
                'url' => '/admin/helloA2',
                'submenu' => null
            ],
        ]
    ],
];

$config['accesscontrol'] = $accesscontrol;
?>

