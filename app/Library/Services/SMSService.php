<?php
namespace App\Library\Services;
use GuzzleHttp\Client;
use Config;

class SMSService
{
    public function sendOTP($request){   
        //if $claim->main_claimant->mobile does not start with 07,+447 or 447 then return error
        if (strpos($request['mobile'], '07') !== 0 && strpos($request['mobile'], '+447') !== 0 && strpos($request['mobile'], '447') !== 0) {
            return false;
        }

        if (strlen($request['mobile']) != 11) {
            return false;
        } else {
            // Send SMS
            $client = new \GuzzleHttp\Client([
                'verify' => false
            ]);
            //make post request to sms api
            $smsResponse = $client->request('POST', 'https://uk.simplysend.io/api/sms/send', [
                'headers' => [
                    'Authorization' => 'Bearer ' . config('app.keys.sssms'),
                    'Content-Type' => 'application/json',
                ],
                'json' => [
                    'dst_number' => $request['mobile'],
                    'sender_id' => 'ACHL',
                    'msg_body' => 'Your One-Time OTP is '.$request['otp'].'. DO NOT SHARE THIS WITH ANYONE.',
                    'test' => true
                ],

            ]);
            return true;
        }
    }

    public function welcome($request){

        // Send SMS
        $client = new \GuzzleHttp\Client([
            'verify' => false
        ]);
        //make post request to sms api
        $smsResponse = $client->request('POST', 'https://uk.simplysend.io/api/sms/send', [
            'headers' => [
                'Authorization' => 'Bearer ' . config('app.keys.sssms'),
                'Content-Type' => 'application/json',
            ],
            'json' => [
                'dst_number' => $request['mobile'],
                'sender_id' => 'ACHL',
                'msg_body' => 'Congratulations and welcome, '.$request['first_name'].' '.$request['last_name'].'! You have successfully registered for the warranty.',
                'test' => true
            ],

        ]);
        return true;
    }
}


