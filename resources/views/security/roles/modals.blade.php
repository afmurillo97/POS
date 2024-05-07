<!-- Modal Edit -->
<div class="modal fade" id="modalEdit{{ $role->id }}" tabindex="-1" role="dialog" aria-labelledby="modalEdit{{ $role->id }}Label" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Update Role</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('roles.update', $role) }}" method="POST" class="form">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="form-group">
                        <label for="name" class="col-form-label">Name:</label>
                        <input type="text" value="{{ $role->name }}" class="form-control" name="name" id="name" aria-describedby="name-error" aria-invalid="true">
                    </div>
                    <div class="form-group">
                        <h5>Permissions List:</h5>
                        {!! Form::model($role, [ 'route' => ['roles.update', $role], 'method' => 'put']) !!}
                            @foreach($permissions as $permission)
                                <div>
                                    <label>
                                        {!! Form::checkbox('permissions[]', $permission->id, $role->hasPermissionTo($permission->id) ? : false, ['class' => 'mr-1']) !!}
                                        {{ $permission->name }}
                                    </label>
                                </div>
                            @endforeach
                            {!! Form::submit('Asign Permissions', [ 'class' => 'btn btn-primary' ]) !!}
                        {!! Form::close() !!}
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="reset" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Update</button>
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
                <form action="{{ route('roles.destroy', $role ) }}" method="POST" class="d-inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Delete</button>
                </form>
            </div>
        </div>
    </div>
</div>