<x-admin.layout type="user">

        <div class="page-content">
            <!--breadcrumb-->
            <div
                class="page-breadcrumb d-none d-sm-flex align-items-center mb-3"
            >
                <div class="breadcrumb-title pe-3">User</div>
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
                               User
                            </li>
                        </ol>
                    </nav>
                </div>
                <div class="ms-auto">
                    <div class="btn-group">
                        <a href="{{route('user_form',['type' => 'create', 'id' => '0'])}}">
                            <button type="button" class="btn btn-primary">
                                Add User
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
                                    <th>User Name</th>
                                    <th>Role</th>
                                    <th>User Email</th>
                                    <th>Image</th>
                                    <th>Description</th>
                                    <th>Created Date</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($data['users'] as $key => $user)
                                    <tr>
                                        <td>{{$key+1}}</td>
                                        <td>{{$user->name}}</td>
                                        <td>{{$user->role->name}}</td>
                                        <td>{{$user->email}}</td>
                                        <td>
                                            <img src="{{asset('upload_image/user/'.$user->image)}}" class="rounded-circle p-1 border" width="45" height="45" alt="...">
                                        </td>
                                        <td>{!!$user->description!!}</td>
                                        <td>{{$user->created_at}}</td>
                                        <td>
                                            <a href="{{route('user_form',['type'=>'edit','id'=>$user->id])}}">
                                                <i class="text-primary" data-feather="edit"></i>
                                            </a>
                                            <a  data-bs-toggle="modal" data-bs-target="#deleteModal{{ $user->id }}" href="#">
                                                <i class="text-primary" data-feather="trash-2"></i>
                                            </a>
                                            <x-admin.modal type="user" id="{{ $user->id }}" />
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

</x-admin.layout>
