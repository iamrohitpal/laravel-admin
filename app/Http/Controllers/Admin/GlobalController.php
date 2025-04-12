<?php

namespace App\Http\Controllers\Admin;

use App\Models\Blog;
use App\Models\Category;
use App\Models\Enquiry;
use App\Models\Product;
use App\Models\Role;
use App\Models\Seo;
use App\Models\User;
use Illuminate\Http\Request;

class GlobalController
{
    public function delete_data(Request $request, $type, $id)
    {
        if ($type == 'blog') {
            $delete_blog = Blog::where('id', $id)->first();
            if (! empty($delete_blog)) {
                $delete_blog->delete();

                return redirect()->route('blog_list')->with('success', 'Blog Deleted Successfully!');
            } else {
                return back()->with('error', 'Data Not Available!');
            }
        } elseif ($type == 'category') {
            $delete_data = Category::where('id', $id)->first();
            $sub_cat = Category::where('cat_id', $id)->get();
            if (! empty($delete_data)) {
                if ($sub_cat) {
                    foreach ($sub_cat as $val) {
                        $delete_cat = Category::where('id', $val->id)->first();
                        $delete_cat->delete();
                    }
                }
                $delete_data->delete();

                return redirect()->route('category_list')->with('success', 'Category Data Deleted Successfully!');
            } else {
                return redirect()->back()->with('error', 'Something went wrong!');
            }
        } elseif ($type == 'subcateory') {
            $delete_data = Category::where('id', $id)->first();
            if (! empty($delete_data)) {
                $delete_data->delete();

                return redirect()->route('subcategory_list')->with('success', 'Sub Category Data Deleted Successfully!');
            } else {
                return redirect()->back()->with('error', 'Something went wrong!');
            }
        } elseif ($type == 'product') {
            $delete_data = Product::where('id', $id)->first();
            if (! empty($delete_data)) {
                $delete_data->delete();

                return redirect()->route('product_list')->with('success', 'Product Data Deleted Successfully!');
            } else {
                return redirect()->back()->with('error', 'Something went wrong!');
            }
        } elseif ($type == 'enquiry') {
            $delete_data = Enquiry::where('id', $id)->first();
            if (! empty($delete_data)) {
                $delete_data->delete();

                return redirect()->route('enquiry_list')->with('success', 'Enquiry Data Deleted Successfully!');
            } else {
                return redirect()->back()->with('error', 'Something went wrong!');
            }
        } elseif ($type == 'seo') {
            $delete_data = Seo::where('id', $id)->first();
            if (! empty($delete_data)) {
                $delete_data->delete();

                return redirect()->route('seo_list')->with('success', 'Seo Data Deleted Successfully!');
            } else {
                return redirect()->back()->with('error', 'Something went wrong!');
            }
        } elseif ($type == 'role') {
            $delete_data = Role::where('id', $id)->first();
            if (! empty($delete_data)) {
                $delete_data->delete();

                return redirect()->route('role_list')->with('success', 'Role Data Deleted Successfully!');
            } else {
                return redirect()->back()->with('error', 'Something went wrong!');
            }
        } elseif ($type == 'user') {
            $delete_data = User::where('id', $id)->first();
            if (! empty($delete_data)) {
                $delete_data->delete();

                return redirect()->route('user_list')->with('success', 'User Data Deleted Successfully!');
            } else {
                return redirect()->back()->with('error', 'Something went wrong!');
            }
        }
    }
}
