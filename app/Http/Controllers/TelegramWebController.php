<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TelegramWebController extends Controller
{
    public function index()
    {
        return view('telegram.web.index');
    }
}
