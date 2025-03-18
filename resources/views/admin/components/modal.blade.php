<div class="col">
    <div class="modal fade" id="deleteModal{{$id}}" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Delete Confirmation</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">Are you sure you want to delete this item?</div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <a href="{{route('delete_data',['type' => $type,'id' => $id])}}"><button type="button"  class="btn btn-primary">Delete</button></a>
                </div>
            </div>
        </div>
    </div>
</div>