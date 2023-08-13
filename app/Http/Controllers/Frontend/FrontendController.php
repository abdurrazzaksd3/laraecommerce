<?php

namespace App\Http\Controllers\Frontend;

use App\Models\Slider;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class FrontendController extends Controller
{
    //

    public function index(){
        $sliders = Slider::where('status','0')->get();
        return view('frontend.index', compact('sliders'));
    }


}
