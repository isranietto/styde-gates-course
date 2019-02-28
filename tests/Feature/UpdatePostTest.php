<?php

namespace Tests\Feature;

use App\Post;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UpdatePostTest extends TestCase
{
    use RefreshDatabase;

    /** @test * */
    function admins_can_update_posts()
    {
        $this->withoutExceptionHandling();

        $post =  factory(Post::class)->create();

        $admin = $this->createAdmin();

        $this->actingAs($admin);

        $response = $this->put("/admin/posts/{$post->id}" ,[
            'title' => 'Updated post',
        ]);

        $response->assertStatus(200)
            ->assertSee('Post updated!');

        $this->assertDatabaseHas('posts', [
            'id' => $post->id,
            'title' => 'Updated post',
        ]);
    }

    /** @test * */
    function authors_users_can_update_posts()
    {
        $user = $this->createUser();
        $this->actingAs($user);

        $post =  factory(Post::class)->create(['user_id' => $user->id]);

        $response = $this->put("/admin/posts/{$post->id}" ,[
            'title' => 'Updated post',
        ]);

        $response->assertStatus(200)
            ->assertSee('Post updated!');

        $this->assertDatabaseHas('posts', [
            'id' => $post->id,
            'title' => 'Updated post',
        ]);
    }

    /** @test * */
    function unauthorized_users_cannot_update_posts()
    {
        $post =  factory(Post::class)->create();

        $user = $this->createUser();

        $this->actingAs($user);

        $response = $this->put("/admin/posts/{$post->id}" ,[
            'title' => 'Updated post',
        ]);

        $response->assertStatus(403); //

        $this->assertDatabaseMissing('posts', [
            'id' => $post->id,
            'title' => 'Updated post',
        ]);
    }

    /** @test * */
    function guests_cannot_update_posts()
    {
        $post =  factory(Post::class)->create();

        $response = $this->put("/admin/posts/{$post->id}" ,[
            'title' => 'Updated post',
        ]);

        $response->assertStatus(302)
            ->assertRedirect('login');

        $this->assertDatabaseMissing('posts', [
            'id' => $post->id,
            'title' => 'Updated post',
        ]);
    }
}
