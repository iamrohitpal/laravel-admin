<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Blog;
use App\Models\Permission;
use App\Traits\UploadFileTrait;
use App\Traits\GlobalDeleteTrait;
use DB;

class BlogController extends Controller
{
    use UploadFileTrait;
    use GlobalDeleteTrait;
    private bool $list;
    private bool $create;
    private bool $edit;
    private bool $delete;
    public function __construct()
    {
        $this->list = Permission::getPermissionBySlugAndId('Blog');
        $this->create = Permission::getPermissionBySlugAndId('Blog', 'Create');
        $this->edit = Permission::getPermissionBySlugAndId('Blog', 'Edit');
        $this->delete = Permission::getPermissionBySlugAndId('Blog', 'Delete');
    }

    public function blog_list()
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

        if (empty($request->file)) {
            $filename = $request->old_file;
        } else {
            $filename = $this->fileupload($request->file, 'blog');
        }

        $string = strtolower($request->title);
        $string = preg_replace('/[^a-z0-9]+/', '-', $string);
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
}