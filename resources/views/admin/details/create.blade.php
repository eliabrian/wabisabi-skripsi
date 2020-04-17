@extends('admin.sidebar')


@section('main')
<h2 class="mb-4">New Product</h2>

<div class="row">
    <div class="col-lg-12">
        <div class="card mb-4">
            <div class="card-header">
                Product Detail Form
            </div>

            @error('path')
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{$message}}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            @enderror

            <div class="card-body">
                <form action="/details" method="POST" enctype="multipart/form-data">
                    @csrf


                    <div class="form-group">
                        <label for="productSelect" class="text-dark">Product</label>

                        <select class="form-control @error('product_id')is-invalid @enderror" id="productSelect"
                            name="product_id" required>
                            <option value="">--Select Product--</option>

                            @foreach ($products as $product)
                            <option value="{{$product->id}}" {{old('product_id') == $product->id ? 'selected' : ''
                                }}>
                                {{$product->name}}
                            </option>
                            @endforeach

                        </select>

                        @error('product_id')
                        <div class="invalid-feedback">
                            {{$message}}
                        </div>
                        @enderror

                    </div>

                    <div class="form-group">
                        <label for="image">Product Picture</label>
                        <input type="file" class="form-control-file" id="image" name="path">
                        <small id="imageHelpBlock" class="form-text text-muted">
                            <sup>*</sup> The image must not be larger than 2MB.
                        </small>
                        @error('path')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>



                    <a href="/details" class="btn btn-outline-primary float-right">Cancel</a>
                    <button class="btn btn-primary float-right mr-2" type="submit">Submit</button>

                </form>
            </div>
        </div>
    </div>
</div>

@endsection