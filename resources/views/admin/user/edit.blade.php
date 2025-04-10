<x-admin.layout type="user">
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
            <div class="breadcrumb-title pe-3">User</div>
            <div class="ps-3">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0 p-0">
                        <li class="breadcrumb-item">
                            <a href="{{ route('dashboard') }}"><i class="bx bx-home-alt"></i></a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">
                            User
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
                        <form action="{{ route('save_user') }}" method="POST" class="row g-3"
                            enctype="multipart/form-data">
                            @csrf
                            <div class="col-12">
                                <label for="inputFirstName" class="form-label">User Name</label>
                                <input type="text" name="name" class="form-control"
                                    value="{{ $data['user']['name'] ?? '' }}" placeholder="User Name..."
                                    id="inputFirstName">
                                <input type="hidden" name="id" value="{{ $data['user']['id'] ?? '0' }}">
                            </div>
                            <div class="col-12">
                                <label for="email" class="form-label">User Email</label>
                                <input type="email" name="email" class="form-control"
                                    value="{{ $data['user']['email'] ?? '' }}" placeholder="User Email..."
                                    id="email">
                            </div>
                            <div class="col-12">
                                <label for="password" class="form-label">User Password</label>
                                <input type="password" name="password" class="form-control" value=""
                                    placeholder="User Password..." id="password">
                            </div>
                            <div class="col-12">
                                <label class="form-label">User Role</label>
                                <select name="role_id" class="single-select form-control">
                                    @foreach ($data['roles'] as $role)
                                        <option value="{{ $role->id }}"
                                            {{ !empty($data['user']['role_id']) ? (in_array($role->id, explode(',', $data['user']['role_id'])) ? 'selected' : '') : '' }}>
                                            {{ $role->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-12">
                                <label class="form-label">Select User Image</label>
                                <input type="file" name="image" id="file-input" accept="image/*"
                                    class="form-control-file form-control height-auto">
                                <div id="preview-container">
                                    @php
                                        $images = [];
                                    @endphp
                                    @if (!empty($data['images']))
                                        @foreach ($data['images'] as $val)
                                            <div class='preview'>
                                                <img src='{{ asset('upload_image/user/' . $val->name) }}'>
                                                <button class='delete' data-image-name="{{ $val->name }}"> X
                                                </button>
                                                @php
                                                    $images[] = $val->name;
                                                @endphp
                                            </div>
                                        @endforeach
                                        <input type="hidden" name="old_file" id="old_file"
                                            value="{{ json_encode($images) }}">
                                    @endif
                                </div>
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
    <script src="{{ asset('admin/assets/js/jquery.min.js') }}"></script>
    <script>
        $(document).ready(function() {
            $("#file-input").on("change", function() {
                var files = $(this)[0].files;
                var maxFiles = 5;
                $("#preview-container").empty();

                if (files.length > 0) {
                    // Limit the number of files to maxFiles
                    if (files.length > maxFiles) {
                        alert("You can only upload up to " + maxFiles + " images at a time.");
                        files = Array.prototype.slice.call(files, 0,
                            maxFiles); // Select only the first 4 files
                    }

                    for (var i = 0; i < files.length; i++) {
                        var reader = new FileReader();
                        reader.onload = function(e) {
                            $("<div class='preview'><img src='" + e.target.result +
                                "'><button class='delete'> X </button></div>").appendTo(
                                "#preview-container");
                        };
                        reader.readAsDataURL(files[i]);
                    }
                }
            });
            let images = @json($images);
            $("#preview-container").on("click", ".delete", function() {
                let imageName = $(this).data('image-name');
                $(this).parent(".preview").remove();
                images = images.filter(function(value) {
                    return value !== imageName;
                });
                $('#old_file').val(JSON.stringify(images));
            });
        });
    </script>
    <!--end row-->
</x-admin.layout>
