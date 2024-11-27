<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @OA\Schema(
 *     schema="Movie",
 *     type="object",
 *     title="Movie",
 *     description="Movie model",
 *     @OA\Property(
 *         property="item_id",
 *         type="integer",
 *         description="Unique identifier for the movie"
 *     ),
 *     @OA\Property(
 *         property="title",
 *         type="string",
 *         description="Title of the movie"
 *     ),
 *     @OA\Property(
 *         property="director",
 *         type="string",
 *         description="Director of the movie"
 *     ),
 *     @OA\Property(
 *         property="publication_year",
 *         type="integer",
 *         description="Year the movie was published"
 *     ),
 *     @OA\Property(
 *         property="genre",
 *         type="string",
 *         description="Genre of the movie"
 *     ),
 *     @OA\Property(
 *         property="availability",
 *         type="boolean",
 *         description="Availability status of the movie (true if available, false if rented)"
 *     )
 * )
 */

class Movies extends Model
{
    use HasFactory;
    
    public $timestamps = false;

    protected $fillable = [
        'item_id',
        'title',
        'director',
        'publication_year',
        'genre',
        'availability',
    ];
}
