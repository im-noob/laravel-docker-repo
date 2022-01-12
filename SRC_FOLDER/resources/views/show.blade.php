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
                            <br>
                            <button class="btn btn-primary collect-details"
                                    table_id="{{$table->id}}"
                                    data-toggle="modal"
                                    data-target="#collect-details">Book</button>
                        </div>
                    </div>
                </div>
            @empty
                No Table Available
            @endforelse
        </div>

    </section>


    <!-- Modal -->
    <div class="modal fade" id="collect-details" tabindex="-1" role="dialog" aria-labelledby="collect-details" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">Book Reservation</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{route('book')}}" method="post">
                        @csrf
                        <input type="hidden" name="booking_date" value="{{$booking_date}}">
                        <input type="hidden" name="start_time" value="{{$start_time}}">
                        <input type="hidden" name="no_of_person" value="{{$no_of_person}}">
                        <input type="hidden" name="table_id" value="" id="table_id">

                        <div class="row">
                            <div class="col-sm-6">
                                <div class="mb-3">
                                    <label for="first_name" class="form-label">First Name</label>
                                    <input type="text" class="form-control" id="first_name" name="first_name" required>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="mb-3">
                                    <label for="last_name" class="form-label">Last Name</label>
                                    <input type="text" class="form-control" id="last_name" name="last_name" required>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="mb-3">
                                    <label for="email" class="form-label">Email address</label>
                                    <input type="email" class="form-control" id="email" name="email" required>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="mb-3">
                                    <label for="phone_no" class="form-label">Phone no</label>
                                    <input type="tel" class="form-control" id="phone_no" name="phone_no" required>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Book Now</button>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>

    @push('script')
        <script>
            $(function () {
                $('.collect-details').on('click', function () {
                    $('#collect-details').modal('show')
                    $('#table_id').val($(this).attr('table_id'));
                });
                $('[data-dismiss="modal"]').on('click', function () {
                    $('#collect-details').modal('hide')
                });
            });
        </script>
    @endpush
@endsection
