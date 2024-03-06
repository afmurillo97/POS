<!-- Modal Edit -->
<div class="modal fade" id="modalEdit{{ $category->id }}" tabindex="-1" role="dialog" aria-labelledby="modalEdit{{ $category->id }}Label" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Update Category</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('categories.update', $category->id) }}" method="POST" class="form">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="form-group">
                        <label for="category" class="col-form-label">Name:</label>
                        <input type="text" value="{{ $category->category }}" class="form-control" name="category" id="category" aria-describedby="category-error" aria-invalid="true">
                    </div>
                    <div class="form-group">
                        <label for="description" class="col-form-label">Description:</label>
                        <textarea class="form-control" name="description" id="description">{{ $category->description }}</textarea>
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
<div class="modal fade" id="modalDelete{{ $category->id }}" tabindex="-1" aria-labelledby="modalDelete{{ $category->id }}Label" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title fs-5" id="modalDelete{{ $category->id }}Label">Delete Category</h1>
            </div>
            <div class="modal-body">
                Are you sure to delete the category {{ $category->category }}?
            </div>
            <div class="modal-footer">
                <form action="{{ route('categories.destroy', $category->id ) }}" method="POST" class="d-inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Delete</button>
                </form>
            </div>
        </div>
    </div>
</div>