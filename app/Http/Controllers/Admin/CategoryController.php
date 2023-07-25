<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;
use App\Http\Requests\CategoryFormRequest;
use App\Models\Category;
use Illuminate\Auth\Events\Validated;
use Illuminate\Contracts\Support\ValidatedData;

class CategoryController extends Controller
{
    public function index(){
        return view('admin.category.index');
    }

    public function create(){
        return view('admin.category.create');
    }

    public function store (CategoryFormRequest $request)
    {
        
        $validatedData = $request->validated();

        $category = new Category();
        $category->name = $validatedData['name'];
        $category->slug = Str::slug ($validatedData['slug']);
        $category->description = $validatedData['description'];

        if($request->hasFile('image'))
        {
            $file = $request->file('image');
            $ext = $file->getClientOriginalExtension();
            $fileName = time().'.'.$ext;

            $file->move('uploads/category', $fileName);
            $category->image = $fileName;
        }
       

        $category->meta_title = $validatedData['meta_title'];
        $category->meta_keyword = $validatedData['meta_keyword'];
        $category->meta_description = $validatedData['description'];

        $category->status = $request->status==true? '1':'0';
        $category->save();

        return redirect('admin/category')->with('message','Category Added Successfully');
    }

    public function edit(Category $category)
    {
        return view('admin.category.edit', compact('category'));
    }
    
    public function update(CategoryFormRequest $request, $category)
    {
        $category = Category::findOrFail($category);

        $validatedData = $request->validated();

        $category->name = $validatedData['name'];
        $category->slug = Str::slug ($validatedData['slug']);
        $category->description = $validatedData['description'];

        if($request->hasFile('image'))
        {

            $path = 'uploads/categopry/'.$category->image;
            if(File::exists($path)){
            
                File::delete($path);
            }

            $file = $request->file('image');
            $ext = $file->getClientOriginalExtension();
            $fileName = time().'.'.$ext;

            $file->move('uploads/category', $fileName);
            $category->image = $fileName;
        }
       

        $category->meta_title = $validatedData['meta_title'];
        $category->meta_keyword = $validatedData['meta_keyword'];
        $category->meta_description = $validatedData['description'];

        $category->status = $request->status==true? '1':'0';
        $category->update();

        return redirect('admin/category')->with('message','Category Udated Successfully');
    }

}
