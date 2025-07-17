<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>
    <link rel="icon" href="{{ asset('storage/images/logo.png') }}" type="image/png">

    <link href="assets/vendor/aos/aos.css" rel="stylesheet">
    <link href="{{ asset('css/admin.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.12.1/css/all.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js" charset="utf-8"></script>
    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>
    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous"/>
    <!-- include summernote css/js -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.js"></script>
    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    {{-- datepicker --}}
    <link rel="stylesheet" href="/css/datepicker.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.7.1/css/bootstrap-datepicker.css">
    <script src="https://code.highcharts.com/highcharts.js"></script>
    <style>
      .navbar{
        z-index: 1;
        top:0;
        display:block;
        position: fixed;
        width: 100%;
      }
      .border-left-primary {
        border-left: 0.25rem solid #ff7ec9 !important; /*Warna untuk sisi kiri di semua menu dashboard back end*/
      }
      .notif-badge {
        position: absolute;
        top: -2px;
        right: 0px;
        background-color: red;
        color: white;
        font-size: 10px;
        border-radius: 50%;
        padding: 2px 6px;
        z-index: 10;
      }
      
      /* Search Bar Styles - Inline version */
      .search-container-inline {
        position: relative;
        margin: 0 15px;
      }
      
      .search-container-inline .search-form {
        position: relative;
        display: flex;
        align-items: center;
      }
      
      .search-container-inline .search-input {
        background: rgba(255, 255, 255, 0.2);
        border: 1px solid rgba(255, 255, 255, 0.3);
        border-radius: 20px;
        padding: 6px 35px 6px 12px;
        color: white;
        font-size: 13px;
        width: 200px;
        transition: all 0.3s ease;
      }
      
      .search-container-inline .search-input::placeholder {
        color: rgba(255, 255, 255, 0.7);
      }
      
      .search-container-inline .search-input:focus {
        outline: none;
        background: rgba(255, 255, 255, 0.3);
        border-color: #fd6bc5;
        box-shadow: 0 0 0 2px rgba(253, 107, 197, 0.3);
        width: 250px;
      }
      
      .search-container-inline .search-btn {
        position: absolute;
        right: 3px;
        top: 50%;
        transform: translateY(-50%);
        background: none;
        border: none;
        color: white;
        font-size: 14px;
        cursor: pointer;
        padding: 4px;
        border-radius: 50%;
        transition: all 0.3s ease;
      }
      
      .search-container-inline .search-btn:hover {
        background: rgba(255, 255, 255, 0.2);
      }
      
      .search-container-inline .search-results {
        position: absolute;
        top: 100%;
        left: 0;
        right: 0;
        background: white;
        border: 1px solid #ddd;
        border-radius: 8px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        max-height: 300px;
        overflow-y: auto;
        z-index: 1000;
        display: none;
        min-width: 250px;
      }
      
      .search-result-item {
        padding: 12px 15px;
        border-bottom: 1px solid #eee;
        cursor: pointer;
        transition: background-color 0.2s;
      }
      
      .search-result-item:hover {
        background-color: #f8f9fa;
      }
      
      .search-result-item:last-child {
        border-bottom: none;
      }
      
      .search-result-title {
        font-weight: 600;
        color: #333;
        margin-bottom: 4px;
      }
      
      .search-result-description {
        font-size: 12px;
        color: #666;
      }
      
      .search-result-category {
        font-size: 10px;
        color: #fd6bc5;
        font-weight: 500;
        text-transform: uppercase;
      }
      
      /* Navbar Layout Fix */
      .navbar-nav-wrapper {
        display: flex;
        align-items: center;
        justify-content: space-between;
        width: 100%;
      }
      
      .navbar-brand-wrapper {
        flex-shrink: 0;
      }
      
      .navbar-nav-right {
        flex-shrink: 0;
        margin-left: auto;
      }
      
      .navbar-nav-right .navbar-nav {
        align-items: center;
      }
      
      /* Responsive */
      @media (max-width: 992px) {
        .search-container-inline .search-input {
          width: 150px;
          font-size: 12px;
        }
        .search-container-inline .search-input:focus {
          width: 180px;
        }
        .search-container-inline {
          margin: 0 10px;
        }
      }
      
      @media (max-width: 768px) {
        .search-container-inline {
          display: none !important;
        }
      }

      .sidebar {
  background-color: #fd6bc5;
  width: 250px;
  padding: 10px;
}
.sidebar a {
  display: block;
  padding: 10px;
  color: white;
  text-decoration: none;
}
.dropdown-content {
  display: none;
  background-color: #fda7d0;
  margin-left: 15px;
}
.dropdown:hover .dropdown-content {
  display: block;
}
.mobile_nav_items {
  transition: all 0.3s ease;
  display: none;
  background-color: #fd6bc5;
  padding: 10px;
}

