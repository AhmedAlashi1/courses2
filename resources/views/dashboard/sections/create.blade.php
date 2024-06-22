
@extends('dashboard.layouts.master')
@section('title', __('messages.Add Muscles') )

@section('content')

    <!-- row -->
    <div class="row">
        <div class="col-xl-12">
            <div class="card mg-b-20">
                <div class="card-body">
                    <form id="fileUploadForm" class="needs-validation was-validated" action="{{route('section.store')}}" method="post" enctype="multipart/form-data">
                        @csrf

                        <input  type="hidden" name="courses_id" value="{{$id}}">
                        <div class="row row-sm">
                            <div class="form-group col-md-6 has-success mg-t-10">
                                <label for="title_ar">{{ __('messages.name in arabic') }}  :</label>
                                <input value="{{old('title_ar')}}" id="title_ar" type="text" class="form-control " name="title_ar"  required>
                                @error('name_ar')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group col-md-6 has-success mg-t-10">
                                <label for="exampleInputEmail1">{{ __('messages.payment_status') }} :</label>
                                <select class="testselect2" required="" name="is_paid">
                                    <option value="0" >Free</option>
                                    <option value="1" >Paid</option>
                                </select>
                            </div>
{{--                            <div class="form-group col-md-6 has-success mg-t-10">--}}
{{--                                <label for="name_en">{{ __('messages.name in english') }}  :</label>--}}
{{--                                <input value="{{old('name_en')}}" id="name_en" type="text" class="form-control " name="title_en"  required>--}}
{{--                                @error('name_en')--}}
{{--                                <span class="text-danger">{{ $message }}</span>--}}
{{--                                @enderror--}}
{{--                            </div>--}}
{{--                            <div class="form-group col-md-12 has-success mg-t-10">--}}
{{--                                <label for="image">{{ __('messages.photo') }}  :</label>--}}
{{--                                <input id="image" type="file" class="form-control " name="photo"  required>--}}
{{--                                @error('photo')--}}
{{--                                <span class="text-danger">{{ $message }}</span>--}}
{{--                                @enderror--}}
{{--                            </div>--}}

                            <div class="modal-footer">
                                <div class="form-group col-md-12 has-success mg-t-20">
                                    <button type="submit" class="btn btn-success" >{{ __('messages.save') }}</button>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="progress">
                                    <div class="progress-bar progress-bar-striped progress-bar-animated bg-green"
                                         role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"
                                         style="width: 0%; background-color: green">

                                    </div>
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


