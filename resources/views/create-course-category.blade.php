@extends('components.layout')

@section('title', 'eLearning')

@section('css')
    @vite('resources/css/create-course-category.css')
@endsection

@section('content')
<div class="content">

    <div class="create-course-category">
        <h2>
            Create Course Category
        </h2>

        <div class="category-form">
            <form action="/create-course-category" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="text" name="category_name" id="category_name" placeholder="Enter Category Name" required>
                @error('category_name')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
                <textarea name="category_description" id="category_description" placeholder="Enter Category Description" required></textarea>
                <input type="file" name="category_image" id="category_image" required>
                <button class="btn btn-primary" id="create-category-btn">Create</button>
            </form>
        </div>

        <div class="current-categories">
            <h4>Current Categories</h4>
            <div class="current-categories-count">
                <h5>Number of Categories: {{$categoryCount}}</h5>
            </div>
        </div>
    </div>


</div>
@endsection
