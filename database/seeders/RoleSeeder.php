<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $administrator = Role::updateOrCreate([
            'name' => 'Administrator',
        ]);

        $director = Role::updateOrCreate([
            'name' => 'Director',
        ]);

        $finance = Role::updateOrCreate([
            'name' => 'Finance',
        ]);

        $hr = Role::updateOrCreate([
            'name' => 'HR',
        ]);

        $employee = Role::updateOrCreate([
            'name' => 'Employee',
        ]);

        $commissioner = Role::updateOrCreate([
            'name' => 'Commissioner',
        ]);

        $project_manager = Role::updateOrCreate([
            'name' => 'Project Manager',
        ]);


        $permissions = [
            // Dashboard
            'view:dashboard' => ['Commissioner', 'Employee', 'HR', 'Finance', 'Director', 'Administrator', 'Project Manager'],

            // Import Master Data
            'view:import_master_data' => ['Finance', 'Administrator'],

            // Export Master Data
            'view:export_master_data' => ['Finance', 'Administrator'],

            // User
            'view:user' => ['Finance', 'Administrator'],
            'create:user' => ['Finance', 'Administrator'],
            'update:user' => ['Finance', 'Administrator'],
            'delete:user' => ['Finance', 'Administrator'],

            // Employee
            'view:employee' => ['Finance', 'Administrator'],
            'create:employee' => ['Finance', 'Administrator'],
            'update:employee' => ['Finance', 'Administrator'],
            'delete:employee' => ['Finance', 'Administrator'],
            'permission:employee' => ['Administrator'],

            // Position
            'view:position' => ['Administrator'],
            'create:position' => ['Administrator'],
            'update:position' => ['Administrator'],
            'delete:position' => ['Administrator'],

            // Department
            'view:department' => ['Administrator'],
            'create:department' => ['Administrator'],
            'update:department' => ['Administrator'],
            'delete:department' => ['Administrator'],

            // Site
            'view:site' =>   ['Administrator'],
            'create:site' => ['Administrator'],
            'update:site' => ['Administrator'],
            'delete:site' => ['Administrator'],

            // Visit
            'view:visit-all' => ['Finance', 'HR', 'Administrator'],
            'view:visit' => ['Finance', 'Employee', 'HR', 'Administrator'],
            'create:visit' => ['Finance', 'Employee', 'Administrator'],
            'update:visit' => ['Finance', 'Administrator'],
            'delete:visit' => ['Finance', 'Administrator'],

            // Visit Category
            'view:visit-category' => ['Finance', 'Administrator'],
            'create:visit-category' => ['Finance', 'Administrator'],
            'update:visit-category' => ['Finance', 'Administrator'],
            'delete:visit-category' => ['Finance', 'Administrator'],

            // Email Template
            'view:email-template' => ['Finance', 'Administrator'],
            'create:email-template' => ['Finance', 'Administrator'],
            'update:email-template' => ['Finance', 'Administrator'],
            'delete:email-template' => ['Finance', 'Administrator'],

            // Machine
            'view:machine' => ['Administrator'],
            'create:machine' => ['Administrator'],
            'update:machine' => ['Administrator'],
            'delete:machine' => ['Administrator'],

            // Attendance
            'view:attendance-all' => ['Finance', 'Administrator'],
            'view:attendance' => ['Employee', 'Finance', 'Director', 'Administrator'],
            'create:attendance' => ['Employee', 'Administrator'],
            'update:attendance' => ['Finance', 'Administrator'],
            'delete:attendance' => ['Finance', 'Administrator'],

            // Attendance Temp
            'view:attendance-temp-all' => ['Finance', 'HR', 'Administrator'],
            'view:attendance-temp' => ['Finance', 'Employee', 'HR', 'Administrator'],
            'create:attendance-temp' => ['Employee', 'Administrator'],
            'update:attendance-temp' => ['Administrator'],
            'delete:attendance-temp' => ['Administrator'],
            'approve:attendance-temp' => ['Administrator', 'Finance', 'HR'],

            // Role
            'view:role' => ['Administrator'],
            'create:role' => ['Administrator'],
            'update:role' => ['Administrator'],
            'delete:role' => ['Administrator'],

            // Permission
            'view:permission' => ['Administrator'],
            'create:permission' => ['Administrator'],
            'update:permission' => ['Administrator'],
            'delete:permission' => ['Administrator'],

            // Settings
            'view:setting' => ['Administrator'],
            'create:setting' => ['Administrator'],
            'update:setting' => ['Administrator'],
            'delete:setting' => ['Administrator'],

            // Daily Report
            // 'view:daily-report-all' => ['Finance','HR', 'Director', 'Administrator'],
            // 'view:daily-report' => ['Employee'],
            // 'create:daily-report' => ['Employee'],
            // 'update:daily-report' => ['Employee', 'Administrator'],
            // 'delete:daily-report' => ['Employee', 'Administrator'],

            // Announcement
            'view:announcement' => ['Finance', 'Administrator'],
            'create:announcement' => ['Finance', 'Administrator'],
            'update:announcement' => ['Finance', 'Administrator'],
            'delete:announcement' => ['Finance', 'Administrator'],

            // Financial Request
            'view:financial-request-all' => ['HR', 'Director', 'Finance', 'Administrator'],
            'view:financial-request' => ['Employee', 'HR', 'Director', 'Finance', 'Administrator'],
            'create:financial-request' => ['Employee'],
            'update:financial-request' => ['Finance', 'Administrator'],
            'delete:financial-request' => ['Finance', 'Administrator'],
            'approve:financial-request' => ['Employee', 'Finance', 'Director', 'Administrator'],

            // absent Request
            'view:absent-request-all' => ['Finance', 'Administrator'],
            'view:absent-request' => ['Employee'],
            'create:absent-request' => ['Employee'],
            'update:absent-request' => ['Employee', 'HR', 'Finance', 'Administrator'],
            'delete:absent-request' => ['Employee', 'HR', 'Finance', 'Administrator'],
            'approve:absent-request' => ['Employee', 'HR', 'Finance', 'Director', 'Administrator'],

            // Leave Request
            'view:leave-request-all' => ['Finance', 'Administrator'],
            'view:leave-request' => ['Employee'],
            'create:leave-request' => ['Employee'],
            'update:leave-request' => ['Employee', 'HR', 'Finance', 'Administrator'],
            'delete:leave-request' => ['Employee', 'HR', 'Finance', 'Administrator'],
            'approve:leave-request' => ['Employee', 'HR', 'Finance', 'Director', 'Administrator'],

            // Report
            'view:report' => ['Finance', 'Administrator'],

            // Project
            'view:project-all' => ['HR', 'Finance', 'Director', 'Administrator', 'Project Manager', 'Employee', 'commissioner'],
            'view:project' => ['Employee', 'Project Manager'],
            'create:project' => ['Administrator', 'Project Manager'],
            'update:project' => ['Administrator', 'Project Manager'],
            'delete:project' => ['Administrator', 'Project Manager'],
            'export:project' => ['Administrator', 'Finance', 'Project Manager'],

            'view:client' => ['Administrator', 'Project Manager'],
            'create:client' => ['Administrator', 'Project Manager'],
            'update:client' => ['Administrator', 'Project Manager'],
            'delete:client' => ['Administrator', 'Project Manager'],

            // Category Project
            'view:category-project' => ['Administrator', 'Project Manager'],
            'create:category-project' => ['Administrator', 'Project Manager'],
            'update:category-project' => ['Administrator', 'Project Manager'],
            'delete:category-project' => ['Administrator',  'Project Manager'],

            // Profile
            'view:profile' => ['Employee', 'HR', 'Director', 'Project Manager', 'Finance', 'commissioner'],
            'update:profile' => ['Employee', 'HR', 'Director', 'Project Manager', 'Finance', 'commissioner'],

            //inventory
            'view:category-inventory-all' => ['Finance', 'Director', 'Administrator', 'commissioner'],
            'view:category-inventory' => ['Finance', 'Administrator'],
            'create:category-inventory' => ['Finance', 'Administrator'],
            'update:category-inventory' => ['Finance', 'Administrator'],
            'delete:category-inventory' => ['Finance', 'Administrator'],

            //inventory
            'view:inventory-all' => ['HR', 'Finance', 'Director', 'Administrator', 'commissioner'],
            'view:inventory' => ['Finance', 'Administrator'],
            'create:inventory' => ['Finance', 'Administrator'],
            'update:inventory' => ['Finance', 'Administrator'],
            'delete:inventory' => ['Finance', 'Administrator'],

            //request item
            'view:item-request-all' => ['HR', 'Finance', 'Director', 'Administrator', 'commissioner'],
            'view:item-request' => ['Finance', 'Administrator'],
            'create:item-request' => ['Finance', 'Administrator'],
            'update:item-request' => ['Finance', 'Administrator'],
            'delete:item-request' => ['Finance', 'Administrator'],
            'approve:item-request' => ['Director', 'commissioner'],

            'view:employee-inventory' => ['Finance', 'Administrator'],
            'create:employee-inventory' => ['Finance', 'Administrator'],
            'update:employee-inventory' => ['Finance', 'Administrator'],
            'delete:employee-inventory' => ['Finance', 'Administrator'],

            'view:status-inventory' => ['Finance', 'Administrator'],
            'create:status-inventory' => ['Finance', 'Administrator'],
            'update:status-inventory' => ['Finance', 'Administrator'],
            'delete:status-inventory' => ['Finance', 'Administrator'],
        ];

        foreach ($permissions as $permissionName => $roles) {
            $permission = Permission::updateOrCreate([
                'name' => $permissionName,
                'guard_name' => 'web',
            ]);

            // Assign permission to roles
            foreach ($roles as $roleName) {
                $role = Role::updateOrCreate(['name' => $roleName]);
                $role->givePermissionTo($permission);
            }
        }
    }
}
