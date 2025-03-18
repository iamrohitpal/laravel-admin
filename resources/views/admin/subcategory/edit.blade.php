<x-admin.layout type="subCategory">
    <link href="{{asset('admin/assets/plugins/select2/css/select2.min.css')}}" rel="stylesheet" />
	<link href="{{asset('admin/assets/plugins/select2/css/select2-bootstrap4.css')}}" rel="stylesheet" />
    <!--start page wrapper -->
    <div class="page-wrapper">
        <div class="page-content">
            <!--breadcrumb-->
            <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
                <div class="breadcrumb-title pe-3">Sub Category</div>
                <div class="ps-3">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-0 p-0">
                            <li class="breadcrumb-item">
                                <a href="{{route('dashboard')}}"><i class="bx bx-home-alt"></i></a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">
                                Sub Category
                            </li>
                        </ol>
                    </nav>
                </div>
            </div>
            <!--end breadcrumb-->
            <hr />
            <div class="row">
                <div class="col-xl-12 mx-auto">
                    <div class="card border-top border-0 border-4 border-primary">
                        <div class="card-body p-5">
                            <form action="{{route('save_subcategory')}}" method="POST" class="row g-3" enctype="multipart/form-data">
                                @csrf
                                <div class="col-12">
                                    <label class="form-label">Category</label>
                                    <select name="cat_id[]" class="multiple-select form-control" multiple>
                                        @foreach ($data['category'] as $category)
                                            <option value="{{$category->id}}" {{!empty($data['cat_edit_data']['cat_id']) ? (in_array($category->id, explode(',', $data['cat_edit_data']['cat_id'])) ? 'selected' : '') : ''}}>{{$category->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-12">
                                    <label for="inputFirstName" class="form-label">Sub Category Name</label>
                                    <input type="text" name="name" class="form-control" value="{{$data['cat_edit_data']['name'] ?? ''}}" placeholder="Sub Category Name..." id="inputFirstName">
                                    <input type="hidden" name="id" value="{{$data['cat_edit_data']['id'] ?? '0'}}">
                                </div>
                                <div class="col-12">
                                    <label for="inputAddress2" class="form-label">Upload Image</label>
                                    <input type="file" name="image" class="form-control" id="formFile" >
                                    <input type="hidden" name="old_image" value="{{$data['cat_edit_data']['image'] ?? ''}}">
                                </div>
                                <div class="col-12">
                                    <label for="inputAddress2" class="form-label">Description</label>
                                    <textarea name="description" class="form-control" id="mytextarea" placeholder="Description..." rows="5">{{$data['cat_edit_data']['description'] ?? ''}}</textarea>
                                </div>
                                <div class="col-2">
                                    <button type="submit" class="btn btn-primary px-5">Submit</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="{{asset('admin/assets/js/jquery.min.js')}}"></script>
    <script src="{{asset('admin/assets/plugins/select2/js/select2.min.js')}}"></script>
    <script>
        $('.single-select').select2({
			theme: 'bootstrap4',
			width: $(this).data('width') ? $(this).data('width') : $(this).hasClass('w-100') ? '100%' : 'style',
			placeholder: $(this).data('placeholder'),
			allowClear: Boolean($(this).data('allow-clear')),
		});
		$('.multiple-select').select2({
			theme: 'bootstrap4',
			width: $(this).data('width') ? $(this).data('width') : $(this).hasClass('w-100') ? '100%' : 'style',
			placeholder: $(this).data('placeholder'),
			allowClear: Boolean($(this).data('allow-clear')),
		});
    </script>
    <!--end row-->
</x-admin.layout>
