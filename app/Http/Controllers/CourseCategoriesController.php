<?php

namespace App\Http\Controllers;

use App\Models\CourseCategories;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class CourseCategoriesController extends Controller
{
    public function showCreateCourseCategory()
    {

        if (Auth::user()->role !== 'admin') {
            return redirect()->route('home')->with('error', 'You are not authorized to view this page');
        }
        $categoryCount = CourseCategories::count();
        
        return view('create-course-category', compact('categoryCount'));
    }

    public function createCourseCategory(Request $request)
    {

        if (Auth::user()->role !== 'admin') {
            return redirect()->route('home')->with('error', 'You are not authorized to view this page');
        }

        $request->validate([
            'category_name' => 'required|string|max:255',
            'category_description' => 'required|string|max:255',
            'category_image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $categoryName = $request->input('category_name');
        $categoryImage = $request->file('category_image');

        if (!$categoryImage->isValid()) {
            return back()->with('error', 'Invalid image');
        }

        $filename = "{$categoryName}". "-" . uniqid() . '.jpeg';

        Storage::putFileAs('public/category_images', $categoryImage, $filename);

        // Create the course category in the database

        $category = CourseCategories::create([
            'category_name' => $categoryName,
            'description' => $request->input('category_description'),
            'image' => $filename,
        ]);

        return redirect()->route('create-category')->with('success', 'Course category created successfully');
    }

    public function editCourseCategory(CourseCategories $category)
    {
        if (Auth::user()->role !== 'admin') {
            return redirect()->route('home')->with('error', 'You are not authorized to view this page');
        }

        return view('course-category-edit', compact('category'));
    }

    public function updateCourseCategory(Request $request, CourseCategories $category)
    {
        if (Auth::user()->role !== 'admin') {
            return redirect()->route('home')->with('error', 'You are not authorized to view this page');
        }

        $request->validate([
            'category_name' => 'required|string|max:255',
            'category_description' => 'required|string|max:255',
            'category_image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $categoryName = ucfirst($request->input('category_name'));
        $categoryImage = $request->file('category_image');

        if ($categoryImage) {
            if (!$categoryImage->isValid()) {
                return back()->with('error', 'Invalid image');
            }

            $filename = "{$categoryName}". "-" . uniqid() . '.jpeg';

            Storage::putFileAs('public/category_images', $categoryImage, $filename);
        } else {
            $filename = $category->image;
        }

        $category->update([
            'category_name' => $categoryName,
            'description' => $request->input('category_description'),
            'image' => $filename,
        ]);

        return redirect()->route('edit-category', $category)->with('success', 'Category updated successfully');
    }

    public function showCategoryCourses(CourseCategories $category)
    {
        $courses = $category->courses()->with('instructors')->get();

        $courses = $courses->where('status', 'public');

        // dd($courses);

        return view('category-courses', compact('category', 'courses'));
    }
}
