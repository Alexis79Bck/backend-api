<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Loteria extends Model
{
    /** TRAITS */
    USE SoftDeletes;
    use HasFactory;

    /** ATTRIBUTES */
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
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
}
