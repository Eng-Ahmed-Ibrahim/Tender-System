@extends('customers.index')

@section('cssfield')
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
@endsection

@section('content')
<div class="container">
    <div id="sidebar-menu" class="row">
        <h3>All Categories</h3>
        @foreach($categories as $category)
            <div class="category-item col-md-8 mb-3">
                <!-- Main Category Title -->
                <button class="category-btn w-100 btn btn-primary" style="background-color: rgb(54, 112, 112);" data-bs-toggle="collapse" data-bs-target="#subcategory-{{ $category['type'] }}-{{ $category['id'] }}">
                    {{ $category['title'] }}
                </button>

                <!-- Subcategories (Initially Collapsed) -->
                @if($category['children']->isNotEmpty())
                    <div class="subcategory-list collapse mt-2" id="subcategory-{{ $category['type'] }}-{{ $category['id'] }}">
                        @foreach($category['children'] as $subcategory)
                            <!-- Adjusted Link with category type and cat_id -->
                            @if($category['type'] === 'category1')
                                <a href="{{ route('commercial.customer.createAds', ['cat_id' => $subcategory->id, 'type' => $category['type']]) }}" class="btn btn-secondary w-100 mb-1 text-start">
                                    {{ $subcategory->title }}
                                </a>
                            @elseif($category['type'] === 'category2')
                                <a href="{{ route('commercial.customer.createAds', ['cat_id' => $subcategory->id, 'type' => $category['type']]) }}" class="btn btn-secondary w-100 mb-1 text-start">
                                    {{ $subcategory->title }}
                                </a>
                            @elseif($category['type'] === 'category3')
                                <a href="{{ route('commercial.customer.createAds', ['cat_id' => $subcategory->id, 'type' => $category['type']]) }}" class="btn btn-secondary w-100 mb-1 text-start">
                                    {{ $subcategory->title }}
                                </a>
                            @elseif($category['type'] === 'category4')
                                <a href="{{ route('commercial.customer.createAds', ['cat_id' => $subcategory->id, 'type' => $category['type']]) }}" class="btn btn-secondary w-100 mb-1 text-start">
                                    {{ $subcategory->title }}
                                </a>
                            @elseif($category['type'] === 'category5')
                                <a href="{{ route('commercial.customer.createAds', ['cat_id' => $subcategory->id, 'type' => $category['type']]) }}" class="btn btn-secondary w-100 mb-1 text-start">
                                    {{ $subcategory->title }}
                                </a>
                            @endif
                        @endforeach
                    </div>
                @endif
            </div>
        @endforeach
    </div>
</div>

@section('jsfield')
<script>
    document.querySelectorAll('.category-btn').forEach(function(categoryElement) {
        categoryElement.addEventListener('click', function() {
            let subcategoryList = document.querySelector(this.getAttribute('data-bs-target'));
            if (subcategoryList) {
                subcategoryList.classList.toggle('show'); // Use 'show' class for Bootstrap collapse
            }
        });
    });
</script>
@endsection
@endsection
