<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Modalidad extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'modalidad';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'nombre_modalidad',
        'abreviacion_modalidad',
    ];

    public function contratos()
    {
        return $this->hasMany(Contrato::class,'id_modalidad');
    }
}