.mobile_nav_items.active {
  display: block;
}

    </style>
</head>
<body>
    <input type="checkbox" id="check">
  <!-- navbar utama -->
<nav class="navbar navbar-expand-lg navbar-dark bg-secondary">
  <div class="container-fluid">
    <div class="navbar-nav-wrapper">
      <!-- Brand -->
      <div class="navbar-brand-wrapper">
        <a href="/dashboard" class="navbar-brand" style="display: flex; align-items: center; margin-left: 10px; text-decoration: none;">
          <img src="{{ asset('storage/images/logo.png') }}" alt="Logo" style="height: 50px; margin-right: 8px;">
          <span style="font-weight: bold; font-size: 1.25rem; color: #fd6bc5;">Sosial Media</span>
        </a>
      </div>

      <!-- Right Side Navigation -->
      <div class="navbar-nav-right">
        <div class="collapse navbar-collapse" id="navbarNavDropdown">
          <ul class="navbar-nav ml-auto">
            <!-- Desktop user dan notif seperti biasa -->
            <li class="nav-item dropdown d-none d-lg-block">
              <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="color: white">
                <i class="fas fa-user" style="color: white"></i> {{ Auth::user()->name }}
              </a>
              <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownMenuLink">
                <a class="dropdown-item" href="{{ route('profile.show') }}">{{ __('Profil Saya') }}</a>
                <a class="dropdown-item" href="{{ route('logout') }}"
                  onclick="event.preventDefault();document.getElementById('logout-form').submit();">{{ __('Log Out') }}</a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">@csrf</form>
              </div>
            </li>

            @php
              $notifs = \App\Models\Notification::where('user_id', Auth::id())->where('is_read', false)->latest()->get();
            @endphp

            <li class="nav-item dropdown d-none d-lg-block">
              <a class="nav-link position-relative" href="#" id="notifDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="color: white">
                <i class="fas fa-bell"></i>
                @if($notifs->count() > 0)
                  <span class="notif-badge">{{ $notifs->count() }}</span>
                @endif
              </a>
              <div class="dropdown-menu dropdown-menu-right" aria-labelledby="notifDropdown" style="width: 300px;">
                <h6 class="dropdown-header">Notifikasi</h6>
                @forelse ($notifs as $notif)
                  <a href="{{ route('notifications.markRead', $notif->id) }}" class="dropdown-item small text-wrap">{{ $notif->message }}</a>
                @empty
                  <span class="dropdown-item text-muted">Tidak ada notifikasi baru</span>
                @endforelse
                <div class="dropdown-divider"></div>
                <a href="{{ route('notifications.markAllRead') }}" class="dropdown-item text-center text-primary">Tandai semua telah dibaca</a>
              </div>
            </li>

            <!-- Tombol hamburger mobile, sembunyikan di desktop -->
            <li class="nav-item d-lg-none" style="display: flex; align-items: center;">
              <label class="nav-link" for="check" style="padding: 0; display: flex; align-items: center;">
                <i class="fas fa-bars" id="sidebar_btn" style="font-size: 20px;"></i>
              </label>
            </li>
          </ul>
        </div>
      </div>
    </div>
  </div>
</nav>

