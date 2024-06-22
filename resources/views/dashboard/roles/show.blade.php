@extends('dashboard.layouts.master')
@section('title', __('messages.Permissions') )
@section('content')
    <!-- row -->
    <div class="row">
        <div class="col-xl-12">
            <div class="card mg-b-20">
                <div class="card-body">

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
                                            @foreach($permission['actions'] as $action)
                                                <th>{{__('messages.permissions.'.$action)}}</th>
                                            @endforeach
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <tr>
                                            @foreach($permission['permissions'] as $row)
                                                <td style="text-align: center;">
                                                    <label>
                                                        <i class="icon {{ in_array($row, $selectedPermissions) ? 'ion-ios-checkmark' : 'icon ion-ios-close' }}"
                                                           style="color: {{ in_array($row, $selectedPermissions) ? '#00eb1b' : 'red' }}; font-size: 50px;"></i>
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

                </div>
            </div>
        </div>
    </div>
@endsection

