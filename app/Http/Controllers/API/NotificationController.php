<?php

namespace App\Http\Controllers\API;

use App\CPU\Helpers;
use App\Http\Controllers\Controller;
use App\Models\Approver;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class NotificationController extends Controller
{
    public function firebase_token_worker(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'firebase_token' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => Helpers::error_processor($validator)], 403);
        }

        Customer::where('id', $request->user()->id)->update([
            'device_token' => $request['firebase_token'],
        ]);

        return response()->json(['message' => 'token firebase berhasil diupdate'], 200);
    }

    public function firebase_token_approver(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'firebase_token' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => Helpers::error_processor($validator)], 403);
        }

        Approver::where('id', $request->user()->id)->update([
            'device_token' => $request['firebase_token'],
        ]);

        return response()->json(['message' => 'token firebase berhasil diupdate'], 200);
    }

    /**
     * Write code on Method.
     *
     * @return response()
     */
    public function sendNotification($device_token, $message)
    {
        $SERVER_API_KEY = 'AAAAhmPgxWA:APA91bGLrQAAoOPWqt3ZUWz2H3LwTbkhTaFYYh0gq3lFhSy5sDg98SFyIXF3uz9r44Wb3bFXQTbmIGcOzHFOz4SAgyUeyfqZJROFLsP_DLb37CaPBRqytM25Y8HpDgIsTcQNDZcJj1HB';

        // payload data, it will vary according to requirement
        $data = [
            'to' => $device_token, // for single device id
            'data' => $message,
        ];
        $dataString = json_encode($data);

        $headers = [
            'Authorization: key='.$SERVER_API_KEY,
            'Content-Type: application/json',
        ];

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send');
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $dataString);

        $response = curl_exec($ch);

        curl_close($ch);

        return $response;
    }
}
