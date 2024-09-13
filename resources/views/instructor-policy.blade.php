@extends('components.layout')

@section('title', 'Instructor Policy • eLearning')

@section('css')
    @vite('resources/css/instructor-policy.css')
@endsection

@section('content')
<div class="content">

    <div class="main-content">
        <h2>Policy</h2>
        <p>Before you become an instructor on the eLearning platform, please read and agree to the following terms:</p>
        <div class="policy">
            <h3>Terms of Service for Instuctors</h3>
            <p>By using the eLearning platform, you agree to the following terms:</p>
            <ul>
                <li>You must be at least 18 years old to use the platform.</li>
                <li>You must not use the platform for any illegal or unauthorized purpose.</li>
                <li>You must not use the platform to violate any laws in your jurisdiction.</li>
                <li>You must not use the platform to distribute spam or unsolicited messages.</li>
                <li>You must not use the platform to distribute any content that is harmful, abusive, or offensive.</li>
                <li>You must not use the platform to distribute any content that infringes on the rights of others.</li>
                <li>You must not use the platform to distribute any content that is false or misleading.</li>
                <li>You must not use the platform to distribute any content that is defamatory or libelous.</li>
                <li>You must not use the platform to distribute any content that is obscene.</li>
            </ul>

        </div>

    </div>

    <div class="upgrated-user">

        <h2>Notice</h2>

        <p>
            If you become an instructor on the eLearning platform, you won't be able to use the platform as a student.
            You will have access to additional features that are only available to instructors.
        </p>

        <p>
            Your current courses will remain active, but you won't be able to enroll in new courses or access any student features.
            Also note that you won't be able to switch back to a student account once you become an instructor.
        </p>

        <p>
            You can always create a new account if you want to use the platform as a student again or if you want to create a new instructor account.
        </p>


        <div class="acceptance-actions">
            <form action="{{route('instructor-upgrade', $user->id)}}" method="POST">
                @csrf
                <div>
                    <input type="checkbox" class="btn" name="agree" id="agree" required>
                    <label for="agree">I have read and agree to the terms of service for instructors.</label>
                </div>
                <div class="hidden upgrade-form" id="update-form">
                    <input type="password" name="password" class="form-control" placeholder="Password" >
                    <input type="password" name="password_confirmation" class="form-control" placeholder="Confirm Password">

                    <button id="upgrate-btn" class="btn btn-primary">Continue</button>
                </div>
                @error('password')
                    <div class="alert alert-danger">{{ $message }}</div>    
                @enderror
                
            </form>

            <div>
                <a href="{{route('profile', $user)}}" class="btn btn-danger">Cancel</a>
            </div>
        </div>
    </div>

    

</div>
    
@endsection

@push('scripts')
    @vite('resources/js/instructor-policy.js')
    
@endpush