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
    /**
     * @OA\Post(
     *     path="/rentItem",
     *     summary="Rent a book or movie",
     *     description="Allows a user to rent a book or movie based on their user type and the current rental limit",
     *     tags={"Rentals"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(property="user_id", type="integer", description="ID of the user"),
     *             @OA\Property(property="item_type", type="string", enum={"book", "movie"}, description="The type of item to rent"),
     *             @OA\Property(property="book_id", type="integer", nullable=true, description="ID of the book (if book is selected)"),
     *             @OA\Property(property="movie_id", type="integer", nullable=true, description="ID of the movie (if movie is selected)")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Item rented successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean"),
     *             @OA\Property(property="message", type="string", example="Item rented successfully!")
     *         )
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Bad request, validation error"
     *     )
     * )
     */
    public function rentItem(Request $request) 
    {
        $request->validate([
            'user_id' => 'required|exists:users,user_id',
            'item_type' => 'required',
            'book_id' => 'nullable|exists:books,item_id',
            'movie_id' => 'nullable|exists:movies,item_id',
        ]);

        try {
            $user = User::findOrFail($request->user_id);
            $currentRentals = Rentals::where('renter_id', $request->user_id)
                                    ->where('returned', false)
                                    ->count();
        
            // Log current rentals for debugging
            Log::info('Current rentals count: ', ['user_id' => $request->user_id, 'current_rentals' => $currentRentals]);
        
            // Check rental limits based on user type
            if (strtolower($user->user_type) === 'student' && $currentRentals >= 2) {
                return redirect('/displayRentView')->with('error', 'Students can only rent up to 2 items.');
            }
        
            if (strtolower($user->user_type) === 'teacher' && $currentRentals >= 3) {
                return redirect('/displayRentView')->with('error', 'Teachers can only rent up to 3 items.');
            }

            $book_id = $request->item_type === 'book' ? $request->book_id : null;
            $movie_id = $request->item_type === 'movie' ? $request->movie_id : null;

            DB::statement('CALL rentItem(?, ?, ?)', [
                $request->user_id,
                $book_id,
                $movie_id
            ]);

            return redirect('/displayRentView')->with('success', 'Item rented successfully!');
        } catch (\Exception $e) {
            Log::error('Error renting item: ' . $e->getMessage());
            return redirect('/displayRentView')->with('error', $e->getMessage());
        }
    }

    /**
     * @OA\Post(
     *     path="/returnItem",
     *     summary="Return a rented book or movie",
     *     tags={"Rentals"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(property="id", type="integer", description="Rental ID to return")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Item returned successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean"),
     *             @OA\Property(property="message", type="string", example="Item returned successfully!")
     *         )
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Bad request, validation error"
     *     )
     * )
     */

    public function returnItem(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:rentals,id', 
        ]);

        try {
            // Call the stored procedure to handle the return
            DB::statement('CALL returnItem(?)', [$request->id]);

            // Redirect back to the return view with success message
            return redirect('displayReturnView')->with('success', 'Item returned successfully!');
        } catch (\Exception $e) {
            // Log the error and redirect with an error message
            Log::error('Error returning item: ' . $e->getMessage());
            return redirect('displayReturnView')->with('error', 'Error returning item: ' . $e->getMessage());
        }
    }
}

