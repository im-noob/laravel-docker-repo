@extends('main')
@section('content')
    @include('form_component')
    <section class="mt-5">
        <div class="row">
            @forelse($tables as $table)
                <div class="col-sm-4">
                    <div class="card mt-2">
                        <div class="card-body" style="text-align: center">
                            {{$table->table_name}}
                            {{$table->capacity}}
                            <br>
                            <form method="POST" action="{{route('book')}}">
                                @csrf
                                <input type="hidden" name="booking_date" value="{{$booking_date}}">
                                <input type="hidden" name="start_time" value="{{$start_time}}">
                                <input type="hidden" name="no_of_person" value="{{$no_of_person}}">
                                <input type="hidden" name="table_id" value="{{$table->id}}">
                                <button class="btn btn-primary">Book</button>
                            </form>
                        </div>
                    </div>
                </div>
            @empty
                No Table Available
            @endforelse
        </div>

    </section>
@endsection
