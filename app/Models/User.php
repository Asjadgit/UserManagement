<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, HasRoles, HasApiTokens;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'status',
        'last_login_at',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
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

    public function teams()
    {
        return $this->belongsToMany(Team::class, 'team_user');
    }

    public function managedTeam()
    {
        return $this->hasMany(Team::class, 'manager_id');
    }

    public function visibilityGroups()
    {
        return $this->belongsToMany(VisibilityGroup::class, 'user_visibility_group');
    }

    // One-to-Many Relationship with UserMeta
    public function meta()
    {
        return $this->hasMany(UserMeta::class);
    }

    public function getMeta($key)
    {
        return $this->meta()->where('meta_key', $key)->value('meta_value');
    }

    public function setMeta($key, $value)
    {
        return $this->meta()->updateOrCreate(
            ['meta_key' => $key, 'user_id' => $this->id], // Ensure user_id is included
            ['meta_value' => $value]
        );
    }

    // // Relationships
    // public function createdDeals()
    // {
    //     return $this->hasMany(Deal::class, 'created_by');
    // }

    // public function assignedDeals()
    // {
    //     return $this->hasMany(Deal::class, 'assigned_to');
    // }

    // public function ownedDeals()
    // {
    //     return $this->hasMany(Deal::class, 'owner_id');
    // }

}
