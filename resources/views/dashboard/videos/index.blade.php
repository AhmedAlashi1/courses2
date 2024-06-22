@extends('dashboard.layouts.master')
@section('title', __('messages.Videos') )

@section('content')

    @push('styles')
        <style>
            .filter-buttons {
                display: flex;
                margin-bottom: 20px;
            }

            .list-view-button,
            .grid-view-button {
                border: 1px solid white;
                padding: 5px;
                font-size: 14px;
                cursor: pointer;
                border-radius: 3px;
            }

            .list-view-button:hover,
            .grid-view-button:hover {
                background: white;
                color: #0e2439;
            }

            .list-view-button {
                margin-right: 10px;
            }

        </style>
    @endpush

    <div class="modal" id="modaldemo8" style="display: none;" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content modal-content-demo">
                <div class="modal-header">
                    <h6 class="modal-title">{{ __('messages.Delete Operation') }}</h6>
                    <button aria-label="Close" class="close" data-bs-dismiss="modal" type="button"><span
                            aria-hidden="true">&times;</span></button>
                </div>
                <ul id="list_error_message3"></ul>
                <div class="modal-body">
                    <p>{{ __('messages.Are sure of the deleting process ?') }}</p><br>
                    <input class="form-control" id="nameDetele" type="text" readonly="">
                </div>
                <div class="modal-footer">
                    <button class="btn ripple btn-secondary" data-bs-dismiss="modal" type="button">{{ __('messages.Close') }}</button>
                    <button type="submit" class="btn btn-danger" id="deleteVideoFiles">{{ __('messages.Delete') }}</button>
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-5">
        <div class="col-xl-12">
            <div class="row row-xs wd-xl-80p">
                <div class="col-sm-6 col-md-3 mb-4">
                    <a href="{{route('videos.create',[$course_id,$section_id])}}" class="btn btn-info-gradient btn-block"
                       style="font-weight: bold; color: beige;">{{ __('messages.add') }}
                    </a>
                </div>
            </div>
        </div>
        <div class="col-lg-12 col-xl-12">
            <div class="row mb-3">
                <form class="row">


                <div class="form-group col-md-3 has-success mg-b-0">
                    <label for="exampleInputEmail1">{{ __('messages.courses') }}</label>
                    <select class="testselect2" name="courses_id" >
                        <option value="">All</option>
{{--                        @foreach($courses as $course)--}}
                            <option value="{{$courses->id}}" @selected(request('courses_id') == $courses->id)>{{$courses->title_ar}}</option>
{{--                        @endforeach--}}
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
                <div class="filter-buttons">
                    <div class="list-view-button"><i class="fa fa-bars" aria-hidden="true"></i> List view</div>
                    <div class="grid-view-button"><i class="fa fa-th-large" aria-hidden="true"></i> Grid view</div>
                </div>
            </div>
            <div class="row">
                @foreach($videos as $video)
                    <div class="col-md-4 col-sm-6 single-item">
                        <div class="card p-0 ">
                            <div class="d-flex align-items-center px-3 pt-3">
                                <div class="float-end ms-auto">
                                    <a href="javascript:void(0);" class="option-dots" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <i class="fe fe-more-vertical"></i>
                                    </a>
                                    <div class="dropdown-menu rounded-7">
                                        <a class="dropdown-item " href="{{route('videos.edit',$video->id)}}" ><i class="fe fe-edit me-2"></i> {{__('messages.Edit')}}</a>
                                        <a class="dropdown-item delete-btn" href="javascript:void(0);" data-id="{{ $video->id }}" data-namee="{{ $video->title_ar }}"><i class="fe fe-trash me-2"></i>
                                            {{__('messages.Delete')}}</a>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body pt-0 text-center">
                                <div class="file-manger-icon" style="padding-bottom : 8px;">
                                    <a href="{{$video->path}}" data-video="{{asset($video->path)}}" target="_blank" >
                                        <img src="{{ $video->image ? asset($video->image) : asset('dashboard/img/users/6.jpg') }}" alt="img" class="rounded-7">
                                    </a>
                                </div>
                                <h6 class="mb-1 fs-10 font-weight-semibold">{{ $video->title_ar }}</h6>
                                <span class="text-muted">{{ $video->duration ? $video->duration : null }} </span>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="mb-4">
                {{ $videos->appends($_GET)->links() }}
            </div>
        </div>
    </div>

    <!-- Edit modal -->
    <div class="modal" id="editModal" style="display: none;" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <form action="" method="post" id="updateForm">
                <div class="modal-content modal-content-demo">
                    <div class="modal-header">
                        <h6 class="modal-title">{{ __('messages.Edit') }}</h6>
                        <button aria-label="Close" class="close" data-bs-dismiss="modal" type="button"><span
                                aria-hidden="true">&times;</span></button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="form-group col-md-12 mg-b-0">
                                <div class="alert alert-danger" id="update-errors" style="display: none"></div>
                            </div>
                            <div class="form-group col-md-6 has-success mg-b-0">
                                <label for="editName">Name (En) :</label>
                                <input type="text" name="name" id="name" class="form-control" required>
                            </div>
                            <div class="form-group col-md-6 has-success mg-b-0">
                                <label for="editNameAr">Name (Ar) :</label>
                                <input type="text" name="name_ar" id="name_ar" class="form-control" required>
                            </div>
                            <div class="form-group col-md-6 has-success mg-b-0">
                                <label for="exampleInputEmail1">{{ __('messages.Place') }} :</label>
                                <select class="testselect2" required="" id="place" name="place[]" multiple="multiple">
                                    <option value="home">HOME</option>
                                    <option value="gym">GYM</option>
                                </select>

                            </div>
                            <div class="form-group col-md-6 has-success mg-b-0">
                                <label for="exampleInputEmail1">{{ __('messages.Gender') }} :</label>
                                <select class="testselect2" required="" id="gender" name="gender[]" multiple="multiple">
                                    <option value="male">Male</option>
                                    <option value="female">Female</option>
                                </select>

                            </div>
                            <div class="form-group col-md-6 has-success mg-b-0">
                                <label for="exampleInputEmail1">{{ __('messages.Age') }} :</label>
                                <select class="testselect2" required="" id="age" name="age[]" multiple="multiple">

                                    <option value="+18">+18</option>
                                    <option value="-18">-18 </option>

                                </select>
                            </div>
                            <div class="form-group col-md-6 has-success mg-b-0">
                                <label for="exampleInputEmail1">Muscles :</label>
                                <select class="testselect2" required="" id="muscles_id" name="muscles_id" >

