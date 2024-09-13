@extends('components.layout')

@section('title', 'Course • eLearning')

@section('css')
    @vite('resources/css/course-view.css')
@endsection

@section('content')
<div class="content">

    <div class="course-header">
        <div class="course-image">
            <img src="/storage/course_images/{{$course->image}}" class="image-thumbnail" alt="{{$course->name}}">
        </div>
        <div class="course-details">
            <div>
                <h2>
                    {{$course->title}}
                </h2>
            </div>
            <div class="course-info">
                <div class="course-author">
                    <div class="author-image">
                        <img src="/storage/profile_images/{{$instructor->profile_image}}" class="image-thumbnail" alt="author image">
                    </div>
                    <h4>Author: <span>{{$instructor->first_name}} {{$instructor->last_name}}</span></h4>
                </div>
                <div class="category">
                    <h5>Category: 
                        <span>
                            @foreach ($course->categories as $category)
                            {{$category->category_name}}

                            @endforeach
                        </span>
                    </h5>
                </div>
            
                @if (Auth::user()->role == 'admin')
                    <div class="course-actions">
                        <a href="/admin-dashboard" class="btn btn-primary">Admin Dashboard</a>
                    </div>
                    
                @endif

                @if (!$isEnrolled && Auth::user()->role == 'student')
                    <form action="{{ route('enroll-course', $course->id) }}" method="post">
                        @csrf
                        <button type="submit" class="btn btn-primary">Enroll</button>
                    </form>
                @endif
                    
                @foreach ($enrollments as $enrollment)

                    @if($enrollment->user_id == Auth::user()->id)
                        <form action="{{route('course-learning', $course->id)}}" method="get">
                            <button type="submit" class="btn btn-primary">Go to Course</button>
                        </form>
                    @endif
                @endforeach
                
                
            </div>
        </div>
        
    </div>

    <hr>
    <div class="course-content">
        <div class="course-description">
            <h3>Description</h3>
            <p>
                {{$course->description}}
            </p>

        </div>

        <div class="lessons">
            <div class="lessons-data">
                <h3>Lessons</h3>
                <span>{{$lessons->count()}}</span>
            </div>

            @foreach ($lessons as $lesson)
            <div class="lesson card">
                <h3>Lesson {{$loop->iteration}}: {{$lesson->name}}</h3>
                <p>
                    {{$lesson->description}}
                </p>                
            @endforeach
            

        </div>

    </div>

</div>
@endsection

