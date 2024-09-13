@extends('components.layout')

@section('title', 'Admin Dashboard • eLearning')
    
@section('css')
    @vite('resources/css/admin-dashboard.css')
@endsection

@section('content')
<div class="content">

    <nav>
        <div class="nav nav-tabs" id="nav-tab" role="tablist">
          <button class="nav-link active" id="nav-dashboard-tab" data-bs-toggle="tab" data-bs-target="#nav-dashboard" type="button" role="tab" aria-controls="nav-dashboard" aria-selected="true">Dashboard</button>
          <button class="nav-link" id="nav-users-tab" data-bs-toggle="tab" data-bs-target="#nav-users" type="button" role="tab" aria-controls="nav-users" aria-selected="false">Users</button>
          <button class="nav-link" id="nav-categories-tab" data-bs-toggle="tab" data-bs-target="#nav-categories" type="button" role="tab" aria-controls="nav-categories" aria-selected="false">Categories</button>
          <button class="nav-link" id="nav-lessons-tab" data-bs-toggle="tab" data-bs-target="#nav-lessons" type="button" role="tab" aria-controls="nav-lessons" aria-selected="false">Courses</button>
          
        </div>
      </nav>
      <div class="tab-content" id="nav-tabContent">
        <div class="tab-pane fade show active" id="nav-dashboard" role="tabpanel" aria-labelledby="nav-dashboard-tab" tabindex="0">
            <div class="dashboard">
                <h2>Dashboard</h2>
                <div class="cards">
                    <div class="card">
                        <h3>Total Users</h3>
                        <h4>{{$totalUsers}}</h4>
                    </div>
                    <div class="card">
                        <h3>Admins</h3>
                        <h4>{{$userCountsByRole['admin'] ?? 0 }}</h4>
                    </div>
                    <div class="card">
                        <h3>Instructors</h3>
                        <h4>{{$userCountsByRole['instructor'] ?? 0}}</h4>
                    </div>
                    <div class="card">
                        <h3>Students</h3>
                        <h4>{{$userCountsByRole['student'] ?? 0 }}</h4>
                    </div>
                    <div class="card">
                        <h3>Course Categories</h3>
                        <h4>{{$categoriesCount}}</h4>
                    </div>
                    <div class="card">
                        <h3>Courses</h3>
                        <h4>{{$courses->count()}}</h4>
                    </div>
                    <div class="card">
                        <h3>Lessons</h3>
                        <h4>{{$lessons->count()}}</h4>
                    </div>
                </div>
            </div>
        </div>
        <div class="tab-pane fade" id="nav-users" role="tabpanel" aria-labelledby="nav-users-tab" tabindex="0">
            <div class="users-dashboard">
                <div class="filtering" style="display: flex;">
                    <h2>Users</h2>
                    <div class="filters">
                        <input type="text" id="filter-user-name" placeholder="Filter by Name">
                        <input type="text" id="filter-user-email" placeholder="Filter by Email">
                        <select id="filter-user-role">
                            <option value="">Filter by Role</option>
                            @foreach ($roles as $role)
                                <option value="{{ $role }}">{{ $role }}</option>
                            @endforeach
                        </select>
                        <button id="user-filter-btn" class="btn btn-primary bi bi-filter">Filter</button>
                        <button id="user-clear-filter" class="btn btn-danger bi bi-x">Clear Filter</button>
                    </div>
                    <div>
                        <form action="/add-user-form" method="get">
                            <button type="submit" class="btn btn-primary" id="add-user">Add User</button>
                        </form>
                    </div>
                </div>
                <table class="table" id="user-table">
                    <thead>
                        <tr>
                            <th scope="col">ID</th>
                            <th scope="col">Name</th>
                            <th scope="col">Email</th>
                            <th scope="col">Role</th>
                            <th scope="col">Enrollments</th>
                            <th scope="col">Courses</th>
                            <th scope="col">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($users as $user)
                            <tr>
                                <th scope="row">{{ $user->id }}</th>
                                <td>{{ $user->first_name }} {{ $user->last_name }}</td>
                                <td>
                                    {{ $user->email }}
                                </td>
                                <td>{{ $user->role }}</td>
                                <td>{{ $user->enrollments->count() }}</td>
                                <td>{{ $user->courses->count() }}</td>
                                <td>
                                    <form action="/profile/{{$user->id}}" method="get">
                                        <button type="submit" class="btn btn-success">Profile</button>
                                    </form>
                                    <form action="/profile/edit/{{$user->id}}" method="get">
                                        <button type="submit" class="btn btn-primary">Edit</button>
                                    </form>
                                </td>
                            </tr>
                            
                        @endforeach
                        
                    </tbody>
                </table>
            </div>
        </div>
        <div class="tab-pane fade" id="nav-categories" role="tabpanel" aria-labelledby="nav-categories-tab" tabindex="0">
            <div class="categories-dashboard">
                <div class="filtering" style="display: flex;">
                    <h2>Categories</h2>
                    <div class="filters">
                        <input type="text" id="filter-category-name" placeholder="Filter by Name">
                        <input type="text" id="filter-category-description" placeholder="Filter by Description">
                        <button id="category-filter-btn" class="btn btn-primary bi bi-filter">Filter</button>
                        <button id="clear-category-filter" class="btn btn-danger bi bi-x">Clear Filter</button>
                    </div>
                    <div>
                        <form action="/course-category" method="get">
                            @csrf
                        <button class="btn btn-primary" id="add-category">Add Category</button>
                        </form>
                    </div>
                </div>
                <table class="table" id="category-table">
                    <thead>
                        <tr>
                            <th scope="col">ID</th>
                            <th scope="col">Name</th>
                            <th scope="col">Description</th>
                            <th scope="col">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($categories as $category)
                            <tr>
                                <th scope="row">{{ $category->id }}</th>
                                <td>{{ $category->category_name }}</td>
                                <td>
                                    {{ $category->description }}
                                </td>
                                <td>
                                    <form action="{{route('category-courses', $category->id)}}" method="get">
                                        <button type="submit" class="btn btn-success">View Courses</button>
                                    </form>
                                    <form action="/edit-course-category/{{$category->id}}" method="get">
                                        <button type="submit" class="btn btn-primary">Edit</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                        
                    </tbody>
                    
                </table>
                {{$categories->links()}}
            </div>                           
        </div>
        <div class="tab-pane fade" id="nav-lessons" role="tabpanel" aria-labelledby="nav-lessons-tab" tabindex="0">
            <div class="lessons-dashboard">
                <div class="filtering" style="display: flex;">
                    <h2>Courses</h2>
                    <div class="filters">
                        <input type="text" id="filter-lesson-name" placeholder="Filter by Name">
                        <select id="filter-lesson-category">
                            <option value="">Filter by Category</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->category_name }}">{{ $category->category_name }}</option>
                            @endforeach
                        </select>
                        <input type="text" id="filter-lesson-instructor" placeholder="Filter by Instructor">
                        <button id="lesson-filter-btn" class="btn btn-primary bi bi-filter">Filter</button>
                        <button id="clear-lesson-filter" class="btn btn-danger bi bi-x">Clear Filter</button>
                    </div>
                </div>
                <table class="table" id="lesson-table">
                    <thead>
                        <tr>
                            <th scope="col">ID</th>
                            <th scope="col">Name</th>
                            <th scope="col">Description</th>
                            <th scope="col">Category</th>
                            <th scope="col">Instructor</th>
                            <th scope="col">Status</th>
                            <th scope="col">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($courses as $course)
                            <tr>
                                <th scope="row">{{ $course['course']->id }}</th>
                                <td>{{ $course['course']->title }}</td>
                                <td>
                                    {{ $course['course']->description }}
                                </td>
                                <td>{{ $course['category'] }}</td>
                                <td>{{ $course['instructor'] }}</td>
                                <td>{{ ucfirst($course['course']->status) }}</td>
                                <td class="{{ $course['course']->status == 'public' ? 'status-public' : ($course['course']->status == 'private' ? 'status-private' : 'status-draft') }}">
                                    <form action="{{route('course', $course['course']->id)}}" method="get">
                                        <button type="submit" class="btn btn-success">View</button>
                                    </form>
                                    <form action="{{route('edit-course', $course['course']->id)}}" method="get">
                                        <button type="submit" class="btn btn-primary">Edit</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach

                        
                    </tbody>
                </table>
            </div>
        </div>
        
      </div>

    </nav>
</div>
@endsection

@push('scripts')
    @vite('resources/js/admin-dashboard.js')    
@endpush