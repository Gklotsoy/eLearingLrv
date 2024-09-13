<?php

namespace App\Http\Controllers;

use App\Models\Course;
use Illuminate\Http\Request;
use App\Models\CourseCategories;
use Illuminate\Support\Facades\Auth;

class CourseController extends Controller
{
    public function showCreateCourse()
    {

        $categories = CourseCategories::all('id', 'category_name');

        return view('create-course', compact('categories'));
    }

    public function createCourse(Request $request)
    {

        $request->validate([
            'course_title' => 'required',
            'course_category' => 'required',
            'course_description' => 'required',
            'course_image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $courseTitle = $request->input('course_title');
        $courseCategoryId = $request->input('course_category');
        $courseDescription = $request->input('course_description');
        $courseImage = $request->file('course_image');

        if (!$courseImage->isValid()) {
            return back()->with('error', 'Invalid image');
        }

        $filename = "{$courseCategoryId}" . "-" . uniqid() . '.jpeg';

        $courseImage->storeAs('public/course_images', $filename);

        // Create the course in the database

        $course = Course::create([
            'title' => $courseTitle,
            'description' => $courseDescription,
            'image' => $filename,
        ]);

        // add the id of the course that was just created and the category id to the pivot table course_category

        $course->categories()->attach($courseCategoryId);

        // add the id of the course that was just created to the pivot table course_instructor table

        $instructorId = Auth::user()->id;
        $course->instructors()->attach($instructorId);

        // get the id of the course that was just created

        $courseId = $course->id;

        // redirect to the edit course page

        return redirect()->route('edit-course', ['course' => $courseId])->with('success', 'Course created successfully');

    }

    public function editCourse($id)
    {
        $course = Course::find($id);
        $categories = CourseCategories::all('id', 'category_name');

        $user = $course->instructors->first();

        $lessons = $course->lessons;

        return view('edit-course', compact('course', 'categories', 'lessons', 'user'));
    }

    public function updateCourse(Request $request, $id)
    {
        $request->validate([
            'course_title' => 'required',
            'course_description' => 'required',
            'course_image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $course = Course::find($id);

        $courseCategoryId = $course->categories->first()->id;

        $courseTitle = $request->input('course_title');
        $courseDescription = $request->input('course_description');
        $courseImage = $request->file('course_image');

        $course = Course::find($id);

        if ($courseImage) {
            if (!$courseImage->isValid()) {
                return back()->with('error', 'Invalid image');
            }

            // delete the old image
            $oldImage = $course->image;
            if ($oldImage) {
                unlink(storage_path('app/public/course_images/' . $oldImage));
            }

            $filename = "{$courseCategoryId}" . "-" . uniqid() . '.jpeg';

            $courseImage->storeAs('public/course_images', $filename);

            $course->image = $filename;
        }

        
        $course->title = $courseTitle;
        $course->description = $courseDescription;

        $course->save();

        $course->categories()->sync($courseCategoryId);

        return redirect()->route('edit-course', ['course' => $id])->with('success', 'Course updated successfully');
    }


    public function publishCourse($id)
    {   
        $course = Course::find($id);

        $user = $course->instructors->first();

        if (Auth::user()->id !== $user->id && !Auth::user()->role == 'admin') {
            return redirect()->route('home')->with('error', 'You are not authorized to publish this course');
        }

        $lessons = $course->lessons;

        if ($lessons->count() < 1) {
            return redirect()->route('edit-course', ['course' => $id])->with('error', 'You need to add at least one lesson to this course before you can publish it');
        }

        $course->status = 'public';

        $course->save();

        return redirect()->route('instructor-dashboard', ['user' => $user->id])->with('success', 'Course published successfully');
    }

    public function showCourse($id)
    {
        $course = Course::find($id);

        $instructor = $course->instructors->first();

        $lessons = $course->lessons;

        $enrollments = $course->enrollments;

        $isEnrolled = $enrollments->contains('user_id', Auth::user()->id);

        // dd($enrollements);

        return view('course-view', compact('course', 'lessons', 'instructor', 'enrollments', 'isEnrolled'));
    }


    public function learningCourse($id)
    {
        $course = Course::find($id);

        $instructor = $course->instructors->first();

        $lessons = $course->lessons->map(function ($lesson) {
            $lesson->is_completed = $lesson->progress()
                ->where('user_id', Auth::id())
                ->value('is_completed');
            return $lesson;
        });

        $completedLessonsCount = $lessons->where('is_completed', 1)->count();

        $enrollments = $course->enrollments;

        $isEnrolled = $enrollments->contains('user_id', Auth::user()->id);

        $isInstructor = $instructor->id === Auth::user()->id;

        if (!$isEnrolled && !$isInstructor) {
            return redirect()->route('home')->with('error', 'You need to enroll in this course to view the lessons');
        }

        return view('course-learning', compact('course', 'lessons', 'instructor', 'enrollments', 'isEnrolled', 'isInstructor', 'completedLessonsCount'));
    }
}
