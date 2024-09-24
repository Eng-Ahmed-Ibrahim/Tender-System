@extends('admin.index')



@section('content')
<div class="container">
    <section id="sidebar-menu" class="row">
        <h3>All Categories</h3>

        @foreach($categories as $category)
            <article class="category-item col-md-6 mb-4">
                <a href="{{ route('normalads.create',['cat_id' => $category->id]) }}"class="category-btn w-100 btn d-flex align-items-center justify-content-start p-3" 
                   style="background-color: rgb(166, 202, 235);">

                    <img src="{{ asset('storage/' . $category->photo) }}" 
                         alt="{{ $category['title'] }} image" 
                         class="img-fluid me-3" 
                         style="width: 80px; height: 80px; object-fit: cover;" 
                        >
                   
                    <!-- Category Title -->
                    <span>{{ $category['title'] }}</span>
                </a>
            </article>
        @endforeach
    </section>
</div>



@endsection
