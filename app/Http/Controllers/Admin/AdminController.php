<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Permission;
use App\Models\User;
use App\Models\Help;
use App\Models\Blog;
use App\Models\Buy;
use App\Models\Sell;
use App\Models\News;
use App\Models\Gallery;
use App\Models\Testing_lab;
use App\Models\Contactus;
use App\Models\Product;
use App\Models\Aboutus;
use App\Models\Infrastructure;
use App\Models\Certification;
use App\Models\Category;
use App\Models\Enquiry;
use App\Models\Dealer;
use App\Models\Seo;
use Auth;
use Hash;
use DB;

class AdminController extends Controller
{
    private bool $list;
    private bool $create;
    private bool $edit;
    private bool $delete;
    public function __construct()
    {
        $this->list = Permission::getPermissionBySlugAndId('Dashboard');
        $this->create = Permission::getPermissionBySlugAndId('Dashboard', 'Create');
        $this->edit = Permission::getPermissionBySlugAndId('Dashboard', 'Edit');
        $this->delete = Permission::getPermissionBySlugAndId('Dashboard', 'Delete');
    }

    public function dashboard()
    {
        if (! $this->list) {
            abort(403);
        }

        $data['totalCategories'] = Category::where('cat_id', '0')->count();
        $data['totalSubCategories'] = Category::where('cat_id', '!=',  '0')->count();
        $data['totalProducts'] = Product::where('status', '1')->count();
        $data['totalenquiries'] = Product::where('status', '1')->count();
        return view('admin.index', compact('data'));
    }

    public function help(Request $request)
    {
        $data['help'] = Help::where('is_deleted', '0')->get();
        return view('Admin.Help.help', compact('data'));
    }

    //============ News Section Crud ====================//
    public function news(Request $request)
    {
        $data['blog_data'] = News::where('is_deleted', '0')->get();
        return view('Admin.News.listview', compact('data'));
    }
    public function news_form($type, $id)
    {
        $data = News::where('id', $id)->first();
        return view('Admin.News.editview', compact('data'));
    }
    public function save_news(Request $request)
    {
        $validate = $request->validate([
            'title' => 'required',
            'description' => 'required',
        ]);

        if (isset($request->old_file)) {
            $filename = $request->old_file;
        } else {
            $filename = $this->fileupload($request->file, 'news');
        }
        $addnews = News::updateOrCreate(['id' => $request->id], [
            'title' => $request->title,
            'file' => $filename,
            'description' => $request->description,
        ]);
        if (!empty($addnews)) {
            return redirect()->route('news_list')->with('success', 'Data Added Successfully!');
        } else {
            return back()->with('error', 'Something went wrong!');
        }
    }
    //============ News Section Crud ====================//

    //============ Gallery Section Crud ====================//
    public function gallery_list(Request $request)
    {
        $data['galley_data'] = Gallery::where('status', 'active')->where('is_deleted', '0')->get();
        return view('Admin.Gallery.listview', compact('data'));
    }
    public function gallery_form($type, $id)
    {
        $data = Gallery::where('id', $id)->where('is_deleted', '0')->first();
        return view('Admin.Gallery.editview', compact('data'));
    }
    public function save_gallery(Request $request)
    {
        $filename = $this->fileupload($request->file, 'gallery');
        $add_gallary = Gallery::updateOrCreate(['id' => $request->id], [
            'gallery_image' => $filename,
        ]);
        if (!empty($add_gallary)) {
            return redirect()->route('gallery_list')->with('success', 'Image Added Successfully!');
        } else {
            return back()->with('error', 'Something went wrong!');
        }
    }
    //============ Gallery Section Crud ====================//

    //============ Tesring Lab Section Crud ====================//
    public function testing_lab_list(Request $request)
    {
        $data['galley_data'] = Testing_lab::where('status', 'active')->where('is_deleted', '0')->get();
        return view('Admin.TestingLab.listview', compact('data'));
    }
    public function testingLab_form($type, $id)
    {
        $data = Testing_lab::where('id', $id)->where('is_deleted', '0')->first();
        return view('Admin.TestingLab.editview', compact('data'));
    }
    public function save_testingLab(Request $request)
    {
        // dd($request->all());
        $filename = $this->fileupload($request->file, 'testing_lab');
        $add_gallary = Testing_lab::updateOrCreate(['id' => $request->id], [
            'testing_lab_image' => $filename,
        ]);
        if (!empty($add_gallary)) {
            return redirect()->route('testing_lab_list')->with('success', 'Image Added Successfully!');
        } else {
            return back()->with('error', 'Something went wrong!');
        }
    }
    //============ Tesring Lab Section Crud ====================//

