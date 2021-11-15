<?php

namespace App\Http\Controllers\Restaurant;

use LimitIterator;

use Illuminate\Http\Request;
use App\Models\Restaurant\Lunch;
use Helpers\Date\DateRangeIterator;

use App\Http\Controllers\Controller;



class LunchController extends Controller
{
    public function post_date(Request $request)
    {
        Lunch::where(["date" => $request->date])
            ->update(["price" => $request->price, "price_additional" => $request->price_additional, "type" => $request->type, "serving_time" => $request->serving_time]);

        return response()->json("Päivä päivitetty", 200);
    } //end postLunch()

    public function post_defaults(Request $request)
    {
        foreach ($request->toArray() as $data) {
            if ($data["price"] == "null") {
                $data["price"] = "";
            }
            if ($data["price_additional"] == "null") {
                $data["price_additional"] = "";
            }
            Lunch::where(["date" => $data["date"]])
                ->update(["serving_time" => $data["serving_time"], "price" => $data["price"], "price_additional" => $data["price_additional"], "type" => $data["type"]]);
        }
        return response()->json("Päivien oletusarvot päivitetty", 200);
    } //end postLunch()

    public function post_lunch(Request $request)
    {
        Lunch::where(["date" => $request->date])
            ->update(["json" => $request->json]);

        return response()->json("Lounas päivitetty", 200);
    } //end postLunch()

    public function delete_lunch(Request $request)
    {
        Lunch::where(["date" => $request->date])
            ->update(["json" => $request->json]);

        return response()->json("Annos poistettu", 200);
    } //end postLunch()

    public function get(Request $request)
    {

        $start = $request->start_date;
        $end = $request->end_date;
        $max = 50;

        $lunches = Lunch::whereBetween("date", [$start, $end])->orderBy("date", "asc")->limit($max)->get();


        $dates = [];
        foreach (new LimitIterator(new DateRangeIterator($start, $end), 0, $max) as $date) {
            array_push($dates, $date);
        }
        if ($request->user()) {
            $dates_missing = [];

            foreach ($dates as $date) {
                if ($lunches->contains("date", $date) === false) {
                    $lunches->push((object)["date" => $date, "json" =>  "", "serving_time" => ""]);
                    array_push($dates_missing, $date);
                }
            }
        }
        foreach ($lunches as $lunch) {
            if ($request->user()) {
                if (array_search($lunch->date, $dates_missing) !== false) {
                    Lunch::create(["date" => $lunch->date]);
                }
            }
            $lunch->json = json_decode($lunch->json);
            $lunch->serving_time = json_decode($lunch->serving_time);
        }
        return response($lunches, 200);
    } //end get()
}//end class
