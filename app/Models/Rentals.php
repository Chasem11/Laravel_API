<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @OA\Schema(
 *     schema="Rental",
 *     type="object",
 *     title="Rental",
 *     description="Rental model",
 *     @OA\Property(
 *         property="id",
 *         type="integer",
 *         description="Unique identifier for the rental"
 *     ),
 *     @OA\Property(
 *         property="renter_id",
 *         type="integer",
 *         description="The ID of the user who rented the item"
 *     ),
 *     @OA\Property(
 *         property="rental_date",
 *         type="string",
 *         format="date",
 *         description="The date the item was rented"
 *     ),
 *     @OA\Property(
 *         property="return_date",
 *         type="string",
 *         format="date",
 *         description="The date the item was returned"
 *     ),
 *     @OA\Property(
 *         property="returned",
 *         type="boolean",
 *         description="Status of whether the item has been returned"
 *     ),
 *     @OA\Property(
 *         property="book_id",
 *         type="integer",
 *         nullable=true,
 *         description="ID of the rented book, null if a movie is rented"
 *     ),
 *     @OA\Property(
 *         property="movie_id",
 *         type="integer",
 *         nullable=true,
 *         description="ID of the rented movie, null if a book is rented"
 *     )
 * )
 */
class Rentals extends Model
{
    use HasFactory;
    public $timestamps = false;

    protected $fillable = [
        'renter_id',
        'rental_date',
        'return_date',
        'returned',
        'book_id',
        'movie_id'
    ];

    /**
     * @OA\Property(
     *     property="user",
     *     description="User who rented the item",
     *     ref="#/components/schemas/User"
     * )
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'renter_id', 'user_id');
    }

    /**
     * @OA\Property(
     *     property="movies",
     *     description="Movie associated with the rental",
     *     ref="#/components/schemas/Movie"
     * )
     */
    public function movies()
    {
        return $this->belongsTo(Movies::class, 'movie_id', 'item_id');
    }

    /**
     * @OA\Property(
     *     property="books",
     *     description="Book associated with the rental",
     *     ref="#/components/schemas/Book"
     * )
     */
    public function books()
    {
        return $this->belongsTo(Books::class, 'book_id', 'item_id');
    }
}

