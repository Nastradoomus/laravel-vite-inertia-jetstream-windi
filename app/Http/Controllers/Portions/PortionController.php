<?php

namespace App\Http\Controllers\Portions;


use Illuminate\Http\Request;
use App\Models\Portions\Portion;

use App\Http\Controllers\Controller;

class PortionController extends Controller
{
    public function post(Request $request)
    {
        if ($request->id) {
            Portion::where(["id" => $request->id])
                ->update(["title" => $request->title, "body" => $request->body, "ingredients" => $request->ingredients, "allergenic" => $request->allergenic, "price" => $request->price, "price_additional" => $request->price_additional]);
            return response()->json("Annoskortti päivitetty", 200);
        } else {
            $portion = new Portion;
            $portion->title = $request->title;
            $portion->body = $request->body;
            $portion->ingredients = $request->ingredients;
            $portion->allergenic = $request->allergenic;
            $portion->price = $request->price;
            $portion->price_additional = $request->price_additional;
            $portion->save();
            return response()->json(["message" => "Annoskortti lisätty", "id" => $portion->id], 200);
        }
    }

    public function search(Request $request)
    {
        $data = Portion::search($request->title)->orderBy("title", "asc")->get();
        if (count($data) == 0) return response(null, 200);
        foreach ($data as $d) {
            $d->json = json_decode($d->json);
        }
        return response($data, 200);
    }

    public function get()
    {
        $data = Portion::all();
        foreach ($data as $d) {
            $d->json = json_decode($d->json);
        }
        return response($data, 200);
    }

    public function check(Request $request)
    {
        $data = Portion::where(["title" => $request->title])->get();
        if (count($data) == 0) return response("true", 200);
        return response("false", 200);
    }
}
