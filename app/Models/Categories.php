<?php

namespace App\Models;

use App\Models\User;
use App\Models\Note;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Categories extends Model
{
    protected $fillable = ['name', 'user_id', 'status'];

    
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function notes()
    {
        return $this->hasMany(Note::class);
    }

    //! Accesor para que el status se muestre como activo o inactivo
    protected function status(): Attribute
    {
        return Attribute::make(
            get: fn($value) => $value == 'active' ? 'activo' : 'inactivo',
            //! fn => funcion flecha
        );
    }
}