<!-- Mobile navigation bar -->
<div class="mobile_nav">
  <div class="nav_bar" style="display: flex; align-items: center; justify-content: space-between; padding: 10 10px;">
    <p style="font-size: 16px; color: white; margin: 0;">Menu</p>

    <div style="display: flex; align-items: center; gap: 15px;">
      <!-- Notif Icon Mobile -->
      <div style="position: relative;">
        <a href="javascript:void(0)" id="notifToggleMobile" style="color: white; font-size: 20px;">
          <i class="fas fa-bell"></i>
          @if($notifs->count() > 0)
            <span class="notif-badge" style="top: -5px; right: -8px; position: absolute;">{{ $notifs->count() }}</span>
          @endif
        </a>
        <div id="notifDropdownMobile" style="display: none; position: absolute; right: 0; top: 28px; background: white; color: black; width: 280px; border-radius: 5px; max-height: 250px; overflow-y: auto; box-shadow: 0 2px 6px rgba(0,0,0,0.2); z-index: 1050;">
          <h6 class="dropdown-header" style="padding: 10px 15px; margin: 0; border-bottom: 1px solid #ddd;">Notifikasi</h6>
          @forelse ($notifs as $notif)
            <a href="{{ route('notifications.markRead', $notif->id) }}" class="dropdown-item small text-wrap" style="padding: 8px 15px; display: block; color: #333;">{{ $notif->message }}</a>
          @empty
            <span class="dropdown-item text-muted" style="padding: 10px 15px;">Tidak ada notifikasi baru</span>
          @endforelse
          <div class="dropdown-divider"></div>
          <a href="{{ route('notifications.markAllRead') }}" class="dropdown-item text-center text-primary" style="padding: 8px 15px;">Tandai semua telah dibaca</a>
        </div>
      </div>

      <!-- User Icon Mobile -->
      <div style="position: relative;">
        <a href="javascript:void(0)" id="userToggleMobile" style="color: white; font-size: 20px;">
          <i class="fas fa-user"></i>
        </a>
        <div id="userDropdownMobile" style="display: none; position: absolute; right: 0; top: 28px; background: white; color: black; width: 180px; border-radius: 5px; box-shadow: 0 2px 6px rgba(0,0,0,0.2); z-index: 1050;">
          <a href="{{ route('profile.show') }}" class="dropdown-item" style="padding: 8px 15px; display: block; color: #333;">Profil Saya</a>
          <a href="{{ route('logout') }}" class="dropdown-item" style="padding: 8px 15px; display: block; color: #333;"
             onclick="event.preventDefault();document.getElementById('logout-form-mobile').submit();">Log Out</a>
          <form id="logout-form-mobile" action="{{ route('logout') }}" method="POST" class="d-none">@csrf</form>
        </div>
      </div>

      <!-- Hamburger -->
      <i class="fa fa-list nav_btn" style="color: white; font-size: 22px; cursor: pointer;"></i>
    </div>
  </div>

  <div class="mobile_nav_items">
  
    <a href="/dashboard"><i class="fas fa-tachometer-alt"></i><span>Dashboard</span></a>  
  @if(auth()->user()->role == 'admin')
    <a href="/kategoris"><i class="fas fa-tags"></i><span>Kategori</span></a>
    @endif  
    <a href="/jadwal_kontens"><i class="fas fa-calendar-alt"></i><span>Jadwal Konten</span></a>
    <a href="/kalender-jadwal"><i class="fas fa-calendar"></i><span>Kalender Jadwal</span></a>
    <a href="/file_kontens"><i class="fas fa-file-alt"></i><span>File Kontens</span></a>
    <a href="{{ route('laporan.jadwal.view') }}"><i class="fas fa-chzart-line"></i><span>Laporan</span></a>
    @if(auth()->user()->role == 'admin')
    <a href="/akun"><i class="fas fa-user"></i><span>User</span></a>
    @endif 
  </div>
