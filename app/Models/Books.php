<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @OA\Schema(
 *     schema="Book",
 *     type="object",
 *     title="Book",
 *     description="Book model",
 *     @OA\Property(
 *         property="item_id",
 *         type="integer",
 *         description="Unique identifier for the book"
 *     ),
 *     @OA\Property(
 *         property="title",
 *         type="string",
 *         description="Title of the book"
 *     ),
 *     @OA\Property(
 *         property="author",
 *         type="string",
 *         description="Author of the book"
 *     ),
 *     @OA\Property(
 *         property="publication_year",
 *         type="integer",
 *         description="Year the book was published"
 *     ),
 *     @OA\Property(
 *         property="genre",
 *         type="string",
 *         description="Genre of the book"
 *     ),
 *     @OA\Property(
 *         property="availability",
 *         type="boolean",
 *         description="Availability status of the book (true if available, false if rented)"
 *     )
 * )
 */
class Books extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'item_id',
        'title',
        'author',
        'publication_year',
        'genre',
        'availability',
    ];
}

