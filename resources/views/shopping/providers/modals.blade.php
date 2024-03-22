<!-- Modal Edit -->
<div class="modal fade" id="modalEdit{{ $provider->id }}" tabindex="-1" role="dialog" aria-labelledby="modalEdit{{ $provider->id }}Label" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Update Provider</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('providers.update', $provider) }}" method="POST" class="form">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="form-group">
                        <label for="name" class="col-form-label">Name:</label>
                        <input type="text" value="{{ $provider->name }}" class="form-control" name="name" id="name" aria-describedby="name-error" aria-invalid="true">
                    </div>
                    <div class="form-group">
                        <label for="id_type" class="col-form-label">ID Type</label>
                        <select class="form-control" name="id_type" id="id_type">
                            <option value="Citizenship Card" title="Citizenship Card" {{ $provider->id_type == 'Citizenship Card' ? 'selected' : '' }}>Citizenship Card</option>
                            <option value="Foreigner ID" title="Foreigner ID" {{ $provider->id_type == 'Foreigner ID' ? 'selected' : '' }}>Foreigner ID</option>
                            <option value="Identity card" title="Identity card" {{ $provider->id_type == 'Identity card' ? 'selected' : '' }}>Identity card</option>
                            <option value="NIT" title="NIT" {{ $provider->id_type == 'NIT' ? 'selected' : '' }}>NIT</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="id_number" class="col-form-label">ID Number:</label>
                        <input type="number" value="{{ $provider->id_number }}" class="form-control" name="id_number" id="id_number" aria-describedby="-error" aria-invalid="true" disabled>
                    </div>
                    <div class="form-group">
                        <label for="address" class="col-form-label">Address:</label>
                        <input type="text" value="{{ $provider->address }}" class="form-control" name="address" id="address" aria-describedby="-error" aria-invalid="true">
                    </div>
                    <div class="form-group">
                        <label for="phone" class="col-form-label">Phone:</label>
                        <input type="number" value="{{ $provider->phone }}" class="form-control" name="phone" id="phone" aria-describedby="-error" aria-invalid="true">
                    </div>
                    <div class="form-group">
                        <label for="email" class="col-form-label">Email:</label>
                        <input type="text" value="{{ $provider->email }}" class="form-control" name="email" id="email" aria-describedby="-error" aria-invalid="true">
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
<div class="modal fade" id="modalDelete{{ $provider->id }}" tabindex="-1" aria-labelledby="modalDelete{{ $provider->id }}Label" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title fs-5" id="modalDelete{{ $provider->id }}Label">Delete Provider</h1>
            </div>
            <div class="modal-body">
                Are you sure to delete the Provider {{ $provider->name }}?
            </div>
            <div class="modal-footer">
                <form action="{{ route('providers.destroy', $provider ) }}" method="POST" class="d-inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Delete</button>
                </form>
            </div>
        </div>
    </div>
</div>