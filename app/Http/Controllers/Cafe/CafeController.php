<?php

namespace App\Http\Controllers\Cafe;


use Illuminate\Http\Request;
use App\Models\Cafe\Cafe;
use App\Models\Cafe\Data;
use Inertia\Inertia;


use App\Http\Controllers\Controller;



class CafeController extends Controller
{
    public function post_type(Request $request)
    {
        if ($request->id) {
            Cafe::where(["id" => $request->id])
                ->update(["icon" => $request->icon, "type" => $request->type]);
            return response()->json("Kategoria päivitetty", 200);
        } else {
            $cafe = new Cafe;
            $cafe->icon = $request->icon;
            $cafe->type = $request->type;
            $cafe->save();
            return response()->json(["message" => "Kategoria lisätty", "id" => $cafe->id], 200);
        }
    }

    public function post_item(Request $request)
    {
        Cafe::where(["type" => $request->type])
            ->update(["json" => $request->json]);

        return response()->json("Lista päivitetty", 200);
    }

    public function delete_item(Request $request)
    {
        Cafe::where(["type" => $request->type])
            ->update(["json" => $request->json]);

        return response()->json("Annos poistettu", 200);
    }

    public function delete_type(Request $request)
    {
        if ($request->id) {
            Cafe::where(["id" => $request->id])
                ->delete();
            return response()->json("Kategoria poistettu", 200);
        } else return response()->json("Listalta ei löytynyt poistettavaa kategoriaa", 200);
    }

    public function get(Request $request)
    {
        $data = Cafe::all();
        foreach ($data as $d) {
            $d->json = json_decode($d->json);
        }
        if ($request->user()) {
            return Inertia::render('Cafe/Cafe', [
                "data" => $data
            ]);
        } else {
            return response($data, 200);
        };
    }
}
