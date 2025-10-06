<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class FuenteScraper extends Model
{
    /** TRAITS */
    use SoftDeletes;
    use HasFactory;

    /** ATTRIBUTES */
    protected $table = 'scraping_sources';
    protected $fillable = [
        'source_name',
        'source_url',
        'script',
        'start_date',
        'end_date',
        'processed_at',
        'is_valid'
    ];
    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'processed_at' => 'datetime',
        'is_valid' => 'boolean',
    ];

    /** RELATIONSHIPS */
    public function resultados()
    {
        return $this->hasMany(Resultado::class, 'scraping_source_id');
    }

    /** SCOPES */
    public function scopeValidas($query)
    {
        return $query->where('is_valid', true);
    }
    public function scopeInvalidas($query)
    {
        return $query->where('is_valid', false);
    }
    public function scopePorNombre($query, string $name)
    {
        return $query->where('name', 'LIKE', "%{$name}%");
    }
    public function scopeProcesadas($query)
    {
        return $query->whereNotNull('processed_at');
    }
    public function scopeNoProcesadas($query)
    {
        return $query->whereNull('processed_at');
    }
    
}
