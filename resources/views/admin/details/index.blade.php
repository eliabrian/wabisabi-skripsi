@extends('admin.sidebar')

@section('main')
<h2 class="mb-4">Product Detail</h2>


<div class="card">

    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
        <h6 class="m-0 font-weight-bold text-primary">
            Detail Table
        </h6>
        <a href="/details/create" class="btn btn-primary btn-icon-split btn-sm">
            <span class="icon text-white-50">
                <i class="fas fa-fw fa-upload"></i>
            </span>
            <span class="text">Add Image to A Product</span>
        </a>
    </div>

    @if(session('status'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{session('status')}}
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    @endif

    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>Product</th>
                        <th>Image</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($details as $detail)
                    <tr>
                        <td>{{$detail->product->name}}</td>

                        <td>
                            <button type="button" class="btn btn-primary" data-toggle="modal"
                                data-target="#detailImage{{$loop->iteration}}">
                                Click here for Image
                            </button>

                            <!-- Modal -->
                            <div class="modal fade" id="detailImage{{$loop->iteration}}" tabindex="-1" role="dialog"
                                aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLongTitle">
                                                {{$detail->product->name}}</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <img src="/storage/{{$detail->path}}" alt="" srcset="" width="100%">
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary"
                                                data-dismiss="modal">Close</button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </td>

                        <td>

                            <a class="btn btn-dark" href="/details/{{$detail->id}}/edit" role="button">Update</a>

                            <!-- Button trigger modal -->
                            <button type="button" class="btn btn-outline-dark" data-toggle="modal"
                                data-target="#deleteModal{{$loop->iteration}}">
                                Delete
                            </button>

                        </td>
                    </tr>


                    <!-- Modal -->
                    <div class="modal fade" id="deleteModal{{$loop->iteration}}" tabindex="-1" role="dialog"
                        aria-labelledby="deleteModalLabel{{$loop->iteration}}" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="deleteModalLabel">Are you sure you want to delete this?
                                    </h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    Select "Delete" below if you want to delete this data.
                                </div>
                                <div class="modal-footer">
                                    <form action="/details/{{$detail->id}}" method="post" class="d-inline">
                                        @method('delete')
                                        @csrf
                                        <button tyle="submit" class="btn btn-light"> Delete</button>
                                    </form>
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                                </div>
                            </div>
                        </div>
                    </div>

                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

</div>


@endsection