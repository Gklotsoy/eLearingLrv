<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Course;
use App\Models\Lesson;
use Illuminate\Http\Request;
use App\Models\CourseCategories;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Intervention\Image\ImageManager;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Drivers\Gd\Driver;
use Termwind\Components\Dd;

class UserController extends Controller
{
    public function index()
    {   
        
        if(Auth::check()){
            $categories = CourseCategories::all()->sortBy('created_at');
            return view('homepage-user', compact('categories'));
        }

        return view('homepage-guest');
    }


    public function signup(Request $request)
    {
        $signupData = $request->validate([
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'email' => 'required|email|unique:users',
            'password' => 'required|string|confirmed',
        ]);

        if(!$signupData){
            return back()->with('error', 'Invalid data');
        }

        $user = User::create($signupData);

        Auth::login($user);

        return redirect('/')->with('success', 'Account created successfully');
    }

    public function login(Request $request)
    {
        $loginData = $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        if(!$loginData){
            return "Invalid data";
        }

        if(!Auth::attempt($loginData)){
            return back()->with('error', 'Invalid credentials');
        }

        return redirect()->route('home');
    }

    public function logout()
    {
        Auth::logout();

        return redirect()->route('home');
    }

    public function addUserForm()
    {
        if(Auth::user()->role !== 'admin'){
            return back()->with('error', 'You are not authorized to view this page');
        }

        //take the allowed roles from the database and pass them to the view
        $userRoles = [
            'admin',
            'instructor',
            'student',
        ];

        return view('add-user', compact('userRoles'));
    }

    public function addUser(Request $request)
    {
        if(Auth::user()->role !== 'admin'){
            return back()->with('error', 'You are not authorized to add a user');
        }

        $userData = $request->validate([
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'email' => 'required|email|unique:users',
            'password' => 'required|string|confirmed',
            'role' => 'required|string:in:admin,instructor,student',
        ]);

        if(!$userData){
            return back()->with('error', 'Invalid data');
        }

        $user = User::create($userData);

        return redirect()->route('admin-dashboard')->with('success', 'User created successfully');
    }

    public function profile(User $user)
    {
        
        if(!$user){
            return back()->with('error', 'User not found');
        }

        $user = User::find($user->id);

        $enrollments = $user->enrollments->map(function($enrollment){
            return [
                'course' => $enrollment->course,
            ];
        });

        // dd($enrollments);

        return view('user-profile', compact('user', 'enrollments'));
    }

    public function editProfile(User $user)
    {

        if(Auth::user()->id !== $user->id && Auth::user()->role !== 'admin'){
            return back()->with('error', 'You are not authorized to edit this profile');
        }


        return view('edit-profile', compact('user'));
    }

    public function updateProfile(Request $request, User $user)
    {

        if(Auth::user()->id !== $user->id && Auth::user()->role !== 'admin'){
            return back()->with('error', 'You are not authorized to edit this profile');
        }

        $profileData = $request->validate([
            'first_name' => 'required|string|required',
            'last_name' => 'required|string|required',
            'email' => 'required|email|unique:users,email,'.$user->id,
        ]);

        $user->update($profileData);

        return view('edit-profile', compact('user'));
    }

    public function deleteProfile(Request $request, User $user)
    {

        if(Auth::user()->id !== $user->id && Auth::user()->role !== 'admin'){
            return back()->with('error', 'You are not authorized to delete this profile');
        }

        $deleteData = $request->validate([
            'deletion_password' => 'required|string|confirmed',
        ]);

        if(Auth::user()->role === 'admin'){
            if(!Hash::check($deleteData['deletion_password'], Auth::user()->password)){
                return back()->with('error', 'Invalid Admin password');
            }
            $user->delete();
            return redirect()->route('home')->with('success', 'User deleted successfully');
        }
        
        if(!Hash::check($deleteData['deletion_password'], $user->password)){
            return back()->with('error', 'Invalid password');
        }

        //Delete the user's profile image
        Storage::delete('public/profile_images/' . $user->profile_image);

        // Delete the user

        $user->delete();

        if(Auth::user()->id !== $user->id){
            return redirect()->route('profile', Auth::user());
        }

        return redirect()->route('home');
    }

