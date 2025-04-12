<x-admin.layout type="seo">
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
            <div class="breadcrumb-title pe-3">Seo</div>
            <div class="ps-3">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0 p-0">
                        <li class="breadcrumb-item">
                            <a href="{{ route('dashboard') }}"><i class="bx bx-home-alt"></i></a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">
                            Seo
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
                        <form action="{{ route('save_seo') }}" method="POST" class="row g-3"
                            enctype="multipart/form-data">
                            @csrf
                            <div class="col-12">
                                <label for="inputFirstName" class="form-label">Page Url</label>
                                <input type="url" name="url" class="form-control"
                                    value="{{ $data['seo']['url'] ?? '' }}" placeholder="Page Url..."
                                    id="inputFirstName">
                                <input type="hidden" name="id" value="{{ $data['seo']['id'] ?? '0' }}">
                            </div>

                            <div class="col-12">
                                <label for="inputTitle" class="form-label">Title</label>
                                <input type="text" name="title" class="form-control"
                                    value="{{ $data['seo']['title'] ?? '' }}" placeholder="Page Url..."
                                    id="inputTitle">
                            </div>
                            
                            <div class="col-12">
                                <label for="inputKeyword" class="form-label">Keyword</label>
                                <textarea name="keywords" class="form-control" id="inputKeyword" placeholder="Keyword..." rows="3">{{ $data['seo']['keywords'] ?? '' }}</textarea>
                            </div>

                            <div class="col-12">
                                <label for="inputDescription" class="form-label">Description</label>
                                <textarea name="description" class="form-control" id="inputDescription" placeholder="Description..." rows="4">{{ $data['seo']['description'] ?? '' }}</textarea>
                            </div>

                            <div class="col-12">
                                <label for="inputScript" class="form-label">Script</label>
                                <textarea name="script" class="form-control" id="inputScript" placeholder="Description..." rows="5">{{ $data['seo']['description'] ?? '' }}</textarea>
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
