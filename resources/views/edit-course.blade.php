@extends('components.layout')

@section('title', 'Edit Course • eLearning')


@section('css')
    @vite('resources/css/edit-course.css')
@endsection

@section('content')
<div class="content">
    <ul class="nav nav-tabs" id="myTab" role="tablist">
        <li class="nav-item" role="presentation">
          <button class="nav-link active" id="course-tab" data-bs-toggle="tab" data-bs-target="#course-tab-pane" type="button" role="tab" aria-controls="course-tab-pane" aria-selected="true">Course Details</button>
        </li>
        <li class="nav-item" role="presentation">
          <button class="nav-link" id="lesson-tab" data-bs-toggle="tab" data-bs-target="#lesson-tab-pane" type="button" role="tab" aria-controls="lesson-tab-pane" aria-selected="false">Lessons</button>
        </li>
    </ul>

    <a href="{{ route('instructor-dashboard', ['user' => $user->id]) }}" class="btn btn-primary">Dashboard</a>

    <div class="tab-content" id="myTabContent">
        <div class="tab-pane fade show active" id="course-tab-pane" role="tabpanel" aria-labelledby="course-tab" tabindex="0">
            <div class="course-details">
                <div class="course-image">
                    <img src="/storage/course_images/{{$course->image}}" class="image-thumbnail" alt="course image">
                </div>
                <div class="course-info">

                    <form action="/instructor/courses/update-course/{{$course->id}}" method="POST" enctype="multipart/form-data" id="edit-course-form">
                        @csrf
                        @method('PUT')
                        <label for="file-image">Change the Course Image</label>                                
                        <div class="input-group mb-3">
                            <div class="input-group-text">
                              <input class="form-check-input mt-0" type="checkbox" id="image-checkbox" aria-label="Checkbox for following text input">
                            </div>
                            <input type="file" class="form-control" id="image-input" name="course_image" aria-label="Text input with checkbox" disabled>
                        </div>
                        @error('course_image')
                            <div class="alert alert-danger">{{ $message }}</div>            
                        @enderror
                        <div>
                            <label for="course-title">Course Title</label>
                            <button class="btn btn-primary" id="course-title-btn"><i class="fa-regular fa-pen-to-square"></i></button>
                            <textarea class="form-control course-data" id="course-title" name="course_title" rows="3" disabled required>{{$course->title}}</textarea>
                        </div>
                        @error('course_title')
                            <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                        <div>
                            <label for="course-description">Course Description</label>
                            <button class="btn btn-primary" id="course-description-btn"><i class="fa-regular fa-pen-to-square"></i></button>
                            <textarea class="form-control course-data" id="course-description" name="course_description" rows="3" disabled required>{{$course->description}}</textarea>
                        </div>
                        @error('course_description')
                            <div class="alert alert-danger">{{ $message }}</div>
                        @enderror

                        <button id="update-btn" class="btn btn-primary">Update Course</button>
                        
                    </form>
                </div>
            </div>
        </div>
        
        <div class="tab-pane fade" id="lesson-tab-pane" role="tabpanel" aria-labelledby="lesson-tab" tabindex="0">
            <div class="lessons-section">

                <button id="add-lesson-btn" class="btn btn-primary">Add Lesson</button>

                <div class="add-lesson" id="new-lesson-form" hidden>
                    <form action="/instructor/course/add-lesson" method="POST" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="course_id" value="{{$course->id}}">
                        <div>
                            <label for="lesson-title">Lesson Title</label>
                            <input type="text" class="form-control" id="lesson-title" name="lesson_title" required>
                        </div>
                        @error('lesson_title')
                            <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                        <div>
                            <label for="lesson-description">Lesson Description</label>
                            <textarea class="form-control" id="lesson-description" name="lesson_description" rows="3" required></textarea>
                        </div>
                        @error('lesson_description')
                            <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                        <div>
                            <label for="lesson-video">Lesson Video</label>
                            <input type="file" class="form-control" id="lesson-video" name="lesson_video" required>
                        </div>
                        @error('lesson_video')
                            <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                        <button id="save-lesson-btn" class="btn btn-primary">Save</button>
                        <button id="cancel-lesson-btn" class="btn btn-danger">Cancel</button>
                    </form>
                    <div class="cancel-lesson">
                        
                    </div>
                </div>

                <div class="added-lessons">
                    <h3>Lessons</h3>
                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">Lesson Title</th>
                                <th scope="col">Lesson Description</th>
                                <th scope="col">Lesson Video</th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if ($lessons->count() == 0)
                                <tr>
                                    <td colspan="4">No lessons added</td>
                                </tr>
                                
                            @else
                                    @foreach ($lessons as $lesson)
                                        <tr>
                                            <td>{{$lesson->name}}</td>
                                            <td>{{$lesson->description}}</td>
                                            <td><a href="/storage/lesson_videos/{{$lesson->video_url}}" target="_blank">View Video</a></td>
                                            <td>
                                                <form action="/edit/lesson/{{$lesson->id}}" method="GET">
                                                    @csrf
                                                    <button class="btn btn-primary edit-lesson-btn"  data-id="{{$lesson->id}}">Edit</button>
                                                </form>
                                                <form action="/instructor/course/delete-lesson/{{$lesson->id}}" method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button class="btn btn-danger delete-lesson-btn" data-id="{{$lesson->id}}">Delete</button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                            @endif
                            
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
        
    </div>
</div>
@endsection

@push('scripts')
    @vite('resources/js/edit-course.js')
@endpush