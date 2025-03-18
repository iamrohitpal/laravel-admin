<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Client\Request;
use App\Http\Controllers\Controller;
use App\Models\Permission;
use App\Models\Category;
use App\Traits\UploadFileTrait;

class SubCategoryController extends Controller
{
    use UploadFileTrait;
    
    public function subcategory_list()
    {
        if (! Permission::getPermissionBySlugAndId('Sub Category')) {
            abort(403);
        }

        $data['subcategory'] = Category::where('status', '1')->where('cat_id', '!=', '0')->get();
        foreach ($data['subcategory'] as $key => $value) {
            explode(',', $value->cat_id);
            $categories = Category::where('status', '1')->whereIn('id', explode(',', $value->cat_id))->get();
            $catName = [];
            foreach ($categories as $category) {
                $catName[] = $category->name;
            }
            $data['subcategory'][$key]['category'] = implode(' | ', $catName);
        }
        return view('admin.subcategory.index', compact('data'));
    }

    public function subcategory_form($type, $id)
    {
        if (! Permission::getPermissionBySlugAndId('Sub Category')) {
            abort(403);
        }

        $data['cat_edit_data'] = Category::where('status', '1')->where('id', $id)->first();
        $data['category'] = Category::where('status', '1')->where('cat_id', '0')->get();
        return view('admin.subcategory.edit', compact('data'));
    }

    public function save_subcategory(Request $request)
    {
        if (! Permission::getPermissionBySlugAndId('Sub Category')) {
            abort(403);
        }

        if ($request->id == '0') {
            $validate = $request->validate([
                'name' => 'required|unique:categories',
                'description' => 'required',
                'cat_id' => 'required',
            ]);
        } else {
            $validate = $request->validate([
                'name' => 'required',
                'description' => 'required',
                'cat_id' => 'required',
            ]);
        }

        if (!empty($request->image)) {
            $image = $this->fileupload($request->image, 'category');
        } else {
            $image = $request->old_image;
        }
        $string = strtolower($request->name);
        $string = preg_replace('/[^a-z0-9]+/', '-', $string);
        $subCatId = implode(',', $request->cat_id);

        $add_data = Category::updateOrCreate(['id' => $request->id], [
            'name' => $request->name,
            'image' => $image,
            'description' => $request->description,
            'cat_id' => $subCatId,
            'slug' => $string,
        ]);
        if (!empty($add_data)) {
            return redirect()->route('subcategory_list')->with('success', 'Category Added Successfully!');
        } else {
            return redirect()->back()->with('error', 'Something went erong!');
        }
    }
}