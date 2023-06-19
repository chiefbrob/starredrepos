<?php

namespace App\Models;

use App\Traits\CanBlog;
use App\Traits\CanTeamUp;
use App\Traits\HasGithubToken;
use App\Traits\HasRoles;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens;
    use HasFactory;
    use Notifiable;
    use HasRoles;
    use SoftDeletes;
    use CanBlog;
    use CanTeamUp;
    use HasGithubToken;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'username',
        'name',
        'email',
        'phone_number',
        'phone_number_verified_at',
        'password',
        'photo',
        'language',
        'details',
        'team_id',
    ];

    protected $appends = ['admin', 'rolesList'];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'details' => 'array',
    ];

    public function isAdmin()
    {
        $role = Role::where('name', 'admin')->firstOrCreate(['name' => 'admin']);

        return $this->hasRole($role) ? true : $this->email === config('app.email');
    }

    public function getAdminAttribute()
    {
        return $this->isAdmin();
    }

    public function contacts(): HasMany
    {
        return $this->hasMany(Contact::class);
    }

    public function addresses(): HasMany
    {
        return $this->hasMany(Address::class);
    }
}