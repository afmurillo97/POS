<!-- Modal Edit -->
<div class="modal fade" id="modalEdit{{ $client->id }}" tabindex="-1" role="dialog" aria-labelledby="modalEdit{{ $client->id }}Label" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Update Client</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('clients.update', $client) }}" method="POST" class="form">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="form-group">
                        <label for="name" class="col-form-label">Name:</label>
                        <input type="text" value="{{ $client->name }}" class="form-control" name="name" id="name" aria-describedby="name-error" aria-invalid="true">
                    </div>
                    <div class="form-group">
                        <label for="client_type" class="col-form-label">Client Type:</label>
                        <input type="text" value="{{ $client->client_type }}" class="form-control" name="client_type" id="client_type" aria-describedby="-error" aria-invalid="true">
                    </div>
                    <div class="form-group">
                        <label for="id_type" class="col-form-label">ID Type</label>
                        <select class="form-control" name="id_type" id="id_type">
                            <option value="Citizenship Card" title="Citizenship Card" {{ $client->id_type == 'Citizenship Card' ? 'selected' : '' }}>Citizenship Card</option>
                            <option value="Foreigner ID" title="Foreigner ID" {{ $client->id_type == 'Foreigner ID' ? 'selected' : '' }}>Foreigner ID</option>
                            <option value="Identity card" title="Identity card" {{ $client->id_type == 'Identity card' ? 'selected' : '' }}>Identity card</option>
                            <option value="NIT" title="NIT" {{ $client->id_type == 'NIT' ? 'selected' : '' }}>NIT</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="id_number" class="col-form-label">ID Number:</label>
                        <input type="number" value="{{ $client->id_number }}" class="form-control" name="id_number" id="id_number" aria-describedby="-error" aria-invalid="true" disabled>
                    </div>
                    <div class="form-group">
                        <label for="address" class="col-form-label">Address:</label>
                        <input type="text" value="{{ $client->address }}" class="form-control" name="address" id="address" aria-describedby="-error" aria-invalid="true">
                    </div>
                    <div class="form-group">
                        <label for="phone" class="col-form-label">Phone:</label>
                        <input type="number" value="{{ $client->phone }}" class="form-control" name="phone" id="phone" aria-describedby="-error" aria-invalid="true">
                    </div>
                    <div class="form-group">
                        <label for="email" class="col-form-label">Email:</label>
                        <input type="text" value="{{ $client->email }}" class="form-control" name="email" id="email" aria-describedby="-error" aria-invalid="true">
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
<div class="modal fade" id="modalDelete{{ $client->id }}" tabindex="-1" aria-labelledby="modalDelete{{ $client->id }}Label" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title fs-5" id="modalDelete{{ $client->id }}Label">Delete Client</h1>
            </div>
            <div class="modal-body">
                Are you sure to delete the Client {{ $client->name }}?
            </div>
            <div class="modal-footer">
                <form action="{{ route('clients.destroy', $client ) }}" method="POST" class="d-inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Delete</button>
                </form>
            </div>
        </div>
    </div>
</div>