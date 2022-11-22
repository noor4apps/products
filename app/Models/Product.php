<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'image', 'description'];

    protected function imgFullPath(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => asset('storage/' . $this->image),
        );
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'user_product');
    }
}
