<?php

namespace App\Models\Restaurant;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Menu extends Model
{

    use HasFactory;

    protected $table = "restaurant_menu_items";
    protected $fillable = ["type", "icon", "json"];
    protected $attributes = [
        "json" => null,
        "icon" => null,
        "type" => null,
    ];
}
