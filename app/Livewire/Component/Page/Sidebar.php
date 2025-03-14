<?php

namespace App\Livewire\Component\Page;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Sidebar extends Component
{
    public $menuUsers = [];
    protected $menus = [
        [
            'title' => 'Dashboard',
            'menus' => [
                [
                    'name' => 'Dashboard',
                    'url' => '/dashboard',
                    'route' => 'dashboard.index',
                    'icon' => 'bx bx-home-circle',
                    'permission' => 'view:dashboard'
                ],
            ]
        ],
        [
            'title' => 'Master Data',
            'menus' => [
                [
                    'name' => 'Import Master Data',
                    'url' => '/import-master-data',
                    'route' => 'import.index',
                    'icon' => 'bx bx-upload',
                    'permission' => 'view:import_master_data',
                ],
                [
                    'name' => 'Status Inventory',
                    'url' => '/status-inventory',
                    'route' => 'status-inventory.index',
                    'icon' => 'bx bx-upload',
                    'permission' => 'view:status-inventory',
                ],
                [
                    'name' => 'Machine',
                    'url' => '/machine',
                    'route' => 'machine.index',
                    'icon' => 'bx bx-fingerprint',
                    'permission' => 'view:machine',
                ],
                [
                    'name' => 'Site',
                    'url' => '/site',
                    'route' => 'site.index',
                    'icon' => 'bx bx-building-house',
                    'permission' => 'view:site'
                ],
                [
                    'name' => 'Department',
                    'url' => '/department',
                    'route' => 'department.index',
                    'icon' => 'bx bxl-codepen',
                    'permission' => 'view:department'
                ],
                [
                    'name' => 'Position',
                    'url' => '/position',
                    'route' => 'position.index',
                    'icon' => 'bx bx-briefcase-alt-2',
                    'permission' => 'view:position'
                ],
                [
                    'name' => 'Role',
                    'url' => '/role',
                    'route' => 'role.index',
                    'icon' => 'bx bxs-key',
                    'permission' => 'view:role'
                ],
                // [
                //     'name' => 'User',
                //     'url' => '/user',
                //     'route' => 'user.index',
                //     'icon' => 'bx bx-user-circle',
                //     'permission' => 'view:user'
                // ],
                [
                    'name' => 'Employee',
                    'url' => '/employee',
                    'route' => 'employee.index',
                    'icon' => 'bx bxs-user-circle',
                    'permission' => 'view:employee'
                ],

            ]
        ],
        [
            'title' => 'Administrator',
            'menus' => [
                // [
                //     'name' => 'Daily Report All',
                //     'url' => '/daily-report-all',
                //     'route' => 'daily-report.index',
                //     'icon' => 'bx bxs-report',
                //     'permission' => 'view:daily-report-all'
                // ],
                [
                    'name' => 'Attendance All',
                    'url' => '/attendance-all',
                    'route' => 'attendance.all',
                    'icon' => 'bx bx-purchase-tag-alt',
                    'permission' => 'view:attendance-all',
                ],
                [
                    'name' => 'Absent Request All',
                    'url' => '/absent-request-all',
                    'route' => 'absent-request.all',
                    'icon' => 'bx bxs-tired',
                    'permission' => 'view:absent-request-all',
                ],
                [
                    'name' => 'Leave Request All',
                    'url' => '/leave-request-all',
                    'route' => 'leave-request.all',
                    'icon' => 'bx bx-log-out-circle',
                    'permission' => 'view:leave-request-all',
                ],
            ]
        ],
        [
            'title' => 'Application',
            'menus' => [
                [
                    'name' => 'Project',
                    'url' => '/project',
                    'icon' => 'bx bx-briefcase-alt',
                    'permission' => 'view:project',
                    'subMenus' => [
                        [
                            'name' => 'Client',
                            'url' => '/client',
                            'route' => 'client-project.index',
                            'icon' => 'bx bx-user',
                            'permission' => 'view:client'
                        ],
                        [
                            'name' => 'Category Project',
                            'url' => '/category-project',
                            'route' => 'category-project.index',
                            'icon' => 'bx bx-category',
                            'permission' => 'view:category-project'
                        ],
                        [
                            'name' => 'My Project',
                            'url' => '/project',
                            'route' => 'project.index',
                            'icon' => 'bx bx-log-out-circle',
                            'permission' => 'view:project'
                        ],
                        [
                            'name' => 'Team Project',
                            'url' => '/project/team',
                            'route' => 'project-team.index',
                            'icon' => 'bx bx-log-out-circle',
                            'permission' => 'view:project'
                        ],
                    ],
                ],
                [
                    'name' => 'Attendance',
                    'url' => '/attendance',
                    'route' => 'attendance.index',
                    'icon' => 'bx bx-purchase-tag-alt',
                    'permission' => 'view:attendance'
                ],
                [
                    'name' => 'Absent Request',
                    'icon' => 'bx bxs-tired',
                    'url' => '/absent-request',
                    'permission' => 'view:absent-request',
                    'subMenus' => [
                        [
                            'name' => 'My Absent Request',
                            'url' => '/absent-request',
                            'route' => 'absent-request.index',
                            'icon' => 'bx bxs-tired',
                            'permission' => 'view:absent-request'
                        ],
                        [
                            'name' => 'Team Absent Request',
                            'url' => '/absent-request/team',
                            'route' => 'team-absent-request.index',
                            'icon' => 'bx bxs-tired',
                            'permission' => 'view:absent-request'
                        ],
                    ],
                ],
                [
                    'name' => 'Leave Request',
                    'url' => '/leave-request',
                    'icon' => 'bx bx-log-out-circle',
                    'permission' => 'view:leave-request',
                    'subMenus' => [
                        [
                            'name' => 'My Leave Request',
                            'url' => '/leave-request',
                            'route' => 'leave-request.index',
                            'icon' => 'bx bx-log-out-circle',
                            'permission' => 'view:leave-request'
                        ],
                        [
                            'name' => 'Team Leave Request',
                            'url' => '/leave-request/team',
                            'route' => 'team-leave-request.index',
                            'icon' => 'bx bx-log-out-circle',
                            'permission' => 'view:leave-request'
                        ],
                    ],
                ],
                [
                    'name' => 'Inventory',
                    'url' => '/inventory',
                    'icon' => 'bx bx-building-house',
                    'permission' => 'view:inventory',
                    'subMenus' => [
                        [
                            'name' => 'Category Inventory',
                            'url' => '/category-inventory',
                            'route' => 'category.index',
                            'icon' => 'bx bx-log-out-circle',
                            'permission' => 'view:category-inventory'
                        ],
                        [
                            'name' => 'Inventory',
                            'url' => '/inventory',
                            'route' => 'inventory.index',
                            'icon' => 'bx bx-log-out-circle',
                            'permission' => 'view:inventory'
                        ],
                        [
                            'name' => 'Employee Inventory',
                            'url' => '/employee-inventory',
                            'route' => 'employee-inventory.index',
                            'icon' => 'bx bx-log-out-circle',
                            'permission' => 'view:employee-inventory'
                        ],
                        [
                            'name' => 'Item Request',
                            'url' => '/item-request',
                            'route' => 'request-item.index',
                            'icon' => 'bx bx-log-out-circle',
                            'permission' => 'view:item-request'
                        ],
                    ],
                ],
                [
                    'name' => 'Announcement',
                    'url' => '/announcement',
                    'route' => 'announcement.index',
                    'icon' => 'bx bx-error-circle',
                    'permission' => 'view:announcement'
                ],
                // [
                //     'name' => 'Financial Request',
                //     'url' => '/financial-request',
                //     'route' => 'financial-request.index',
                //     'icon' => 'bx bxs-bank',
                //     'permission' => 'view:financial-request-all'
                // ],
                // [
                //     'name' => 'Financial Request',
                //     'url' => '/financial-request',
                //     'icon' => 'bx bxs-bank',
                //     'permission' => 'view:financial-request',
                //     'subMenus' => [
                //         [
                //             'name' => 'My Financial Request',
                //             'url' => '/financial-request',
                //             'route' => 'financial-request.index',
                //             'icon' => 'bx bxs-bank',
                //             'permission' => 'view:financial-request'
                //         ],
                //         [
                //             'name' => 'Team Financial Request',
                //             'url' => '/financial-request/team',
                //             'route' => 'team-financial-request.index',
                //             'icon' => 'bx bxs-bank',
                //             'permission' => 'view:financial-request'
                //         ],
                //     ]
                // ]
            ]
        ],
        [
            'title' => 'Other',
            'menus' => [
                [
                    'name' => 'Email Template',
                    'url' => '/email-template',
                    'route' => 'email-template.index',
                    'icon' => 'bx bx-code-curly',
                    'permission' => 'view:email-template'
                ],
            ]
        ],
         [
             'title' => 'Report',
             'menus' => [
                 [
                     'name' => 'Report Attendance',
                     'url' => '/report-attendance',
                     'route' => 'report.attendance',
                     'icon' => 'bx bx-bar-chart-alt-2',
                     'permission' => 'view:report'
                 ],
                // [
                //     'name' => 'Report absent',
                //     'url' => '/report-absent-request',
                //     'route' => 'report-absent-request.index',
                //     'icon' => 'bx bx-bar-chart-alt-2',
                //     'permission' => 'view:report-absent-request'
                // ],
                // [
                //     'name' => 'Report Leave',
                //     'url' => '/report-leave-request',
                //     'route' => 'report-leave-request.index',
                //     'icon' => 'bx bx-bar-chart-alt-2',
                //     'permission' => 'view:report-leave-request'
                // ],
                // [
                //     'name' => 'Report Financial',
                //     'url' => '/report-financial-request',
                //     'route' => 'report-financial-request.index',
                //     'icon' => 'bx bx-bar-chart-alt-2',
                //     'permission' => 'view:report-financial-request'
                // ],
                // [
                //     'name' => 'Report Visit',
                //     'url' => '/report-visit-request',
                //     'route' => 'report-visit-request.index',
                //     'icon' => 'bx bx-bar-chart-alt-2',
                //     'permission' => 'view:report-visit'
                // ],
            ]
        ],
        // [
        //     'title' => 'Setting',
        //     'menus' => [
        //         [
        //             'name' => 'Setting',
        //             'url' => '/setting',
        //             'route' => 'setting.index',
        //             'icon' => 'bx bx-cog',
        //             'permission' => 'view:setting'
        //         ],
        //     ]
        // ],
    ];

