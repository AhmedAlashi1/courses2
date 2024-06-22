
@extends('dashboard.layouts.master')
@section('title', __('messages.Update Role') )
@push('styles')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style>
        .checkbox-label {
            position: relative;
            display: inline-block;
            padding-left: 25px;
            font-size: 16px;
            cursor: pointer;
        }

        .checkbox-label .checkbox-custom {
            position: absolute;
            top: 2px;
            left: 0;
            width: 16px;
            height: 16px;
            border: 1px solid #ccc;
            background-color: #fff;
        }

        .checkbox-label .checkbox-custom::before {
            content: "";
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 8px;
            height: 8px;
            background-color: #0162e8;
            border-radius: 50%;
            opacity: 0;
            transition: opacity 0.2s ease-in-out;
        }

        .checkbox-label input[type="checkbox"]:checked + .checkbox-custom::before {
            opacity: 1;
        }

        .checkbox-label input[type="checkbox"] {
            display: none;
        }

        .checkbox-label:hover .checkbox-custom {
            border-color: #0162e8;
        }

        .checkbox-label:hover input[type="checkbox"]:checked + .checkbox-custom::before {
            background-color: #f95374;
        }
        .table td {
            vertical-align: middle;
        }


    </style>
@endpush

    @section('content')
        {!! Form::model($role, ['method' => 'PUT','route' => ['roles.update', $role->id]]) !!}
        <!-- row -->
        <div class="row">
            <div class="col-xl-12">
                <div class="card mg-b-20">
                    <div class="card-body">
                        <div class="form-group col-md-12 has-success mg-t-10">
                            <label>{{__('messages.Role Name')}}  :</label>
                            {!! Form::text('name', null, array('class' => 'form-control')) !!}
                        </div>


                        @foreach($permissions as $key => $permission)
                        <div class="card">
                            <div class="card-header d-flex justify-content-center align-items-center"> <!-- Add 'd-flex' and 'justify-content-center align-items-center' classes -->
                                <h4 class="tx-20 font-weight-bold mb-1">{{__('messages.permissions.'.$permission['name'])}}</h4>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-hover mb-0 text-md-nowrap text-center"> <!-- Add 'text-center' class here -->
                                        <thead>
                                        <tr>
{{--                                            <th>{{__('messages.permissions.all')}}</th>--}}
                                            @foreach($permission['actions'] as $action)
                                                <th>{{__('messages.permissions.'.$action)}}</th>
                                            @endforeach
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <tr>
                                            {{--<th>
                                                <label class="checkbox-label">
                                                    {{ Form::checkbox('selectAll', 1, false, array('class' => 'select-all')) }}
                                                    <div class="main-toggle main-toggle-success">
                                                        <span></span>
                                                    </div>
                                                </label>
                                            </th>--}}

                                            @foreach($permission['permissions'] as $row)
                                                <td>
                                                    <label class="checkbox-label">
                                                        {{ Form::checkbox('permission[]', $row, in_array($row, $selectedPermissions), array('class' => 'checkbox-item')) }}
                                                        <div class="main-toggle main-toggle-success checkbox-item-toggle {{ in_array($row, $selectedPermissions) ? 'on' : '' }}">
                                                            <span></span>
                                                        </div>
                                                    </label>
                                                </td>
                                            @endforeach
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        @endforeach




                        <div class="modal-footer">
                            <div class="form-group col-md-12 has-success mg-t-20">
                                <button type="submit" class="btn btn-success" >{{ __('messages.save') }}</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        {!! Form::close() !!}
    @endsection
    @section('script')

        <!-- Internal Treeview js -->
        <script src="{{URL::asset('dashboard/plugins/treeview/treeview.js')}}"></script>
        <script src="{{URL::asset('dashboard/plugins/jquery-ui/ui/widgets/datepicker.js')}}"></script>
        <!--Internal  jquery.maskedinput js -->
        <script src="{{URL::asset('dashboard/plugins/jquery.maskedinput/jquery.maskedinput.js')}}"></script>
        <!--Internal  spectrum-colorpicker js -->
        <script src="{{URL::asset('dashboard/plugins/spectrum-colorpicker/spectrum.js')}}"></script>
        <!-- Internal Select2.min js -->
        <script src="{{URL::asset('dashboard/plugins/select2/js/select2.min.js')}}"></script>
        <!--Internal Ion.rangeSlider.min js -->
        <script src="{{URL::asset('dashboard/plugins/ion-rangeslider/js/ion.rangeSlider.min.js')}}"></script>
        <!--Internal  jquery-simple-datetimepicker js -->
        <script src="{{URL::asset('dashboard/plugins/amazeui-datetimepicker/js/amazeui.datetimepicker.min.js')}}"></script>
        <!-- Ionicons js -->
        <script src="{{URL::asset('dashboard/plugins/jquery-simple-datetimepicker/jquery.simple-dtpicker.js')}}"></script>
        <!--Internal  pickerjs js -->
        <script src="{{URL::asset('dashboard/plugins/pickerjs/picker.min.js')}}"></script>
        <!-- Internal form-elements js -->
        <script src="{{URL::asset('dashboard/js/form-elements.js')}}"></script>

        <script>

            $(document).on('change', '.select-all', function () {
                let isChecked = $(this).prop('checked');
                let parent = $(this).closest('tr');
                parent.find('.checkbox-item').prop('checked', isChecked);
                parent.find('.checkbox-item-toggle').toggleClass('on');
            })

        </script>
    @stop
