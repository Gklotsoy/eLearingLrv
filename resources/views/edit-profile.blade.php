@extends('components.layout')

@section('title', 'Edit Profile • eLearning')

@section('css')
    @vite('resources/css/edit-profile.css')
@endsection



@section('content')
    <div class="content">
        <div class="profile-info">
            <h2>
                Your Profile Information
            </h2>

            <div class="modal modal-delete" id="modal-delete">
                <div class="delete-account">
                    <h3>Delete Account</h3>
                    <div class="warning">
                        <i class="fa-solid fa-exclamation-triangle"></i>

                        @if (auth()->user()->role === 'admin')
                            <p>
                                Warning! <br>
                                Delete this account will also delete all the courses and lessons created by this user. <br>

                            </p>
                        @else
                            <p>
                                Are you sure you want to delete your account? <br>
                                This action cannot be undone. <br>
                                All your data will be lost.
                            </p>
                        @endif
                            
                    </div>
                    
                    <div class="delete-form">
                        <form action="/profile/delete/{{$user->id}}" method="POST">
                            @csrf
                            @method('DELETE')
                            <input type="password" name="deletion_password" id="deletion_password" placeholder="Enter your password" required>
                            <input type="password" name="deletion_password_confirmation" id="deletion_password_confirmation" placeholder="Confirm your password" required>
                            <button class="btn btn-danger" id="confirm-delete-btn" >Delete</button>
                            <button class="btn btn-primary" id="cancel-delete-btn">Cancel</button>
                        </form>
                    </div>

                </div>
            </div>

            <div class="change-password-modal modal" id="change-password-modal">
                <h2>Change Password</h2>
                <form action="/profile/update-password/{{$user->id}}" method="POST">
                    @csrf
                    @method('PUT')
                    <label for="current_password">Current Password</label>
                    <input type="password" name="current_password" id="current_password" class="form-control" required>
                    <label for="new_password">New Password</label>
                    <input type="password" name="new_password" id="new_password" class="form-control" required>
                    <label for="new_password_confirmation">Confirm New Password</label>
                    <input type="password" name="new_password_confirmation" id="new_password_confirmation" class="form-control" required>
                    <button class="btn btn-primary" id="change-password-btn">Change Password</button>
                    <button class="btn btn-danger" id="cancel-password-btn">Cancel</button>
                </form>

            </div>

            <div class="modal-picture-update modal" id="modal-picture">
                <div class="update-picture">
                    <h2>Update Profile Picture</h2>
                    <form action="/profile/update-image/{{$user->id}}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <input type="file" name="profile_picture" id="profile_picture" class="form-control" required>
                        <button class="btn btn-primary" id="update-picture-btn">Update Picture</button>
                        <button class="btn btn-danger" id="cancel-picture-btn">Cancel</button>
                    </form>
                </div>
            </div>

            <div class="user-img">
                <img src="/storage/profile_images/{{$user->profile_image}}" alt="User Image" id="user-img">
            </div>

            <div class="form-user-info">
                <form action="/profile/update/{{$user->id}}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="form-group">
                        <label for="first_name">First Name</label>
                        <input type="text" name="first_name" id="first_name" class="form-control" value="{{$user->first_name}}" disabled required>
                        <label for="last_name">Last Name</label>
                        <input type="text" name="last_name" id="last_name" class="form-control" value="{{$user->last_name}}" disabled required>
                        <label for="email">Email</label>
                        <input type="email" name="email" id="email" class="form-control" value="{{$user->email}}" disabled required>
                        
                        <button class="btn btn-primary" id="form-update-btn" style="display: none;">Update</button>
                        
                    </div>
                </form>

                <div class="user-actions">
                    <button type="button" class="btn btn-primary" id="update-btn">Update Profile</button>
                    <button type="button" class="btn btn-danger" id="delete-btn">Delete Account</button>
                    <button type="button" class="btn btn-warning" id="password-btn">Change Password</button>
                </div>
            </div>

            <div class="change-image-guide">
                <p>
                    Click on the image to change your profile picture.

                </p>
            </div>

            @if ($user->role != 'instructor' && $user->role != 'admin')
                <div>
                    <form action="{{route('instructor-policy', $user->id)}}" method="GET">
                        <button class="btn btn-primary">Become an Instructor</button>
                    </form>
                    
                </div>
                
            @endif
            

        </div>

    </div>
@endsection

@push('scripts')
    @vite('resources/js/edit-profile.js')
@endpush