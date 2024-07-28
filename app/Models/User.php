<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $table = "users";

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */

    // database fields
    protected $fillable = [
        'firstname',
        'lastname',
        'address',
        'phone',
        'email',
        'approval',
        'no_of_trainees',
        'trainees_for_today',
        'password',
        'role',
        'status'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    // this function returns the relationship that users have with each booking
    // each user can have many bookings (reservations)
    // first parameter is the Model class that we want the relationship to be formed with
    // second parameter is the field that is powering that relationship
        // i.e. a common field between the two tables (foreign key)
    public function memberBookings() {
        return $this->hasMany(Booking::class, 'user_id');
    }

}
