<?php

namespace App\Http\Controllers;

use App\Models\Enrollment;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class EnrollmentsContoroller extends Controller
{
    public function enrollCourse($id)
    {
        $user = Auth::user();

        if ($user->role !== 'student') {
            return redirect()->route('home')->with('error', 'Only students can enroll in courses');
        }

        $enrollment = new Enrollment();
        $enrollment->user_id = $user->id;
        $enrollment->course_id = $id;
        $enrollment->save();

        

        return redirect()->route('home')->with('success', 'You have successfully enrolled in the course');
    }
}
