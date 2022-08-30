<?php

namespace App\Http\Controllers;

// use Illuminate\Http\Request;
use App\Jobs\SendMailJob;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Jobs\TestEmailJob;
use App\Mail\TestEmail;
use App\Product;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    // public function __construct()
    // {
    //     $this->middleware('auth');
    // }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home');
    }
    public function sendMail()
    {
        $users = User::all();
        // dd($users);
        foreach($users as $user){
            dispatch(new SendMailJob($user));
        }

        // SendMailJob::dispatch($details);

        return response('Email sent successfully');
    }
    public function sendEmail(){


        $users = User::all();
        foreach($users as $user){
            dispatch(new TestEmailJob($user));
        }
        return "Send ALL Email";
    }
}
