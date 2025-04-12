<x-admin.layout type="blog">
    <style>
        .preview {
            display: inline-block;
            margin: 10px;
        }

        .preview img {
            width: 100px;
            height: 100px;
            margin-right: 10px;
        }
    </style>

    <div class="page-content">
        <!--breadcrumb-->
        <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
            <div class="breadcrumb-title pe-3">Blog</div>
            <div class="ps-3">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0 p-0">
                        <li class="breadcrumb-item">
                            <a href="{{ route('dashboard') }}"><i class="bx bx-home-alt"></i></a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">
                            Blog
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
                        <form action="{{ route('save_blog') }}" method="POST" class="row g-3"
                            enctype="multipart/form-data">
                            @csrf
                            <div class="col-12">
                                <label for="inputFirstName" class="form-label">Blog Name</label>
                                <input type="text" name="name" class="form-control"
                                    value="{{ $data['blog']['name'] ?? '' }}" placeholder="Blog Name..."
                                    id="inputFirstName">
                                <input type="hidden" name="id" value="{{ $data['blog']['id'] ?? '0' }}">
                            </div>

                            <div class="col-12">
                                <label for="inputAddress2" class="form-label">Upload Image</label>
                                <input type="file" name="image" class="form-control" id="formFile" >
                                <input type="hidden" name="old_image" value="{{$data['blog']['image'] ?? old('image')  ?? ''}}">
                            </div>
                            
                            <div class="col-12">
                                <label for="inputAddress2" class="form-label">Description</label>
                                <textarea name="description" class="form-control" id="mytextarea" placeholder="Description..." rows="5">{{ $data['blog']['description'] ?? '' }}</textarea>
                            </div>
                            <div class="col-12">
                                <label for="inputAddress2" class="form-label">Long Description</label>
                                <textarea name="long_description" class="form-control" id="longtextarea" placeholder="Long Description..."
                                    rows="5">{{ $data['blog']['long_description'] ?? '' }}</textarea>
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
    <!--end row-->
</x-admin.layout>
