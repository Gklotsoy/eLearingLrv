@extends('components.layout')

@section('title', 'Edit Course Category')
    
@section('css')
    @vite('resources/css/course-category-edit.css')
@endsection

@section('content')
<div class="content">
    <div class="course-category">
        <div class="course-category-header">
            <h3>Edit Course Category</h3>
            <div class="cateogory-image">
                <img src="/storage/category_images/{{$category->image}}" class="img-thumbnail" alt="Programming">
            </div>
        </div>
        <div class="course-category-body">
            <form action="/course-category/update/{{$category->id}}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="form-group">
                    <label for="category">Category Name</label>
                    <input type="text" name="category_name" class="form-control" id="category-name" value="{{$category->category_name}}" required>
                    <label for="category_description">{{$category->category_name}}</label>
                    <textarea name="category_description" class="form-control" id="category-description" rows="5" required>{{$category->description}}</textarea>
                    <label for="category_image">Category Image</label>
                    <div class="input-group mb-3">
                        <div class="input-group-text">
                          <input class="form-check-input mt-0" type="checkbox" value="" aria-label="Checkbox for following text input" id="image-checker">
                        </div>
                        <input type="file" class="form-control" aria-label="Text input with checkbox" name="category_image" id="category-image" disabled>
                    </div>
                    <p>* If you want to change the category please check the box.</p>
                    <button type="submit" id="update-category-btn" class="btn btn-primary">Update</button>
                </div>
            </form>

    </div>
</div>
@endsection

@push('scripts')
    @vite('resources/js/course-category-edit.js')
    
@endpush