<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Rentals;
use App\Models\Books;
use App\Models\Movies;
use Carbon\Carbon;

class ChatBotController extends Controller
{
    /**
     * @OA\Post(
     *     path="/chatbot",
     *     summary="Chat with the AI-powered assistant",
     *     tags={"Chatbot"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(property="user_id", type="integer", description="User's ID"),
     *             @OA\Property(property="message", type="string", description="User's message to the chatbot")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Chatbot response",
     *         @OA\JsonContent(type="string")
     *     )
     * )
     */
    public function chatbot(Request $request)
    {
        $userId = $request->input('user_id');
        $message = strtolower($request->input('message'));

        // Check for keywords in the message
        if (strpos($message, 'due rentals') !== false || strpos($message, 'overdue') !== false) {
            return $this->getDueRentals($userId);
        } elseif (strpos($message, 'available books') !== false) {
            return $this->getAvailableBooks();
        } elseif (strpos($message, 'available movies') !== false) {
            return $this->getAvailableMovies();
        } else {
            return response()->json("I'm sorry, I can only help you with due rentals and available books or movies.", 200);
        }
    }

    private function getDueRentals($userId)
    {
        $dueRentals = Rentals::where('renter_id', $userId)
                             ->where('returned', 0)
                             ->with(['books', 'movies'])
                             ->get();

        if ($dueRentals->isEmpty()) {
            return response()->json("You have no due rentals.", 200);
        }

        $dueItems = [];
        foreach ($dueRentals as $rental) {
            if ($rental->book_id) {
                $dueItems[] = "Book: " . $rental->books->title;
            } elseif ($rental->movie_id) {
                $dueItems[] = "Movie: " . $rental->movies->title;
            }
        }

        return response()->json("You have due rentals: " . implode(', ', $dueItems), 200);
    }

    private function getAvailableBooks()
    {
        $availableBooks = Books::where('availability', 1)->pluck('title')->toArray();

        if (empty($availableBooks)) {
            return response()->json("No books are currently available.", 200);
        }

        return response()->json("Available books: " . implode(', ', $availableBooks), 200);
    }

    private function getAvailableMovies()
    {
        $availableMovies = Movies::where('availability', 1)->pluck('title')->toArray();

        if (empty($availableMovies)) {
            return response()->json("No movies are currently available.", 200);
        }

        return response()->json("Available movies: " . implode(', ', $availableMovies), 200);
    }

    private function processWithOpenAI($message)
    {
        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . env('OPENAI_API_KEY'),
        ])->post('https://api.openai.com/v1/completions', [
            'model' => 'text-davinci-003',
            'prompt' => "The user asked: \"$message\". Respond with relevant information about due rentals and available items.",
            'max_tokens' => 50,
        ]);

        return trim($response->json()['choices'][0]['text']);
    }
}
