<?php

namespace App\Models\Defaults;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class RestaurantData extends Model
{

    use HasFactory;


    protected $table = "defaults";
    protected $fillable = ["title", "json"];
    protected $attributes = [
        "title" => null,
        "json" => null,
    ];
}
