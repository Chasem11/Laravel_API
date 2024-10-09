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
use Illuminate\Support\Facades\Auth;

class ViewController extends Controller
{
    /**
     * @OA\Get(
     *     path="/displayBooksView",
     *     summary="Display the available books",
     *     tags={"Views"},
     *     @OA\Response(
     *         response=200,
     *         description="Returns the view with available books"
     *     )
     * )
     */
    public function displayBookView()
    {
        $books = Books::where('availability', 1)->get();

        return view('books', compact('books'));
    }

    /**
     * @OA\Get(
     *     path="/displayMoviesView",
     *     summary="Display the available movies",
     *     tags={"Views"},
     *     @OA\Response(
     *         response=200,
     *         description="Returns the view with available movies"
     *     )
     * )
     */
    public function displayMovieView()
    {
        $movies = Movies::where('availability', 1)->get();

        return view('movies', compact('movies'));
    }

    /**
     * @OA\Get(
     *     path="/displayRentItem",
     *     summary="Display the rent item view",
     *     tags={"Views"},
     *     @OA\Response(
     *         response=200,
     *         description="Returns the view to rent a book or movie"
     *     )
     * )
     */
    public function displayRentView()
    {
        $books = Books::where('availability', 1)->get();
        $movies = Movies::where('availability', 1)->get();

        $users = User::withCount(['rentals' => function ($query) {
            $query->where('returned', false);
        }])->get();

        return view('rentItem', compact('users', 'books', 'movies'));
    }

    /**
     * @OA\Get(
     *     path="/displayReturnItem",
     *     summary="Display the return item view",
     *     tags={"Views"},
     *     @OA\Response(
     *         response=200,
     *         description="Returns the view to return a rented book or movie"
     *     )
     * )
     */
    public function displayReturnView()
    {
        $userId = Auth::id();
        $rentals = Rentals::where('renter_id', $userId)
                          ->where('returned', false)
                          ->with(['books', 'movies'])
                          ->get();
    
        return view('returnItem', compact('rentals'));
    }
}
