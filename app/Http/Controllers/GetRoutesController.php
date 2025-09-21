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

/**
 * @OA\Info(
 *     version="1.0.0",
 *     title="Media Library API",
 *     description="API for managing book and movie rentals"
 * )
 */
class GetRoutesController extends Controller
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /**
     * @OA\Get(
     *     path="/users",
     *     summary="Get all users",
     *     tags={"Users"},
     *     @OA\Response(
     *         response=200,
     *         description="A list of users",
     *         @OA\JsonContent(type="array", @OA\Items(ref="#/components/schemas/User"))
     *     )
     * )
     */
    public function getUsers() 
    {
        $users = User::paginate(10);
        return response()->json($users);
    }

    /**
     * @OA\Get(
     *     path="/books",
     *     summary="Get all books",
     *     tags={"Books"},
     *     @OA\Response(
     *         response=200,
     *         description="A list of books",
     *         @OA\JsonContent(type="array", @OA\Items(ref="#/components/schemas/Book"))
     *     )
     * )
     */
    public function getBooks() 
    {
        $books = Books::paginate(10);
        return response()->json($books);
    }

    /**
     * @OA\Get(
     *     path="/availableBooks",
     *     summary="Get available books",
     *     tags={"Books"},
     *     @OA\Response(
     *         response=200,
     *         description="A list of available books",
     *         @OA\JsonContent(type="array", @OA\Items(ref="#/components/schemas/Book"))
     *     )
     * )
     */
    public function getAvailableBooks()
    {
        $books = Books::where('availability', 1)->paginate(10, ['title']);
        return response()->json($books);
    }

    /**
     * @OA\Post(
     *     path="/getRentals",
     *     summary="Get rentals by date",
     *     tags={"Rentals"},
     *     @OA\Parameter(
     *         name="date",
     *         in="query",
     *         required=true,
     *         @OA\Schema(type="string"),
     *         description="Number of days to filter rentals"
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="A list of rentals",
     *         @OA\JsonContent(type="array", @OA\Items(ref="#/components/schemas/Rental"))
     *     )
     * )
     */
    public function getRentals(Request $request) 
    {
        $date = $request->input('date');
        $rentals = Rentals::where('rental_date', '>=', Carbon::today()->subDays($date))->paginate(10);
        return response()->json($rentals);
    }

    /**
     * @OA\Get(
     *     path="/movies",
     *     summary="Get all movies",
     *     tags={"Movies"},
     *     @OA\Response(
     *         response=200,
     *         description="A list of movies",
     *         @OA\JsonContent(type="array", @OA\Items(ref="#/components/schemas/Movie"))
     *     )
     * )
     */
    public function getMovies()
    {
        $movies = Movies::paginate(10);
        return response()->json($movies);
    }

    /**
     * @OA\Get(
     *     path="/availableMovies",
     *     summary="Get available movies",
     *     tags={"Movies"},
     *     @OA\Response(
     *         response=200,
     *         description="A list of available movies",
     *         @OA\JsonContent(type="array", @OA\Items(ref="#/components/schemas/Movie"))
     *     )
     * )
     */
    public function getAvailableMovies()
    {
        $movies = Movies::where('availability', 1)->paginate(10, ['title']);
        return response()->json($movies);
    }

    /**
     * @OA\Get(
     *     path="/dueRentals",
     *     summary="Get due rentals",
     *     tags={"Rentals"},
     *     @OA\Response(
     *         response=200,
     *         description="A list of due rentals",
     *         @OA\JsonContent(type="array", @OA\Items(ref="#/components/schemas/Rental"))
     *     )
     * )
     */
    public function getDueRentals()
    {
        $rentals = Rentals::where('returned', 0)
            ->with('user:user_id,first_name,last_name', 'movies:item_id,title', 'books:item_id,title')
            ->paginate(10);

        $returnMessage = [];

        foreach ($rentals as $rental) {
            $returnMessage[] = [
                'renter_name' => $rental->User->first_name . ' ' . $rental->User->last_name,
                'rental_date' => $rental->rental_date,
                'book_title' => $rental->books ? $rental->books->title : null,  
                'movie_title' => $rental->movies ? $rental->movies->title : null
            ];
        }
        // Return paginated data with meta
        return response()->json([
            'data' => $returnMessage,
            'current_page' => $rentals->currentPage(),
            'last_page' => $rentals->lastPage(),
            'per_page' => $rentals->perPage(),
            'total' => $rentals->total(),
        ]);
    }
}