    public function filterMenus()
    {
        $user = Auth::user(); // Mendapatkan user yang sedang login
        $this->menuUsers = [];

        foreach ($this->menus as $menu) {
            $filteredMenus = [];

            foreach ($menu['menus'] as $subMenu) {
                $hasPermission = $user->hasPermissionTo($subMenu['permission']);

                if (isset($subMenu['subMenus'])) {
                    $filteredSubMenus = [];
                    foreach ($subMenu['subMenus'] as $subSubMenu) {
                        if ($user->hasPermissionTo($subSubMenu['permission'])) {
                            $filteredSubMenus[] = [
                                'name' => $subSubMenu['name'],
                                'url' => $subSubMenu['url'],
                                'route' => $subSubMenu['route'],
                                'icon' => $subSubMenu['icon'],
                                'permission' => $subSubMenu['permission']
                            ];
                        }
                    }
                    if (!empty($filteredSubMenus)) {
                        $filteredMenus[] = [
                            'name' => $subMenu['name'],
                            'icon' => $subMenu['icon'],
                            'permission' => $subMenu['permission'],
                            'subMenus' => $filteredSubMenus
                        ];
                    }
                } elseif ($hasPermission) {
                    $filteredMenus[] = [
                        'name' => $subMenu['name'],
                        'url' => $subMenu['url'],
                        'route' => $subMenu['route'],
                        'icon' => $subMenu['icon'],
                        'permission' => $subMenu['permission']
                    ];
                }
            }

            if (!empty($filteredMenus)) {
                $this->menuUsers[] = ['title' => $menu['title'], 'menus' => $filteredMenus];
            }
        }
    }

    public function mount()
    {
        $this->filterMenus();
    }

    public function render()
    {
        return view('livewire.component.page.sidebar');
    }
}