    public function updatePassword(Request $request, User $user)
    {

        if(Auth::user()->id !== $user->id){
            return back()->with('error', 'You are not authorized to change this password');
        }

        $passwordData = $request->validate([
            'current_password' => 'required|string',
            'new_password' => 'required|string|confirmed',
        ]);

        if(!Hash::check($passwordData['current_password'], $user->password)){
            return back()->with('error', 'Invalid password');
        }

        $user->update([
            'password' => Hash::make($passwordData['new_password']),
        ]);

        return view('edit-profile', compact('user'))->with('success', 'Password updated successfully');
    }

    public function updateImage(Request $request, User $user)
    {
        if (Auth::user()->id !== $user->id && Auth::user()->role !== 'admin') {
            return back()->with('error', 'You are not authorized to update this image');
        }
        
        $request->validate([
            'profile_picture' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        if(!$request->file('profile_picture')->isValid()){
            return back()->with('error', 'Invalid image');
        }

        // Generate a unique filename
        $filename = $user->id. "-" . uniqid() . ".jpeg";

        //resize image
        $manager = new ImageManager(new Driver());
        $image = $manager->read($request->file('profile_picture'));
        $imageData = $image->cover(200, 200)->toJpeg();

        // Delete the old profile image
        if($user->profile_image !== 'default.jpg'){
            Storage::delete('public/profile_images/' . $user->profile_image);
        }
        
        // Store the new profile image
        Storage::put('public/profile_images/' . $filename, $imageData);

        // Update the user's profile image

        $user->profile_image = $filename;
        $user->save();
        
        if($user->profile_image !== $filename){
            return back()->with('error', 'Image upload failed');
        }

        return back()->with('success', 'Image uploaded successfully');

    }

    public function adminDashboard()
    {
        if(Auth::user()->role !== 'admin'){
            return back()->with('error', 'You are not authorized to view this page');
        }

        $users = User::paginate(6);
        $userRoles = User::all()->pluck('role')->unique();
        $userCountsByRole = User::select('role', DB::raw('count(*) as count'))
        ->groupBy('role')
        ->get()
        ->pluck('count', 'role');
        $roles = ['admin', 'instructor', 'student'];
        $totalUsers = User::all()->count();
        $categories = CourseCategories::paginate(6);
        $categoriesCount = CourseCategories::all()->count();
        $courses = Course::all()->map(function($course){
            return [
                'course' => $course,
                'category' => $course->categories->pluck('category_name')->first(),
                'instructor' => $course->instructors->pluck('first_name')->implode(' '). ' ' . $course->instructors->pluck('last_name')->implode(' '),
            ];
        });


        $lessons = Lesson::all();

        // dd($courseDetails);
        
        return view('admin-dashboard', compact('users', 'categories', 'userRoles', 'userCountsByRole', 'categoriesCount', 'totalUsers', 'roles', 'courses','lessons'));
    }

    public function instructorDashboard($id)
    {
        if(Auth::user()->role !== 'instructor' && Auth::user()->role !== 'admin'){
            return back()->with('error', 'You are not authorized to view this page');
        }

        $user = User::find($id);
        $categories = CourseCategories::all();

        // Get the courses that the instructor has created and pass them to the view
        $courses = $user->courses->map(function ($course) {
            return [
                'course' => $course,
                'enrollments' => $course->enrollments,
                'lessons' => $course->lessons,
            ];
        });
        
        $publishedCourses = $courses->filter(function ($course) {
            return $course['course']->status === 'public';
        });
        $unpublishedCourses = $courses->filter(function ($course) {
            return $course['course']->status === 'private';
        });

        

        return view('instructor-dashboard', compact('categories', 'user', 'publishedCourses', 'unpublishedCourses', 'courses'));
    }

    public function instructorPolicy($id)
    {
        if(Auth::user()->role !== 'student' && Auth::user()->role !== 'admin'){
            return back()->with('error', 'You are not authorized to view this page');
        }

        $user = User::find($id);

        return view('instructor-policy', compact('user'));
    }

    public function instructorUpgrade(Request $request, $id)
    {
        if(Auth::user()->role !== 'student' && Auth::user()->role !== 'admin'){
            return back()->with('error', 'You are not authorized to view this page');
        }

        $user = User::find($id);

        $request->validate([
            'password' => 'required|string|confirmed',
        ]);


        if(!Hash::check($request->password, Auth::user()->password)){
            return back()->with('error', 'Invalid password');
        }

        $user->role = 'instructor';
        $user->save();

        return redirect()->route('instructor-dashboard', ['user' => $user->id])->with('success', 'You are now an instructor');
    }
}
