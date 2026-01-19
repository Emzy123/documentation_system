<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Role;
use App\Models\Student;
use App\Models\Course;
use App\Models\Grade;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AcademicRecordTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        // Create roles safely
        Role::firstOrCreate(['slug' => 'admin'], ['name' => 'admin']);
        Role::firstOrCreate(['slug' => 'student'], ['name' => 'student']);
        Role::firstOrCreate(['slug' => 'staff'], ['name' => 'staff']);
    }

    public function test_admin_can_create_course()
    {
        $adminRole = Role::where('slug', 'admin')->first();
        $admin = User::factory()->create(['role_id' => $adminRole->id]); // Admin

        $response = $this->actingAs($admin)->post(route('admin.courses.store'), [
            'code' => 'CS101',
            'name' => 'Intro to CS',
            'credits' => 3,
            'description' => 'Basics of CS',
        ]);

        $response->assertRedirect(route('admin.courses.index'));
        $this->assertDatabaseHas('courses', ['code' => 'CS101']);
    }

    public function test_admin_can_assign_grades()
    {
        $adminRole = Role::where('slug', 'admin')->first();
        $studentRole = Role::where('slug', 'student')->first();
        
        $admin = User::factory()->create(['role_id' => $adminRole->id]);
        $studentUser = User::factory()->create(['role_id' => $studentRole->id]);
        $student = Student::create([
            'user_id' => $studentUser->id,
            'student_number' => 'S12345',
            'program' => 'BSCS',
            'year_level' => 1
        ]);

        $course = Course::create(['code' => 'CS101', 'name' => 'Intro', 'credits' => 3]);

        $response = $this->actingAs($admin)->post(route('admin.grades.store'), [
            'student_id' => $student->id,
            'course_id' => $course->id,
            'grade' => 'A',
            'semester' => '1st',
            'academic_year' => '2023-2024',
        ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('grades', [
            'student_id' => $student->id,
            'grade' => 'A'
        ]);
    }

    public function test_student_can_view_transcript()
    {
        $studentRole = Role::where('slug', 'student')->first();
        $studentUser = User::factory()->create(['role_id' => $studentRole->id]);
        $student = Student::create([
            'user_id' => $studentUser->id,
            'student_number' => 'S12345',
            'program' => 'BSCS',
            'year_level' => 1
        ]);
        
        $course = Course::create(['code' => 'CS102', 'name' => 'Data Structures', 'credits' => 3]);
        
        Grade::create([
            'student_id' => $student->id,
            'course_id' => $course->id,
            'grade' => 'A-',
            'semester' => '2nd',
            'academic_year' => '2023-2024'
        ]);

        $response = $this->actingAs($studentUser)->get(route('student.transcript'));

        $response->assertStatus(200);
        $response->assertSee('Data Structures');
        $response->assertSee('A-');
    }
}
