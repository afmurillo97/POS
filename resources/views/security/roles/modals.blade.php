<!-- Modal Edit -->
<div class="modal fade" id="modalEdit{{ $role->id }}" tabindex="-1" role="dialog" aria-labelledby="modalEdit{{ $role->id }}Label" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Update Role and Permissions</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('roles.update', $role) }}" method="POST" class="form">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="form-group">
                        <label for="name" class="col-form-label">Role Name:</label>
                        <input type="text" value="{{ $role->name }}" class="form-control" name="name" id="name" aria-describedby="name-error" aria-invalid="true">
                    </div>
                    <div class="form-group">
                        <label for="permissions" class="col-form-label" title="Select All Permissions">
                            Permissions List:
                            <input type="checkbox" onchange="selAll(this)">
                        </label>
                        <div class="custom-table">
                            @foreach($permissions->chunk(5) as $chunk)
                                <div class="custom-row">
                                    @foreach($chunk as $permission)
                                        <div class="custom-cell">
                                            <div class="form-check">
                                                <input class="form-check-input permission-checkbox" type="checkbox" name="permissions[]" value="{{ $permission->id }}" {{ $role->hasPermissionTo($permission->id) ? 'checked' : '' }}>
                                                <label class="form-check-label">{{ $permission->name }}</label>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    @can('Edit Roles')
                    <button type="reset" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Update</button>
                    @endcan
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Delete -->
<div class="modal fade" id="modalDelete{{ $role->id }}" tabindex="-1" aria-labelledby="modalDelete{{ $role->id }}Label" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title fs-5" id="modalDelete{{ $role->id }}Label">Delete Role</h1>
            </div>
            <div class="modal-body">
                Are you sure to delete the role {{ $role->name }}?
            </div>
            <div class="modal-footer">
                @can('Delete Roles')
                <form action="{{ route('roles.destroy', $role ) }}" method="POST" class="d-inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Delete</button>
                </form>
                @endcan
            </div>
        </div>
    </div>
</div>