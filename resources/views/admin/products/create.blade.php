@extends('admin.sidebar')

@section('main')
<h2 class="mb-4">New Product</h2>

<div class="row">
    <div class="col-lg-12">
        <div class="card mb-4">
            <div class="card-header">
                New Product Form
            </div>

            @error('thumbnail')
            <span class="alert alert-danger" role="alert">
                <strong>{{ $message }}</strong>
            </span>
            @enderror

            <div class="card-body">
                <form action="/products" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <label for="name" class="text-dark">Product Name<sup>*</sup></label>
                        <input type="text" id="name" name="name" autocomplete="off"
                            class="form-control @error('name') is-invalid @enderror" value="{{old('name')}}" required>

                        @error('name')
                        <div class="invalid-feedback">
                            {{$message}}
                        </div>
                        @enderror

                    </div>

                    <div class="form-group">
                        <label for="productDesc">Product Description</label>
                        <textarea class="form-control @error('desc')is-invalid @enderror" id="productDesc" rows="3"
                            name="desc"></textarea>
                        @error('desc')
                        <div class="invalid-feedback">
                            {{$message}}
                        </div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="categorySelect" class="text-dark">Category</label>

                        <select class="form-control @error('category_id')is-invalid @enderror" id="categorySelect"
                            name="category_id" required>
                            <option value="">--Select Category--</option>

                            @foreach ($categories as $category)
                            <option value="{{$category->id}}" {{old('category') == $category->id ? 'selected' : ''
                                }}>
                                {{$category->name}}
                            </option>
                            @endforeach

                        </select>

                        @error('category_id')
                        <div class="invalid-feedback">
                            {{$message}}
                        </div>
                        @enderror

                    </div>

                    <div class="form-group">
                        <label for="image">Product Thumbnail</label>
                        <input type="file" class="form-control-file" id="image" name="thumbnail">
                        <small id="imageHelpBlock" class="form-text text-muted">
                            <sup>*</sup> The image must not be larger than 2MB.
                        </small>
                        @error('thumbnail')
                        <span class="invalid-feedback">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>

                    <div class="form-group" class="text-dark">
                        <label for="price">Price</label>
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text">Rp</span>
                            </div>
                            <input type="text" id="price" class="form-control @error('price') is-invalid @enderror"
                                name="price" value="{{old('price')}}" required>
                            <div class="input-group-append">
                                <span class="input-group-text">.-</span>
                            </div>
                            @error('price')
                            <div class="invalid-feedback">
                                {{$message}}
                            </div>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="stock" class="text-dark">Stock<sup>*</sup></label>
                        <input type="text" id="stock" name="stock" autocomplete="off"
                            class="form-control @error('stock') is-invalid @enderror" value="{{old('stock')}}" required>
                        @error('stock')
                        <div class="invalid-feedback">
                            {{$message}}
                        </div>
                        @enderror
                    </div>

                    <a href="/products" class="btn btn-outline-primary float-right">Cancel</a>
                    <button class="btn btn-primary float-right mr-2" type="submit">Submit</button>

                </form>
            </div>
        </div>
    </div>
</div>

@endsection