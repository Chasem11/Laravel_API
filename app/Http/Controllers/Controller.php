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

    public function displayUserView()
    {
        return view('newUser');
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

        // Return a success response
        return response()->json('User created successfully!');
    }
}



