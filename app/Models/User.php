<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    /** TRAITS */
    use HasFactory;
    use Notifiable;
    use HasApiTokens;
    use HasRoles;

    /** ATTRIBUTES */
    protected $fillable = [
        'uuid',
        'name',
        'email',
        'password',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'email_verified_at' => 'datetime',
        'password' => 'hashed'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $appends = [
        'name_with_status', 
        'display_name', 
        'display_status_text',
        'email_with_status',
        'display_email'
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    // protected function casts(): array
    // {
    //     return [
    //         'email_verified_at' => 'datetime',
    //         'password' => 'hashed',
    //     ];
    // }

    /** RELATIONSHIPS */
    public function profile(): HasOne
    {
        return $this->hasOne(UserProfile::class);
    }

    /** SCOPES */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeInactive($query)
    {
        return $query->where('is_active', false);
    }

    public function scopePorNombre($query, string $name)
    {
        return $query->where('name', 'LIKE', "%{$name}%");
    }

    public function scopePorEmail($query, string $email)
    {
        return $query->where('email', 'LIKE', "%{$email}%");
    }

    /** ACCESSORS */
    public function getDisplayNameAttribute(): string
    {
        return ucfirst(strtolower($this->name));
    }

    public function getDisplayStatusTextAttribute(): string
    {
        return $this->is_active ? 'Activo' : 'Inactivo';
    }

    public function getNameWithStatusAttribute(): string
    {
        $estado = $this->is_active ? 'Activo' : 'Inactivo';
        return "{$this->name} ({$estado})";
    }

    public function getEmailWithStatusAttribute(): string
    {
        $estado = $this->is_active ? 'Activo' : 'Inactivo';
        return "{$this->email} ({$estado})";
    }

    public function getDisplayEmailAttribute(): string
    {
        return strtolower($this->email);
    }
}