    public function contactus_list(Request $request)
    {
        $data['contactus'] = Contactus::get();
        return view('Admin.Contactus.listview', compact('data'));
    }
    public function contactus_form($type, $id)
    {
        $data = Contactus::where('id', $id)->first();
        return view('Admin.Contactus.editview', compact('data'));
    }
    public function save_contactus(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required',
            'phone' => 'required',
            'email' => 'required',
            'address' => 'required',
            'twitter_link' => 'required',
            'pinterest_link' => 'required',
            'facebook_link' => 'required',
            'instagram_link' => 'required',
        ]);
        $insert_data =  Contactus::updateOrCreate(['id' => $request->id], $request->all());
        if (!empty($insert_data)) {
            return redirect()->route('contactus_list')->with('sucess', 'Contact Updated Sucessfully!');
        } else {
            return back()->with('error', 'Something went wrong!');
        }
    }
    public function contactus_details(Request $request)
    {
        $data = Contactus::where('id', 1)->first();
        return view('Admin.Contactus.detailview', compact('data'));
    }
    public function aboutus_list()
    {
        $data = Aboutus::all();
        return view('Admin.About_us.listview', compact('data'));
    }
    public function aboutus_form($type, $id)
    {
        $data = Aboutus::where('id', $id)->first();
        return view('Admin.About_us.index', compact('data'));
    }
    public function save_aboutus(Request $request)
    {
        $validation = $request->validate([
            'content_1' => 'required',
            'content_2' => 'required',
            'content_3' => 'required',
            'content_4' => 'required',
            'content_5' => 'required',
            'content_6' => 'required',
            'content_7' => 'required',
            'content_8' => 'required',
            'content_9' => 'required',
            'content_10' => 'required',
            'content_11' => 'required',
        ]);
        $update_data = Aboutus::updateOrCreate(['id' => $request->id], [
            'content_1' => $request->content_1,
            'content_2' => $request->content_2,
            'content_3' => $request->content_3,
            'content_4' => $request->content_4,
            'content_5' => $request->content_5,
            'content_6' => $request->content_6,
            'content_7' => $request->content_7,
            'content_8' => $request->content_8,
            'content_9' => $request->content_9,
            'content_10' => $request->content_10,
            'content_11' => $request->content_11,
        ]);
        if (!empty($update_data)) {
            return redirect()->route('about_usList')->with('success', 'Data Updated Successfully!');
        } else {
            return back()->with('error', 'Something went wrong!');
        }
    }
    public function certificate_list(Request $request)
    {
        $data['certificate'] = Certification::where('is_deleted', '0')->get();
        return view('Admin.Certification.listview', compact('data'));
    }
    public function certificate_form($type, $id)
    {
        $data = Certification::where('id', $id)->where('is_deleted', '0')->first();
        return view('Admin.Certification.editview', compact('data'));
    }
    public function save_certificate(Request $request)
    {
        $validate = $request->validate([
            'name' => 'required',
        ]);
        if (isset($request->old_file)) {
            $filename = $request->old_file;
        } else {
            $filename = $this->fileupload($request->file, 'certification');
        }
        $add_data = Certification::updateOrCreate(['id' => $request->id], [
            'name' => $request->name,
            'file' => $filename,
        ]);
        if (!empty($add_data)) {
            return redirect()->route('certificate_list')->with('success', 'Data Added Successfully!');
        } else {
            return redirect()->back()->with('error', 'Somthing went wrong!');
        }
    }

    public function product_enquiry_list()
    {
        $data['product_enquiry'] = Enquiry::where('is_deleted', '0')->where('state', '=', '')->get();
        return view('Admin.Enquiry.product_listview', compact('data'));
    }

    public function dealer_list()
    {
        $data['dealer'] = Dealer::get();
        return view('Admin.Dealer.listview', compact('data'));
    }
    public function seo_list()
    {
        $data['seo'] = Seo::where('is_deleted', '0')->get();
        return view('Admin.Seo.listview', compact('data'));
    }
    public function seo_form($type, $id)
    {
        $data['seo'] = Seo::where('id', $id)->where('is_deleted', '0')->first();
        return view('Admin.Seo.editview', compact('data'));
    }
    public function save_seo(Request $request)
    {
        if ($request->id) {
            $validation = $request->validate([
                'page_name' => 'required',
                // 'page_title' => 'required',
                // 'meta_author' => 'required',
                'meta_keywords' => 'required',
                'meta_description' => 'required',
            ]);
        } else {
            $validation = $request->validate([
                'page_name' => 'required|unique:seo',
                // 'page_title' => 'required',
                // 'meta_author' => 'required',
                'meta_keywords' => 'required',
                'meta_description' => 'required',
            ]);
        }

        $add_data = Seo::updateOrCreate(['id' => $request->id], [
            'page_name' => $request->page_name ?? '',
            'meta_title' => $request->page_title ?? '',
            'meta_author' => $request->meta_author ?? '',
            'meta_keywords' => $request->meta_keywords ?? '',
            'meta_description' => $request->meta_description ?? '',
        ]);
        if (!empty($add_data)) {
            return redirect()->route('seo_list')->with('success', 'Data Updated Successfully!');
        } else {
            return redirect()->back()->with('error', 'Somthing went wrong!');
        }
    }

    public function fileupload($file, $type, $id = null)
    {
        $path = "upload_image/" . $type;
        
        if (file_exists($path)) {
            
            $filename = time() . '-' . $type . '-' . $file->getClientOriginalName();
            $file->move($path, $filename);
            if ($id) {
                DB::table('images')->insert([
                 'product_id' => $id,
                 'name' => $filename,
                ]);
            }
            
            return $filename;
        } else {
            mkdir($path, 0777, true);
            $filename = time() . '-' . $type . '-' . $file->getClientOriginalName();
            $file->move($path, $filename);
            if ($id) {
                DB::table('images')->insert([
                 'product_id' => $id,
                 'name' => $filename,
                ]);
            }

            return $filename;
        }
    }

    //============ Buy Section  ============//
    public function buy(Request $request)
    {
        $buy = Buy::where('is_deleted', '0')->get();
        $data = $buy->map(function ($item) {
            $item->product = Product::where('id', $item->product_id)->first();
            return $item;
        });

        return view('Admin.Buy.listview', compact('data'));
    }
    //============ Buy Section  ============//

    //============ Sell Section  ============//
    public function sell(Request $request)
    {
        // $data = Sell::where('is_deleted', '0')->get();

        $sell = Sell::where('is_deleted', '0')->get();
        $data = $sell->map(function ($item) {
            $item->product = Product::where('id', $item->product_id)->first();
            return $item;
        });
        return view('Admin.Sell.listview', compact('data'));
    }
    //============ Sell Section  ============//

    public function logout()
    {
        Auth::guard('admin')->logout();
        return redirect()->route('login');
    }
}
