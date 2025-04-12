<x-admin.layout type="seo">
    @php
        $create = App\Models\Permission::getPermissionBySlugAndId('Seo', 'Create');
        $edit = App\Models\Permission::getPermissionBySlugAndId('Seo', 'Edit');
        $delete = App\Models\Permission::getPermissionBySlugAndId('Seo', 'Delete');
    @endphp
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
            <div class="ms-auto">
                @if ($create)
                    <div class="btn-group">
                        <a href="{{ route('seo_form', ['type' => 'create', 'id' => '0']) }}">
                            <button type="button" class="btn btn-primary">
                                Add Seo
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
                                <th>Page Url</th>
                                <th>Title</th>
                                <th>Keywords</th>
                                <th>Description</th>
                                <th>Created Date</th>
                                @if ($edit || $delete)
                                <th>Action</th>
                                @endif
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($data['seo'] as $key => $seo)
                                <tr>
                                    <td>{{ $key + 1 }}</td>
                                    <td>{{ $seo->url }}</td>
                                    <td>{{ $seo->title }}</td>
                                    <td>{{ $seo->keywords }}</td>
                                    <td>{!! $seo->description !!}</td>
                                    <td>{{ $seo->created_at }}</td>
                                    @if ($edit || $delete)
                                    <td>
                                        @if ($edit)
                                            <a href="{{ route('seo_form', ['type' => 'edit', 'id' => $seo->id]) }}">
                                                <i class="text-primary" data-feather="edit"></i>
                                            </a>
                                        @endif
                                        @if ($delete)
                                            <a data-bs-toggle="modal" data-bs-target="#deleteModal{{ $seo->id }}"
                                                href="#">
                                                <i class="text-primary" data-feather="trash-2"></i>
                                            </a>
                                        @endif
                                        <x-admin.modal type="seo" id="{{ $seo->id }}" />
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
