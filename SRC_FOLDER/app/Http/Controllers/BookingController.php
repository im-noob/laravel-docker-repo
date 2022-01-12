<?php

namespace App\Http\Controllers;

use App\Booking;
use App\Tables;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    public function index()
    {
        return view('index');
    }

    public function show(Request $request)
    {

        $booking_date = $request->booking_date;
        $no_of_person = $request->no_of_person;
        $start_time = Carbon::parse($request->start_time)->format('h:i');
        $end_time = Carbon::parse($request->start_time)->addHour()->format('h:i');

        /* Table already booked on that particular */
        $table_already_booked = Booking::where('booking_date', $booking_date)
            ->where(function ($query) use ($start_time, $end_time) {
                $query->where(static function ($query) use ($end_time, $start_time) {
                    $query->where('start_time', '<=', $start_time)
                        ->where('start_time', '<=', $end_time);
                })
                    ->orWhere(static function ($query) use ($end_time, $start_time) {
                        $query->where('end_time', '>=', $start_time)
                            ->where('end_time', '>=', $end_time);
                    });
            })
            ->get()
            ->pluck('table_id');
//            ->toSql();
//        dd($table_already_booked);

        $tables = Tables::where('capacity','>=',$no_of_person)
            ->whereNotIn('id',$table_already_booked)
            ->get();

        $start_time = $request->start_time;
        return view('show', compact(
            'tables',
            'booking_date',
            'start_time',
            'no_of_person'
        ));
    }

    public function store(Request $request)
    {
        $end_time = Carbon::parse($request->start_time)->addHour()->format('h:i');

        $booking = new Booking();
        $booking->booking_date = $request->booking_date;
        $booking->start_time = $request->start_time;
        $booking->end_time = $end_time;
        $booking->no_of_person = $request->no_of_person;
        $booking->table_id = $request->table_id;
        $booking->save();

        return redirect()->route('index')->with('success','Booking Successful.');
    }
}
