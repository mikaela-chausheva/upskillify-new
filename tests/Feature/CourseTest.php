<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use App\Models\Course;

class CourseTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    // public function test_example(): void
    // {
    //     $response = $this->get('/');

    //     $response->assertStatus(200);
    // }


    // use RefreshDatabase;

    public function test_teacher_can_create_course()
    {
        $teacher = User::factory()->create(['role' => 'teacher']);

        $this->actingAs($teacher);

        $response = $this->post('/storeCourse', [
            'title' => 'Unit Test Course',
            'description' => 'This is a test course',
            'price' => 99.99,
             'photo_url' => 'http://example.com/image.jpg'
        ]);

        $response->assertRedirect();
        $response->assertSessionHasNoErrors();
        $this->assertDatabaseHas('courses', [
            'title' => 'Unit Test Course',
            'teacher_id' => $teacher->id,
        ]);
        $response->dump();

    }



}
