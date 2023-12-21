<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class AdminCategoryController extends Controller
{
    public function getPage(Request $request)
    {

        $categories = Category::orderBy('name')->paginate(20);

        return view('pages.admin.categories', ['categories' => $categories]);
    }

    public function createCategory(Request $request)
    {
        $request->validate([
            'name' => 'required|max:30',
            'parent_category' => 'nullable',
        ]);

        Category::create([
            'name' => $request->name,
            'parent_category' => $request->parent_category,
        ]);

        return redirect('/admin/categories');
    }
}
