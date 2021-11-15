<?php

namespace App\Models\Portions;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Portion extends Model
{
    use HasFactory;

    protected $table = "portions";
    protected $fillable = ["title", "body", "ingredients", "allergenic", "price", "price_additional"];
    protected $attributes = [
        "title" => null,
        "body" => null,
        "ingredients" => null,
        "allergenic" => null,
        "price" => null,
        "price_additional" => null,
    ];

    public function scopeSearch($query, $keywords)
    {
        return $query->where("title", "LIKE", "%" . $keywords . "%");
    }
}
