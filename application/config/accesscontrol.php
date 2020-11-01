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
        'url' => '#',
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
                'name' => 'DS # (Tag)',
                'url' => '/admin/list-tag',
                'submenu' => null
            ],
        ]
    ],
    [
        'name' => 'Dự Án',
        'url' => '#',
        'submenu' => [
            [
                'name' => 'Phân quận',
                'url' => '/admin/list-user-district',
                'class-icon' => ''
            ],
            [
                'name' => '<div class="text-primary"> DS Dự Án (thẻ) </div>',
                'url' => '/admin/list-apartment',
                'class-icon' => ''
            ],
            [
                'name' => '<div class="text-danger"> DS Dự Án (bảng) </div>',
                'url' => '/admin/list-apartment-like-base',
                'class-icon' => ''
            ],
            [
                'name' => 'Danh Sách Hoa Hồng Ký Gửi',
                'url' => '/admin/list-apartment-commission-rate',
                'submenu' => null
            ],
        ]
    ],
    [
        'name' => 'Google Drive',
        'url' => '/admin/list-google',
        'submenu' => null
    ],
    [
        'name' => 'Báo cáo dẫn khách',
        'url' => '/admin/list-rp-booking-customer',
        'submenu' => null
    ],
    [
        'name' => 'Bảng điều khiển',
        'url' => '/admin/list-dashboard',
        'submenu' => null
    ]
];

$accesscontrol['human-resources'] = [
    [
        'name' => 'Bảng điều khiển',
        'url' => '/admin/list-dashboard',
        'submenu' => null
    ],
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
    [
        'name' => 'DS Thành Viên',
        'url' => '/admin/list-user',
        'class-icon' => null,
        'submenu' => [
            [
                'name' => 'DS Quyền',
                'url' => '/admin/list-role',
                'submenu' => null
            ],
        ]
    ]
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
    [
        'name' => 'Bảng điều khiển',
        'url' => '/admin/list-dashboard',
        'submenu' => null
    ]
];
$accesscontrol['ceo'] = [
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
    [
        'name' => 'Báo cáo Chăm sóc',
        'url' => '/admin/list-care-customer',
        'submenu' => null
    ],
    [
        'name' => 'Danh Sách Hoa Hồng Ký Gửi',
        'url' => '/admin/list-apartment-commission-rate',
        'submenu' => null
    ],
    [
        'name' => 'Bảng điều khiển',
        'url' => '/admin/list-dashboard',
        'submenu' => null
    ],
    [
        'name' => 'Quản lý chi phí',
        'url' => '/admin/list-service',
        'submenu' => null
    ]
];

$accesscontrol['customer-care'] = [
    [
        'name' => 'Khách Hàng',
        'url' => '#',
        'submenu' => [
            [
                'name' => 'DS Khách Hàng',
                'url' => '/admin/list-customer',
                'submenu' => null
            ],
            [
                'name' => 'Thống Kê Chăm sóc',
                'url' => '/admin/list-care-customer',
                'submenu' => null
            ],
            [
                'name' => 'Hợp Đồng',
                'url' => '/admin/list-contract',
                'submenu' => null
            ],
            [
                'name' => 'Danh Sách Hoa Hồng Ký Gửi',
                'url' => '/admin/list-apartment-commission-rate',
                'submenu' => null
            ],
        ]
    ],
    [
        'name' => 'Bảng điều khiển',
        'url' => '/admin/list-dashboard',
        'submenu' => null
    ],
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

