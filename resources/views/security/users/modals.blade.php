<!-- Modal Edit -->
<div class="modal fade" id="modalEdit{{ $user->id }}" tabindex="-1" role="dialog" aria-labelledby="modalEdit{{ $user->id }}Label" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Update User</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('users.update', $user) }}" method="POST" class="form">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="form-group">
                        <label for="role" class="col-form-label">Role:</label>
                        <select class="form-control" name="role" id="role" aria-describedby="role-error" aria-invalid="true">
                            <option value="Admin" {{ $user->role == 'Admin' ? 'selected' : '' }}>Admin</option>
                            <option value="Manager" {{ $user->role == 'Manager' ? 'selected' : '' }}>Manager</option>
                            <option value="Sales" {{ $user->role == 'Sales' ? 'selected' : '' }}>Sales</option>
                            <option value="Guest" {{ $user->role == 'Guest' ? 'selected' : '' }}>Guest</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="name" class="col-form-label">Name:</label>
                        <input type="text" value="{{ $user->name }}" class="form-control" name="name" id="name" aria-describedby="name-error" aria-invalid="true">
                    </div>
                    <div class="form-group">
                        <label for="email" class="col-form-label">Email</label>
                        <input type="email" value="{{ $user->email }}" name="email" id="email" class="form-control" aria-describedby="email-error" aria-invalid="true">
                    </div>
                    <div class="form-group">
                        <label for="password" class="col-form-label">Password:</label>
                        <input type="password" name="password" id="password" class="form-control" aria-describedby="password-error" aria-invalid="true">
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
<div class="modal fade" id="modalDelete{{ $user->id }}" tabindex="-1" aria-labelledby="modalDelete{{ $user->id }}Label" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title fs-5" id="modalDelete{{ $user->id }}Label">Delete User</h1>
            </div>
            <div class="modal-body">
                Are you sure to delete the user {{ $user->name }}?
            </div>
            <div class="modal-footer">
                <form action="{{ route('users.destroy', $user ) }}" method="POST" class="d-inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Delete</button>
                </form>
            </div>
        </div>
    </div>
</div>