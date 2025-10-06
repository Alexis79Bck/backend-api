<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Animal extends Model
{
    /** TRAITS */
    use SoftDeletes;
    use HasFactory;

    /** ATTRIBUTES */
    protected $table = 'animals';
    protected $fillable = [
        'name',
        'number',
        'color',
        'rulette_sector',
        'image_path',
    ];
    protected $casts = [
        'number' => 'string',
    ];

    protected $appends = [
        'number_and_name', 
        'full_info'
    ];

    /** RELATIONSHIPS */
    public function resultados()
    {
        return $this->hasMany(Resultado::class);
    }

    /** SCOPES */
    public function scopePorNombre($query, string $name)
    {
        return $query->where('name', 'LIKE', "%$name%");
    }

    public function scopePorNumero($query, $number)
    {
        return $query->where('number', $number);
    }

    public function scopePorColor($query, string $color)
    {
        return $query->where('color', 'LIKE', "%$color%");
    }

    public function scopePorSectorEnRuleta($query, string $sector)
    {
        return $query->where('rulette_sector', $sector);
    }

    /** ACCESSORS */
    public function getNumberAndNameAttribute(): string
    {       
        return "{$this->number} - {$this->name}";
    }
    public function getFullInfoAttribute(): string
    {       
        return ucfirst(strtolower($this->name)) . ' - ' . $this->number . ' - ' . strtoupper($this->color);
    }



}
