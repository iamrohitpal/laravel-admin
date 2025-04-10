<x-admin.layout type="subCategory">
    @php
        $create = App\Models\Permission::getPermissionBySlugAndId('Sub Category', 'Create');
        $edit = App\Models\Permission::getPermissionBySlugAndId('Sub Category', 'Edit');
        $delete = App\Models\Permission::getPermissionBySlugAndId('Sub Category', 'Delete');
    @endphp
        <div class="page-content">
            <!--breadcrumb-->
            <div
                class="page-breadcrumb d-none d-sm-flex align-items-center mb-3"
            >
                <div class="breadcrumb-title pe-3">Sub Category</div>
                <div class="ps-3">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-0 p-0">
                            <li class="breadcrumb-item">
                                <a href="{{route('dashboard')}}"
                                    ><i class="bx bx-home-alt"></i
                                ></a>
                            </li>
                            <li
                                class="breadcrumb-item active"
                                aria-current="page"
                            >
                               Sub Category
                            </li>
                        </ol>
                    </nav>
                </div>
                <div class="ms-auto">
                    @if ($create)
                    <div class="btn-group">
                        <a href="{{route('subcategory_form',['type' => 'create', 'id' => '0'])}}">
                            <button type="button" class="btn btn-primary">
                                Add Sub Category
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
                        <table
                            id="example"
                            class="table table-striped table-bordered"
                            style="width: 100%"
                        >
                            <thead>
                                <tr>
                                    <th>Id</th>
                                    <th>Category Name</th>
                                    <th>Sub Category Name</th>
                                    <th>Image</th>
                                    <th>Description</th>
                                    <th>Created Date</th>
                                    @if ($edit || $delete)
                                    <th>Action</th>
                                    @endif
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($data['subcategory'] as $key => $category)
                                    <tr>
                                        <td>{{$key+1}}</td>
                                        <td>{{$category->category}}</td>
                                        <td>{{$category->name}}</td>
                                        <td>
                                            <img src="{{asset('upload_image/category/'.$category->image)}}" class="rounded-circle p-1 border" width="45" height="45" alt="...">
                                        </td>
                                        <td>{!!$category->description!!}</td>
                                        <td>{{$category->created_at}}</td>
                                        @if ($edit || $delete)
                                        <td>
                                            @if ($edit)
                                            <a href="{{route('subcategory_form',['type'=>'edit','id'=>$category->id])}}">
                                                <i class="text-primary" data-feather="edit"></i>
                                            </a>
                                            @endif
                                            @if ($delete)
                                            <a  data-bs-toggle="modal" data-bs-target="#deleteModal{{ $category->id }}" href="#">
                                                <i class="text-primary" data-feather="trash-2"></i>
                                            </a>
                                            @endif
                                            <x-admin.modal type="category" id="{{ $category->id }}" />
                                        </td>
                                        @endif
                                    </tr>
                                @endforeach
                            </tbody>
                            {{-- <tfoot>
                                <tr>
                                    <th>Name</th>
                                    <th>Position</th>
                                    <th>Office</th>
                                    <th>Age</th>
                                    <th>Start date</th>
                                    <th>Salary</th>
                                </tr>
                            </tfoot> --}}
                        </table>
                    </div>
                </div>
            </div>
        </div>

</x-admin.layout>
