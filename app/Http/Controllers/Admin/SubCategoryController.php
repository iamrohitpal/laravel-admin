<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Permission;
use App\Models\Category;
use App\Traits\GlobalDeleteTrait;
use App\Traits\UploadFileTrait;

class SubCategoryController extends Controller
{
    use GlobalDeleteTrait;
    use UploadFileTrait;
    private bool $list;
    private bool $create;
    private bool $edit;
    private bool $delete;
    public function __construct()
    {
        $this->list = Permission::getPermissionBySlugAndId('Product');
        $this->create = Permission::getPermissionBySlugAndId('Product', 'Create');
        $this->edit = Permission::getPermissionBySlugAndId('Product', 'Edit');
        $this->delete = Permission::getPermissionBySlugAndId('Product', 'Delete');
    }

    public function subcategory_list()
    {
        if (! $this->list) {
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
        $permission = ($id == '0') ? $this->create : $this->edit;
        if (! $this->list || ! $permission) {
            abort(403);
        }

        $data['cat_edit_data'] = Category::where('status', '1')->where('id', $id)->first();
        $data['category'] = Category::where('status', '1')->where('cat_id', '0')->get();

        return view('admin.subcategory.edit', compact('data'));
    }

    public function save_subcategory(Request $request)
    {
        $permission = ($request->id == '0') ? $this->create : $this->edit;
        if (! $this->list || ! $permission) {
            abort(403);
        }
        $id = ($request->id == 0) ? null : $request->id;
        $validate = $request->validate([
            'name' => 'required|unique:categories,name'.$id,
            'description' => 'required',
            'cat_id' => 'required',
        ]);

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