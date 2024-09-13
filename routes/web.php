<?php

use App\Models\Enrollment;
use App\Models\CourseCategories;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\LessonController;
use App\Http\Controllers\EnrollmentsContoroller;
use App\Http\Controllers\CourseCategoriesController;

Route::get('/', [UserController::class, 'index'])->name('login');

Route::get('/', [UserController::class, 'index'])->name('home');

Route::post('/signup', [UserController::class, 'signup']);

Route::post('/login', [UserController::class, 'login']);

Route::get('/logout', [UserController::class, 'logout'])->name('logout')->middleware('auth');

Route::get('/profile/{user}', [UserController::class, 'profile'])->name('profile')->middleware('auth');

Route::get('/profile/edit/{user}', [UserController::class, 'editProfile'])->name('edit-profile')->middleware('auth');

Route::get('/add-user-form', [UserController::class, 'addUserForm'])->name('add-user-form')->middleware('auth');

Route::post('/admin/user/store', [UserController::class, 'addUser'])->name('add-user')->middleware('auth');

Route::put('/profile/update/{user:id}', [UserController::class, 'updateProfile'])->name('update-profile')->middleware('auth');

Route::delete('/profile/delete/{user:id}', [UserController::class, 'deleteProfile'])->name('delete-profile')->middleware('auth');

Route::put('/profile/update-password/{user:id}', [UserController::class, 'updatePassword'])->name('update-password')->middleware('auth');

Route::put('/profile/update-image/{user:id}', [UserController::class, 'updateImage'])->name('edit-image')->middleware('auth');

Route::get('/profile/user/instructor-policy/{user:id}', [UserController::class, 'instructorPolicy'])->name('instructor-policy')->middleware('auth');

Route::post('/profile/user/instructor-upgrade/{user:id}', [UserController::class, 'instructorUpgrade'])->name('instructor-upgrade')->middleware('auth');

Route::get('/admin-dashboard', [UserController::class, 'adminDashboard'])->name('admin-dashboard')->middleware('auth');

Route::get('/course-category', [CourseCategoriesController::class, 'showCreateCourseCategory'])->name('create-category')->middleware('auth');

Route::post('/create-course-category', [CourseCategoriesController::class, 'createCourseCategory'])->middleware('auth');

Route::get('/category-courses/{category:id}', [CourseCategoriesController::class, 'showCategoryCourses'])->name('category-courses')->middleware('auth');

Route::get('/edit-course-category/{category}', [CourseCategoriesController::class, 'editCourseCategory'])->name('edit-category')->middleware('auth');

Route::put('/course-category/update/{category:id}', [CourseCategoriesController::class, 'updateCourseCategory'])->name('update-category')->middleware('auth');

Route::get(('/instructor-dashboard/{user:id}'), [UserController::class, 'instructorDashboard'])->name('instructor-dashboard')->middleware('auth');

Route::get('/instructor/courses/create', [CourseController::class, 'showCreateCourse'])->name('create-course')->middleware('auth');

Route::post('/instructor/courses/save', [CourseController::class, 'createCourse'])->name('store-course')->middleware('auth');

Route::get('/instructor/courses/edit/{course}', [CourseController::class, 'editCourse'])->name('edit-course')->middleware('auth');

Route::put('/instructor/courses/update-course/{course:id}', [CourseController::class, 'updateCourse'])->name('update-course')->middleware('auth');

Route::put('/instructor/course/publish/{course:id}', [CourseController::class, 'publishCourse'])->name('publish-course')->middleware('auth');

Route::get('/course/{course:id}', [CourseController::class, 'showCourse'])->name('course')->middleware('auth');

Route::get('user/learning/course/{course:id}', [CourseController::class, 'learningCourse'])->name('course-learning')->middleware('auth');

Route::post('/instructor/course/add-lesson', [LessonController::class, 'addLesson'])->name('add-lesson')->middleware('auth');

Route::delete('/instructor/course/delete-lesson/{lesson:id}', [LessonController::class, 'deleteLesson'])->name('delete-lesson')->middleware('auth');

Route::post('/course/enroll/{course:id}', [EnrollmentsContoroller::class, 'enrollCourse'])->name('enroll-course')->middleware('auth');

Route::post('/lessons/{lesson:id}/completion', [LessonController::class, 'updateCompletion']);