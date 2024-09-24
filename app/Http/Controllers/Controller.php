<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use App\Models\User;
use App\Models\Books;
use App\Models\Rentals;
use App\Models\Movies;

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

    public function getRentals() 
    {
        $rentals = Rentals::all();

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

    
}