{{--                                    @foreach($muscles as $muscle)--}}
{{--                                        <option value="{{$muscle->id}}">{{$muscle->name_en}}</option>--}}
{{--                                    @endforeach--}}

                                </select>
                            </div>
                            <b>Repetition</b>
                            <div class="form-group col-md-4 has-success mg-b-0">
                                <label>level 1 :</label>
                                <input type="number" min="0" class="form-control" name="repetitions[level_1]" id="repetitions_level_1" required>
                            </div>
                            <div class="form-group col-md-4 has-success mg-b-0">
                                <label>level 2 :</label>
                                <input type="number" min="0" class="form-control" name="repetitions[level_2]" id="repetitions_level_2" required>
                            </div>
                            <div class="form-group col-md-4 has-success mg-b-0">
                                <label>level 3 :</label>
                                <input type="number" min="0" class="form-control" name="repetitions[level_3]" id="repetitions_level_3" required>
                            </div>
                            <b>Round</b>
                            <div class="form-group col-md-4 has-success mg-b-0">
                                <label>level 1 :</label>
                                <input type="number" min="0" class="form-control" name="rounds[level_1]" id="rounds_level_1" required>
                            </div>
                            <div class="form-group col-md-4 has-success mg-b-0">
                                <label>level 2 :</label>
                                <input type="number" min="0" class="form-control" name="rounds[level_2]" id="rounds_level_2" required>
                            </div>
                            <div class="form-group col-md-4 has-success mg-b-0">
                                <label>level 3 :</label>
                                <input type="number" min="0" class="form-control" name="rounds[level_3]" id="rounds_level_3" required>
                            </div>
                            <b>Weight</b>
                            <div class="form-group col-md-4 has-success mg-b-0">
                                <label>level 1 :</label>
                                <input type="number" min="0" class="form-control" name="weights[level_1]" id="weights_level_1" required>
                            </div>
                            <div class="form-group col-md-4 has-success mg-b-0">
                                <label>level 2 :</label>
                                <input type="number" min="0" class="form-control" name="weights[level_2]" id="weights_level_2" required>
                            </div>
                            <div class="form-group col-md-4 has-success mg-b-0">
                                <label>level 3 :</label>
                                <input type="number" min="0" class="form-control" name="weights[level_3]" id="weights_level_3" required>
                            </div>
                            <b>Rest period</b>
                            <div class="form-group col-md-4 has-success mg-b-0">
                                <label>level 1 :</label>
                                <input type="number" min="0" class="form-control" name="rest_periods[level_1]" id="rest_periods_level_1" required>
                            </div>
                            <div class="form-group col-md-4 has-success mg-b-0">
                                <label>level 2 :</label>
                                <input type="number" min="0" class="form-control" name="rest_periods[level_2]" id="rest_periods_level_2" required>
                            </div>
                            <div class="form-group col-md-4 has-success mg-b-0">
                                <label>level 3 :</label>
                                <input type="number" min="0" class="form-control" name="rest_periods[level_3]" id="rest_periods_level_3" required>
                            </div>
                            <b>Estimated calories burn</b>
                            <div class="form-group col-md-4 has-success mg-b-0">
                                <label>level 1 :</label>
                                <input type="number" min="0" class="form-control" name="estimated_calories_burn[level_1]" id="estimated_calories_burn_level_1" required>
                            </div>
                            <div class="form-group col-md-4 has-success mg-b-0">
                                <label>level 2 :</label>
                                <input type="number" min="0" class="form-control" name="estimated_calories_burn[level_2]" id="estimated_calories_burn_level_2" required>
                            </div>
                            <div class="form-group col-md-4 has-success mg-b-0">
                                <label>level 3 :</label>
                                <input type="number" min="0" class="form-control" name="estimated_calories_burn[level_3]" id="estimated_calories_burn_level_3" required>
                            </div>

                            <div class="form-group col-md-12 has-success mg-b-0 mt-1">
                                <label>Alternative video:</label>
                                <span id="alternative-video"></span> <a href="" id="alternative-video-url">Change</a> <a href="#" data-url="" data-key="alternative_video_id" id="alternative-video-delete-url" class="alternative-video-delete-url">Delete</a>
                            </div>
                            <div class="form-group col-md-12 has-success mg-b-0 mt-1">
                                <label>Alternative video 2:</label>
                                <span id="second-alternative-video"></span> <a href="" id="second-alternative-video-url">Change</a> <a href="#" data-url="" data-key="second_alternative_video_id" id="second-alternative-video-delete-url" class="alternative-video-delete-url">Delete</a>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn ripple btn-secondary" data-bs-dismiss="modal" type="button">{{ __('messages.Close') }}</button>
                        <button type="submit" class="btn btn-success">Save</button>
                    </div>
                </div>
            </form>
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
    <script src="{{URL::asset('dashboard/plugins/sumoselect/jquery.sumoselect.js')}}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

    <script>

        // jQuery.noConflict();
        $(document).on('click', '.delete-btn', function(e) {
            e.preventDefault();
            var id = $(this).data('id');
            var name = $(this).data('namee');

            $('#nameDetele').val(name); // Display the name in the delete confirmation modal

            // Show the delete confirmation modal
            $('#modaldemo8').modal('show');

            // Click event for the "Delete" button in the modal
            $(document).off("click", "#deleteVideoFiles").on("click", "#deleteVideoFiles", function(e) {
                e.preventDefault();

                // Update the AJAX call to GET
                $.ajax({
                    type: 'GET',
                    url: '{{ route("videos.delete", ":id") }}'.replace(':id', id),
                    // Pass data as query parameters in the URL
                    data: { _method: 'DELETE' },
                    success: function(response) {
                        $('#modaldemo8').modal('hide');
                        // You may need to reload the table data after deletion, similar to your previous code
                        // $('#videos-table').DataTable().ajax.reload();
                        toastr.success('Video successfully deleted!', 'Success')
                        window.location.reload()
                    },
                    error: function(xhr, status, error) {
                        console.error(error);
                    }
                });
            });
        });

        {{--$(document).on('click', '.edit-btn', function () {--}}
        {{--    let video = $(this).data('video');--}}
        {{--    let editModal = $('#editModal');--}}
        {{--    editModal.modal('show')--}}

        {{--    editModal.find('#name').val(video.name)--}}
        {{--    editModal.find('#name_ar').val(video.name_ar)--}}
        {{--    editModal.find('#place').val(video.place.replace(/\s+/g, '').split(','))--}}
        {{--    editModal.find('#gender').val(video.gender.replace(/\s+/g, '').split(','))--}}
        {{--    editModal.find('#muscles_id').val(video.muscles_id)--}}
        {{--    editModal.find('#age').val(video.age.replace(/\s+/g, '').split(','))--}}

        {{--    editModal.find('#repetitions_level_1').val(video.repetitions ? video.repetitions['level_1'] : 10)--}}
        {{--    editModal.find('#repetitions_level_2').val(video.repetitions ? video.repetitions['level_2'] : 12)--}}
        {{--    editModal.find('#repetitions_level_3').val(video.repetitions ? video.repetitions['level_3'] : 15)--}}

        {{--    editModal.find('#rounds_level_1').val(video.rounds ? video.rounds['level_1'] : 4)--}}
        {{--    editModal.find('#rounds_level_2').val(video.rounds ? video.rounds['level_2'] : 4)--}}
        {{--    editModal.find('#rounds_level_3').val(video.rounds ? video.rounds['level_3'] : 4)--}}

        {{--    editModal.find('#weights_level_1').val(video.weights ? video.weights['level_1'] : 5)--}}
        {{--    editModal.find('#weights_level_2').val(video.weights ? video.weights['level_2'] : 7)--}}
        {{--    editModal.find('#weights_level_3').val(video.weights ? video.weights['level_3'] : 10)--}}

        {{--    editModal.find('#rest_periods_level_1').val(video.rest_periods ? video.rest_periods['level_1'] : 40)--}}
        {{--    editModal.find('#rest_periods_level_2').val(video.rest_periods ? video.rest_periods['level_2'] : 40)--}}
        {{--    editModal.find('#rest_periods_level_3').val(video.rest_periods ? video.rest_periods['level_3'] : 40)--}}

        {{--    editModal.find('#estimated_calories_burn_level_1').val(video.estimated_calories_burn ? video.estimated_calories_burn['level_1'] : 10)--}}
        {{--    editModal.find('#estimated_calories_burn_level_2').val(video.estimated_calories_burn ? video.estimated_calories_burn['level_2'] : 20)--}}
        {{--    editModal.find('#estimated_calories_burn_level_3').val(video.estimated_calories_burn ? video.estimated_calories_burn['level_3'] : 30)--}}

        {{--    // editModal.find('#alternative-video').text(video.alternative_video?.name || '')--}}
        {{--    --}}{{--editModal.find('#alternative-video-url').attr('href',"{{route('videosFile.alternativeVideo', ':id')}}?key=alternative_video_id".replace(':id', video.id))--}}

        {{--    // editModal.find('#second-alternative-video').text(video.second_alternative_video?.name || '')--}}
        {{--    --}}{{--editModal.find('#second-alternative-video-url').attr('href',"{{route('videosFile.alternativeVideo', ':id')}}?key=second_alternative_video_id".replace(':id', video.id))--}}

        {{--    --}}{{--editModal.find('.alternative-video-delete-url').attr('data-url',"{{route('videosFile.alternativeVideo.delete', ':id')}}".replace(':id', video.id))--}}

        {{--    --}}{{--editModal.find('#updateForm').attr('action', "{{route('video-file.update', ':id')}}".replace(':id', video.id))--}}

        {{--    $('#place')[0].sumo.reload();--}}
        {{--    $('#gender')[0].sumo.reload();--}}
        {{--    $('#muscles_id')[0].sumo.reload();--}}
        {{--    $('#age')[0].sumo.reload();--}}
        {{--})--}}

        $(document).on('submit', '#updateForm', function (e) {
            e.preventDefault();
            let formData = new FormData(this);
            formData.append('_method', 'put');
            let url = $(this).attr('action');
            let error_messages = $('#update-errors');
            $.ajax({
                type: "POST",
                url: url,
                dataType: 'json',
                data: formData,
                cache: false,
                contentType: false,
                processData: false,
                success: function(result) {
                    error_messages.css('display', 'none')
                    $("#editModal").modal('hide');
                    toastr.success('Video data successfully updated!', 'Success')
                    setTimeout(() => {
                        window.location.reload()
                    }, 1500)
                },
                error: function(reject) {

                    if (reject.status === 422) {
                        var errors = $.parseJSON(reject.responseText);
                        error_messages.css('display', 'block')
                        console.log('errors', errors)
                        $.each(errors.errors, function(key, val) {
                            error_messages.append('<br>'+val[0]);
                        })
                    }
                }
            })
        })

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

        const listViewButton = document.querySelector('.list-view-button');
        const gridViewButton = document.querySelector('.grid-view-button');

        listViewButton.onclick = function () {
            $('.single-item').removeClass('col-md-4').addClass('col-md-12')
        }

        gridViewButton.onclick = function () {
            $('.single-item').removeClass('col-md-12').addClass('col-md-4')
        }

        $(document).on('click', '.alternative-video-delete-url', function () {
            let url = $(this).data('url');
            let key = $(this).data('key');
            $.ajax({
                url: url,
                type: 'delete',
                data: {key: key},
                success(response) {
                    if (key === 'alternative_video_id') {
                        $('#alternative-video').text('')
                    } else {
                        $('#second-alternative-video').text('')
                    }
                },
                error(error) {
                    console.log('error', error)
                }
            })
        })

    </script>
@stop
