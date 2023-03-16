<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use App\Models\Book;

class BooksApiTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    function can_get_all_books()
    {
        $books = Book::factory(4)->create();

        $response = $this->getJson(route('books.index'));

        foreach ($books as $book) {
            $response->assertJsonFragment([
                'title' => $book->title
            ]);
        }
    }

    /** @test */
    public function can_get_one_book()
    {
        $book = Book::factory()->create();

        $response = $this->getJson(route('books.show', $book));

        $response->assertJsonFragment([
            'title' => $book->title
        ]);
    }

    /** @test */
    public function can_create_books()
    {
        $response = $this->postJson(route('books.store', [
            'title' => 'Test book'
        ]));

        $response->assertJsonFragment([
            'title' => 'Test book'
        ]);

        $this->assertDatabaseHas('books', [
            'id' => 1,
            'title' => 'Test book'
        ]); 
    }


}
