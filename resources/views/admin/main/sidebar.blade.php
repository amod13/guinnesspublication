<div id="amdSidebar" class="amd-sidebar expanded shadow-sm">
    <div class="close-btn d-md-none text-end px-3 pt-3">
        <i class="fas fa-times fa-lg" id="closeSidebar" style="cursor: pointer; color: var(--light-text);"></i>
    </div>
    <div class="amd-logo ">
        <a href="{{ route('adminLayout') }}">
            <img src="https://amdsoft.com.np/wp-content/uploads/2024/10/amd-jpg-01.jpg" alt=""
                style="height: 40px; width: auto; object-fit: contain; ">
        </a>
    </div>
    <hr>

    {{-- Sidebar Menu Appended From A Components --}}
    @php
        $menuItems = [
            [
                'title' => 'Dashboard',
                'icon' => 'fas fa-home amd-icon-color4',
                'route' => 'adminLayout',
                'permission' => ['controller' => 'DashboardManagementController', 'method' => 'adminLayout'],
            ],
            [
                'title' => 'User Manage',
                'icon' => 'fas fa-user amd-icon-color6',
                'iconColor' => 'icon-color-7',
                'submenu' => [
                    [
                        'title' => 'Role',
                        'route' => 'role.index',
                        'route_pattern' => 'role.*',
                        'permission' => ['controller' => 'RoleController', 'method' => 'index'],
                    ],
                    [
                        'title' => 'Permission',
                        'route' => 'permission.index',
                        'route_pattern' => 'permission.*',
                        'permission' => ['controller' => 'PermissionController', 'method' => 'index'],
                    ],
                    [
                        'title' => 'Users',
                        'route' => 'user.index',
                        'route_pattern' => 'user.*',
                        'permission' => ['controller' => 'UserController', 'method' => 'index'],
                    ],
                ],
            ],
            [
                'title' => 'Media Library',
                'icon' => 'fas fa-photo-video amd-icon-color4',
                'route' => 'media-library.index',
                'permission' => ['controller' => 'MediaLibraryController', 'method' => 'index'],
            ],
            [
                'title' => 'Pages',
                'icon' => 'fas fa-file amd-icon-color8',
                'route' => 'page.index',
                'route_pattern' => 'page.*',
                'permission' => ['controller' => 'PageController', 'method' => 'index'],
            ],
            [
                'title' => 'Menus',
                'icon' => 'fas fa-list amd-icon-color4',
                'route' => 'menu.index',
                'route_pattern' => 'menu.*',
                'permission' => ['controller' => 'MenuController', 'method' => 'index'],
            ],
            [
                'title' => 'Employee Manage',
                'icon' => 'fas fa-person amd-icon-color2',
                'iconColor' => 'icon-color-9',
                'submenu' => [
                    [
                        'title' => 'Designations',
                        'route' => 'designation.index',
                        'route_pattern' => 'designation.*',
                        'permission' => ['controller' => 'DesignationController', 'method' => 'index'],
                    ],
                    [
                        'title' => 'Departments',
                        'route' => 'department.index',
                        'route_pattern' => 'department.*',
                        'permission' => ['controller' => 'DepartmentController', 'method' => 'index'],
                    ],
                    [
                        'title' => 'Sub Departments',
                        'route' => 'subdepartment.index',
                        'route_pattern' => 'subdepartment.*',
                        'permission' => ['controller' => 'SubDepartmentController', 'method' => 'index'],
                    ],
                    [
                        'title' => 'Employees',
                        'route' => 'employee.index',
                        'route_pattern' => 'employee.*',
                        'permission' => ['controller' => 'EmployeeController', 'method' => 'index'],
                    ],
                ],
            ],

            [
                'title' => 'Content Manage',
                'icon' => 'fas fa-pen-nib amd-icon-color5',
                'iconColor' => 'icon-color-9',
                'submenu' => [
                    [
                        'title' => 'Sliders',
                        'route' => 'slider.index',
                        'route_pattern' => 'slider.*',
                        'permission' => ['controller' => 'SliderController', 'method' => 'index'],
                    ],
                    [
                        'title' => 'About Us',
                        'route' => 'about-us.index',
                        'route_pattern' => 'about-us.*',
                        'permission' => ['controller' => 'AboutUsController', 'method' => 'index'],
                    ],
                ],
            ],
            [
                'title' => 'Book Manage',
                'icon' => 'fas fa-book amd-icon-color5',
                'iconColor' => 'icon-color-9',
                'submenu' => [
                    [
                        'title' => 'Book Categories',
                        'route' => 'bookcategories.index',
                        'route_pattern' => 'bookcategories.*',
                        'permission' => ['controller' => 'BookCategoriesController', 'method' => 'index'],
                    ],
                    [
                        'title' => 'Books',
                        'route' => 'books.index',
                        'route_pattern' => 'books.*',
                        'permission' => ['controller' => 'BookController', 'method' => 'index'],
                    ],
                ],
            ],

                [
                'title' => 'Gallery Manage',
                'icon' => 'fas fa-photo-video amd-icon-color5',
                'iconColor' => 'icon-color-9',
                'submenu' => [
                    [
                        'title' => 'Gallery Categories',
                        'route' => 'gallery-category.index',
                        'route_pattern' => 'gallery-category.*',
                        'permission' => ['controller' => 'GalleryCategoryController', 'method' => 'index'],
                    ],
                    [
                        'title' => 'Galleries',
                        'route' => 'gallery.index',
                        'route_pattern' => 'gallery.*',
                        'permission' => ['controller' => 'GalleryController', 'method' => 'index'],
                    ],
                ],
            ],

                [
                'title' => 'Dealers',
                'icon' => 'fas fa-building amd-icon-color6',
                'route' => 'dealers.index',
                'route_pattern' => 'dealers.*',
                'permission' => ['controller' => 'DealersController', 'method' => 'index'],
            ],

            [
                'title' => 'Marketings',
                'icon' => 'fas fa-calendar-check amd-icon-color1',
                'route' => 'marketings.index',
                'route_pattern' => 'marketings.*',
                'permission' => ['controller' => 'MarketingsController', 'method' => 'index'],
            ],

            [
                'title' => 'Settings',
                'icon' => 'fas fa-cog amd-icon-color5',
                'iconColor' => 'icon-color-9',
                'submenu' => [
                    [
                        'title' => 'Theme Settings',
                        'route' => 'theme-settings.index',
                        'route_pattern' => 'theme-settings.*',
                        'permission' => ['controller' => 'ThemeSettingController', 'method' => 'index'],
                    ],
                    [
                        'title' => 'General Settings',
                        'route' => 'setting.index',
                        'route_pattern' => 'setting.*',
                        'permission' => ['controller' => 'SettingController', 'method' => 'index'],
                    ],
                ],
            ],
        ];
    @endphp

    <x-ui.sidebar-menu :items="$menuItems" />

</div>
