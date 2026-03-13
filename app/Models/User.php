<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Tymon\JWTAuth\Contracts\JWTSubject;


class User extends Authenticatable implements JWTSubject
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'address',
        'phone',
        'city',
        'state',
        'profile_image',
        'role'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];


    public function orders()        { return $this->hasMany(Order::class); }
    public function cart()          { return $this->hasMany(Cart::class); }
    public function reviews()       { return $this->hasMany(Review::class); }
    public function chats()         { return $this->hasMany(Chat::class); }
    public function notifications() { return $this->hasMany(Notification::class); }
 
    // ── Helpers ───────────────────────────────────────────────────────────
    // public function isAdmin(): bool
    // {
    //     return $this->role === '1';
    // }
 
    public function getInitialAttribute(): string
    {
        return strtoupper(substr($this->name, 0, 1));
    }
 
    public function getProfileImageUrlAttribute(): string
    {
        return $this->profile_image
            ? asset('storage/' . $this->profile_image)
            : 'https://ui-avatars.com/api/?name=' . urlencode($this->name) . '&background=1A3C6E&color=fff';
    }

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [];
    }

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
}
