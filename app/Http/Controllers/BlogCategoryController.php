<?php

namespace App\Http\Controllers;

use App\Models\BlogCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;

class BlogCategoryController extends Controller
{
    public function index()
    {
        $page_data["categories"] = BlogCategory::all();
        return view("admin.blog_category.index", $page_data);
    }

    public function store(Request $request)
    {
        $request->merge([
            'title' => ltrim($request->title),
            'subtitle' => ltrim($request->subtitle),
        ]);

        $request->validate([
            'title' => 'required|string|max:255',
        ]);

        BlogCategory::create([
            'title'    => $request->title,
            'subtitle' => $request->subtitle,
            'slug'     => Str::slug($request->title),
        ]);

        Session::flash('success', get_phrase('Category add successfully'));
        return redirect()->back();
    }
    public function update(Request $request, $id)
    {
        $request->merge([
            'title' => ltrim($request->title),
            'subtitle' => ltrim($request->subtitle),
        ]);

        $request->validate([
            'title' => 'required|string|max:255',
        ]);

        $query = BlogCategory::where('id', $id);
        if ($query->doesntExist()) {
            Session::flash('success', get_phrase('Data not found.'));
            return redirect()->back();
        }

        $data['title']    = $request->title;
        $data['subtitle'] = $request->subtitle;
        $data['slug']     = Str::slug($request->title);

        $query->update($data);
        Session::flash('success', get_phrase('Category update successfully'));
        return redirect()->back();
    }

    public function delete($id)
    {
        $query = BlogCategory::find($id);

        if (!$query) {
            Session::flash('error', get_phrase('Data not found.'));
            return redirect()->back();
        }

        $query->delete();

        Session::flash('success', get_phrase('Category deleted successfully'));
        return redirect()->back();
    }
}
