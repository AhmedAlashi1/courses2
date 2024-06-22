
@extends('dashboard.layouts.master')
@section('title', __('messages.Videos') )
@section('content')

    <!-- row -->
    <div class="row">
        <div class="col-xl-12">
            <div class="card mg-b-20">

                <div class="card-body">
                    <form id="fileUploadForm" class="needs-validation was-validated" action="{{route('videos.update',$video->id)}}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="row row-sm">

{{--                            <input type="hidden" name="section_id" value="{{$section_id}}">--}}
{{--                            <div class="form-group col-md-6 has-success mg-t-10">--}}
{{--                                <label for="exampleInputEmail1">{{ __('messages.courses') }} :</label>--}}
{{--                                    <select class="testselect2" required="" name="courses_id">--}}
{{--                                        @foreach($courses as $course)--}}
{{--                                        <option value="{{$course_id}}" >{{$courses->title_ar}}</option>--}}
{{--                                        @endforeach--}}
{{--                                    </select>--}}
{{--                            </div>--}}
{{--                            <div class="form-group col-md-6 has-success mg-t-10">--}}
{{--                                <label for="exampleInputEmail1">{{ __('messages.section') }} :</label>--}}
{{--                                <select class="testselect2" required="" name="section_id">--}}
{{--                                    --}}{{--                                        @foreach($courses as $course)--}}
{{--                                    <option value="{{$section_id}}" >{{$sections->title_ar}}</option>--}}
{{--                                    --}}{{--                                        @endforeach--}}
{{--                                </select>--}}
{{--                            </div>--}}

                            <div class="form-group col-md-6 has-success mg-t-10">
                                <label for="title_ar">{{ __('messages.name in arabic') }}  :</label>
                                <input value="{{$video->title_ar}}" id="title_ar" type="text" class="form-control " name="title_ar"  required>
                                @error('title_ar')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group col-md-6 has-success mg-t-10">
                                <label for="description">{{ __('description') }}  :</label>
                                <input value="{{$video->description_ar}}" id="description_ar" type="text" class="form-control " name="description_ar"  required>
                                @error('description_ar')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>


                            <div class="form-group col-md-6 has-success mg-t-10">
                                <label for="exampleInputEmail1">{{ __('messages.duration') }} : </label>
                                <input type="text"  class="form-control" value="{{$video->duration}}" name="duration"  >

                            </div>
                            <div class="form-group col-md-6 has-success mg-t-10">
                                <label for="exampleInputEmail1">{{ __('messages.Videos Url') }} : </label>
                                <input type="text"  class="form-control" value="{{$video->path}}" name="path"  required>

                            </div>
                            <div class="form-group col-md-12 has-success mg-t-10">
                                <label for="exampleInputEmail1">{{ __('messages.Image') }} : </label>
                                <input type="file"  class="form-control"  name="image" accept="image/*" >

                            </div>




                            <div class="modal-footer">
                                <div class="form-group col-md-12 has-success mg-t-20">
                                <button type="submit" class="btn btn-success" >{{ __('messages.Save') }}</button>
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


    <script>
        $(function () {
            $(document).ready(function () {
                $('#fileUploadForm').ajaxForm({
                    beforeSend: function () {
                        var percentage = '0';
                    },
                    uploadProgress: function (event, position, total, percentComplete) {
                        var percentage = percentComplete;
                        $('.progress-bar').css("display", "block");
                        $('.progress .progress-bar').css("width", percentage+'%', function() {
                            return $(this).attr("aria-valuenow", percentage) + "%";
                        })

                    },
                    complete: function (xhr) {
                        $('#error_message').html("");
                        $('#error_message').addClass("alert alert-success");
                        $('#error_message').text('File has been uploaded successfully');
                        $('.progress-bar').css("display", "none");
                        // $('#success_message .alert-success').text('File has been uploaded successfully');
                        console.log('File has uploaded');
                    }
                });
            });
        });
    </script>

@stop
