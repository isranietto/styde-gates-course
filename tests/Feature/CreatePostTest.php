<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CreatePostTest extends TestCase
{
    use RefreshDatabase;

    /** @test * */
    function admin_can_create_a_posts()
    {
        $this->withoutExceptionHandling();

        $this->actingAs($this->createAdmin());

        $this->post('/admin/posts', [
            'title' => 'New Post',
        ])->assertStatus(201);

        $this->assertDatabaseHas('posts',[
            'title' => 'New Post',
        ]);

    }

    /** @test * */
    function authors_can_create_a_posts()
    {
        $this->withoutExceptionHandling();

        $this->actingAs($user = $this->createUser(['role' => 'author']));

        $this->post('/admin/posts', [
            'title' => 'New Post',
        ])->assertStatus(201);

        $this->assertDatabaseHas('posts',[
            'title' => 'New Post',
            'user_id' => auth()->user()->id,
        ]);

    }

    /** @test * */
    function unathorized_users_cannot_create_a_posts()
    {
        $this->actingAs($user = $this->createUser(['role' => 'subscriber']));

        $this->post('/admin/posts', [
            'title' => 'New Post',
        ])->assertStatus(403); // No autorizado

        $this->assertDatabaseMissing('posts',[
            'title' => 'New Post',
            'user_id' => auth()->user()->id,
        ]);

    }
}
