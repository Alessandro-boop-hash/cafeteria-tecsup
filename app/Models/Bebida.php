<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Bebida extends Model {
    protected $fillable = ['categoria_id', 'nombre', 'precio', 'imagen'];
    
    public function categoria() {
        return $this->belongsTo(Categoria::class);
    }
}
