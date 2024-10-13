<?php

namespace App\Models;

use App\Models\Categoria;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Producto extends Model
{
    use HasFactory;

    protected $fillable=[
        'codigo',
        'nombre',
        'precio',
        'cantidad',
        'imagen'
    ];

    public function categorias()
    {
        return $this->belongsToMany(Categoria::class, 'categ_prod');
    }
}
