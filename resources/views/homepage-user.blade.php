@extends('components.layout')

@section('title', 'eLearning')

@section('css')
    @vite('resources/css/homepage-user.css')
@endsection

@section('content')

    <div class="content">
        
        <h1>Course Categories</h1>

        <div class="categories">
            
            @foreach ($categories as $category)
                <div class="category">
                    <div class="category-img">
                        <a href="{{route('category-courses', $category->id)}}">
                            <img src="/storage/category_images/{{$category->image}}" class="img-thumbnail" alt="{{ $category->name }}">
                        </a>
                    </div>
                    <div class="category-description">
                        <a href="{{route('category-courses', $category->id)}}"><h3>{{ $category->category_name }}</h3></a>
                        <p>{{ $category->description }}</p>
                    </div>
                </div>
                
            @endforeach
        </div>
    </div>
            

@endsection