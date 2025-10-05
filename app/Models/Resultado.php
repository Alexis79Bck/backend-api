<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Resultado extends Model
{
    /** TRAITS */
    use SoftDeletes;
    use HasFactory;

    /** ATTRIBUTES */
    protected $table = 'results';
    protected $fillable  = [
        'draw_id',
        'animal_id',
        'date',
        'processed',
        'scraping_source_id',
    ];
    protected $casts = [
        'date' => 'date',
        'processed' => 'boolean',
    ];

    /** RELATIONSHIPS */
    public function sorteo()
    {
        return $this->belongsTo(Sorteo::class, 'draw_id');  
    }

    public function animal()
    {
        return $this->belongsTo(Animal::class, 'animal_id');  
    }

    public function fuenteScraper() {
        return $this->belongsTo(FuenteScraper::class, 'scraping_source_id');  
    }

    /** SCOPES */
    public function scopeProcesado($query)
    {
        return $query->where('processed', true);
    }
    public function scopeNoProcesado($query)
    {
        return $query->where('processed', false);
    }
    public function scopePorFecha($query, string $date)
    {
        return $query->where('date', 'LIKE', "%{$date}%");
    }

}
