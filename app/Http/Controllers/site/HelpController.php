<?php

namespace App\Http\Controllers\site;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

class HelpController extends Controller
{
    public function show()
    {
        return view('site.help',array(
            'permission' => true,
            'footer' => \App\Footermenu::with('Footeritem')->get(),
            'socialmedialist' => \App\Socialmedialist::all(),
        ));
    }
}
