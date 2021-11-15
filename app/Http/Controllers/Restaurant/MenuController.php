<?php

namespace App\Http\Controllers\Restaurant;


use Illuminate\Http\Request;
use App\Models\Restaurant\Menu;
use Inertia\Inertia;


use App\Http\Controllers\Controller;



class MenuController extends Controller
{
    public function post_type(Request $request)
    {
        if ($request->id) {
            Menu::where(["id" => $request->id])
                ->update(["icon" => $request->icon, "type" => $request->type]);
            return response()->json("Kategoria päivitetty", 200);
        } else {
            $menu = new Menu;
            $menu->icon = $request->icon;
            $menu->type = $request->type;
            $menu->save();
            return response()->json(["message" => "Kategoria lisätty", "id" => $menu->id], 200);
        }
    }

    public function post_item(Request $request)
    {
        Menu::where(["type" => $request->type])
            ->update(["json" => $request->json]);

        return response()->json("Lista päivitetty", 200);
    }

    public function delete_item(Request $request)
    {
        Menu::where(["type" => $request->type])
            ->update(["json" => $request->json]);

        return response()->json("Annos poistettu", 200);
    }

    public function delete_type(Request $request)
    {
        if ($request->id) {
            Menu::where(["id" => $request->id])
                ->delete();
            return response()->json("Kategoria poistettu", 200);
        } else return response()->json("Listalta ei löytynyt poistettavaa kategoriaa", 200);
    }

    public function get(Request $request)
    {
        $data = Menu::all();
        foreach ($data as $d) {
            $d->json = json_decode($d->json);
        }
        if ($request->user()) {
            return Inertia::render("Restaurant/Menu", [
                "data" => $data
            ]);
        } else {
            return response($data, 200);
        };
    }
}
