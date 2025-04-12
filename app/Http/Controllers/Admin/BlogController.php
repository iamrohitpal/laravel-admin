<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use App\Models\Permission;
use App\Traits\UploadFileTrait;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    use UploadFileTrait;

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
        if (! $this->list) {
            abort(403);
        }

        $data['blogs'] = Blog::get();

        return view('admin.blog.index', compact('data'));
    }

    public function blog_form($type, $id)
    {
        $permission = ($id == '0') ? $this->create : $this->edit;
        if (! $this->list || ! $permission) {
            abort(403);
        }

        $data['blog'] = Blog::where('id', $id)->first();

        return view('admin.blog.edit', compact('data'));
    }

    public function save_blog(Request $request)
    {
        $permission = ($request->id == '0') ? $this->create : $this->edit;
        if (! $this->list || ! $permission) {
            abort(403);
        }

        $validate = $request->validate([
            'name' => 'required',
            'description' => 'required',
        ]);

        if (empty($request->image)) {
            $filename = $request->old_image;
        } else {
            $filename = $this->fileupload($request->image, 'blog');
        }

        $string = strtolower($request->title);
        $string = preg_replace('/[^a-z0-9]+/', '-', $string);
        $addBlog = Blog::updateOrCreate(['id' => $request->id], [
            'name' => $request->name,
            'image' => $filename,
            'slug' => $string,
            'description' => $request->description,
        ]);

        if (! empty($addBlog)) {
            return redirect()->route('blog_list')->with('success', 'Data Added Successfully!');
        } else {
            return back()->with('error', 'Something went wrong!');
        }
    }
}
