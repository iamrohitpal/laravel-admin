<x-admin.layout type="role">
    <!--start page wrapper -->
    <div class="page-wrapper">
        <div class="page-content">
            <!--breadcrumb-->
            <div
                class="page-breadcrumb d-none d-sm-flex align-items-center mb-3"
            >
                <div class="breadcrumb-title pe-3">Role</div>
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
                               Role
                            </li>
                        </ol>
                    </nav>
                </div>
                <div class="ms-auto">
                    <div class="btn-group">
                        <a href="{{route('role_form',['type' => 'create', 'id' => '0'])}}">
                            <button type="button" class="btn btn-primary">
                                Add Role
                            </button>
                        </a>
                    </div>
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
                                    <th>Name</th>
                                    <th>Description</th>
                                    <th>Permission Type</th>
                                    <th>Created Date</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($data['roles'] as $key => $role)
                                    <tr>
                                        <td>{{$key+1}}</td>
                                        <td>{{$role->name}}</td>
                                        <td>{!!$role->description!!}</td>
                                        <td>{{$role->permission_type}}</td>
                                        <td>{{$role->created_at}}</td>
                                        <td>
                                            <a href="{{route('role_form',['type'=>'edit','id'=>$role->id])}}">
                                                <i class="text-primary" data-feather="edit"></i>
                                            </a>
                                            <a  data-bs-toggle="modal" data-bs-target="#deleteModal{{ $role->id }}" href="#">
                                                <i class="text-primary" data-feather="trash-2"></i>
                                            </a>
                                            <x-admin.modal type="role" id="{{ $role->id }}" />
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--end page wrapper -->
</x-admin.layout>
