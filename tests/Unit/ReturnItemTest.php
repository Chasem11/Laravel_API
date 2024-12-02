<?php

namespace Tests\Unit;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Rentals;
use App\Models\Movies;
use App\Models\Books;

class ReturnItemTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */

    use RefreshDatabase;

    public function test_return_item()
    {
        $movie = Movies::factory()->create(['item_id' => 1, 'availability' => false]);

        $rental = Rentals::factory()->create([
            'movie_id' => $movie->item_id,
            'returned' => false
        ]);
        
        //verify the initial test state
        $this->assertDatabaseHas('rentals', [
            'id' => $rental->id,
            'returned' => false,
        ]);

        $this->assertDatabaseHas('movies', [
            'item_id' => $movie->item_id,
            'availability' => false,
        ]);

        \DB::statement('CALL returnItem(?)', [$rental->id]);


        $this->assertDatabaseHas('rentals', [
            'id' => $rental->id,
            'returned' => true,
        ]);

        $this->assertDatabaseHas('movies', [
            'item_id' => $movie->item_id,
            'availability' => true,
        ]);

    }
}
