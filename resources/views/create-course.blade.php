@extends('components.layout')

@section('title', 'Create Course • eLearning')

@section('css')
    @vite('resources/css/create-course.css')
@endsection

@section('content')
<div class="content">

    <div class="create-course">
        <h3>
            Create Course 
        </h3>

        <form action="/instructor/courses/save" method="POST" id="create-course-form" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label for="course-title">Course Title</label>
                <input type="text" name="course_title" id="course-title" class="form-control" required>
                @error('course_title')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
                <label for="course-description">Course Description</label>
                <textarea name="course_description" id="course-description" class="form-control" required></textarea>
                @error('course_description')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
                <label for="course-image">Course Image</label>
                <input type="file" name="course_image" id="course-image" class="form-control" required>
                @error('course_image')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
                <label for="course-category">Category</label>
                <select name="course_category" id="course-category" class="form-control" required>
                    <option value="">Choose a Category</option>
                    @foreach ($categories as $category) {
                        <option value="{{ $category->id }}">{{ $category->category_name }}</option>
                    }
                        
                    @endforeach
                </select>
                @error('course_category')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="course-actions">
                <button class="btn btn-primary" id="save-course-btn">Save Changes</button>
            </div>
        </form> 
    </div>

</div>
@endsection

@push('scripts')
    @vite('resources/js/create-course.js')
@endpush