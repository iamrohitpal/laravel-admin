<x-admin.layout type="category">
    <link href="{{asset('admin/assets/plugins/select2/css/select2.min.css')}}" rel="stylesheet" />
	<link href="{{asset('admin/assets/plugins/select2/css/select2-bootstrap4.css')}}" rel="stylesheet" />

        <div class="page-content">
            <!--breadcrumb-->
            <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
                <div class="breadcrumb-title pe-3">Category</div>
                <div class="ps-3">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-0 p-0">
                            <li class="breadcrumb-item">
                                <a href="{{route('dashboard')}}"><i class="bx bx-home-alt"></i></a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">
                                Category
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
                            <form action="{{route('save_category')}}" method="POST" class="row g-3" enctype="multipart/form-data">
                                @csrf
                                <div class="col-12">
                                    <label for="inputFirstName" class="form-label">Category Name</label>
                                    <input type="text" name="name" class="form-control" value="{{$data['name'] ?? old('name') ?? ''}}" placeholder="Category Name..." id="inputFirstName">
                                    <input type="hidden" name="id" value="{{$data['id'] ?? '0'}}">
                                </div>
                                <div class="col-12">
                                    <label for="inputAddress2" class="form-label">Upload Image</label>
                                    <input type="file" name="image" class="form-control" id="formFile" >
                                    <input type="hidden" name="old_image" value="{{$data['image'] ?? old('image')  ?? ''}}">
                                </div>
                                <div class="col-12">
                                    <label for="inputAddress2" class="form-label">Description</label>
                                    <textarea name="description" class="form-control" id="mytextarea" placeholder="Description..." rows="5">{{$data['description'] ?? old('description')  ?? ''}}</textarea>
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
