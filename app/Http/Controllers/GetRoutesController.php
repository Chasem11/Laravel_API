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
        $users = User::all();
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
        $books = Books::all();
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
        $books = Books::where('availability', 1)->get('title');
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
        $rentals = Rentals::where('rental_date', '>=', Carbon::today()->subDays($date))->get();
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
        $movies = Movies::all();
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
        $movies = Movies::where('availability', 1)->get('title');
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
        $rentals = Rentals::where('returned', 0)->with('user:user_id,first_name,last_name', 'movies:item_id,title', 'books:item_id,title')->get();
        $returnMessage = [];

        foreach ($rentals as $rental) {
            $returnMessage[] = [
                'renter_name' => $rental->User->first_name . ' ' . $rental->User->last_name,
                'rental_date' => $rental->rental_date,
                'book_title' => $rental->books ? $rental->books->title : null,  
                'movie_title' => $rental->movies ? $rental->movies->title : null
            ];
        }
        return response()->json($returnMessage);
    }

    /**
     * @OA\Post(
     *     path="/createUser",
     *     summary="Create a new user",
     *     tags={"Users"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(property="first_name", type="string", description="First name of the user"),
     *             @OA\Property(property="last_name", type="string", description="Last name of the user"),
     *             @OA\Property(property="email", type="string", description="Email of the user"),
     *             @OA\Property(property="password", type="string", description="Password of the user"),
     *             @OA\Property(property="user_type", type="string", description="Type of user (student or teacher)"),
     *             @OA\Property(property="gender", type="string", description="Gender of the user"),
     *             @OA\Property(property="grade_level", type="string", nullable=true, description="Grade level of the user (if student)"),
     *             @OA\Property(property="department", type="string", nullable=true, description="Department of the user (if teacher)")
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="User created successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="User created successfully!")
     *         )
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Invalid input"
     *     )
     * )
     */
    public function createUser(Request $request)
    {
        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8',
            'user_type' => 'required|string',
            'gender' => 'required|string',
            'grade_level' => 'nullable|in:9,10,11,12|required_if:user_type,student',
            'department' => 'nullable|string|max:255|required_if:user_type,teacher',
        ]);

        // Create the new user with hashed password
        User::create([
            'first_name' => $request->input('first_name'),
            'last_name' => $request->input('last_name'),
            'email' => $request->input('email'),
            'password' => bcrypt($request->input('password')),
            'user_type' => $request->input('user_type'),
            'grade_level' => $request->input('user_type') === 'student' ? $request->input('grade_level') : null,
            'department' => $request->input('user_type') === 'teacher' ? $request->input('department') : null,
            'gender' => $request->input('gender')
        ]);

        return redirect('login')->with('success', 'Account created successfully! Please log in.');
    }


    /**
     * @OA\Post(
     *     path="/login",
     *     summary="User login",
     *     tags={"Authentication"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(property="email", type="string", description="Email of the user"),
     *             @OA\Property(property="password", type="string", description="Password of the user")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Login successful",
     *         @OA\JsonContent(
     *             @OA\Property(property="token", type="string", example="your_jwt_token_here"),
     *             @OA\Property(property="user", type="object", ref="#/components/schemas/User")
     *         )
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Invalid login credentials"
     *     )
     * )
     */

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        if (!Auth::attempt($request->only('email', 'password'))) {
            return response()->json(['message' => 'Invalid login credentials'], 401);
        }

        $user = Auth::user();
        $token = $user->createToken('API Token')->plainTextToken;

        return response()->json(['token' => $token, 'user' => $user], 200);
    }

    /**
     * @OA\Post(
     *     path="/logout",
     *     summary="User logout",
     *     tags={"Authentication"},
     *     description="Logs out the authenticated user and invalidates their session.",
     *     @OA\Response(
     *         response=200,
     *         description="Logout successful",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Logout successful")
     *         )
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthenticated - user is not logged in"
     *     ),
     *     security={{ "bearerAuth": {} }}
     * )
     */

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login'); 
    }
}



