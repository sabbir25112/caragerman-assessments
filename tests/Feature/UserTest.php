<?php namespace Tests\Feature;

use App\Models\UserType;
use App\User\Exceptions\InvalidUserInformationException;
use App\User\Exceptions\UserTypeNotAllowedException;
use App\User\ParentUser;
use App\User\Student;
use App\User\Teacher;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_will_have_a_type()
    {
        $student = new Student();
        $this->assertTrue($student::UserType == UserType::Student);
    }

    public function test_save_method_will_check_user_type()
    {
        $this->expectException(UserTypeNotAllowedException::class);
        $this->expectExceptionMessage("You Can't Set UserType Manually");

        $student = new Student();
        $student->first_name = "Sabbir";
        $student->last_name = "Ahmed";
        $student->email = "sabbir25112@gmail.com";
        $student->user_type_id = UserType::Teacher;
        $student->save();
    }

    public function test_save_method_will_check_profile_photo()
    {
        $this->expectException(InvalidUserInformationException::class);
        $this->expectExceptionMessage("You didn't provide enough information to create a new user");

        $student = new Student();
        $student->first_name = "Sabbir";
        $student->last_name = "Ahmed";
        $student->email = "sabbir25112@gmail.com";
        $student->user_type_id = UserType::Student;
        $student->profile_photo = "photo.png";
        $student->save();
    }

    public function test_save_method_will_check_email()
    {
        $this->expectException(InvalidUserInformationException::class);
        $this->expectExceptionMessage("You didn't provide enough information to create a new user");

        $student = new Student();
        $student->first_name = "Sabbir";
        $student->last_name = "Ahmed";
        $student->profile_photo = "profile.jpg";
        $student->user_type_id = UserType::Student;
        $student->save();
    }

    public function test_save_method_will_create_user_with_proper_information()
    {
        $student = new Student();
        $student->first_name = "Sabbir";
        $student->last_name = "Ahmed";
        $student->profile_photo = "profile.jpg";
        $student->email = "sabbir25112@gmail.com";
        $student->user_type_id = UserType::Student;
        $student->save();

        $this->assertDatabaseHas('users', [
            "first_name" => "Sabbir"
        ]);
    }

    public function test_create_method_will_also_validate_user_type()
    {
        $this->expectException(UserTypeNotAllowedException::class);
        $this->expectExceptionMessage("You Can't Set UserType Manually");

        Student::create([
            'first_name'    => 'Student',
            'last_name'     => 'User',
            'email'         => 'student@test.com',
            'user_type_id'  => UserType::Teacher,
            'profile_photo' => 'student.jpg',
        ]);
    }

    public function test_create_method_will_create_user_with_proper_information()
    {
        Teacher::create([
            'first_name'    => 'New',
            'last_name'     => 'Teacher',
            'email'         => 'new_teacher@test.com',
            'user_type_id'  => UserType::Teacher,
            'profile_photo' => 'teacher.jpg',
        ]);

        $this->assertDatabaseHas('users', [
            "first_name" => "New",
            "last_name"  => "Teacher",
            'email'      => 'new_teacher@test.com',
        ]);
    }

    public function test_teacher_and_parent_will_have_salutation_in_their_full_name()
    {
        $teacher = Teacher::create([
            'salutation'    => 'Mr.',
            'first_name'    => 'New',
            'last_name'     => 'Teacher',
            'email'         => 'new_teacher@test.com',
            'user_type_id'  => UserType::Teacher,
            'profile_photo' => 'teacher.jpg',
        ]);
        $this->assertTrue($teacher->full_name == "Mr. New Teacher");

        $parent = ParentUser::create([
            'salutation'    => 'Mr.',
            'first_name'    => 'Ahmed',
            'last_name'     => 'Senior',
            'email'         => 'ahmed_senior@test.com',
            'user_type_id'  => UserType::Parent,
            'profile_photo' => 'parent.jpg',
        ]);
        $this->assertTrue($parent->full_name == "Mr. Ahmed Senior");
    }

    public function test_student_will_not_have_salutation_in_their_full_name()
    {
        $student = Student::create([
            'salutation'    => 'Mr.',
            'first_name'    => 'Sabbir',
            'last_name'     => 'Ahmed',
            'email'         => 'sabbir@test.com',
            'user_type_id'  => UserType::Student,
            'profile_photo' => 'student.jpg',
        ]);

        $this->assertFalse($student->full_name == "Mr. Sabbir Ahmed");
        $this->assertTrue($student->full_name == "Sabbir Ahmed");
    }

    public function test_teacher_and_parent_salutation_will_skip_in_full_name_if_they_do_not_have_salutation()
    {
        $teacher = Teacher::create([
            'first_name'    => 'New',
            'last_name'     => 'Teacher',
            'email'         => 'new_teacher@test.com',
            'user_type_id'  => UserType::Teacher,
            'profile_photo' => 'teacher.jpg',
        ]);
        $this->assertTrue($teacher->full_name == "New Teacher");

        $parent = ParentUser::create([
            'first_name'    => 'Ahmed',
            'last_name'     => 'Senior',
            'email'         => 'new_parent@test.com',
            'user_type_id'  => UserType::Parent,
            'profile_photo' => 'parent.jpg',
        ]);
        $this->assertTrue($parent->full_name == "Ahmed Senior");
    }

    public function test_user_will_return_default_avatar_if_no_profile_photo_is_defined()
    {
        $parent = ParentUser::create([
            'first_name'    => 'Ahmed',
            'last_name'     => 'Senior',
            'email'         => 'new_parent@test.com',
            'user_type_id'  => UserType::Parent,
        ]);

        $this->assertTrue($parent->getAvatar() == 'default_avatar.jpg');
    }
}
