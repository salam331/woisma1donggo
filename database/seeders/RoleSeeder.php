<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create roles
        $admin = Role::firstOrCreate(['name' => 'admin']);
        $guru = Role::firstOrCreate(['name' => 'guru']);
        $siswa = Role::firstOrCreate(['name' => 'siswa']);
        $orang_tua = Role::firstOrCreate(['name' => 'orang_tua']);
        $publik = Role::firstOrCreate(['name' => 'publik']);

        // Create all permissions first
        $permissions = [
            // User management
            'view users', 'create users', 'edit users', 'delete users', 'show users',
            // Teacher management
            'view teachers', 'create teachers', 'edit teachers', 'delete teachers', 'show teachers',
            // Student management
            'view students', 'create students', 'edit students', 'delete students', 'show students',
            // Parent management
            'view parents', 'create parents', 'edit parents', 'delete parents', 'show parents',
            // Class management
            'view classes', 'create classes', 'edit classes', 'delete classes', 'show classes',
            // Subject management
            'view subjects', 'create subjects', 'edit subjects', 'delete subjects', 'show subjects',
            // Material management
            'view materials', 'create materials', 'edit materials', 'delete materials', 'show materials',
            // Schedule management
            'view schedules', 'create schedules', 'edit schedules', 'delete schedules', 'show schedules',
            // Attendance management
            'view attendances', 'create attendances', 'edit attendances', 'delete attendances', 'show attendances', 'summary attendances',
            // Grade management
            'view grades', 'create grades', 'edit grades', 'delete grades', 'show grades',
            // Exam management
            'view exams', 'create exams', 'edit exams', 'delete exams', 'show exams',
            // Invoice management
            'view invoices', 'create invoices', 'edit invoices', 'delete invoices', 'show invoices',
            // School profile management
            'view school-profiles', 'edit school-profiles',
            // Announcement management
            'view announcements', 'create announcements', 'edit announcements', 'delete announcements', 'show announcements',
            // Gallery management
            'view galleries', 'create galleries', 'edit galleries', 'delete galleries', 'show galleries',
            // Contact messages management
            'view contact-messages', 'create contact-messages', 'edit contact-messages', 'delete contact-messages', 'show contact-messages',
            // Dashboard
            'view dashboard',
            // Student detail
            'view student-details',
            // Public pages
            'view about', 'view gallery', 'view contact',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        // Assign permissions to roles
        $admin->syncPermissions($permissions); // Admin gets all permissions

        $guru->syncPermissions([
            'view dashboard',
            'view classes', 'show classes',
            'view attendances', 'create attendances', 'edit attendances', 'show attendances',
            'view schedules', 'show schedules',
            'view materials', 'create materials', 'edit materials', 'show materials',
            'view subjects', 'show subjects',
            'view announcements',
            'view grades', 'create grades', 'edit grades', 'show grades',
            'view exams', 'create exams', 'edit exams', 'show exams',
        ]);

        $siswa->syncPermissions([
            'view dashboard',
            'view schedules',
            'view attendances',
            'view grades',
            'view materials', 'show materials',
            'view announcements', 'show announcements',
            'view invoices', 'show invoices',
        ]);

        $orang_tua->syncPermissions([
            'view dashboard',
            'view announcements', 'show announcements',
            'view student-details',
            'view attendances',
            'view grades',
            'view invoices',
        ]);

        $publik->syncPermissions([
            'view dashboard', 'view about', 'view gallery', 'view announcements', 'view contact',
        ]);
    }
}
