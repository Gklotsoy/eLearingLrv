<div class="header">
    <div class="navbar">
        <div class="logo row">
            <a href="/"><h1>eLearning</h1></a>
        </div>

        @if (!Auth::check())
        <div class="form row">
            <form action="/login" method="post">
                @csrf
                <input type="email" name="email" placeholder="Email">
                <input type="password" name="password" placeholder="Password">
                <button type="submit">Login</button>
            </form>
        </div>
        @else
        <div class="search-bar">
            <input type="text" name="search" placeholder="Search">
            <button class="fa-solid fa-magnifying-glass" style="color: #f0f2f4;" type="submit"></button>
        </div>

        <div class="menu">
            <a href="/profile/{{auth()->user()->id}}"><i class="fa-solid fa-user"></i>  Profile</a>
            <a href="/logout"><i class="fa-solid fa-right-from-bracket"></i>  Logout</a>
        </div>
        @endif
        
    </div>
</div>