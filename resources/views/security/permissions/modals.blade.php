<!-- Modal Edit -->
<div class="modal fade" id="modalEdit{{ $permission->id }}" tabindex="-1" permission="dialog" aria-labelledby="modalEdit{{ $permission->id }}Label" aria-hidden="true">
    <div class="modal-dialog" permission="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Update Permission</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('permissions.update', $permission) }}" method="POST" class="form">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="form-group">
                        <label for="name" class="col-form-label">Name:</label>
                        <input type="text" value="{{ $permission->name }}" class="form-control" name="name" id="name" aria-describedby="name-error" aria-invalid="true">
                    </div>
                </div>
                <div class="modal-footer">
                    @can('Edit Permissions')
                    <button type="reset" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Update</button>
                    @endcan
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Delete -->
<div class="modal fade" id="modalDelete{{ $permission->id }}" tabindex="-1" aria-labelledby="modalDelete{{ $permission->id }}Label" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title fs-5" id="modalDelete{{ $permission->id }}Label">Delete Permission</h1>
            </div>
            <div class="modal-body">
                Are you sure to delete the permission {{ $permission->name }}?
            </div>
            <div class="modal-footer">
                @can('Delete Permissions')
                <form action="{{ route('permissions.destroy', $permission ) }}" method="POST" class="d-inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Delete</button>
                </form>
                @endcan
            </div>
        </div>
    </div>
</div>