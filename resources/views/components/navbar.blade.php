<div>
    <nav class="nav justify-content-center nav__links my-4 py-2 border-top border-bottom border-dark">
        <a class="nav-link text-dark" href="{{ url('/') }}">Home</a>
        <div class="dropdown">
            <a class="nav-link dropdown-toggle text-dark" href="{{url('/')}}" role="button" id="dropdownKoleksi"
                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                Collections
            </a>

            <div class="dropdown-menu" aria-labelledby="dropdownKoleksi">
                @foreach ($categories as $category)
                <a class="dropdown-item" href="/collection/{{$category->name}}">{{$category->name}}</a>
                @endforeach
            </div>
        </div>
    </nav>
</div>