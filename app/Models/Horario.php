<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Horario extends Model
{
    /** TRAITS */
    use SoftDeletes;
    use HasFactory;

    /** ATTRIBUTES */
    protected $table = 'schedules';
    protected $fillable = [
        'time',
        'lottery_id',
    ];

    /** RELATIONSHIPS */
    public function loteria()
    {
        return $this->belongsTo(Loteria::class, 'lottery_id');  
    }
    public function sorteos()
    {
        return $this->hasMany(Sorteo::class, 'schedule_id');
    }

    /** SCOPES */
    public function scopePorHora($query, string $time)
    {
        return $query->where('time', 'LIKE', "%{$time}%");  
    }

    
}
