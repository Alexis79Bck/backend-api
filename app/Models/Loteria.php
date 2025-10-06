<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Loteria extends Model
{
    /** TRAITS */
    use SoftDeletes;
    use HasFactory;

    /** ATTRIBUTES */
    protected $table = 'lotteries';
    protected $fillable = [
        'name',
        'slug',
        'is_active',
    ];
    protected $casts = [
        'is_active' => 'boolean',
    ];

    protected $appends = [
        'name_with_status', 
        'display_name', 
        'display_status_text'
    ];


    /** RELATIONSHIPS */
    public function sorteos(): HasMany
    {
        return $this->hasMany(Sorteo::class);
    }
    public function horarios(): HasMany
    {
        return $this->hasMany(Horario::class);
    }

    /** SCOPES */
    public function scopeActiva($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeInactiva($query)
    {
        return $query->where('is_active', false);
    }

    public function scopePorNombre($query, string $name)
    {
        return $query->where('name', 'LIKE', "%{$name}%");
    }

    public function scopeOrdenarPorNombre($query)
    {
        return $query->orderBy('name');
    }

    /** ACCESSORS */
    public function getNameWithStatusAttribute(): string
    {
        $estado = $this->is_active ? 'Activa' : 'Inactiva';
        return "{$this->name} ({$estado})";
    }

    public function getDisplayNameAttribute(): string
    {
        return ucfirst(strtolower($this->name));
    }

    public function getDisplayStatusTextAttribute(): string
    {
        return $this->is_active ? 'Activa' : 'Inactiva';
    }




}
