<?php

namespace App\Http\Controllers;

use App\Booking;
use App\Tables;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
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



        /*Adding Restaurant Validations */
        $not_allowed = false;
        $closed_time = false;
        $past_time = false;
        $two_horus_before = false;
        $hours_left = Carbon::now()->diffInHours($start_time, false);
//        dd($hours_left);
        if ($hours_left < 0) {
            $not_allowed = true;
            $err_message = "Select future date and time. ";
        }else if ($hours_left < 2) {
            $not_allowed = true;
            $err_message = 'You can make a reservation min 2 hours before the reservation time slot.';
        }else if ($closed_time) {
            $not_allowed = true;
            $err_message = "Restaurant doesn't allow online reservation on following day of week and timings.
                    Saturday 3 to 8 PM
                    Sunday 8 AM to 8 PM";
        }
        if ($not_allowed) {
            $tables = [];
            redirect()->route('index')->with('error','Booking Successful.');
            return back()->with('error',$err_message??'');
        }




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

    public function store(Request $request): RedirectResponse
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
