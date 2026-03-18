<?php

namespace Tests\Feature;

use App\Models\Book;
use App\Models\Category;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BookTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_create_a_book()
    {
        $user = User::factory()->create();

        $category = Category::create([
            'name' => 'Elmi Fantastika',
        ]);

        $response = $this->actingAs($user)->post(route('books.store'), [
            'title' => 'Test Kitabı',
            'description' => 'Test açıqlaması',
            'price' => 25,
            'category_id' => $category->id,
        ]);

        $response->assertStatus(302);

        $this->assertDatabaseHas('books', [
            'title' => 'Test Kitabı',
            'price' => 25,
            'user_id' => $user->id,
        ]);
    }
}
