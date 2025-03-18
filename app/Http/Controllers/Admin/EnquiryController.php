<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Client\Request;
use App\Http\Controllers\Controller;
use App\Models\Permission;
use App\Models\Enquiry;
use App\Traits\UploadFileTrait;

class EnquiryController extends Controller
{
    use UploadFileTrait;

    public function enquiry_list()
    {
        if (! Permission::getPermissionBySlugAndId('Enquiry')) {
            abort(403);
        }

        $data['enquiries'] = Enquiry::get();
        return view('admin.enquiry.index', compact('data'));
    }
}