
@extends('dashboard.layouts.master')
@section('title', __('Videos') )
@section('content')

    <div class="row">
        <div class="col-xl-12">
            <div class="row row-xs wd-xl-80p">
                <div class="col-sm-6 col-md-6 mb-4">
                        <form action="{{route('videosFile.changeAlternativeVideo',$video->id)}}" method="post">
                            @csrf
                            <p><h5>Your selected video is:</h5> <span id="selected-video-name">{{ request('key', 'alternative_video_id') === 'alternative_video_id' ? @$video->alternativeVideo->name : @$video->secondAlternativeVideo->name }}</span></p>
                            <input type="hidden" name="{{ request('key', 'alternative_video_id') }}" id="video-id">
                            <div class="form-group col-md-12 has-success mg-t-20">
                                <button type="submit" class="btn btn-success" >{{ __('Save') }}</button>
                            </div>
                        </form>
                </div>
            </div>
        </div>
        <div class="col-lg-12 col-xl-12">
            <div class="row mb-3">
                <form class="row">
                    <div class="form-group col-md-3 has-success mg-b-0">
                        <label for="exampleInputEmail1">{{ __('messages.Place') }} :</label>
                        <select class="testselect2" name="place[]" multiple="multiple">
                            <option value="home" @selected(in_array('home', request('place', [])))>HOME</option>
                            <option value="gym" @selected(in_array('gym', request('place', [])))>GYM</option>
                        </select>
                    </div>
                    <div class="form-group col-md-3 has-success mg-b-0">
                        <label for="exampleInputEmail1">{{ __('messages.Gender') }} :</label>
                        <select class="testselect2" name="gender[]" multiple="multiple">
                            <option value="male" @selected(in_array('male', request('gender', [])))>Male</option>
                            <option value="female" @selected(in_array('female', request('gender', [])))>Female</option>
                        </select>
                    </div>
                    <div class="form-group col-md-3 has-success mg-b-0">
                        <label for="exampleInputEmail1">{{ __('messages.Age') }} :</label>
                        <select class="testselect2" name="age[]" multiple="multiple">
                            <option value="+18" @selected(in_array('+18', request('age', [])))>+18</option>
                            <option value="-18" @selected(in_array('-18', request('age', [])))>-18 </option>
                        </select>
                    </div>
                    <div class="form-group col-md-3 has-success mg-b-0">
                        <label for="exampleInputEmail1">{{ __('messages.Muscles') }}</label>
                        <select class="testselect2" name="muscles_id" >
                            <option value="">All</option>
                            @foreach($muscles as $muscle)
                                <option value="{{$muscle->id}}" @selected(request('muscles_id') == $muscle->id)>{{$muscle->name_en}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group col-md-4 has-success mg-b-0">
                        <label for="exampleInputEmail1">Search</label>
                        <input class="form-control" name="keyword" value="{{ request('keyword') }}" placeholder="Search video..." type="text">
                    </div>
                    <div class="form-group col-md-4 has-success mg-b-0 mt-4">
                        <button class="btn btn-primary" type="submit">Search</button>
                    </div>
                </form>

            </div>
            <div class="row">
                @foreach($videos as $video)
                    <div class="col-xl-3 col-md-4 col-sm-6">
                        <div class="card p-0 ">
                            <div class="d-flex align-items-center px-3 pt-3">
                                <div class="float-end ms-auto">
                                    <input type="radio"
                                           name="video_file"
                                           value="{{ $video->id }}"
                                           class="select-video"
                                           data-name="{{ $video->name }}"
                                           {{ $video->alternative_video_id == $video->id ? 'checked' : '' }}
                                    >
                                </div>
                            </div>
                            <div class="card-body pt-0 text-center">
                                <div class="file-manger-icon">
                                    <a href="javascript:void(0);" class="show-video" data-video="{{asset($video->path)}}">
                                        <img src="{{ $video->image ? asset($video->image) : asset('dashboard/img/users/6.jpg') }}" alt="img" class="rounded-7">
                                    </a>
                                </div>
                                <h6 class="mb-1 fs-14 font-weight-semibold">{{ $video->name }}</h6>
                                <span class="text-muted">{{ ($video->duration??'0').':00' }} m</span>
                            </div>
                        </div>
                    </div>
                @endforeach

            </div>

            <div class="mb-4">
                {{ $videos->links() }}
            </div>
        </div>
    </div>


    <!-- show modal -->
    <div class="modal" id="showVideoModal" style="display: none;" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content modal-content-demo">
                <div class="modal-header">
                    <h6 class="modal-title">{{ __('messages.show_video') }}</h6>
                    <button aria-label="Close" class="close" data-bs-dismiss="modal" type="button"><span
                            aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">
                    <video id="video" width="100%" height="520" controls>
                        <source src="" type="video/mp4">
                    </video>
                </div>
                <div class="modal-footer">
                    <button class="btn ripple btn-secondary close-video" data-bs-dismiss="modal" type="button">{{ __('messages.Close') }}</button>
                </div>
            </div>
        </div>
    </div>

@endsection
@section('script')
    <script src="{{URL::asset('dashboard/js/advanced-form-elements.js')}}"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.form/4.3.0/jquery.form.min.js"></script>
    <script src="{{URL::asset('dashboard/plugins/sumoselect/jquery.sumoselect.js')}}"></script>

    <script>
        $(document).on('click', '#showDeleteModal', function () {
            $('#deleteModal').modal('show');
        })
    </script>

    <script>
        $(document).on('click', '.show-video', function () {
            let videoUrl = $(this).data('video');
            let videoModal = $('#showVideoModal');
            videoModal.find('source').attr('src', videoUrl)
            $('#video')[0].load();

            videoModal.modal('show');
        })

        $(document).on('hide.bs.modal', '#showVideoModal', function () {
            var media = $("#video").get(0);
            media.pause();
            media.currentTime = 0;
        })

        $(document).on('click', '.select-video', function () {
            let id = $(this).val();
            let name = $(this).data('name');
            $('#video-id').val(id);
            $('#selected-video-name').text(name)
        })

    </script>
@stop
