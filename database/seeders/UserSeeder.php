<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Teacher;
use App\Models\Student;
use App\Models\ParentModel;
use App\Models\SchoolClass;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create Admin User
        $admin = User::firstOrCreate([
            'email' => 'admin@sman1donggo.sch.id'
        ], [
            'name' => 'Administrator',
            'password' => Hash::make('password'),
            'email_verified_at' => now(),
        ]);
        $admin->assignRole('admin');

        // Create Teacher User
        $teacherUser = User::firstOrCreate([
            'email' => 'guru@sman1donggo.sch.id'
        ], [
            'name' => 'Guru Matematika',
            'password' => Hash::make('password'),
            'email_verified_at' => now(),
        ]);
        $teacherUser->assignRole('guru');

        // Create Teacher Record
        $teacher = Teacher::firstOrCreate([
            'nip' => '1234567890'
        ], [
            'name' => 'Guru Matematika',
            'email' => 'guru@sman1donggo.sch.id',
            'phone' => '081234567890',
            'address' => 'Jl. Pendidikan No. 1, Donggo',
            'birth_date' => '1980-01-01',
            'gender' => 'male',
            'subject_specialization' => 'Matematika',
        ]);

        // Create Student User
        $studentUser = User::firstOrCreate([
            'email' => 'siswa@sman1donggo.sch.id'
        ], [
            'name' => 'Ahmad Siswa',
            'password' => Hash::make('password'),
            'email_verified_at' => now(),
        ]);
        $studentUser->assignRole('siswa');

        // Create Class first
        $class = SchoolClass::firstOrCreate([
            'name' => 'XII IPA 1'
        ], [
            'grade_level' => '12',
            'major' => 'IPA',
            'teacher_id' => $teacher->id,
            'academic_year' => 2024,
            'capacity' => 30,
        ]);

        // Create Student Record
        $student = Student::firstOrCreate([
            'nis' => '2024001'
        ], [
            'name' => 'Ahmad Siswa',
            'email' => 'siswa@sman1donggo.sch.id',
            'phone' => '081234567891',
            'address' => 'Jl. Siswa No. 1, Donggo',
            'birth_date' => '2006-05-15',
            'gender' => 'male',
            'class_id' => $class->id,
            'parent_id' => null, // Will update after parent is created
        ]);

        // Create Parent User
        $parentUser = User::firstOrCreate([
            'email' => 'ortu@sman1donggo.sch.id'
        ], [
            'name' => 'Budi Orang Tua',
            'password' => Hash::make('password'),
            'email_verified_at' => now(),
        ]);
        $parentUser->assignRole('orang_tua');

        // Create Parent Record
        $parent = ParentModel::firstOrCreate([
            'email' => 'ortu@sman1donggo.sch.id'
        ], [
            'name' => 'Budi Orang Tua',
            'phone' => '081234567892',
            'address' => 'Jl. Orang Tua No. 1, Donggo',
            'relationship' => 'father',
        ]);

        // Link student to parent
        $student->update(['parent_id' => $parent->id]);

        // Create Public User (optional, for general access)
        $publicUser = User::firstOrCreate([
            'email' => 'public@sman1donggo.sch.id'
        ], [
            'name' => 'Pengunjung Umum',
            'password' => Hash::make('password'),
            'email_verified_at' => now(),
        ]);
        $publicUser->assignRole('publik');

        $this->command->info('Users seeded successfully!');
        $this->command->info('Admin: admin@sman1donggo.sch.id / password');
        $this->command->info('Teacher: guru@sman1donggo.sch.id / password');
        $this->command->info('Student: siswa@sman1donggo.sch.id / password');
        $this->command->info('Parent: ortu@sman1donggo.sch.id / password');
        $this->command->info('Public: public@sman1donggo.sch.id / password');

        //php artisan db:seed --class=UserSeeder
        //php artisan db:seed --class=RoleSeeder
    }
}
