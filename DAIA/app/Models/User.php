<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Auth;
use PhpParser\Node\Expr\BinaryOp\BooleanOr;

class User extends Authenticatable
{

    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class);
    }

    public function review(): HasMany
    {
        return $this->hasMany(Review::class);
    }

    public function products(): BelongsToMany
    {
        return $this->belongsToMany(Product::class);
    }

    public function events(): BelongsToMany
    {
        return $this->belongsToMany(Event::class);
    }

    public function hasRole(string $role)
    {
        if (Auth::user()->role === $role) return true;
        else return false;
    }

    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'user_name',
        'email',
        'password',
        'role',
        'birthdate',
        'address',
        'first_name',
        'last_name',
        'telephone',
        'user_active'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'user_active'
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
            'birthdate' => 'date',
            'telephone' => 'integer',
            'user_active' => 'boolean'
        ];
    }
}
