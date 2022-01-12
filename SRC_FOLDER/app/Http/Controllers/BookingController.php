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
        $select_time = $request->select_time;
        $no_of_person = $request->no_of_person;
        $tables = Tables::where('capacity','>=',$no_of_person)->get();

        return view('show', compact(
            'tables',
            'booking_date',
            'select_time',
            'no_of_person'
        ));
    }

    public function store(Request $request)
    {
        $end_time = Carbon::parse($request->select_time)->addHour()->format('h:i');

        $booking = new Booking();
        $booking->booking_date = $request->booking_date;
        $booking->start_time = $request->select_time;
        $booking->end_time = $end_time;
        $booking->no_of_person = $request->no_of_person;
        $booking->table_id = $request->table_id;
        $booking->save();

        return redirect()->route('index')->with('success','Booking Successful.');
    }
}
