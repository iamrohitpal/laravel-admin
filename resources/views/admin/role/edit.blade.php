<x-admin.layout type="role">
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
    <div class="page-wrapper">
        <div class="page-content">
            <!--breadcrumb-->
            <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
                <div class="breadcrumb-title pe-3">Role</div>
                <div class="ps-3">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-0 p-0">
                            <li class="breadcrumb-item">
                                <a href="{{ route('dashboard') }}"><i class="bx bx-home-alt"></i></a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">
                                Role
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
                            <form action="{{ route('save_role') }}" method="POST" class="row g-3"
                                enctype="multipart/form-data">
                                @csrf
                                <div class="col-12">
                                    <label for="inputFirstName" class="form-label">Role Name</label>
                                    <input type="text" name="name" class="form-control" required
                                        value="{{ $data['role']['name'] ?? old('name') ?? '' }}" placeholder="Role Name..."
                                        id="inputFirstName">
                                    <input type="hidden" name="id" value="{{ $data['role']['id'] ?? '0' }}">
                                </div>
                                <div class="col-12">
                                    <label for="inputAddress2" class="form-label">Description</label>
                                    <textarea name="description" class="form-control" id="mytextarea" placeholder="Description..." rows="5">{{ $data['role']['description'] ?? old('description') ?? '' }}</textarea>
                                </div>
                                <div class="col-12">
                                    <label class="form-label">Permission Type</label>
                                    <select name="permission_type" class="single-select form-control" required>
                                        @foreach ($data['type'] as $key => $role)
                                        @php
                                            $selected = !empty($data['role']['permission_type']) ? $data['role']['permission_type'] : '';
                                        @endphp
                                            <option value="{{ $key }}"
                                            {{($selected == $key) || ($selected == old('permission_type')) ? 'selected' : ''}}> {{ $role }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-12 role-permission">
                                    <label class="form-label">Role Permissions</label>
                                    <table style="width: 100%">
                                        @foreach ($data['permission'] as $permission)
                                            <tr style="border-bottom: 1px solid #ced4da;line-height: 40px;">
                                                <td>{{$permission['name']}}</td>
                                                @foreach ($permission['permission'] as $role)
                                                    <td><input id="permissions{{$role['id']}}" name="permissions[]" value="{{$role['id']}}" type="checkbox" {{ !empty($data['role']['permissions']) ? (in_array($role['id'], explode(',', $data['role']['permissions'])) ? 'checked' : '') : '' }}> <label for="permission_id{{$role['id']}}">{{$role['name']}}</label></td>
                                                @endforeach
                                            </tr>
                                        @endforeach
                                    </table>
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
    <script src="{{ asset('admin/assets/js/jquery.min.js') }}"></script>
    <script>
        $(document).ready(function () {
            let roleSelect = $(".single-select");
            let rolePermissionDiv = $(".role-permission");
            console.log(roleSelect.val());
            function togglePermissions() {
                if (roleSelect.val() === "custom") {
                    rolePermissionDiv.show();
                } else {
                    rolePermissionDiv.hide();
                }
            }

            togglePermissions();

            roleSelect.on("change", togglePermissions);
        });
    </script>
    <!--end row-->
</x-admin.layout>
