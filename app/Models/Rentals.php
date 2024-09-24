<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class rentals extends Model
{
    use HasFactory;

    protected $fillable = [
        'renter_id',
        'rental_date',
        'return_date',
        'returned',
        'renter_id',
        'book_id',
        'movie_id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'renter_id', 'user_id');
    }

    public function movies()
    {
        return $this->belongsTo(Movies::class, 'movie_id', 'item_id');
    }

    public function books()
    {
        return $this->belongsTo(Books::class, 'book_id', 'item_id');
    }
}
