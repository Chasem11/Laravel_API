<?php

namespace Tests\Unit;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\User;
use App\Models\Movies;
use App\Models\Books;
use App\Models\Rentals;

class RentItemTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */

    use RefreshDatabase;

    public function test_example()
    {
        $user = User::factory()->create(['user_type' => 'student']);
        $movie = Movies::factory()->create(['item_id' => 1, 'availability' => true]);
        $book = Books::factory()->create(['item_id' => 2, 'availability' => true]);

        // Rent the movie
        \DB::statement('CALL rentItem(?, NULL, ?)', [$user->user_id, $movie->item_id]);

        // Verify the movie rental
        $this->assertDatabaseHas('rentals', [
            'renter_id' => $user->user_id,
            'movie_id' => $movie->item_id,
            'returned' => false,
        ]);

        $this->assertDatabaseHas('movies', [
            'item_id' => $movie->item_id,
            'availability' => false,
        ]);

        // Rent the book
        \DB::statement('CALL rentItem(?, ?, NULL)', [$user->user_id, $book->item_id]);

        // Verify the book rental
        $this->assertDatabaseHas('rentals', [
            'renter_id' => $user->user_id,
            'book_id' => $book->item_id,
            'returned' => false,
        ]);

        $this->assertDatabaseHas('books', [
            'item_id' => $book->item_id,
            'availability' => false,
        ]);
    }
}
