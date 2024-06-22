<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\VideosResource;
use App\Models\Videos;
use App\Models\WatchingVideoUser;
use Illuminate\Http\Request;
use function Laravel\Prompts\error;

class VideosController extends Controller
{
    public function show($id){
        $data = Videos::where('id', $id)->with('watching_user',function ($q){
            $q->where('user_id', auth()->id());
        })->first();
        $user = auth()->user();

        if (!$data) {
            return sendError('video not found');
        }
        if (!$data->watching){
            WatchingVideoUser::create(
                [
                    'video_id' => $data->id,
                    'user_id' => $user->id
                ]
            );
        }
        $data->refresh();
        return sendResponse(new VideosResource($data));
    }

    function getVideoInfo($video_id){

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, 'https://www.youtube.com/youtubei/v1/player?key=AIzaSyAO_FJ2SlqU8Q4STEHLGCilw_Y9_11qcW8');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, '{  "context": {    "client": {      "hl": "en",      "clientName": "WEB",      "clientVersion": "2.20210721.00.00",      "clientFormFactor": "UNKNOWN_FORM_FACTOR",   "clientScreen": "WATCH",      "mainAppWebInfo": {        "graftUrl": "/watch?v='.$video_id.'",           }    },    "user": {      "lockedSafetyMode": false    },    "request": {      "useSsl": true,      "internalExperimentFlags": [],      "consistencyTokenJars": []    }  },  "videoId": "'.$video_id.'",  "playbackContext": {    "contentPlaybackContext": {        "vis": 0,      "splay": false,      "autoCaptionsDefaultOn": false,      "autonavState": "STATE_NONE",      "html5Preference": "HTML5_PREF_WANTS",      "lactMilliseconds": "-1"    }  },  "racyCheckOk": false,  "contentCheckOk": false}');
        curl_setopt($ch, CURLOPT_ENCODING, 'gzip, deflate');

        $headers = array();
        $headers[] = 'Content-Type: application/json';
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        $result = curl_exec($ch);
        if (curl_errno($ch)) {
            return sendError(curl_error($ch));
        }
        curl_close($ch);
        return sendResponse(\GuzzleHttp\json_decode($result));

    }
}
