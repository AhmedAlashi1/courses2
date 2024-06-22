<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\NotificationResource;
use App\Models\Notifications;
use Carbon\Carbon;
use Carbon\CarbonInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationsController extends Controller
{
    public function __invoke(Request $request)
    {
        $user = Auth::user();
        $notifications = Notifications::where('user_id', $user->id)->orderBy('created_at', 'desc')->get();

        return sendResponse(NotificationResource::collection($notifications));
    }

}



