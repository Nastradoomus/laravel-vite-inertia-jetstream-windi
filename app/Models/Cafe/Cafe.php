<?php

namespace App\Models\Cafe;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Cafe extends Model
{

    use HasFactory;

    protected $table = "cafe_menu_items";
    protected $fillable = ["type", "icon", "json"];
    protected $attributes = [
        "json" => null,
        "icon" => null,
        "type" => null,
    ];
}
