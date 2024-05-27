<?php

namespace App\Http\Controllers;

use App\Models\Hike;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $hikes = Hike::orderBy('created_at', 'desc')->limit(4)->get();
        return view('home', ['hikes' => $hikes]);
    }
}
