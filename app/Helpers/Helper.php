<?php

use App\Http\Resources\Api\CartResource;
use App\Models\Otp;
use Carbon\Carbon;
use DateInterval;
use DatePeriod;

function resource_collection($resource): array
{
    return json_decode($resource->response()->getContent(), true) ?? [];
}

function langs(){
    return ['en', 'ar'];
}

function spin_game_array(){
    return [
        '1' => 'digit_one',
        '2' => 'digit_two',
        '3' => 'digit_three',
        '4' => 'digit_four',
        '5' => 'digit_five',
        '6' => 'digit_six',
        '7' => 'digit_seven',
        '8' => 'digit_eight',
        '9' => 'digit_nine',
    ];
}

function generate_otp_function(){
    return str_pad(mt_rand(0, 9999), 4, '0', STR_PAD_LEFT);
}

function checkValidAppliedCouponBeforeSubmitOrder($coupon , $timezone){
    if($coupon == null){
        return true;
    }
    if ($coupon->expiration_date >= Carbon::now($timezone)->format('Y-m-d') && $coupon->status == 'pending') {
        return true;
    } else {
       return false;
    }
}

function generateTimeSlotsBetweenIntervals($start_time, $end_time, $interval = '1 hour'){
    $start = Carbon::parse($start_time);
    $end = Carbon::parse($end_time);

    // Fix: Ensure the interval format is correct (e.g., 'PT1H' for 1 hour)
    $interval = new DateInterval('PT' . strtoupper($interval[0]) . 'H');
    $time_slots = [];

    // Create a DatePeriod to iterate over the time range
    $period = new DatePeriod($start, $interval, $end);
    foreach ($period as $slot) {
        $time_slots[] = ['time' => $slot->format('h:i A') , 'booked' => 0 ];
    }
    // Add the end time to ensure it's included in the slots
    return $time_slots;
}



function get_day_calendar_index(){
    return [
        'Saturday' => 1,
        'Sunday' => 2,
        'Monday' => 3 ,
        'Tuesday' => 4,
        'Wednesday' => 5,
        'Thursday' => 6,
        'Friday' => 7
    ];
}



function create_new_otp($email , $code){
    Otp::where(['email' => $email])->delete();
    Otp::create([
        'email' => $email,
        'code' => $code,
    ]);
    return;
}

function weekDays (){
    return ['Saturday', 'Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday'];
}

// function generate_code_unique() {
//     // Generate a random prefix of length 2 using letters
//     $prefix = substr(str_shuffle('ABCDEFGHIJKLMNOPQRSTUVWXYZ'), 0, 3);

//     // Get the current date in the format "YmdHis" (YearMonthDayHourMinuteSecond)
//     $currentDate = date('YmdHis');

//     // Generate a random number between 1000 and 9999
//     $randomNumber = mt_rand(1000, 9999);

//     // Combine the prefix, date, and random number to create the code
//     $shipmentCode = $prefix . $currentDate . $randomNumber;

//     return $shipmentCode;
// }



// function generateQrCode($shipmentCode){
//     return QrCode::size(300)->generate($shipmentCode);
// }

// function pushNotificationStore($title, $body, $token)
// {
//     if (!$token) return;

//     if (!is_array($token)) {
//         $token = [$token];
//     }

//     $url = 'https://fcm.googleapis.com/fcm/send';
//     $serverKey = 'AAAAEdvg3CI:APA91bEspQQ7Eb7PFcCPtgj3VVE7ietM1DGtG4H55SMyThAnAPaChUqHSA8p9DYHXpJtQ8uU0Z_8UZALcsOelpKkDJSyVLejM77k9aLGq22oMUa7Fy0JrHt1zaVN61zLuIhmVfA7dTc6';

//     $data = [
//         "registration_ids" => $token,
//         "notification" => [
//             "title" => $title,
//             "body" => $body,
//             "sound" => "default",
//             "badge" => "1",
//             // "click_action" => "FCM_PLUGIN_ACTIVITY",
//         ],
//         // "data" => $notificationData
//     ];

//     $encodedData = json_encode($data);

//     $headers = [
//         'Authorization:key=' . $serverKey,
//         'Content-Type: application/json',
//     ];

//     $ch = curl_init();

//     curl_setopt($ch, CURLOPT_URL, $url);
//     curl_setopt($ch, CURLOPT_POST, true);
//     curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
//     curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
//     curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
//     curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
//     // Disabling SSL Certificate support temporarly
//     curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
//     curl_setopt($ch, CURLOPT_POSTFIELDS, $encodedData);
//     // Execute post
//     $result = curl_exec($ch);

//     // Close connection
//     curl_close($ch);
//     // FCM response
//     // dump($result);
//     return $result;
// }
