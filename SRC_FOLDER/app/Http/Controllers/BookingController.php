<?php

namespace App\Http\Controllers;

use App\Booking;
use App\Tables;
use Carbon\Carbon;
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
        $start_time = Carbon::parse($booking_date . $request->start_time);
        $end_time = Carbon::parse($booking_date . $request->start_time)->addHour();

        /* Table already booked on that particular */
        $table_already_booked = Booking::where(function ($query) use ($start_time, $end_time) {
                $query->where('start_time', '<', $end_time)
                    ->Where('end_time', '>', $start_time);
            })
            ->get()
            ->pluck('table_id');

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
        $start_time = Carbon::parse($request->booking_date . $request->start_time);
        $end_time = Carbon::parse($request->booking_date . $request->start_time)->addHour();

        $booking = new Booking();
        $booking->first_name = $request->first_name;
        $booking->last_name = $request->last_name;
        $booking->email = $request->email;
        $booking->phone_no = $request->phone_no;

        $booking->booking_date = $request->booking_date;
        $booking->start_time = $start_time;
        $booking->end_time = $end_time;
        $booking->no_of_person = $request->no_of_person;
        $booking->table_id = $request->table_id;
        $booking->save();

        return redirect()->route('index')->with('success','Booking Successful.');
    }
}
