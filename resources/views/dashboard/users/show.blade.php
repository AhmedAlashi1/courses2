@extends('dashboard.layouts.master')
@section('title')
    {{$user->name}} Profile
@endsection
@push('styles')


    <style>

        .custom-main-div {
            /*max-height: 400px; !* Adjust this value to set the maximum height of the main div *!*/
            overflow-y: auto; /* Enable vertical scrolling when content overflows */
        }
        /* Add spacing and alignment for the profile card */
        .card {
            margin-bottom: 20px;
            /* Add other styles as per your design */
        }

        /* Remove default image borders and make the image circular */
        .profile-user img {
            width: 100px;
            height: 100px;
            border-radius: 50%;
            object-fit: cover;
            border: 3px solid #fff; /* Add border color to match your design */
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1); /* Optional: Add shadow effect */
            transition: box-shadow 0.3s ease;
        }

        /* Add hover effect to the profile image */
        .profile-user:hover img {
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        /* Style the edit icon */
        .edit-profile-icon {
            position: absolute;
            bottom: 0;
            right: 0;
            background-color: #007bff; /* Add a color for the edit icon */
            color: #fff; /* Add a text color for the edit icon */
            padding: 4px;
            border-radius: 50%;
            font-size: 14px;
            transition: background-color 0.3s ease;
        }

        /* Add hover effect to the edit icon */
        .edit-profile-icon:hover {
            background-color: #0056b3; /* Change the color on hover */
        }
    </style>
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>

    <!-- Popper.js -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.1/dist/umd/popper.min.js"></script>

    <!-- Bootstrap JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

@endpush

@section('content')
    <!-- row -->
    <div class="row row-sm">
        <div class="col-lg-4">
            <div class="card mg-b-20">
                <div class="card-body">
                    <div class="pl-0">
                        <div class="main-profile-overview">
                            <div class="main-img-user profile-user">
                                <img alt="User Image" src="{{ $user->image != '' ? asset($user->image) : asset('dashboard/img/users/6.jpg') }}">
                                <a class="edit-profile-icon fas fa-camera" href="JavaScript:void(0);"></a>
                            </div>
                            <div class="user-info">
                                <h5 class="main-profile-name">{{ $user->name }}</h5>
                                <p class="main-profile-email">{{ $user->email }}</p>
                                <div class="nav-tabs"></div>
                                @php
                                    use Carbon\Carbon;
                                @endphp
                                <div class="profile-details mt-4">
                                    @if($user->phone)
                                        <p class="main-profile-name-text">{{ __('messages.Phone Number') }} : <span style="color: #0a7ffb">  {{ $user->phone }}</span></p>
                                    @endif
                                    @if($user->created_at)
                                        <p class="main-profile-name-text">{{ __('messages.Subscription date') }} :  <span style="color: #0a7ffb">{{ Carbon::parse($user->created_at)->format('Y-m-d') }}</span> </p>
                                    @endif
                                </div>
                            </div>
                        </div><!-- main-profile-overview -->
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-8">
            <div class="row row-sm">
                <div class="col-sm-12 col-xl-4 col-lg-12 col-md-12">
                    <div class="card ">
                        <div class="card-body">
                            <div class="counter-status d-flex md-mb-0 justify-content-between"> <!-- Updated class added -->
                                <div class="counter-icon bg-primary-transparent">
                                    <i class="icon-layers text-primary"></i>
                                </div>
                                <div class="ml-auto"> <!-- Changed class from 'mr-auto' to 'ml-auto' -->
                                    <h5 class="tx-13">{{__('messages.exercises done')}}</h5>
                                    <h2 class="mb-0 tx-22 mb-1 mt-1">{{$user_exercise_days?->done ?? 0}}</h2>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-12 col-xl-4 col-lg-12 col-md-12">
                    <div class="card ">
                        <div class="card-body">
                            <div class="counter-status d-flex md-mb-0 justify-content-between">
                                <div class="counter-icon bg-danger-transparent">
                                    <i class="icon-paypal text-danger"></i>
                                </div>
                                <div class="ml-auto">
                                    <h5 class="tx-13">{{__('messages.exercises not done')}}</h5>
                                    <h2 class="mb-0 tx-22 mb-1 mt-1">{{$user_exercise_days?->not_done ?? 0}}</h2>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-12 col-xl-4 col-lg-12 col-md-12">
                    <div class="card ">
                        <div class="card-body">
                            <div class="counter-status d-flex md-mb-0 justify-content-between"> <!-- Updated class added -->
                                <div class="counter-icon bg-success-transparent">
                                    <i class="icon-rocket"></i>
                                </div>
                                <div class="ml-auto"> <!-- Changed class from 'mr-auto' to 'ml-auto' -->
                                    <h5 class="tx-13"><span>{{ __('messages.Expiry date') }}</h5>
                                    <h2 class="mb-0 tx-22 mb-1 mt-1">{{ Carbon::parse($user->exp_date)->format('Y-m-d') }}</h2>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-body">
                    <div class="tabs-menu ">
                        <!-- Tabs -->
                        <ul class="nav nav-tabs profile navtab-custom panel-tabs">
                            <li class="">
                                <a href="#profile" data-toggle="tab" aria-expanded="false"> <span class="visible-xs"><i class="las la-user-circle tx-16 mr-1"></i></span> <span class="hidden-xs">{{__('messages.about user')}}</span> </a>
                            </li>
                            <li class="active">
                                <a href="#home" data-toggle="tab" aria-expanded="true"> <span class="visible-xs"><i class="las la-images tx-15 mr-1"></i></span> <span class="hidden-xs">{{__('messages.details')}}</span> </a>
                            </li>
                            <li class="">
                                <a href="#orders" data-toggle="tab" aria-expanded="false"> <span class="visible-xs"><i class="las la-images tx-15 mr-1"></i></span> <span class="hidden-xs">{{__('Orders')}}</span> </a>
                            </li>
                        </ul>
                    </div>
                    <div class="tab-content border-left border-bottom border-right border-top-0 p-4 custom-main-div">
                        <div class="tab-pane active" id="home">
                            <div class="">
                                @if($user_details->main_goal)
                                    <div class="card card-success">
                                        <div class="card-body">
                                            <span class="font-weight-bold">{{__('messages.main goal')}} </span>  : {{$user_details->main_goal}}
                                        </div>
                                    </div>
                                @endif
                            </div>
                            @if($user_details->training_goal)
                                <div class="">
                                    <div class="card card-success">
                                        <div class="card-body">
                                            <span class="font-weight-bold">{{__('messages.training goal')}} </span>
                                             : {{$user_details->training_goal}}
                                        </div>
                                    </div>
                                </div>
                            @endif

                            @if($user_details->motivates_exercise)
                                <div class="">
                                    <div class="card card-success">
                                        <div class="card-body">
                                            <span class="font-weight-bold">{{__('messages.motivates exercise')}} </span>
                                             : {{$user_details->motivates_exercise}}
                                        </div>
                                    </div>
                                </div>
                            @endif

                            @if($user_details->body_type)
                                <div class="">
                                    <div class="card card-success">
                                        <div class="card-body">
                                            <span class="font-weight-bold">{{__('messages.body type')}}</span>
                                             : {{$user_details->body_type}}
                                        </div>
                                    </div>
                                </div>
                            @endif

                            @if($user_details->goal_weight)
                                <div class="">
                                    <div class="card card-success">
                                        <div class="card-body">
                                            <span class="font-weight-bold">{{__('messages.goal weight')}}</span>
                                            : {{$user_details->goal_weight}}
                                        </div>
                                    </div>
                                </div>
                            @endif

                            @if($user_details->desired_body_type)
                                <div class="">
                                    <div class="card card-success">
                                        <div class="card-body">
                                            <span class="font-weight-bold">{{__('messages.desired body type')}}</span>
                                             : {{$user_details->desired_body_type}}
                                        </div>
                                    </div>
                                </div>
                            @endif

                            @if($user_details->target_zone)
                                <div class="">
                                    <div class="card card-success">
                                        <div class="card-body">
                                            <span class="font-weight-bold">{{__('messages.target zone')}} </span>
                                             : {{$user_details->target_zone}}
                                        </div>
                                    </div>
                                </div>
                            @endif

                            @if($user_details->last_happy_body)
                                <div class="">
                                    <div class="card card-success">
                                        <div class="card-body">
                                            <span class="font-weight-bold">{{__('messages.last happy body')}}</span>
                                             : {{$user_details->last_happy_body}}
                                        </div>
                                    </div>
                                </div>
                            @endif

                            @if($user_details->fitness_level)
                                <div class="">
                                    <div class="card card-success">
                                        <div class="card-body">
                                           <span class="font-weight-bold">{{__('messages.fitness level')}} </span> : {{$user_details->fitness_level}}
                                        </div>
                                    </div>
                                </div>
                            @endif

                            @if($user_details->many_push_ups)
                                <div class="">
                                    <div class="card card-success">
                                        <div class="card-body">
                                            <span class="font-weight-bold">{{__('messages.many push ups')}}</span>
                                             : {{$user_details->many_push_ups}}
                                        </div>
                                    </div>
                                </div>
                            @endif

                            @if($user_details->live_elementary)
                                <div class="">
                                    <div class="card card-success">
                                        <div class="card-body">
                                            <span class="font-weight-bold">{{__('messages.live elementary')}} </span>
                                             : {{$user_details->live_elementary}}
                                        </div>
                                    </div>
                                </div>
                            @endif

                            @if($user_details->walk_daily)
                                <div class="">
                                    <div class="card card-success">
                                        <div class="card-body">
                                            <span class="font-weight-bold">{{__('messages.walk daily')}} </span>
                                             : {{$user_details->walk_daily}}
                                        </div>
                                    </div>
                                </div>
                            @endif

                            @if($user_details->feel_meals)
                                <div class="">
                                    <div class="card card-success">
                                        <div class="card-body">
                                            <span class="font-weight-bold">{{__('messages.feel meals')}} </span>
                                             : {{$user_details->feel_meals}}
                                        </div>
                                    </div>
                                </div>
                            @endif

                            @if($user_details->get_sleep)
                                <div class="">
                                    <div class="card card-success">
                                        <div class="card-body">
                                            <span class="font-weight-bold">{{__('messages.get sleep')}} </span>
                                             : {{$user_details->get_sleep}}
                                        </div>
                                    </div>
                                </div>
                            @endif

                            @if($user_details->water_consumption)
                                <div class="">
                                    <div class="card card-success">
                                        <div class="card-body">
                                            <span class="font-weight-bold">{{__('messages.water consumption')}} </span>
                                            : {{$user_details->water_consumption}}
                                        </div>
                                    </div>
                                </div>
                            @endif

                            @if($user_details->training_location)
                                <div class="">
                                    <div class="card card-success">
                                        <div class="card-body">
                                            <span class="font-weight-bold">{{__('messages.training location')}} </span>
                                            : {{$user_details->training_location}}
                                        </div>
                                    </div>
                                </div>
                            @endif

                            @if($user_details->Interested_in)
                                <div class="">
                                    <div class="card card-success">
                                        <div class="card-body">
                                            <span class="font-weight-bold">{{__('messages.Interested in')}} </span>
                                            : {{$user_details->Interested_in}}
                                        </div>
                                    </div>
                                </div>
                            @endif

                            @if($user_details->diet)
                                <div class="">
                                    <div class="card card-success">
                                        <div class="card-body">
                                            <span class="font-weight-bold">{{__('messages.diet')}} </span>
                                            : {{$user_details->diet}}
                                        </div>
                                    </div>
                                </div>
                            @endif

                        </div>
                        <div class="tab-pane" id="profile">


                                @if($user->date_of_birth)
                                    <div class="">
                                        <div class="card card-info">
                                            <div class="card-body">
                                                <span class="font-weight-bold">{{__('messages.date of birthday')}} </span>  : {{$user->date_of_birth}}
                                            </div>
                                        </div>
                                    </div>
                                @endif

                                @if($user_details->tall)
                                    <div class="">
                                        <div class="card card-info">
                                            <div class="card-body">
                                                <span class="font-weight-bold">{{__('messages.tall')}}</span>
                                                : {{ number_format($user_details->tall / 100, 2) }} cm
                                            </div>
                                        </div>
                                    </div>
                                @endif

                                @if($user_details->weight)
                                    <div class="">
                                        <div class="card card-info">
                                            <div class="card-body">
                                                <span class="font-weight-bold">{{__('messages.weight')}}</span>
                                                : {{$user_details->weight}} kg
                                            </div>
                                        </div>
                                    </div>
                                @endif

                                @if($user_details->old)
                                    <div class="">
                                        <div class="card card-info">
                                            <div class="card-body">
                                                <span class="font-weight-bold">{{__('messages.old')}}</span>
                                                : {{$user_details->old}} year
                                            </div>
                                        </div>
                                    </div>
                                @endif

                                    @if($user->days_exercise)
                                        <div class="">
                                            <div class="card card-info">
                                                <div class="card-body">
                                                    <span class="font-weight-bold">{{__('messages.days exercise')}} </span>  : {{$user->days_exercise}}
                                                </div>
                                            </div>
                                        </div>
                                    @endif

                                        <div class="">
                                            <div class="card card-info">
                                                <div class="card-body">
                                                    <span class="font-weight-bold">Current exercise </span>: @if(!empty($current_exercise)) Week: {{$current_exercise['week']}}, Day: {{$current_exercise['day']}} @endif
                                                </div>
                                            </div>
                                        </div>


                                    @if($user->sex)
                                        <div class="">
                                            <div class="card card-info">
                                                <div class="card-body">
                                                    <span class="font-weight-bold">{{__('messages.gender')}} </span>  : {{$user->sex}}
                                                </div>
                                            </div>
                                        </div>
                                    @endif


                        </div>
                        <div class="tab-pane" id="orders">
                            <table class="table table-striped">
                                <thead>
                                <th>ID</th>
                                <th>{{ __('Date') }}</th>
                                <th>{{ __('messages.price') }}</th>
                                <th>{{ __('messages.Package Name') }}</th>
                                <th>{{ __('messages.payment method') }}</th>
                                <th>{{ __('messages.end date') }}</th>
                                </thead>
                                <tbody>
                                @foreach($user->orders as $order)
                                    <tr>
                                        <td>{{ $order->id }}</td>
                                        <td>{{ $order->created_at->diffForHumans() }}</td>
                                        <td>{{ $order->price }}</td>
                                        <td>{{ @$order->package->name_en }}</td>
                                        <td>{{ @$order->payment->name_en }}</td>
                                        <td>{{ $order->end_date }}</td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- row closed -->
    </div>
    <!-- Container closed -->
    </div>
    <!-- main-content closed -->
@endsection
