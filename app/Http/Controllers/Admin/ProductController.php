<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Client\Request;
use App\Http\Controllers\Controller;
use App\Models\Permission;
use App\Models\Category;
use App\Models\Product;
use App\Traits\UploadFileTrait;
use DB;

class ProductController extends Controller
{
    use UploadFileTrait;
    
    public function product_list()
    {
        if (! Permission::getPermissionBySlugAndId('Product')) {
            abort(403);
        }

        $data['products'] = Product::where('status', '1')->get();
        foreach ($data['products'] as $key => $product) {
            $categories = Category::whereIn('id', explode(',', $product['sub_cat_id']))->get();
            $catName = [];
            foreach ($categories as $category) {
                $catName[] = $category->name;
            }
            $data['products'][$key]['images'] = DB::table('images')->where('product_id', $product['id'])->take(5)->latest()->get();
            $data['products'][$key]['categories'] = implode(' | ', $catName);
        }

        return view('admin.product.index', compact('data'));
    }
    public function product_form($type, $id)
    {
        if (! Permission::getPermissionBySlugAndId('Product')) {
            abort(403);
        }

        $data['product'] = Product::where('id', $id)->first();
        $data['images'] = DB::table('images')->where('product_id', $id)->take(5)->latest()->get();
        $data['subcategory'] = Category::where('cat_id', '!=', '0')->get();
        return view('admin.product.edit', compact('data'));
    }
    public function save_product(Request $request)
    {
        if (! Permission::getPermissionBySlugAndId('Product')) {
            abort(403);
        }

        if ($request->id == '0') {
            $validation = $request->validate([
                'sub_cat_id' => 'required',
                'name' => 'required|unique:products|unique:categories',
                'description' => 'required',
            ]);
        } else {
            $validation = $request->validate([
                'sub_cat_id' => 'required',
                'name' => 'required',
                'description' => 'required',
            ]);
        }

        $string = strtolower($request->name);
        $string = preg_replace('/[^a-z0-9]+/', '-', $string);
        $subCatId = implode(',', $request->sub_cat_id);
        $add_data = Product::updateOrCreate(['id' => $request->id], [
            'sub_cat_id' => $subCatId,
            'name' => $request->name,
            'slug' => $string,
            'description' => $request->description,
            'long_description' => $request->long_description,
        ]);

        if ($add_data) {
            if ($request->has('images')) {
                $images = $request->file('images');
                $getImages = DB::table('images')->where('product_id', $add_data->id)->get();
                foreach ($getImages as $val) {
                    if (!empty($val)) {
                        DB::table('images')->where('id', $val->id)->delete();
                    }
                }
                foreach ($images as $image) {
                    $filenames[] = $this->fileupload($image, 'product', $add_data->id);
                }
            } else {
                $images = DB::table('images')->where('product_id', $add_data->id)->get();
                $old_image = json_decode($request->old_file);
                foreach ($images as $val) {
                    if (!in_array($val->name, $old_image)) {
                        DB::table('images')->where('id', $val->id)->delete();
                    }
                }
            }
        }

        if (!empty($add_data)) {
            return redirect()->route('product_list')->with('success', 'Data Added Successfully!');
        } else {
            return redirect()->back()->with('error', 'Somthing went wrong!');
        }
    }
}