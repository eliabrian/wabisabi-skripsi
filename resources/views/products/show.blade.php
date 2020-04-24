@extends('layouts.app')

@section('content')

<div class="container">

    <!-- Portfolio Item Heading -->
    <h1 class="my-4">{{$product->name}}
    </h1>

    <!-- Portfolio Item Row -->
    <div class="row">

        <div class="col-md-8">
            <img class="img-fluid" src="/storage/{{$product->thumbnail}}" alt="">
        </div>

        <div class="col-md-4">
            <form action="/carts/store" method="post">
                @if ($product->stock == 0)<fieldset disabled="disabled">@endif

                    @csrf
                    <h3 class="my-3">{{$product->name}}</h3>
                    <hr>
                    <p>{{$product->desc}}</p>
                    <hr>
                    <h4 class="my-3">Rp {{$product->price}},-</h4>
                    <input type="hidden" name="quantity" value="1">
                    <div class="form-group">
                        <label for="quantity">Quantity</label>

                        <select class="form-control" id="quantity" name="quantity">
                            @for ($i = 1; $i <= $product->stock; $i++)
                                <option value="{{$i}}">{{$i}}</option>
                                @endfor
                        </select>
                    </div>
                    <input type="hidden" name="id" value="{{$product->id}}">
                    <input type="hidden" name="thumbnail" value="{{$product->thumbnail}}">
                    <input type="hidden" name="name" value="{{$product->name}}">
                    <input type="hidden" name="price" value="{{$product->price}}">
                    <button type="submit" class="btn btn-outline-dark">Add To
                        Cart</button>

                    @if ($product->stock == 0)
                </fieldset>@endif
            </form>
        </div>

    </div>
    <!-- /.row -->

    <!-- Related Projects Row -->
    @if ($product->details->count() > 0)
    <h3 class="my-4">Related Picture</h3>
    @endif


    <div class="row">

        @foreach ($product->details as $detail)

        <div class="col-md-3 col-sm-6 mb-4">
            <a href="#">
                <img class="img-fluid" src="/storage/{{$detail->path}}" alt="">
            </a>
        </div>
        @endforeach



    </div>
    <!-- /.row -->

</div>
<!-- /.container -->

@endsection