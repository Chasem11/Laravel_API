<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Tymon\JWTAuth\Contracts\JWTSubject;

/**
 * @OA\Schema(
 *     schema="User",
 *     type="object",
 *     title="User",
 *     description="User model representing an individual user in the system",
 *     required={"user_id", "first_name", "last_name", "email", "user_type", "password"},
 *     
 *     @OA\Property(
 *         property="user_id",
 *         type="integer",
 *         description="Unique identifier for the user",
 *         example=1
 *     ),
 *     @OA\Property(
 *         property="first_name",
 *         type="string",
 *         description="First name of the user",
 *         example="John"
 *     ),
 *     @OA\Property(
 *         property="last_name",
 *         type="string",
 *         description="Last name of the user",
 *         example="Doe"
 *     ),
 *     @OA\Property(
 *         property="email",
 *         type="string",
 *         format="email",
 *         description="Email address of the user",
 *         example="johndoe@example.com"
 *     ),
 *     @OA\Property(
 *         property="user_type",
 *         type="string",
 *         enum={"student", "teacher"},
 *         description="Type of user, either 'student' or 'teacher'",
 *         example="student"
 *     ),
 *     @OA\Property(
 *         property="grade_level",
 *         type="integer",
 *         nullable=true,
 *         description="Grade level of the user (applicable only if the user is a student)",
 *         example=10
 *     ),
 *     @OA\Property(
 *         property="department",
 *         type="string",
 *         nullable=true,
 *         description="Department of the user (applicable only if the user is a teacher)",
 *         example="Mathematics"
 *     ),
 *     @OA\Property(
 *         property="gender",
 *         type="string",
 *         description="Gender of the user",
 *         example="male"
 *     ),
 *     @OA\Property(
 *         property="password",
 *         type="string",
 *         format="password",
 *         description="Password for the user's account",
 *         example="securepassword123"
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
    use HasFactory, Notifiable;

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

     /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }
}
