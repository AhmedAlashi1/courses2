<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\CallUs;
use App\Models\User;
use Illuminate\Http\Request;

class CallUsController extends Controller
{
    public function store(Request $request){

        $call_us = CallUs::create($request->all());
        return sendResponse($call_us);

    }
}
