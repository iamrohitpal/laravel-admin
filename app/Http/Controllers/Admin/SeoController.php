<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Permission;
use App\Models\Seo;
use App\Traits\UploadFileTrait;
use Illuminate\Http\Request;

class SeoController extends Controller
{
    use UploadFileTrait;

    private bool $list;

    private bool $create;

    private bool $edit;

    private bool $delete;

    public function __construct()
    {
        $this->list = Permission::getPermissionBySlugAndId('Seo');
        $this->create = Permission::getPermissionBySlugAndId('Seo', 'Create');
        $this->edit = Permission::getPermissionBySlugAndId('Seo', 'Edit');
        $this->delete = Permission::getPermissionBySlugAndId('Seo', 'Delete');
    }

    public function seo_list()
    {
        if (! $this->list) {
            abort(403);
        }

        $data['seo'] = Seo::get();

        return view('admin.seo.index', compact('data'));
    }

    public function seo_form($type, $id)
    {
        $permission = ($id == '0') ? $this->create : $this->edit;
        if (! $this->list || ! $permission) {
            abort(403);
        }

        $data['seo'] = Seo::where('id', $id)->first();

        return view('admin.seo.edit', compact('data'));
    }

    public function save_seo(Request $request)
    {
        $permission = ($request->id == '0') ? $this->create : $this->edit;
        if (! $this->list || ! $permission) {
            abort(403);
        }

        $validate = $request->validate([
            'url' => 'required',
        ]);

        $addSeo = Seo::updateOrCreate(['id' => $request->id], [
            'url' => $request->url,
            'title' => $request->title,
            'keywords' => $request->keywords,
            'description' => $request->description,
            'script' => $request->script,
        ]);

        if (! empty($addSeo)) {
            return redirect()->route('seo_list')->with('success', 'Data Added Successfully!');
        } else {
            return back()->with('error', 'Something went wrong!');
        }
    }
}
