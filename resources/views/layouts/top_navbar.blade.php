 <nav class="navbar navbar-expand-lg navbar-dark bg-primar topnav">
     <div class="container-fluid">
         <a class="navbar-brand" href="#">Admin pannel</a>
         <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
             aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
             <span class="navbar-toggler-icon"></span>
         </button>
         <div class="collapse navbar-collapse" id="navbarNav">
             <ul class="navbar-nav ms-auto">
                 <li>
                     <a class="navbar-brand" href="{{url('logout')}}">Logout</a>

                 </li>

             </ul>
         </div>
     </div>
 </nav>

 <!-- Side Navigation Bar -->
 <div class="sidenav">
     <h4 class="text-center text-white">Admin Panel</h4>
     <hr>
     @if(auth()->check() && auth()->user()->role === 'admin')

     <a href="{{url('dashboard')}}">Dashboard</a>
     <a href="{{url('teacher')}}">Teacher</a>
     <a href="{{url('student')}}">Student</a>

     @endif

 </div>