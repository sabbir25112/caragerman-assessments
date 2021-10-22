<?php namespace Database\Seeders;

use App\Models\UserType;
use App\User\ParentUser;
use App\User\Student;
use App\User\Teacher;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Student::create([
            'first_name'    => 'Student',
            'last_name'     => 'User',
            'email'         => 'student@test.com',
            'user_type_id'  => UserType::Student,
            'profile_photo' => 'student.jpg',
        ]);

        ParentUser::create([
            'salutation'    => 'Mr',
            'first_name'    => 'Parent',
            'last_name'     => 'User',
            'email'         => 'parent@test.com',
            'user_type_id'  => UserType::Parent,
            'profile_photo' => 'parent.jpg',
        ]);

        Teacher::create([
            'salutation'    => 'Mr',
            'first_name'    => 'Teacher',
            'last_name'     => 'User',
            'email'         => 'teacher@test.com',
            'user_type_id'  => UserType::Teacher,
            'profile_photo' => 'teacher.jpg',
        ]);
    }
}
