@extends('components.layout')

@section('title', 'Profile • eLearning')

@section('css')
    @vite('resources/css/user-profile.css')
@endsection

@section('content')
    <div class="content">
        <div class="user-greet row">
            <div class="user-info">
                <div class="user-img">
                    <img src="/storage/profile_images/{{$user->profile_image}}" class="img-thumbnail" alt="User">
                </div>
                <h2>
                @if (auth()->user()->id == $user->id)
                Welcome,     
                @endif
                    {{$user->first_name}}
                </h2>
                @if (auth()->user()->id == $user->id || auth()->user()->role == 'admin')
                
                <div class="user-actions">
                    <a href="/profile/edit/{{$user->id}}" class="btn btn-primary"><i class="fa-solid fa-gear"></i></a>

                    @if (auth()->user()->role == 'admin')
                        <a href="/admin-dashboard" class="btn btn-primary"><i class="fa-solid fa-toolbox"></i></a>
                    @endif

                    @if (auth()->user()->role == 'instructor' || (auth()->user()->role == 'admin' && $user->role == 'instructor'))
                        <a href="/instructor-dashboard/{{$user->id}}" class="btn btn-primary"><i class="fa-solid fa-book"></i></a>
                    @endif


                </div>
                @endif
                
            </div>
            <span><hr></span>
        </div>
        



        <div class="user-courses">
            @if (count($enrollments) != 0)
            <h3>Enrolled Courses</h3>
                
            @endif

            <div class="courses">

                @foreach ($enrollments as $enrollment)
                    <div class="course card">
                        <div class="course-img">
                            <img src="/storage/course_images/{{$enrollment['course']->image}}" class="img-thumbnail" alt="Course">
                        </div>
                        <div class="course-info">
                            <h4>{{$enrollment['course']->title}}</h4>
                            <a href="/course/{{$enrollment['course']->id}}" class="btn btn-primary">View Course</a>
                        </div>
                    </div>
                    
                @endforeach

            </div>

        </div>
    </div>
@endsection

