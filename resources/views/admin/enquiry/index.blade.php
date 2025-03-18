ia<x-admin.layout type="enquiry">
    <!--start page wrapper -->
    <div class="page-wrapper">
        <div class="page-content">
            <!--breadcrumb-->
            <div
                class="page-breadcrumb d-none d-sm-flex align-items-center mb-3"
            >
                <div class="breadcrumb-title pe-3">Enquiries</div>
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
                               Enquiries
                            </li>
                        </ol>
                    </nav>
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
                                    <th>Full Name</th>
                                    <th>Phone</th>
                                    <th>Email</th>
                                    <th>City</th>
                                    <th>State</th>
                                    <th>Message</th>
                                    <th>Created Date</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($data['enquiries'] as $key => $enquiry)
                                    <tr>
                                        <td>{{$key+1}}</td>
                                        <td>{{$enquiry->name}}</td>
                                        <td>{{$enquiry->phone}}</td>
                                        <td>{{$enquiry->email}}</td>
                                        <td>{{$enquiry->city}}</td>
                                        <td>{{$enquiry->state}}</td>
                                        <td>{!!$enquiry->message!!}</td>
                                        <td>{{$enquiry->created_at}}</td>
                                        <td>
                                            <a  data-bs-toggle="modal" data-bs-target="#deleteModal{{ $enquiry->id }}" href="#">
                                                <i class="text-primary" data-feather="trash-2"></i>
                                            </a>
                                            <x-admin.modal type="enquiry" id="{{ $enquiry->id }}" />
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
