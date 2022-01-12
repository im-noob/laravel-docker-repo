<form class="needs-validation" method="POST" action="{{route('check-booking')}}">
    @csrf
    <div class="row">
        <div class="col-md-4 mb-3">
            <label for="booking_date">Select Date</label>
            <input type="date" class="form-control"
                   id="booking_date"
                   name="booking_date"
                   value="{{$booking_date??''}}"
                   placeholder="Select Date" required>
            <div class="valid-tooltip">
                Looks good!
            </div>
        </div>

        <div class="col-md-4 mb-3">
            <label for="select_time">Select Time</label>
            <select class="form-control" name="select_time" id="select_time">
                <option selected name="">Select Time</option>
                @foreach (\Carbon\CarbonInterval::minutes(15)->toPeriod('08:00', '20:00') as $date)
                    <option value="{{$date->format('H:i')}}"
                        {{$select_time??'' === $date->format('H:i') ? 'selected' : ''}}
                    >{{$date->format('H:i')}}</option>
                @endforeach
            </select>
            <div class="valid-tooltip">
                Looks good!
            </div>
        </div>
        <div class="col-md-4 mb-3">
            <label for="no_of_person">Number of Person</label>
            <input type="text" class="form-control"
                   id="no_of_person"
                   name="no_of_person"
                   value="{{$no_of_person??''}}"
                   placeholder="Number of Person" required>
            <div class="valid-tooltip">
                Looks good!
            </div>
        </div>
    </div>
    <button type="submit" class="btn btn-primary">Submit</button>
</form>
