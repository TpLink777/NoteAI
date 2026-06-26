<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use App\Models\User;
use App\Models\Categories;

class Note extends Model
{
    protected $fillable = [
        'title',
        'content',
        'status',
        'user_id',
        'category_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function category()
    {
        return $this->belongsTo(Categories::class);
    }

    protected function status(): Attribute
    {
        return Attribute::make(
            get: fn($value) => $value == 'active' ? 'activo' : 'inactivo',
            //! fn => funcion flecha
        );
    }
}
