<?php

namespace App\Http\Controllers\Defaults;


use Illuminate\Http\Request;
use App\Models\Defaults\RestaurantData as Data;
use Inertia\Inertia;


use App\Http\Controllers\Controller;



class RestaurantController extends Controller
{
    public function post(Request $request)
    {
        Data::where(["title" => $request->title])
            ->update(["json" => $request->json]);

        return response()->json("Oletusasetukset päivitetty", 200);
    }

    public function get(Request $request)
    {
        $data = Data::all();
        foreach ($data as $d) {
            $d->json = json_decode($d->json);
        }
        if ($request->user()) {
            return Inertia::render("Restaurant/Data", [
                "data" => $data
            ]);
        } else {
            return response($data, 200);
        };
    }

    public function get_lunches_defaults()
    {
        $data = Data::where(["title" => "lunch"])->get();
        foreach ($data as $d) {
            $d->json = json_decode($d->json);
        }
        return response($data, 200);
    }
}
