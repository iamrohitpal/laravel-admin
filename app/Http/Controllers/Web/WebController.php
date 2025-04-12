<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use App\Models\Category;
use App\Models\Enquiry;
use App\Models\Product;
use DB;
use Illuminate\Http\Request;

class WebController extends Controller
{
    public function index()
    {
        // $data['blogs'] = Blog::where('is_deleted', '0')->orderBy('id', 'desc')->take(3)->get();
        $data['category'] = Category::where('cat_id', '0')->get();
        $data['subCategory'] = Category::where('cat_id', '!=', '0')->take(3)->get();
        $data['products'] = Product::get();
        foreach ($data['products'] as $key => $product) {
            $image = DB::table('images')->where('product_id', $product->id)->latest()->first('name');
            if ($image) {
                $data['products'][$key]['image'] = DB::table('images')->where('product_id', $product->id)->latest()->first()->name;
            }
        }

        return view('web.index', compact('data'));
    }

    public function about()
    {
        return view('web.pages.about');
    }

    public function mission_vision()
    {
        return view('web.pages.mission_vision');
    }

    public function quality()
    {
        return view('web.pages.quality');
    }

    public function our_strength()
    {
        return view('web.pages.our_strength');
    }

    public function promoters()
    {
        return view('web.pages.promoters');
    }

    public function contact()
    {
        return view('web.pages.contact');
    }

    public function certificate()
    {
        return view('web.pages.certificate');
    }

    public function save_enquiry(Request $request)
    {
        $validate = $request->validate([
            'name' => 'required',
            'email' => 'required',
            'phone' => 'required',
            'subject' => 'required',
            'city' => 'required',
            'state' => 'required',
            'message' => 'required',
        ]);
        $save_data = Enquiry::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'city' => $request->city,
            'state' => $request->state,
            'subject' => $request->subject,
            'message' => $request->message,
        ]);
        if (! empty($save_data)) {
            return ['success', ' -> Enquiry Send Successfully!'];
        } else {
            return ['error', ' -> Something went wrong!'];
        }
    }

    public function blogs()
    {
        $data['blogs'] = Blog::where('is_deleted', '0')->orderBy('id', 'desc')->paginate(3);

        return view('web.pages.blogs', compact('data'));
    }

    public function blog_details($slug)
    {
        $data['blog'] = Blog::where('slug', $slug)->first();
        $data['blogs'] = Blog::get();

        return view('web.pages.blog-details', compact('data'));
    }

    public function all_categories()
    {
        $data['category'] = Category::where('cat_id', '0')->get();

        return view('web.pages.product', compact('data'));
    }

    public function master_function($slug)
    {
        $data['product'] = Product::where('slug', $slug)->first();
        $data['category'] = Category::where('slug', $slug)->where('cat_id', '0')->first();
        $data['subcategory'] = Category::where('slug', $slug)->where('cat_id', '!=', '0')->first();

        if ($data['product']) {
            $data['heading'] = $data['product']->name;
            $data['products'] = Product::where('sub_cat_id', $data['product']->sub_cat_id)->get();
            $data['pro_specification'] = DB::table('specifications')->where('product_id', $data['product']->id)->get();
            $data['product']['images'] = DB::table('images')->where('product_id', $data['product']->id)->take(5)->latest()->get();

            return view('web.pages.product-details', compact('data'));
        } elseif ($data['subcategory']) {
            $data['heading'] = $data['subcategory']->name;
            $data['paragraph'] = $data['subcategory']->description;
            $data['products'] = Product::where('sub_cat_id', $data['subcategory']->id)->get();
            foreach ($data['products'] as $key => $product) {
                $image = DB::table('images')->where('product_id', $product->id)->latest()->first('name');
                if ($image) {
                    $data['products'][$key]['image'] = DB::table('images')->where('product_id', $product->id)->latest()->first()->name;
                }
            }

            return view('web.pages.sub_categories', compact('data'));
        } elseif ($data['category']) {
            $data['heading'] = $data['category']->name;
            $data['paragraph'] = $data['category']->description;
            $subCategory = Category::where('cat_id', '!=', '0')->get();
            foreach ($subCategory as $category) {
                if (in_array($data['category']->id, explode(',', $category->cat_id))) {
                    $data['subcategory'][] = $category;
                }
                $product = Product::where('sub_cat_id', $category->id)->first();
                if ($product) {
                    $data['relatedProducts'][] = $product;
                }
            }

            return view('web.pages.categories', compact('data'));
        } else {
            return redirect()->route('home');
        }
    }
}
