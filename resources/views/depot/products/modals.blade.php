<!-- Modal Edit -->
<div class="modal fade" id="modalEdit{{ $product->id }}" tabindex="-1" role="dialog" aria-labelledby="modalEdit{{ $product->id }}Label" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Update Product</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{route('products.update', $product)}}" method="POST" enctype="multipart/form-data" class="form">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="form-group">
                        <label for="product" class="col-form-label">Name:</label>
                        <input type="text" value="{{ $product->name }}" class="form-control" name="name" id="name" aria-describedby="product-error" aria-invalid="true" placeholder="Enter a product name">
                    </div>
                    <div class="form-group">
                        <label>Category</label>
                        <select class="form-control" name="category_id" id="category_id">
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}" title="{{ $category->description }}" {{ $product->category_id == $category->id ? 'selected' : '' }}>{{ $category->category }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="product" class="col-form-label">Code:</label>
                        <input type="text" value="{{ $product->code }}" class="form-control" name="code" id="code" aria-describedby="product-error" aria-invalid="true" placeholder="Enter the product code">
                    </div>
                    <div class="form-group">
                        <label for="product" class="col-form-label">Stock:</label>
                        <input type="number" value="{{ $product->stock }}" class="form-control" name="stock" id="stock" aria-describedby="product-error" aria-invalid="true" placeholder="Enter the quantity in stock">
                    </div>
                    <div class="form-group">
                        <label for="description" class="col-form-label">Description:</label>
                        <textarea class="form-control" name="description" id="description">{{ $product->description }}</textarea>
                    </div>
                    @if($product->image)
                    <div class="form-group">
                        <label for="currentImage">Image:</label>
                        <img src="{{ asset($product->image) }}" alt="{{ $product->name }}" class="img-thumbnail" id="currentImage" style="max-width: 200px;">
                    </div>
                    @endif
                    <div class="form-group">
                        <label for="image">Update Image:</label>
                        <div class="custom-file">
                            <input type="file" class="custom-file-input" name="image" id="image" accept="image/jpeg,image/png,image/bmp">
                            <label class="custom-file-label" for="image">Choose a new image for the product</label>
                        </div>
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
<div class="modal fade" id="modalDelete{{ $product->id }}" tabindex="-1" aria-labelledby="modalDelete{{ $product->id }}Label" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title fs-5" id="modalDelete{{ $product->id }}Label">Delete Product</h1>
            </div>
            <div class="modal-body">
                Are you sure to delete the product {{ $product->name }}?
            </div>
            <div class="modal-footer">
                <form action="{{ route('products.destroy', $product) }}" method="POST" class="d-inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Delete</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal Image -->
@if($product->image)
    <div class="modal fade" id="imageProductModal{{ $product->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-body">
                    <img id="modalImage" src="{{ asset($product->image) }}"  class="img-fluid">
                </div>
            </div>
        </div>
    </div>
@endif