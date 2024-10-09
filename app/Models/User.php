<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Casts\Attribute;

/**
 * @OA\Schema(
 *     schema="User",
 *     type="object",
 *     title="User",
 *     description="User model",
 *     @OA\Property(
 *         property="user_id",
 *         type="integer",
 *         description="Unique identifier for the user"
 *     ),
 *     @OA\Property(
 *         property="first_name",
 *         type="string",
 *         description="First name of the user"
 *     ),
 *     @OA\Property(
 *         property="last_name",
 *         type="string",
 *         description="Last name of the user"
 *     ),
 *     @OA\Property(
 *         property="email",
 *         type="string",
 *         format="email",
 *         description="Email address of the user"
 *     ),
 *     @OA\Property(
 *         property="user_type",
 *         type="string",
 *         description="Type of user, either 'student' or 'teacher'"
 *     ),
 *     @OA\Property(
 *         property="grade_level",
 *         type="integer",
 *         nullable=true,
 *         description="Grade level of the user (applicable if the user is a student)"
 *     ),
 *     @OA\Property(
 *         property="department",
 *         type="string",
 *         nullable=true,
 *         description="Department of the user (applicable if the user is a teacher)"
 *     ),
 *     @OA\Property(
 *         property="gender",
 *         type="string",
 *         description="Gender of the user"
 *     ),
 *     @OA\Property(
 *         property="rentals",
 *         type="array",
 *         description="List of rentals associated with the user",
 *         @OA\Items(ref="#/components/schemas/Rental")
 *     )
 * )
 */
class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $primaryKey = 'user_id';

    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'first_name',
        'last_name',
        'email',
        'user_type',
        'grade_level',
        'department',
        'gender',
        'password'
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    protected function password()
    {
        return new Attribute(
            null,
            function ($value) {
                return bcrypt($value);
            }
        );
    }

    public function rentals()
    {
        return $this->hasMany(Rentals::class, 'renter_id', 'user_id');
    }
}
