@extends('admin.sidebar')

@section('main')
<h2 class="mb-4">Categories</h2>

<div class="col-xl-3 col-md-6 mb-4">
    <div class="card border-left-primary shadow h-100 py-2">
        <div class="card-body">
            <div class="row no-gutters align-items-center">
                <div class="col mr-2">
                    <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Categories (Total)</div>
                    <div class="h5 mb-0 font-weight-bold text-gray-800">{{count($categories)}}</div>
                </div>
                <div class="col-auto">
                    <i class="fas fa-list-ul fa-2x text-gray-300"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="card">

    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
        <h6 class="m-0 font-weight-bold text-primary">
            Category Table
        </h6>
        <a href="/categories/create" class="btn btn-primary btn-icon-split btn-sm">
            <span class="icon text-white-50">
                <i class="fas fa-fw fa-plus"></i>
            </span>
            <span class="text">Add A New Category</span>
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
                        <th>Name</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($categories as $category)
                    <tr>
                        <td>{{$category->name}}</td>
                        <td>
                            <a class="btn btn-dark" href="/categories/{{$category->id}}/edit" role="button">Update</a>
                            <button type="button" class="btn btn-outline-dark" data-toggle="modal"
                                data-target="#deleteModal">
                                Delete
                            </button>
                        </td>
                    </tr>

                    <!-- Modal -->
                    <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog"
                        aria-labelledby="deleteModalLabel" aria-hidden="true">
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
                                    <form action="/categories/{{$category->id}}" method="post" class="d-inline">
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