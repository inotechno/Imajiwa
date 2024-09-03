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

        $commissioner = Role::updateOrCreate([
            'name' => 'Commissioner',
        ]);

        $employee = Role::updateOrCreate([
            'name' => 'Employee',
        ]);

        $project_manager = Role::updateOrCreate([
            'name' => 'Project Manager',
        ]);

        $permissions = [
            // Dashboard
            'view:dashboard' => ['Commissioner','Employee', 'HR', 'Finance', 'Director', 'Administrator', 'Project Manager'],

            // Import Master Data
            'view:import_master_data' => ['HR', 'Administrator'],

            // Export Master Data
            'view:export_master_data' => ['HR', 'Administrator'],

            // User
            'view:user' => ['HR', 'Director', 'Administrator'],
            'create:user' => ['HR', 'Administrator'],
            'update:user' => ['HR', 'Administrator'],
            'delete:user' => ['HR', 'Administrator'],

            // Employee
            'view:employee' => ['HR', 'Director', 'Administrator'],
            'create:employee' => ['HR', 'Administrator'],
            'update:employee' => ['HR', 'Administrator'],
            'delete:employee' => ['HR', 'Administrator'],

            // Position
            'view:position' => ['HR', 'Director', 'Administrator'],
            'create:position' => ['HR', 'Administrator'],
            'update:position' => ['HR', 'Administrator'],
            'delete:position' => ['HR', 'Administrator'],

            // Department
            'view:department' => ['Finance', 'HR', 'Director', 'Administrator'],
            'create:department' => ['Administrator'],
            'update:department' => ['Administrator'],
            'delete:department' => ['Administrator'],

            // Site
            'view:site' => ['HR', 'Director', 'Administrator'],
            'create:site' => ['HR', 'Administrator'],
            'update:site' => ['HR', 'Administrator'],
            'delete:site' => ['HR', 'Administrator'],

            // Visit
            'view:visit-all' => ['HR', 'Director', 'Administrator'],
            'view:visit' => ['Employee', 'HR', 'Director', 'Administrator'],
            'create:visit' => ['Employee', 'Administrator'],
            'update:visit' => ['Administrator'],
            'delete:visit' => ['Administrator'],

            // Visit Category
            'view:visit-category' => ['Administrator'],
            'create:visit-category' => ['Administrator'],
            'update:visit-category' => ['Administrator'],
            'delete:visit-category' => ['Administrator'],

            // Email Template
            'view:email-template' => ['Administrator'],
            'create:email-template' => ['Administrator'],
            'update:email-template' => ['Administrator'],
            'delete:email-template' => ['Administrator'],

            // Machine
            'view:machine' => ['Administrator'],
            'create:machine' => ['Administrator'],
            'update:machine' => ['Administrator'],
            'delete:machine' => ['Administrator'],

            // Attendance
            'view:attendance-all' => ['Finance', 'Director', 'HR', 'Administrator'],
            'view:attendance' => ['Employee','Finance', 'Director', 'HR', 'Administrator'],
            'create:attendance' => ['Employee', 'Administrator'],
            'update:attendance' => ['Administrator'],
            'delete:attendance' => ['Administrator'],

            // Attendance Temp
            'view:attendance-temp-all' => ['HR', 'Administrator'],
            'view:attendance-temp' => ['Employee','HR', 'Administrator'],
            'create:attendance-temp' => ['Employee', 'Administrator'],
            'update:attendance-temp' => ['Administrator'],
            'delete:attendance-temp' => ['Administrator'],
            'approve:attendance-temp' => ['Administrator', 'HR'],

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
            'view:daily-report-all' => ['HR', 'Director', 'Administrator'],
            'view:daily-report' => ['Employee'],
            'create:daily-report' => ['Employee'],
            'update:daily-report' => ['Employee', 'Administrator'],
            'delete:daily-report' => ['Employee', 'Administrator'],

            // Announcement
            'view:announcement' => ['HR', 'Employee', 'Finance', 'Director', 'Administrator'],
            'create:announcement' => ['HR', 'Administrator'],
            'update:announcement' => ['HR', 'Administrator'],
            'delete:announcement' => ['HR', 'Administrator'],

            // Financial Request
            'view:financial-request-all' => ['HR', 'Director', 'Finance', 'Administrator'],
            'view:financial-request' => ['Employee', 'HR', 'Director', 'Finance', 'Administrator'],
            'create:financial-request' => ['Employee'],
            'update:financial-request' => ['Finance', 'Administrator'],
            'delete:financial-request' => ['Finance', 'Administrator'],
            'approve:financial-request' => ['Employee', 'Finance', 'Director', 'Administrator'],

            // absent Request
            'view:absent-request-all' => ['HR', 'Director', 'Administrator'],
            'view:absent-request' => ['Employee'],
            'create:absent-request' => ['Employee'],
            'update:absent-request' => ['Employee', 'HR', 'Administrator'],
            'delete:absent-request' => ['Employee', 'HR', 'Administrator'],
            'approve:absent-request' => ['Employee', 'HR', 'Director', 'Administrator'],

            // Leave Request
            'view:leave-request-all' => ['HR', 'Director', 'Administrator'],
            'view:leave-request' => ['Employee'],
            'create:leave-request' => ['Employee'],
            'update:leave-request' => ['Employee', 'HR', 'Administrator'],
            'delete:leave-request' => ['Employee', 'HR', 'Administrator'],
            'approve:leave-request' => ['Employee', 'HR', 'Director', 'Administrator'],

            // Report
            'view:report-attendance' => ['Employee', 'Finance', 'HR', 'Director', 'Administrator'],
            'view:report-daily-report' => ['Employee', 'Finance', 'HR', 'Director', 'Administrator'],
            'view:report-financial-request' => ['Employee', 'Finance', 'Director', 'Administrator'],
            'view:report-absent-request' => ['Employee', 'HR', 'Director', 'Administrator'],
            'view:report-leave-request' => ['Employee', 'HR', 'Director', 'Administrator'],
            'view:report-visit' => ['Employee', 'HR', 'Director', 'Administrator'],

            // Project
            'view:project-all' => ['HR', 'Director', 'Administrator' , 'Project Manager', 'Employee'],
            'view:project' => ['Employee', 'Project Manager'],
            'create:project' => ['Administrator', 'Project Manager'],
            'update:project' => ['Administrator', 'Project Manager'],
            'delete:project' => ['Administrator', 'Project Manager'],

            // Profile
            'view:profile' => ['Employee', 'HR', 'Director', 'Project Manager', 'Finance'],
            'update:profile' => ['Employee', 'HR', 'Director', 'Project Manager', 'Finance'],
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
