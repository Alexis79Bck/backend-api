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

    /** ACCESSORS */
    public function getNombreConEstadoAttribute(): string
    {
        $estado = $this->is_active ? 'Activa' : 'Inactiva';
        return "{$this->name} ({$estado})";
    }

    public function getMostrarNombreAttribute(): string
    {
        return ucfirst(strtolower($this->name));
    }

    public function getMostrarTextoEstado(): string
    {
        return $this->is_active ? 'Activa' : 'Inactiva';
    }




}
