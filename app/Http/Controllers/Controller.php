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


class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    #All the getter functions for the different tables
    public function getUsers() 
    {
        $users = User::all();

        return response()->json($users);
    }

    public function getBooks() 
    {
        $books = Books::all();

        return response()->json($books);
    }

    public function getAvailableBooks()
    {
        $books = Books::where('availability', 1)->get('title');

        return response()->json($books);
    }

    public function getRentals(Request $request) 
    {
        $date = $request->input('date');
        $rentals = Rentals::where('rental_date', '>=', Carbon::today()->subDays($date))->get();

        return response()->json($rentals);
    }

    public function getMovies()
    {
        $movies = Movies::all();

        return response()->json($movies);
    }

    public function getAvailableMovies()
    {
        $movies = Movies::where('availability', 1)->get('title');

        return response()->json($movies);
    }


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


    public function createUser(Request $request)
    {
        // Validate the request data
        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'user_type' => 'required|string',
            'gender' => 'required|string',
            'grade_level' => 'nullable|in:9,10,11,12|required_if:user_type,student',
            'department' => 'nullable|string|max:255|required_if:user_type,teacher',
        ]);

        // Create the new user
        User::create([
            'first_name' => $request->input('first_name'),
            'last_name' => $request->input('last_name'),
            'email' => $request->input('email'),
            'user_type' => $request->input('user_type'),
            'grade_level' => $request->input('user_type') === 'student' ? $request->input('grade_level') : null,
            'department' => $request->input('user_type') === 'teacher' ? $request->input('department') : null,
            'gender' => $request->input('gender')
        ]);

        return response()->json('User created successfully!');
    }

    #Rent a book or movie
    public function rentItem(Request $request) 
    {
        $request->validate([
            'user_id' => 'required|exists:users,user_id',
            'item_type' => 'required',
            'book_id' => 'nullable|exists:books,item_id',
            'movie_id' => 'nullable|exists:movies,item_id',
        ]);

        try {
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

    #Return a book or movie
    public function returnItem(Request $request)
    {
        // Validate the request input
        $request->validate([
            'rental_id' => 'required|exists:rentals,rental_id',
        ]);

        try {
            // Call the stored procedure to handle the return
            DB::statement('CALL returnItem(?)', [$request->rental_id]);

            // Redirect back to the return view with success message
            return redirect('displayReturnView')->with('success', 'Item returned successfully!');
        } catch (\Exception $e) {
            // Log the error and redirect with an error message
            Log::error('Error returning item: ' . $e->getMessage());
            return redirect('displayReturnView')->with('error', 'Error returning item: ' . $e->getMessage());
        }
    }


    #functions to display views
    public function displayUserView()
    {
        return view('newUser');
    }

    public function displayHomeView()
    {
        return view('index');
    }

    public function displayBookView()
    {
        $books = Books::where('availability', 1)->get();

        return view('books', compact('books'));
    }

    public function displayMovieView()
    {
        $movies = Movies::where('availability', 1)->get();

        return view('movies', compact('movies'));
    }

    public function displayRentView()
    {
        $users = User::all();
        $books = Books::where('availability', 1)->get();
        $movies = Movies::where('availability', 1)->get();

        return view('rentItem', compact('users', 'books', 'movies'));
    }

    public function displayReturnView()
    {
        $rentals = Rentals::where('returned', 0)
            ->with(['user', 'books', 'movies'])
            ->get();

        return view('returnItem', compact('rentals'));
    }
}



