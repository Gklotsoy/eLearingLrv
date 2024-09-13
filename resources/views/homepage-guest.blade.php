@extends('components.layout')

@section('title', 'eLearning')

@section('css')
    @vite('resources/css/homepage-guest.css')
@endsection

@section('content')
<div class="guestpage">

    <div class="content">
        <div class="about">
            <h1>About Us</h1>
            <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. 
                Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, 
                when an unknown printer took a galley of type and scrambled it to make a type specimen book. 
                It has survived not only five centuries, but also the leap into electronic typesetting, 
                remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset 
                sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like 
                Aldus PageMaker including versions of Lorem Ipsum.
            </p>            
        </div>

        <div class="register">

            <form action="/signup" method="post" class="form">
                @csrf
                <h1>Register</h1>
                <input type="text" value="{{old('first_name')}}" name="first_name" placeholder="First Name">
                @error('first_name')
                    <div class="alert alert-danger" style="color: red">{{ $message }}</div>
                @enderror
                <input type="text" value="{{old('last_name')}}" name="last_name" placeholder="Last Name">
                @error('last_name')
                    <div class="alert alert-danger" style="color: red">{{ $message }}</div>
                @enderror
                <input type="email" value="{{old('email')}}" name="email" placeholder="Email">
                @error('email')
                    <div class="alert alert-danger" style="color: red">{{ $message }}</div>
                @enderror
                <input type="password" name="password" placeholder="Password">
                @error('password')
                    <div class="alert alert-danger" style="color: red">{{ $message }}</div>
                @enderror
                <input type="password" name="password_confirmation" placeholder="Confirm Password">
                <button type="submit">Register</button>
            </form>

        </div>

    </div>

</div>
@endsection

