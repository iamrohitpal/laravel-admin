<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Enquiry;
use App\Models\Permission;
use App\Traits\UploadFileTrait;

class EnquiryController extends Controller
{
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

    public function enquiry_list()
    {
        if (! Permission::getPermissionBySlugAndId('Enquiry')) {
            abort(403);
        }

        $data['enquiries'] = Enquiry::get();

        return view('admin.enquiry.index', compact('data'));
    }
}
