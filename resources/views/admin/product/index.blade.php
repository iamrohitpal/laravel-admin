<x-admin.layout type="product">
    @php
        $create = App\Models\Permission::getPermissionBySlugAndId('Product', 'Create');
        $edit = App\Models\Permission::getPermissionBySlugAndId('Product', 'Edit');
        $delete = App\Models\Permission::getPermissionBySlugAndId('Product', 'Delete');
    @endphp
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
            <div class="ms-auto">
                @if ($create)
                    <div class="btn-group">
                        <a href="{{ route('product_form', ['type' => 'create', 'id' => '0']) }}">
                            <button type="button" class="btn btn-primary">
                                Add Product
                            </button>
                        </a>
                    </div>
                @endif
            </div>
        </div>
        <!--end breadcrumb-->
        <hr />
        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table id="example" class="table table-striped table-bordered" style="width: 100%">
                        <thead>
                            <tr>
                                <th>Id</th>
                                <th>Category Name</th>
                                <th>Product Name</th>
                                <th>Image</th>
                                <th>Description</th>
                                <th>Created Date</th>
                                @if ($edit || $delete)
                                <th>Action</th>
                                @endif
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($data['products'] as $key => $product)
                                <tr>
                                    <td>{{ $key + 1 }}</td>
                                    <td>{{ $product->categories }}</td>
                                    <td>{{ $product->name }}</td>
                                    <td>
                                        @foreach ($product->images as $image)
                                            <img src="{{ asset('upload_image/product/' . $image->name) }}"
                                                class="rounded-circle p-1 border" width="45" height="45"
                                                alt="...">
                                        @endforeach
                                    </td>
                                    <td>{!! $product->description !!}</td>
                                    <td>{{ $product->created_at }}</td>
                                    @if ($edit || $delete)
                                    <td>
                                        @if ($edit)
                                            <a href="{{ route('product_form', ['type' => 'edit', 'id' => $product->id]) }}">
                                                <i class="text-primary" data-feather="edit"></i>
                                            </a>
                                        @endif
                                        @if ($delete)
                                            <a data-bs-toggle="modal" data-bs-target="#deleteModal{{ $product->id }}"
                                                href="#">
                                                <i class="text-primary" data-feather="trash-2"></i>
                                            </a>
                                        @endif
                                        <x-admin.modal type="product" id="{{ $product->id }}" />
                                    </td>
                                    @endif
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

</x-admin.layout>
