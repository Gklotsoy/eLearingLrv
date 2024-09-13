@extends('components.layout')

@section('title', 'Add User • Admin Panel')

@section('css')
    @vite('resources/css/add-user.css')
@endsection

@section('content')
<div class="content">
    <div class="add-user">
        <div class="add-user-header">
            <h3>Add User</h3>
        </div>
        <div class="add-user-body">
            <form action="/admin/user/store" method="POST">
                @csrf
                <div class="form-group">
                    <label for="first_name">First Name</label>
                    <input type="text" name="first_name" class="form-control" id="first-name" value="{{old('first_name')}}" required placeholder="Enter First Name">
                    @error('first_name')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                    <label for="last_name">Last Name</label>
                    <input type="text" name="last_name" class="form-control" id="last-name" value="{{old('last_name')}}" required placeholder="Enter Last Name">
                    @error('last_name')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                    <label for="email">Email</label>
                    <input type="email" name="email" class="form-control" id="email" value="{{old('email')}}" required placeholder="Enter Email">
                    @error('email')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                    <label for="password">Password</label>
                    <input type="password" name="password" class="form-control" id="password" required placeholder="Enter Temporary Password">
                    @error('password')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                    <label for="password_confirmation">Confirm Password</label>
                    <input type="password" name="password_confirmation" class="form-control" id="password-confirmation" required placeholder="Confirm Password">
                    @error('password_confirmation')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                    <label for="role">Role</label>
                    <select name="role" class="form-select" id="role" required>
                        <option value="">Select Role</option>
                        @foreach ($userRoles as $userRole)
                            <option value="{{$userRole}}">{{$userRole}}</option>
                        @endforeach
                    </select>
                    @error('role')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                    <button type="submit" class="btn btn-primary">Add User</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
