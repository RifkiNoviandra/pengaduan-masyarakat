<!-- ======= Header ======= -->
<header id="header" class="fixed-top d-flex align-items-center">
    <div class="container d-flex align-items-center justify-content-between">

      <div class="logo">
        <h1> <a href="index.html"><img src="assets/img/logo.svg"class="img-fluid"><a href="#">CarePasundan</a></h1>
        <!-- Uncomment below if you prefer to use an image logo -->
       
      </div>

      <nav id="navbar" class="navbar">
        <ul>
          <li><a class="nav-link scrollto active" href="{{ url('/')}}">Home</a></li>
          <div> <a class="border-solid" href="{{ route('posts.index')}}">Comunity</a></div> 
          <div> <a class="border-solid" href="{{ route('donations.index')}}">Donasi</a></div> 
          <div> <a class="border-solid" href="{{ url('login')}}">Masuk</a></div>
          <div> <a class="border-solid" href="{{ url('register')}}">Daftar</a></div>
        </ul>
        <i class="bi bi-list mobile-nav-toggle"></i>
      </nav><!-- .navbar -->

    </div>
  </header><!-- End Header -->