<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Lesson;
use App\Models\Progress;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LessonController extends Controller
{
    public function addLesson(Request $request)
    {

        $courseId = $request->input('course_id');
        $course = Course::find($courseId);

        $instructorId = $course->instructors()->pluck('instructor_id')->first();

        if (Auth::user()->id !== $instructorId && !Auth::user()->role == 'admin') {
            return redirect()->route('home')->with('error', 'You are not authorized to add a lesson to this course');
        }

        $request->validate([
            'lesson_title' => 'required',
            'lesson_description' => 'required',
            'lesson_video' => 'required|mimes:mp4|max:512000',
            'course_id' => 'required',
        ]);

        $lessonTitle = $request->input('lesson_title');
        $lessonDescription = $request->input('lesson_description');
        $lessonVideo = $request->file('lesson_video');
        $courseId = $request->input('course_id');

        // save the video file to the right directory

        $filename = "{$courseId}" . "-" . uniqid() . '.mp4';

        $lessonVideo->storeAs('public/lesson_videos', $filename);

        // Create the lesson in the database

        Lesson::create([
            'name' => $lessonTitle,
            'description' => $lessonDescription,
            'video_url' => $filename,
            'course_id' => $courseId,
        ]);

        return redirect()->back()->with('success', 'Lesson added successfully');
    }

    public function deleteLesson(Lesson $lesson)
    {
        $course = Course::find($lesson->course_id);

        $instructorId = $course->instructors()->pluck('instructor_id')->first();

        if (Auth::user()->id !== $instructorId && !Auth::user()->role == 'admin') {
            return redirect()->route('home')->with('error', 'You are not authorized to delete this lesson');
        }

        // delete the video file from the storage

        $videoPath = storage_path('app/public/lesson_videos/' . $lesson->video_url);


        if (file_exists($videoPath)){
            unlink($videoPath);
        }

        $lesson->delete();

        return redirect()->back()->with('success', 'Lesson deleted successfully');
    }

    public function updateCompletion(Request $request, $lessonId)
    {
        $request->validate([
            'completed' => 'required|boolean',
        ]);
    
        $userId = Auth::id();
        $progress = Progress::updateOrCreate(
            ['user_id' => $userId, 'lesson_id' => $lessonId],
            ['is_completed' => $request->input('completed')]
        );

        $is_completed = $progress->is_completed;

        return response()->json(['success' => true, 'is_completed' => $is_completed]);
    

    }
}
