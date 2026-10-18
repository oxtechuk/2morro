<?php

namespace App\Models;

use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Storage;

class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $guarded = ['id'];

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
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function orders(): HasMany
    {
        return $this->hasMany(Order::class);
    }

    public function downloads(): HasMany
    {
        return $this->hasMany(Download::class);
    }

    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class);
    }

    public function profile(): HasOne
    {
        return $this->hasOne(CustomerProfile::class);
    }

    public function crmLogs(): HasMany
    {
        return $this->hasMany(CrmLog::class);
    }

    public function isAdmin(): bool
    {
        return str_ends_with($this->email, '@2morro.com') 
            || $this->email === 'admin@2morro.com' 
            || str_contains(strtolower($this->email), 'admin')
            || ($this->role ?? '') === 'admin'
            || app()->environment('local');
    }

    public function hasRole(string|array $roles): bool
    {
        if ($this->isAdmin()) {
            return true;
        }
        $roles = (array) $roles;
        return in_array($this->role ?? '', $roles);
    }

    public function getRoleNames()
    {
        $role = $this->role ?? ($this->isAdmin() ? 'root' : 'customer');
        return collect([$role]);
    }

    public function thumbnail(): Attribute
    {
        $thumbnail = asset('default/profile.jpg');
        return Attribute::make(
            get: fn() => $thumbnail
        );
    }

    public function fullName(): Attribute
    {
        return Attribute::make(
            get: fn() => trim(($this->name ?? '') . ' ' . ($this->last_name ?? '')) ?: $this->name
        );
    }

    public function scopeRole($query, $role)
    {
        return $query->where('role', $role);
    }

    public function scopeIsActive($query)
    {
        return $query->where('is_active', true);
    }
}
