<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Color;
use App\Http\Requests\ColorFormRequest;

class ColorController extends Controller
{
    public function Index(){
        $colors = Color::all();
        return view('admin.colors.index', compact('colors'));
    }
     
    public function create(){
        return view('admin.colors.create');
    }

    public function store(ColorFormRequest $request){
       $validatedData = $request->validated();
       Color::create($validatedData);

       return redirect('admin/colors')->with('message','Color Added Successfully');
    }
}
