<?php

namespace App\Models\ServiceHours;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class ServiceHour extends Model
{
    use HasFactory;

    protected $table = "service_hours";
    protected $fillable = ["title", "json", "closed_until"];
    protected $attributes = [
        "title" => null,
        "json" => null,
        "closed_until" => null,
    ];
}
