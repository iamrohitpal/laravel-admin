@if(Session::has('errors'))
<div class="alert alert-danger border-0 bg-danger alert-dismissible fade show py-0 m-2">
    <div class="d-flex align-items-center">
        <div class="font-35 text-white"><i class="bx bxs-message-square-x"></i>
        </div>
        <div class="ms-3">
            <h6 class="mb-0 text-white">Danger Alerts</h6>
            <div class="text-white">{{ Session::get('errors') }}</div>
        </div>
    </div>
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endif