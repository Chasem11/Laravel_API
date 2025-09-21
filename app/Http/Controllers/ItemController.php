<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Books;
use App\Models\Rentals;
use App\Models\Movies;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ItemController extends Controller
{
    public function rentItem(Request $request) 
    {
        $validated = $request->validate([
            'item_type'  => 'required|in:book,movie',
            'book_id'    => 'nullable|exists:books,item_id',
            'movie_id'   => 'nullable|exists:movies,item_id',
        ]);

        try {
            $user = auth()->user();
            $currentRentals = Rentals::where('renter_id', $user->user_id)
                                    ->where('returned', false)
                                    ->count();

            $limit = strtolower($user->user_type) === 'student' ? 2 : 3;
            if ($currentRentals >= $limit) {
                return response()->json(['success' => false, 'message' => "Rental limit reached for {$user->user_type}s."], 400);
            }

            $bookId = $validated['item_type'] === 'book' ? $validated['book_id'] : null;
            $movieId = $validated['item_type'] === 'movie' ? $validated['movie_id'] : null;

            DB::beginTransaction();

            if ($bookId) {
                $book = Books::where('item_id', $bookId)->where('availability', true)->first();
                if (!$book) {
                    throw new \Exception('Book is not available.');
                }
                $book->availability = false;
                $book->save();
            }

            if ($movieId) {
                $movie = Movies::where('item_id', $movieId)->where('availability', true)->first();
                if (!$movie) {
                    throw new \Exception('Movie is not available.');
                }
                $movie->availability = false;
                $movie->save();
            }

            $rental = Rentals::create([
                'renter_id'   => $user->user_id,
                'book_id'     => $bookId,
                'movie_id'    => $movieId,
                'rental_date' => now(),
                'returned'    => false,
                'return_date' => null
            ]);

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'item rented successfully',
                'rental_id' => $rental->id
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error renting item: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }


    public function returnItem(Request $request)
    {
        $validated = $request->validate([
            'id' => 'required|exists:rentals,id', 
        ]);

        try {
            $rental = Rentals::findOrFail($validated['id']);

            if ($rental->returned) {
                return response()->json(['success' => false, 'message' => 'item already returned.'], 400);
            }

            DB::beginTransaction();

            // Mark item as available again
            if ($rental->book_id) {
                Books::where('item_id', $rental->book_id)->update(['availability' => true]);
            }
            if ($rental->movie_id) {
                Movies::where('item_id', $rental->movie_id)->update(['availability' => true]);
            }

            $rental->returned = true;
            $rental->return_date = now();
            $rental->save();

            DB::commit();

            return response()->json(['success' => true, 'message' => 'item returned successfully!']);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error returning item: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'error returning item: ' . $e->getMessage()], 500);
        }
    }
}

