<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Events\OrderPlaced;
use Illuminate\Support\Facades\Event;

class EventController extends Controller
{
    public function index()
    {
        $user_id = 1;
        Event::dispatch(new OrderPlaced($user_id));
        return "Email Send Sucessfully";
    }
}



