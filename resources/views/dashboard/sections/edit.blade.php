
@extends('dashboard.layouts.master')
@section('title', __('messages.update Muscles') )

@section('content')

    <!-- row -->
    <div class="row">
        <div class="col-xl-12">
            <div class="card mg-b-20">
                <div class="card-body">
{{--                    <div class="row row-xs align-items-center mg-b-20">--}}
{{--                        <div class="col-md-4">--}}
{{--                            <div class="main-img-user"><img alt="" src="{{ $sections->image != '' ? asset($sections->image) : asset('dashboard/img/users/6.jpg') }}" class=""></div>--}}
{{--                        </div>--}}

{{--                    </div>--}}
                    <form id="fileUploadForm" class="needs-validation was-validated" action="{{route('section.update',$sections->id)}}" method="post" enctype="multipart/form-data">
                        @method('PUT')
                        @csrf
                        <div class="row row-sm">
                            <div class="form-group col-md-6 has-success mg-t-10">
                                <label for="title_ar">{{ __('messages.name in arabic') }}  :</label>
                                <input id="title_ar" type="text" class="form-control " name="title_ar" value="{{$sections->title_ar}}"  required>
                                @error('title_ar')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group col-md-6 has-success mg-t-10">
                                <label for="exampleInputEmail1">{{ __('messages.payment_status') }} :</label>
                                <select class="testselect2" required="" name="is_paid">
                                    <option value="1"  >Paid</option>
                                    <option value="0" @if($sections->is_paid != 1) selected @endif>Free</option>
                                </select>
                            </div>
{{--                            <div class="form-group col-md-6 has-success mg-t-10">--}}
{{--                                <label for="name_en">{{ __('messages.name in english') }}  :</label>--}}
{{--                                <input id="name_en" type="text" class="form-control " name="title_en" value="{{$sections->title_en}}"  required>--}}
{{--                                @error('name_en')--}}
{{--                                <span class="text-danger">{{ $message }}</span>--}}
{{--                                @enderror--}}
{{--                            </div>--}}
{{--                            <div class="form-group col-md-12 has-success mg-t-10">--}}
{{--                                <label for="image">{{ __('messages.photo') }}  :</label>--}}
{{--                                <input id="image" type="file" class="form-control " name="photo">--}}
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
