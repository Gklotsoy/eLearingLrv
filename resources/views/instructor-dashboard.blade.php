@extends('components.layout')

@section('title', 'Instructor Dashboard • Admin Panel')

@section('css')
    @vite('resources/css/instructor-dashboard.css')
@endsection

@section('content')

@if (auth()->user()->role == 'admin')
<div class="admin-visit">
    <h3>
        You are visiting the Instructor Dashboard of {{$user->first_name}} {{$user->last_name}}
    </h3>
</div>    
@endif


<div class="content">
    <ul class="nav nav-tabs" id="myTab" role="tablist">
        <li class="nav-item" role="presentation">
          <button class="nav-link active" id="statistics-tab" data-bs-toggle="tab" data-bs-target="#statistics-tab-pane" type="button" role="tab" aria-controls="statistics-tab-pane" aria-selected="true">Statistics</button>
        </li>
        <li class="nav-item" role="presentation">
          <button class="nav-link" id="unpublished-tab" data-bs-toggle="tab" data-bs-target="#unpublished-tab-pane" type="button" role="tab" aria-controls="unpublished-tab-pane" aria-selected="false">Unpublished</button>
        </li>
        <li class="nav-item" role="presentation">
          <button class="nav-link" id="contact-tab" data-bs-toggle="tab" data-bs-target="#contact-tab-pane" type="button" role="tab" aria-controls="contact-tab-pane" aria-selected="false">Contact</button>
        </li>
    </ul>
    <div class="tab-content" id="myTabContent">
        <div class="tab-pane fade show active" id="statistics-tab-pane" role="tabpanel" aria-labelledby="statistics-tab" tabindex="0">
            <div class="courses-statistics">
                <div class="filtering" style="display: flex;">
                    <h2>Published Courses</h2>
                    <div class="filters">
                        <input type="text" id="filter-course-name" placeholder="Filter by Name">
                        <button id="course-filter-btn" class="btn btn-primary bi bi-filter">Filter</button>
                        <button id="course-clear-filter" class="btn btn-danger bi bi-x">Clear Filter</button>
                    </div>
                    <div>
                        <button class="btn btn-primary add-course-btn">Create Course</button>
                    </div>
                </div>
                <div class="table">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Course</th>
                                <th>Students</th>
                                <th>Lessons</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if ($publishedCourses->count() == 0)
                                <tr>
                                    <td colspan="4">No published courses</td>
                                </tr>
                            @endif
                            @foreach ($publishedCourses as $course)
                                
                            <tr>
                                <td>{{$course['course']->title}}</td>
                                <td>
                                    @if (is_null($course['enrollments']))
                                        <p>0</p>
                                    @else
                                        {{ $course['enrollments']->count() }}
                                    @endif
                                    
                                </td>
                                <td>{{ $course['lessons']->count() }}</td>
                                <td>
                                    <form action="/instructor/courses/edit/{{$course['course']->id}}" method="get">
                                        <button type="submit" class="btn btn-success">View</button>
                                    </form>
                                    <form action="/instructor/courses/edit/{{$course['course']->id}}" method="get">
                                        <button class="btn btn-primary">Edit</button>
                                    </form>
                                </td>

                            @endforeach
                        </tbody>
                    </table>
                </div>
                
            </div>
        </div>
        <div class="tab-pane fade" id="unpublished-tab-pane" role="tabpanel" aria-labelledby="unpublished-tab" tabindex="0">
            <div class="courses-statistics">
                <div class="filtering" style="display: flex;">
                    <h2>Unpublished Courses</h2>
                    <div class="filters">
                        <input type="text" id="filter-course-name" placeholder="Filter by Name">
                        <button id="course-filter-btn" class="btn btn-primary bi bi-filter">Filter</button>
                        <button id="course-clear-filter" class="btn btn-danger bi bi-x">Clear Filter</button>
                    </div>
                    <div>
                        <button class="btn btn-primary add-course-btn">Create Course</button>
                    </div>
                </div>
                <div class="table">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Course</th>
                                <th>Lessons</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>

                            @if ($unpublishedCourses->count() == 0)
                                <tr>
                                    <td colspan="3">No unpublished courses</td>
                                </tr>
                                
                            @endif
                            @foreach ($unpublishedCourses as $course)
                            <tr>
                                <td>{{$course['course']->title}}</td>
                                <td>{{ $course['lessons']->count() }}</td>
                                <td>
                                    <form action="/instructor/course/publish/{{$course['course']->id}}" method="post">
                                        @csrf
                                        @method('PUT')
                                        <button class="btn btn-success">Publish</button>
                                    </form>
                                    
                                    <form action="/instructor/courses/edit/{{$course['course']->id}}" method="get">
                                        <button class="btn btn-primary">Edit</button>
                                    </form>
                                </td>
                                
                            @endforeach
                        
                        </tbody>
                    </table>
                </div>
                
            </div>
        </div>
        <div class="tab-pane fade" id="contact-tab-pane" role="tabpanel" aria-labelledby="contact-tab" tabindex="0">...</div>
    </div>
</div>
@endsection

@push('scripts')
    @vite('resources/js/instructor-dashboard.js')
@endpush