</div>

    <!--mobile navigation bar end-->
    <!--sidebar start-->
    <div class="sidebar">
  <!-- Halaman Utama -->
  <div class="dropdown">
    <a href="/dashboard"><i class="fas fa-home"></i><span>Halaman Utama</span></a>
    @if(auth()->user()->role == 'admin')
    <div class="dropdown-content">
      <a href="/akun"><i class="fas fa-user"></i> Pengguna</a>
    </div>
    @endif 
  </div>

  <!-- Kalender -->
  <div class="dropdown">
    <a href="#"><i class="fas fa-calendar"></i><span>Konten</span></a>
    <div class="dropdown-content">
      <a href="/jadwal_kontens"><i class="fas fa-calendar-alt"></i> Jadwal Konten</a>
      <a href="/kalender-jadwal"><i class="fas fa-calendar"></i> Kalender Jadwal</a>
      @if(auth()->user()->role == 'admin')
      <a href="/kategoris"><i class="fas fa-tags"></i> Kategori</a>
      @endif 
      <a href="/file_kontens"><i class="fas fa-file-alt"></i> File Kontens</a>
    </div>
  </div>

  <!-- Analisis Postingan -->
  <div class="dropdown">
    <a href="#"><i class="fas fa-chart-line"></i><span>Analisis Postingan</span></a>
    <div class="dropdown-content">
      <a href="{{ route('laporan.jadwal.view') }}"><i class="fas fa-chart-line"></i> Laporan</a>
    </div>
  </div>
</div>
    <!--sidebar end-->

    <div class="content">
        @yield('content')
    </div>

    <script type="text/javascript">
   $(document).ready(function() {
    let searchTimeout;

    $('#searchInput').on('input', function(){
        clearTimeout(searchTimeout);
        let query = $(this).val();

        if(query.length >= 2) {
            searchTimeout = setTimeout(function(){
                $.ajax({
                    url: '/search/ajax',
                    type: 'GET',
                    data: { query: query },
                    success: function(response) {
                        displaySearchResults(response);
                    }
                });
            }, 300);
        } else {
            $('#searchResults').hide();
        }
    });

    // Hide results jika klik di luar
    $(document).click(function(e) {
        if (!$(e.target).closest('.search-container-inline').length) {
            $('#searchResults').hide();
        }
    });

    function displaySearchResults(results) {
        let html = '';

        if(results.length === 0) {
            html = '<div class="search-result-item">Tidak ada hasil ditemukan</div>';
        } else {
            results.forEach(item => {
                html += `
                    <div class="search-result-item" onclick="window.location.href='${item.url}'">
                        <div class="search-result-title">${item.title}</div>
                        <div class="search-result-description">${item.description}</div>
                        <div class="search-result-category">${item.category}</div>
                    </div>
                `;
            });
        }

        $('#searchResults').html(html).show();
    }
});

    </script>
   <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.css" rel="stylesheet">
   
   <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
   <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.7.1/js/bootstrap-datepicker.min.js"></script>
  
   <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.js"></script>
   <script type="text/javascript">
 
   $('#summernote').summernote({
       height: 150
   });
   /* Loop through all dropdown buttons to toggle between hiding and showing its dropdown content - This allows the user to have multiple dropdowns without any conflict */
    var dropdown = document.getElementsByClassName("dropdown-btn");
    var i;

    for (i = 0; i < dropdown.length; i++) {
      dropdown[i].addEventListener("click", function() {
      this.classList.toggle("active-side");
      var dropdownContent = this.nextElementSibling;
      if (dropdownContent.style.display === "block") {
      dropdownContent.style.display = "none";
      } else {
      dropdownContent.style.display = "block";
      }
      });
      }
   </script>
   <script>
        $('.dateselect').datepicker({
        format: 'yyyy-mm-dd',
        // startDate: '-3d'
    });
   </script>
   <!-- <script>
  $(document).ready(function(){
    $('.nav_btn').click(function(){
      $('.mobile_nav_items').toggleClass('active');
    });
  });
</script> -->
<script>
  $(document).ready(function(){
    $('#notifToggleMobile').on('click', function(e){
      e.stopPropagation();
      $('#notifDropdownMobile').toggle();
      $('#userDropdownMobile').hide();
    });

    $('#userToggleMobile').on('click', function(e){
      e.stopPropagation();
      $('#userDropdownMobile').toggle();
      $('#notifDropdownMobile').hide();
    });

    $('.nav_btn').on('click', function(){
      $('.mobile_nav_items').toggleClass('active');
    });

    $(document).on('click', function(){
      $('#notifDropdownMobile').hide();
      $('#userDropdownMobile').hide();
    });

    $('#notifDropdownMobile, #userDropdownMobile').on('click', function(e){
      e.stopPropagation();
    });
  });
</script>



   @yield('footer')
  </body>
</html>