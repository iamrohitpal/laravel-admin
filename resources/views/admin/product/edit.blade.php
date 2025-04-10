<x-admin.layout type="product">
    <link href="{{ asset('admin/assets/plugins/select2/css/select2.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('admin/assets/plugins/select2/css/select2-bootstrap4.css') }}" rel="stylesheet" />
    <!--start page wrapper -->
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
            <div class="breadcrumb-title pe-3">Product</div>
            <div class="ps-3">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0 p-0">
                        <li class="breadcrumb-item">
                            <a href="{{ route('dashboard') }}"><i class="bx bx-home-alt"></i></a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">
                            Product
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
                        <form action="{{ route('save_product') }}" method="POST" class="row g-3"
                            enctype="multipart/form-data">
                            @csrf
                            <div class="col-12">
                                <label class="form-label">Sub Category</label>
                                <select name="sub_cat_id[]" class="multiple-select form-control" multiple>
                                    @foreach ($data['subcategory'] as $category)
                                        <option value="{{ $category->id }}"
                                            {{ !empty($data['product']['sub_cat_id']) ? (in_array($category->id, explode(',', $data['product']['sub_cat_id'])) ? 'selected' : '') : '' }}>
                                            {{ $category->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-12">
                                <label for="inputFirstName" class="form-label">Product Name</label>
                                <input type="text" name="name" class="form-control"
                                    value="{{ $data['product']['name'] ?? '' }}" placeholder="Product Name..."
                                    id="inputFirstName">
                                <input type="hidden" name="id" value="{{ $data['product']['id'] ?? '0' }}">
                            </div>
                            <div class="col-12">
                                <label class="form-label">Select Product Image</label>
                                <input type="file" name="images[]" id="file-input" accept="image/*" multiple
                                    class="form-control-file form-control height-auto">
                                <div id="preview-container">
                                    @php
                                        $images = [];
                                    @endphp
                                    @if (!empty($data['images']))
                                        @foreach ($data['images'] as $val)
                                            <div class='preview'>
                                                <img src='{{ asset('upload_image/product/' . $val->name) }}'>
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
                            <div class="col-12">
                                <label for="inputAddress2" class="form-label">Description</label>
                                <textarea name="description" class="form-control" id="mytextarea" placeholder="Description..." rows="5">{{ $data['product']['description'] ?? '' }}</textarea>
                            </div>
                            <div class="col-12">
                                <label for="inputAddress2" class="form-label">Long Description</label>
                                <textarea name="long_description" class="form-control" id="longtextarea" placeholder="Long Description..."
                                    rows="5">{{ $data['product']['long_description'] ?? '' }}</textarea>
                            </div>
                            <!-- Add more button -->
                            {{-- <div class="form-group">
                                    <button type="button" id="add-more" class="btn btn-primary">Add More</button>
                                </div> --}}

                            <!-- Container for dynamic fields -->
                            {{-- <div id="dynamic-fields">
                                    @if (!empty($data['specifications']))
                                        @php $index = 0; @endphp
                                        <input type="hidden" name="specification_id" value="{{$data['product']['id'] ?? ''}}">
                                        @foreach ($data['specifications'] as $spec)
                                            <div class="row field-group">
                                                <div class="col-md-5 col-sm-12">
                                                    <div class="form-group">
                                                        <label class="form-label">Attribute Key</label>
                                                        <input type="hidden"
                                                            name="specifications[{{ $index }}][id]"
                                                            value="{{ $spec->id }}">
                                                        <input type="text"
                                                            name="specifications[{{ $index }}][key]"
                                                            value="{{ $spec->attribute_key }}" class="form-control"
                                                            placeholder="Attribute Key">
                                                    </div>
                                                </div>
                                                <div class="col-md-6 col-sm-12">
                                                    <div class="form-group">
                                                        <label class="form-label">Attribute Value</label>
                                                        <input type="text"
                                                            name="specifications[{{ $index }}][value]"
                                                            value="{{ $spec->attribute_value }}" class="form-control"
                                                            placeholder="Attribute Value">
                                                    </div>
                                                </div>
                                                <div class="col-md-1">
                                                    <button type="button" class="btn btn-danger remove-btn"
                                                        style="margin-top: 30px;">Remove</button>
                                                </div>
                                            </div>
                                            @php $index++; @endphp
                                        @endforeach
                                    @endif
                                </div> --}}
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
    <script src="{{ asset('admin/assets/plugins/select2/js/select2.min.js') }}"></script>
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

        // $(document).ready(function() {
        //     var index =
        //     {{ !empty($data['specifications']) ? count($data['specifications']) : 0 }}; // Start the index from the existing product attributes count

        //     // Function to add new fields dynamically
        //     $('#add-more').click(function() {
        //         var newField = `
    //     <div class="row field-group">
    //         <div class="col-md-5 col-sm-12">
    //             <div class="form-group">
    //                 <label class="form-label">Attribute Key</label>
    //                 <input type="hidden" name="specifications[` + index + `][id]" class="form-control" value="0">
    //                 <input type="text" name="specifications[` + index + `][key]" class="form-control" placeholder="Attribute Key">
    //             </div>
    //         </div>
    //         <div class="col-md-6 col-sm-12">
    //             <div class="form-group">
    //                 <label class="form-label">Attribute Value</label>
    //                 <input type="text" name="specifications[` + index + `][value]" class="form-control" placeholder="Attribute Value">
    //             </div>
    //         </div>
    //         <div class="col-md-1">
    //             <button type="button" class="btn btn-danger remove-btn" style="margin-top: 30px;">Remove</button>
    //         </div>
    //     </div>`;

        //         $('#dynamic-fields').append(newField); // Append new fields
        //         index++; // Increment the index for the next set of fields
        //     });

        //     // Function to remove fields dynamically
        //     $(document).on('click', '.remove-btn', function() {
        //         $(this).closest('.field-group').remove();
        //     });
        // });
    </script>
    <!--end row-->
</x-admin.layout>
