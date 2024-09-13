@extends('components.layout')

@section('title', $category->category_name . ' • Courses')

@section('css')
    @vite('resources/css/category-courses.css')
@endsection

@section('content')
<div class="content">
    <div class="category">
        <h1>{{$category->category_name}}</h1>
    </div>

    <div class="courses">
        @foreach ($courses as $course)
        <div class="card">
            <div class="course">
                <div class="course-image">
                    <img src="/storage/course_images/{{$course->image}}" class="img-thumbnail" alt="{{$course->title}}">
                </div>
                <div class="course-description">
                    <div class="course-title">
                        <h3>{{$course->title}}</h3>
                    </div>
                    <div>
                        <h5>
                            Author: 
                            @foreach ($course->instructors as $instructor)
                            {{$instructor->first_name}} {{$instructor->last_name}}
                            @endforeach

                        </h5>
                        <a href="{{route('course', $course->id)}}" class="btn btn-primary">View Course</a>
                    </div>
                </div>
            </div>
        </div>
        
        @endforeach
    </div>
</div>
@endsection

