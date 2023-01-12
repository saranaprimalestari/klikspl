<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Visitor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class VisitorController extends Controller
{
    public function addVisitor()
    {
        $ip = request()->getClientIp();
        $visitor = Visitor::where([['visitor_ip','=', $ip],['created_at', 'like', Carbon::now()->format('Y-m-d').'%']])->get();
        // dd(!Session::has($ip));
        // dd(count($visitor) == 0);
        if (!Session::has($ip) && count($visitor) == 0) {
            $visitor = Visitor::create([
                'visitor_ip' =>$ip
            ]);
            $ip = rand(0,99999999);
            Session::put('ip',$ip);
        }
    }

    public function visitorDay(){
    $visitorDay = Visitor::where('created_at', 'like', Carbon::now()->format('Y-m-d') .'%')->get();
        
    }

    public function visitorThisMonth(){
        $visitorThisMonth = Visitor::whereBetween('created_at', [Carbon::now()->startOfMonth()->format('Y-m-d'), Carbon::now()->endOfMonth()->format('Y-m-d')])->get();

    }

    public function visitorTotal(){
        $visitorTotal = Visitor::all();

    }
}
