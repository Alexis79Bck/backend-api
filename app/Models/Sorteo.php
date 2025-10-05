<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Sorteo extends Model
{
    /** TRAITS */
    use SoftDeletes;
    use HasFactory;

    /** ATTRIBUTES */
    protected $table = 'draws';
    protected $fillable = [       
        'lottery_id',
        'schedule_id',
        'description',
        'slug',
        'is_active',
    ];
    protected $casts = [
        'is_active' => 'boolean',
    ];

    /** RELATIONSHIPS */
    public function loteria()
    {
        return $this->belongsTo(Loteria::class, 'lottery_id');  
    }

    public function horario()
    {
        return $this->belongsTo(Horario::class, 'schedule_id');  
    }

    /** SCOPES */
    public function scopeActivo($query)
    {
        return $query->where('is_active', true);    
    }
    public function scopeInactivo($query)
    {
        return $query->where('is_active', false);    
    }
    public function scopePorDescripcion($query, string $description)
    {
        return $query->where('description', 'LIKE', "%{$description}%");
    }
    

}
