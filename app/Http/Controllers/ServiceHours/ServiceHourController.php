<?php

namespace App\Http\Controllers\ServiceHours;


use Illuminate\Http\Request;
use App\Models\ServiceHours\ServiceHour;
use Inertia\Inertia;


use App\Http\Controllers\Controller;

class ServiceHourController extends Controller
{
    public function get(Request $request)
    {
        if ($request->user()) {
            $data = ServiceHour::all();
            foreach ($data as $d) {
                $d->json = json_decode($d->json);
            }
            return Inertia::render('ServiceHours/ServiceHours', [
                "data" => $data
            ]);
        } else {
            $data = ServiceHour::where(["title" => $request->title])->get();
            foreach ($data as $d) {
                $d->json = json_decode($d->json);
            }
            return response($data, 200);
        };
    }
    public function get_closed_until(Request $request)
    {
        $data = ServiceHour::where(["title" => $request->title])->get();
        foreach ($data as $d) {
            $d->json = json_decode($d->json);
        }
        return response($data[0]->closed_until, 200);
    }
    public function post(Request $request)
    {
        ServiceHour::where(["title" => $request->title])
            ->update(["closed_until" => $request->closed_until, "json" => $request->json]);

        $title = __($request->title);
        return response()->json("Aukioloajat " . $title . "lle on päivitetty", 200);
    }
}
