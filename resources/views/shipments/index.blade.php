@extends('layouts.app')

@section('content')

<h1 class="px-3 mb-5 text-center">Shipping Address</h1>


<div class="row w-100 m-0">
    <div class="col-md-7">
        <h5>Shipping Details</h5>
        <hr>
        <form action="/shipments" method="POST">
            @csrf
            <div class="form-group">
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text">First and last name</span>
                    </div>
                    <input type="text" name="first_name" aria-label="First name"
                        class="form-control @error('first_name') is-invalid @enderror">

                    <input type="text" name="last_name" aria-label="Last name"
                        class="form-control @error('last_name') is-invalid @enderror">

                </div>
                @error('first_name')
                <small class="text-danger">
                    {{$message}}
                </small>
                @enderror
                @error('last_name')
                <small class="text-danger">
                    {{$message}}
                </small>
                @enderror
            </div>

            <div class="form-group">
                <label for="city">City</label>
                <select class="form-control @error('city_id') is-invalid @enderror" id="city" name="city_id">
                    <option>--Select Your City--</option>
                    @foreach ($cities as $city)
                    <option value="{{$city->city_id}}">{{$city->city_name}}</option>
                    @endforeach
                </select>
                @error('city_id')
                <small class="text-danger">
                    {{$message}}
                </small>
                @enderror
            </div>

            <div class="form-group">
                <label for="address">Address</label>
                <input type="text" name="address" id="address"
                    class="form-control @error('address') is-invalid @enderror">
                @error('address')
                <small class="text-danger">
                    {{$message}}
                </small>
                @enderror
            </div>


            <div class="form-group">
                <label for="phone">Phone</label>
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text" id="basic-addon1">+62</span>
                    </div>
                    <input type="text" class="form-control @error('phone') is-invalid @enderror" placeholder="8123xxx"
                        aria-label="Phone" name="phone" aria-describedby="basic-addon1">
                </div>
                @error('phone')
                <small class="text-danger">
                    {{$message}}
                </small>
                @enderror
            </div>



            <div class="form-group">
                <label for="courier">Courier</label>
                <select class="form-control @error('courier_id') is-invalid @enderror" id="courier" name="courier_id">

                    <option>--Select Courier--</option>
                    @foreach ($couriers as $courier)

                    <option value="{{$courier->code}}">{{$courier->name}}</option>
                    @endforeach
                </select>
                @error('courier_id')
                <small class="text-danger">
                    {{$message}}
                </small>
                @enderror
            </div>
            <button type="submit" class="btn btn-dark btn-block" id="pay-button">Submit</button>

        </form>
    </div>
    <div class="col-md-5">
        <h5>Summary</h5>
        <hr>
        <table class="table table-hover">
            <thead class="thead-light">
                <tr>
                    <th scope="col"></th>
                    <th scope="col">Name</th>
                    <th scope="col">Quantity</th>
                    <th scope="col">Subtotal</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($items as $item)
                <tr>
                    <td>
                        <img src="/storage/{{$item->attributes->thumbnail}}" alt="..." class="img-thumbnail"
                            style="max-height:75px">
                    </td>
                    <td>
                        <p>{{$item->name}}</p>
                    </td>
                    <td>
                        <p>{{$item->quantity}}</p>
                    </td>
                    <td>
                        <p>{{number_format($item->quantity * $item->price, 2, ',', '.')}}</p>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <hr>
        <div class="card-body d-flex">
            <h5>Total:</h5>
            <h5 class="ml-auto">Rp. {{number_format(\Cart::getTotal(), 2, ',', '.')}}</h5>
        </div>
        <hr>
    </div>
</div>



@endsection