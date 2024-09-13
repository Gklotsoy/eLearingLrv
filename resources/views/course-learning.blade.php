@extends('components.layout')

@section('title', 'Course • eLearning')

@section('css')
    @vite('resources/css/course-learning.css')
@endsection

@section('content')
<div class="content">

    <div class="course-title">
        <h2>{{$course->title}}</h2>
    </div>
    <div>
        <h3>Course Progress</h3>
        <p>You have completed {{ $completedLessonsCount }} out of {{ $lessons->count() }} lessons.</p>
    </div>
    <div class="video-section">
        <iframe width="720" height="460" id="video-iframe" src="/storage/lesson_videos/{{$lessons[0]->video_url}}" title="Video Player" name="video" 
        frameborder="0" allow="accelerometer; clipboard-write; encrypted-media; gyroscope; picture-in-picture" 
        allowfullscreen></iframe>
    </div>

    <div class="lessons-btn">
        <button class="btn btn-primary" type="button" data-bs-toggle="collapse" data-bs-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample">
            Lessons
        </button>
    </div>

    <div class="collapse" id="collapseExample">
        <div class="card card-body">
            <div class="lessons">

                @foreach ($lessons as $lesson)
                    <div class="lesson">
                        <div class="lesson-title">
                            
                            <h4>Lesson {{$loop->iteration}}</h4>
                            <h5>{{$lesson->name}}</h5>
                        </div>
                        <div class="start-btn">
                            <button name="play-video" class="btn btn-primary" data-video-url="{{$lesson->video_url}}"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-play-fill" viewBox="0 0 16 16">
                                <path d="m11.596 8.697-6.363 3.692c-.54.313-1.233-.066-1.233-.697V4.308c0-.63.692-1.01 1.233-.696l6.363 3.692a.802.802 0 0 1 0 1.393"/>
                            </svg></i>
                            </button>
                            <span>Check if completed <input type="checkbox" name="completionCheck" data-lesson-id="{{ $lesson->id }}" {{ $lesson->is_completed ? 'checked' : '' }}></span>
                        </div>
                    </div>
                @endforeach

            </div>
        </div>
    </div>

    <div class="notes-section">
        <h4>Notes</h4>
        @foreach ($lessons as $lesson)
            <div class="lesson-notes">
                <h5>Lesson {{$loop->iteration}}</h5>
                <p>{{$lesson->description}}</p>
            </div>
        @endforeach

    </div>
    
</div>
@endsection


@push('scripts')
    @vite('resources/js/course-learning.js')
@endpush