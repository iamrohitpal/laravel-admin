<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Help;
use App\Models\Blog;
use App\Models\Buy;
use App\Models\Sell;
use App\Models\News;
use App\Models\Gallery;
use App\Models\Testing_lab;
use App\Models\Contactus;
use App\Models\Products;
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
    public function dashboard()
    {
        return view('admin.index');
    }

    public function profile(Request $request)
    {
        $data['user'] = User::first();
        return view('Admin.Profile.profile', compact('data'));
    }

    public function update_profile(Request $request)
    {
        $update_data = User::where('id', $request->user_id)->update([
            'name' => $request->name,
            'email' => $request->email,
            // 'insa_link' => $request->instagram ?? '',
            // 'faceb_link' => $request->facebook ?? '',
            // 'twitt_link' => $request->linkedin ?? '',
            // 'linked_link' => $request->twitter ?? '',
        ]);
        if (!empty($update_data)) {
            return redirect()->back()->with('success', 'Profile Updated Successfully!');
        } else {
            return redirect()->back()->wih('error', 'Something went wrong!');
        }
    }

    public function change_password(Request $request)
    {
        $validated = $request->validate([
            'old_password' => 'required',
            'new_password' => 'required_with:password_confirmation|same:password_confirmation',
            'password_confirmation' => 'min:6'
        ]);

        $data_check = User::where('id', $request->user_id)->first();

        if (Hash::check($request->old_password, $data_check->password)) {
            if ($request->old_password == $request->new_password) {
                return redirect()->back()->with('error', 'Old Password and New Password Can not be same!');
            } else {
                $update_data = User::where('id', $request->user_id)->update([
                    'password' => Hash::make($request->new_password),
                ]);
                if (!empty($update_data)) {
                    return redirect()->back()->with('success', 'Password Updated Successfully!');
                } else {
                    return redirect()->back()->with('error', 'Something went wring!');
                }
            }
        } else {
            return redirect()->back()->with('error', 'Old Password is not Correct!');
        }
    }
    public function help(Request $request)
    {
        $data['help'] = Help::where('is_deleted', '0')->get();
        return view('Admin.Help.help', compact('data'));
    }

    //============ Blog Section Crud ====================//
    public function blogs(Request $request)
    {
        $data['blog_data'] = Blog::where('is_deleted', '0')->get();
        return view('Admin.Blog.listview', compact('data'));
    }
    public function blog_form($type, $id)
    {
        $data = Blog::where('id', $id)->first();
        return view('Admin.Blog.editview', compact('data'));
    }
    public function save_blog(Request $request)
    {
        $validate = $request->validate([
            'title' => 'required',
            'description' => 'required',
        ]);

        // dd($request->all());

        if (empty($request->file)) {
            $filename = $request->old_file;
        } else {
            $filename = $this->fileupload($request->file, 'blog');
        }

        $string = strtolower($request->title);
        $string = preg_replace('/[^a-z0-9]+/', '-', $string);
        // dd($string, $request);
        $addBlog = Blog::updateOrCreate(['id' => $request->id], [
            'title' => $request->title,
            'file' => $filename,
            'slug' => $string,
            'description' => $request->description,
        ]);
        if (!empty($addBlog)) {
            return redirect()->route('blog_list')->with('success', 'Data Added Successfully!');
        } else {
            return back()->with('error', 'Something went wrong!');
        }
    }
    //============ Blog Section Crud ====================//

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
    public function category_list()
    {
        $data['category'] = Category::where('cat_id', '0')->get();
        return view('admin.category.index', compact('data'));
    }
    public function category_form($type, $id)
    {
        $data = Category::where('id', $id)->first();
        return view('Admin.Category.editview', compact('data'));
    }
    public function save_category(Request $request)
    {
        $validate = $request->validate([
            'name' => 'required',
            'description' => 'required',
            // 'cat_id' => 'required',
        ]);

        if (!empty($request->image)) {
            $image = $this->fileupload($request->image, 'category');
        } else {
            $image = $request->old_image;
        }
        $string = strtolower($request->name);
        $string = preg_replace('/[^a-z0-9]+/', '-', $string);
        $add_data = Category::updateOrCreate(['id' => $request->id], [
            'name' => $request->name,
            'image' => $image,
            'description' => $request->description,
            'slug' => $string,
            'cat_id' => $request->cat_id ?? '0',
        ]);
        if (!empty($add_data)) {
            return redirect()->route('category_list')->with('success', 'Category Added Successfully!');
        } else {
            return redirect()->back()->with('error', 'Something went erong!');
        }
    }
    public function subcategory_list()
    {
        $data['subcategory'] = Category::where('cat_id', '!=', '0')->get();
        foreach ($data['subcategory'] as $key => $value) {
            $category = Category::where('id', $value->cat_id)->first();
            $data['subcategory'][$key]['category'] = $category['name'];
        }
        return view('Admin.Subcategory.listview', compact('data'));
    }
    public function subcategory_form($type, $id)
    {
        $data['cat_edit_data'] = Category::where('id', $id)->first();
        $data['category'] = Category::where('cat_id', '0')->get();
        return view('Admin.Subcategory.editview', compact('data'));
    }
    public function subscribe_emails()
    {
        $data['subscribe_emails'] = DB::table('subscribe_emails')->get();
        return view('Admin.subscribe_email.listview', compact('data'));
    }
    public function save_subcategory(Request $request)
    {
        $validate = $request->validate([
            'name' => 'required',
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
        $add_data = Category::updateOrCreate(['id' => $request->id], [
            'name' => $request->name,
            'image' => $image,
            'description' => $request->description,
            'cat_id' => $request->cat_id,
            'slug' => $string,
        ]);
        if (!empty($add_data)) {
            return redirect()->route('subcategory_list')->with('success', 'Category Added Successfully!');
        } else {
            return redirect()->back()->with('error', 'Something went erong!');
        }
    }
    public function infrastructure_list(Request $request)
    {
        $data['infrastructure'] = Infrastructure::get();
        // dd($data);
        return view('Admin.Infrastructure.listview', compact('data'));
    }
    public function infrastructure_form($type, $id)
    {
        $data = Infrastructure::where('id', $id)->first();
        return view('Admin.Infrastructure.editview', compact('data'));
    }
    public function save_infrastructure(Request $request)
    {
        $add_gallary = $request->validate([
            // 'f_image' => 'required',
            // 's_image' => 'required',
            // 't_image' => 'required',
            // 'description' => 'required',
        ]);
        if (!empty($request->f_image) && !empty($request->s_image)) {
            $filename1 = $this->fileupload($request->f_image, 'infrastructure');
            $filename2 = $this->fileupload($request->s_image, 'infrastructure');
            $add_gallary = Infrastructure::updateOrCreate(['id' => $request->id], [
                'f_image' => $filename1,
                's_image' => $filename2,
                // 't_image' => $filename3,
                'description' => $request->description,
            ]);
        } else {
            $add_gallary = Infrastructure::updateOrCreate(['id' => $request->id], [
                'description' => $request->description,
            ]);
        }

        if (!empty($add_gallary)) {
            return redirect()->route('infrastructure_list')->with('success', 'Image Added Successfully!');
        } else {
            return back()->with('error', 'Something went wrong!');
        }
    }

    public function product_list()
    {
        $data['product'] = Products::where('is_deleted', '0')->get();
        return view('Admin.Product.listview', compact('data'));
    }
    public function product_form($type, $id)
    {
        $data['product'] = Products::where('id', $id)->first();
        $data['products'] = DB::table('product_specification')->where('product_id', $id)->first();
        $data['subcategory'] = Category::where('cat_id', '!=', '0')->get();
        return view('Admin.Product.editview', compact('data'));
    }
    public function save_product(Request $request)
    {
        $validation = $request->validate([
            'subcategory_id' => 'required',
            'name' => 'required',
            'description' => 'required',
            'long_description' => 'required',
        ]);

        if ($request->has('image1')) {
            $filename1 = $this->fileupload($request->image1, 'product');
        } else {
            $filename1 = $request->old_image1;
        }
        if ($request->has('image2')) {
            $filename2 = $this->fileupload($request->image2, 'product');
        } else {
            $filename2 = $request->old_image2 ?? null;
        }
        if ($request->has('image3')) {
            $filename3 = $this->fileupload($request->image3, 'product');
        } else {
            $filename3 = $request->old_image3 ?? null;
        }

        $string = strtolower($request->name);
        $string = preg_replace('/[^a-z0-9]+/', '-', $string);

        $add_data = Products::updateOrCreate(['id' => $request->id], [
            'subcategory_id' => $request->subcategory_id,
            'name' => $request->name,
            'slug' => $string,
            'image1' => $filename1,
            'image2' => $filename2,
            'image3' => $filename3,
            'description' => $request->description,
            'long_description' => $request->long_description,
        ]);
        // dd($request);
        if (empty($request->specification_id)) {
            $product = Products::latest()->first();
            $data = DB::table('product_specification')->insert([
                'product_id' => $product->id,
                'purity' => $request->purity,
                'natural_admixture' => $request->natural_admixture,
                'delivery_time' => $request->delivery_time,
                'moisture' => $request->moisture,
                'broken_grain' => $request->broken_grain,
                'immature_grain' => $request->immature_grain,
                'damage_discolour_grain' => $request->damage_discolour_grain,
                'foreign_matter' => $request->foreign_matter,
                'average_grain_length' => $request->average_grain_length,
                'supply_ability' => $request->supply_ability,
                'main_export_market_s' => $request->main_export_market_s,
                'packaging_type' => $request->packaging_type,
            ]);
        } else {
            $data = DB::table('product_specification')->where('id', $request->specification_id)->update([
                'product_id' => $request->id,
                'purity' => $request->purity,
                'natural_admixture' => $request->natural_admixture,
                'delivery_time' => $request->delivery_time,
                'moisture' => $request->moisture,
                'broken_grain' => $request->broken_grain,
                'immature_grain' => $request->immature_grain,
                'damage_discolour_grain' => $request->damage_discolour_grain,
                'foreign_matter' => $request->foreign_matter,
                'average_grain_length' => $request->average_grain_length,
                'supply_ability' => $request->supply_ability,
                'main_export_market_s' => $request->main_export_market_s,
                'packaging_type' => $request->packaging_type,
            ]);
        }

        if (!empty($add_data)) {
            return redirect()->route('product_list')->with('success', 'Data Added Successfully!');
        } else {
            return redirect()->back()->with('error', 'Somthing went wrong!');
        }
    }
    public function enquiry_list()
    {
        $data['enquiry'] = Enquiry::where('is_deleted', '0')->where('state', '!=', '')->get();
        return view('Admin.Enquiry.listview', compact('data'));
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
    public function fileupload($file, $type)
    {
        $path = "public/upload_image/" . $type;
        if (file_exists($path)) {
            $filename = time() . '-' . $type . '-' . $file->getClientOriginalName();
            $file->move($path, $filename);
            return $filename;
        } else {
            mkdir($path, 0777, true);
            $filename = time() . '-' . $type . '-' . $file->getClientOriginalName();
            $file->move($path, $filename);
            return $filename;
        }
    }

    //============ Buy Section  ============//
    public function buy(Request $request)
    {
        $buy = Buy::where('is_deleted', '0')->get();
        $data = $buy->map(function ($item) {
            $item->product = Products::where('id', $item->product_id)->first();
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
            $item->product = Products::where('id', $item->product_id)->first();
            return $item;
        });
        return view('Admin.Sell.listview', compact('data'));
    }
    //============ Sell Section  ============//

    public function delete_data(Request $request, $type, $id)
    {
        if ($type == 'blog') {
            $delete_blog = Blog::where('id', $id)->first();
            if (!empty($delete_blog)) {
                $delete_blog->delete();
                return redirect()->route('blog_list')->with('success', 'Blog Deleted Successfully!');
            } else {
                return back()->with('error', 'Data Not Available!');
            }
        } elseif ($type == 'gallery') {
            $delete_gallery = Gallery::where('id', $id)->first();
            if (!empty($delete_gallery)) {
                $delete_gallery->delete();
                return redirect()->route('gallery_list')->with('success', 'Gallery Image Deleted Successfully!');
            } else {
                return back()->with('error', 'Data Not Available!');
            }
        } elseif ($type == 'certificate') {
            $delete_certificate = Certification::where('id', $id)->first();
            if (!empty($delete_certificate)) {
                $delete_certificate->delete();
                return redirect()->route('certificate_list')->with('success', 'Certificate Data Deleted Successfully!');
            } else {
                return back()->with('error', 'Data Not Available!');
            }
        } elseif ($type == 'category') {
            $delete_data = Category::where('id', $id)->first();
            $sub_cat = Category::where('cat_id', $id)->get();
            if (!empty($delete_data)) {
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
            if (!empty($delete_data)) {
                $delete_data->delete();
                return redirect()->route('subcategory_list')->with('success', 'Sub Category Data Deleted Successfully!');
            } else {
                return redirect()->back()->with('error', 'Something went wrong!');
            }
        } elseif ($type == 'product') {
            $delete_data = Products::where('id', $id)->first();
            if (!empty($delete_data)) {
                $delete_data->delete();
                return redirect()->route('product_list')->with('success', 'Product Data Deleted Successfully!');
            } else {
                return redirect()->back()->with('error', 'Something went wrong!');
            }
        } elseif ($type == 'infrastructure') {
            $delete_data = Infrastructure::where('id', $id)->first();
            if (!empty($delete_data)) {
                $delete_data->delete();
                return redirect()->route('infras_list')->with('success', 'Infrastructure Data Deleted Successfully!');
            } else {
                return redirect()->back()->with('error', 'Something went wrong!');
            }
        } elseif ($type == 'enquiry') {
            $delete_data = Enquiry::where('id', $id)->first();
            if (!empty($delete_data)) {
                $delete_data->delete();
                return redirect()->route('enquiry_list')->with('success', 'Enquiry Data Deleted Successfully!');
            } else {
                return redirect()->back()->with('error', 'Something went wrong!');
            }
        } elseif ($type == 'testing_lab') {
            $delete_data = Testing_lab::where('id', $id)->first();
            if (!empty($delete_data)) {
                $delete_data->delete();
                return redirect()->route('testing_lab_list')->with('success', 'Testing Lab Data Deleted Successfully!');
            } else {
                return redirect()->back()->with('error', 'Something went wrong!');
            }
        } elseif ($type == 'news') {
            $delete_data = News::where('id', $id)->first();
            if (!empty($delete_data)) {
                $delete_data->delete();
                return redirect()->route('news_list')->with('success', 'News Data Deleted Successfully!');
            } else {
                return redirect()->back()->with('error', 'Something went wrong!');
            }
        } elseif ($type == 'seo') {
            $delete_data = Seo::where('id', $id)->first();
            if (!empty($delete_data)) {
                $delete_data->delete();
                return redirect()->route('seo_list')->with('success', 'Seo Data Deleted Successfully!');
            } else {
                return redirect()->back()->with('error', 'Something went wrong!');
            }
        }
    }
    public function logout()
    {
        Auth::guard('admin')->logout();
        return redirect()->route('login');
    }
}
