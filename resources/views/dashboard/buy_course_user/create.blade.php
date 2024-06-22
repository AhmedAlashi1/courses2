
@extends('dashboard.layouts.master')
@section('title', __('messages.Add Bay course') )

@section('content')

    <!-- row -->
    <div class="row">
        <div class="col-xl-12">
            <div class="card mg-b-20">
                <div class="card-body">
                    <form id="fileUploadForm" class="needs-validation was-validated" action="{{route('buy_course_user.store')}}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="row row-sm">
                            <input type="hidden" name="user_id" value="{{$id}}">
                            <div class="form-group col-md-6 has-success mg-t-10">
                                <label for="exampleInputEmail1">{{ __('messages.payment_status') }} :</label>
                                <select class="testselect2" required="" name="course_id">
                                    @foreach($courses as $course)
                                    <option value="{{$course->id}}" > {{$course->title_ar}}</option>
                                    @endforeach

                                </select>
                            </div>


                            <div class="modal-footer">
                                <div class="form-group col-md-12 has-success mg-t-20">
                                    <button type="submit" class="btn btn-success" >{{ __('messages.save') }}</button>
                                </div>
                            </div>

                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>

@endsection
@section('script')

    <script src="{{URL::asset('dashboard/js/advanced-form-elements.js')}}"></script>
    <script src="{{URL::asset('dashboard/js/select2.js')}}"></script>
    <script src="{{URL::asset('dashboard/plugins/sumoselect/jquery.sumoselect.js')}}"></script>
@stop
