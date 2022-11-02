<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;

use App\Models\Book;
use Tests\TestCase;

class BooksApiTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function can_get_all_books()
    {
        $books = Book::factory(2)->create();

        $response = $this->getJson(route('books.index'));
        $response->assertJsonFragment([
            'title' => $books[0]->title
        ])->assertJsonFragment([
            'title' => $books[1]->title
        ]);
    }

    /**
     * @test
     */
    public function can_get_one_book()
    {
        $book = Book::factory()->create();

        $response = $this->get(route('books.show', ['book' => $book->id]));
        $response->assertJsonFragment([
            'title' => $book->title
        ]);
    }

    /**
     * @test
     */
    public function can_create_one_book()
    {
        $body = ['title' => 'My new book'];

        $this->postJson(route('books.store'), [])
        ->assertJsonValidationErrorFor('title');

        $this->postJson(route('books.store'), $body)
        ->assertJsonFragment($body);

        $this->assertDatabaseHas('books', $body);
    }

    /**
     * @test
     */
    public function can_update_book()
    {
        $body = ['title' => 'My new book edited'];
        $book = Book::factory()->create();

        $this->patchJson(route('books.update', $book), $body)
        ->assertJsonFragment($body);

        $this->assertDatabaseHas('books', $body);
    }

        /**
     * @test
     */
    public function can_delete_book()
    {
        $book = Book::factory()->create();

        $this->deleteJson(route('books.destroy', $book))
        ->assertNoContent();

        $this->assertDatabaseCount('books', 1)
        ->assertDatabaseHas('books', [
            'id' => $book->id
        ]);
    }
}
