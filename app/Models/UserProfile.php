<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserProfile extends Model
{
    /** TRAITS */
    use HasFactory;

    /** ATTRIBUTES */
    protected $table = 'users_profiles';

    protected $fillable = [
        // 'user_id',
        'first_name',
        'last_name',
        'birthdate',
        'gender',
        'country',
        'phone',
        'bio',
    ];

    protected $appends = [
        'full_name',
        'age',
        'display_gender'
    ];

    /** RELATIONSHIPS */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /** SCOPES */
    public function scopePorPais($query, string $country)
    {
        return $query->where('country', 'LIKE', "%$country%");
    }

    public function scopePorGenero($query, string $gender)
    {
        return $query->where('gender', 'LIKE', "%$gender%");
    }

    public function scopePorNombreOApellido($query, string $name)
    {
        return $query->where('first_name', 'LIKE', "%$name%")
            ->orWhere('last_name', 'LIKE', "%$name%");
    }

    public function scopePorTelefono($query, string $phone)
    {
        return $query->where('phone', 'LIKE', "%$phone%");
    }

    public function scopePorFechaDeNacimiento($query, string $birthdate)
    {
        return $query->where('birthdate', 'LIKE', "%$birthdate%");
    }

    /** ACCESSORS */
    public function getFullNameAttribute(): string
    {
        return trim("{$this->first_name} {$this->last_name}");
    }

    public function getAgeAttribute(): ?int
    {
        if (!$this->birthdate) {
            return null;
        }

        $birthDate = \Carbon\Carbon::parse($this->birthdate);
        $currentDate = \Carbon\Carbon::now();

        return $birthDate->diffInYears($currentDate);
    }

    public function getDisplayGenderAttribute(): string
    {
        return match ($this->gender) {
            'male' => 'Masculino',
            'female' => 'Femenino',
            'other' => 'Otro'
        };
    }
}
