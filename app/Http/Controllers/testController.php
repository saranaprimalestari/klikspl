<?php

namespace App\Http\Controllers;

use DateTime;
use DateTimeZone;
use Carbon\Carbon;
use Illuminate\Http\Request;

class testController extends Controller
{
    public function index(Request $request)
    {
        // $now = new DateTime();
        // $now->setTimezone(new DateTimeZone('Asia/Almaty'));
        // echo $now->format('Y-m-d H:i:s T');
        // echo "<br>";
        
        // date_default_timezone_set('Asia/Jakarta');
        // echo "Now is " . date("Y-m-d H:i:s", strtotime('+5 hours'));
        // echo "<br>";
        // echo "Now is " . date("Y-m-d H:i:s");
        // echo "<br>";

        // echo (new \DateTime())->format('Y-m-d H:i:s');
        // $date = Carbon::now();
        // // echo $date->toDateTimeString();
        // dd($date);

        return view('test',[
            'title' => 'test'
        ]);
    }
}
