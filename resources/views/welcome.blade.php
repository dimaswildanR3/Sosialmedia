<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <meta content="width=device-width, initial-scale=1" name="viewport" />
  <title>Sosial Media</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,600&display=swap" rel="stylesheet" />
  <style>
    body {
      font-family: 'Open Sans', sans-serif;
      background-color: #f0f2f5;
    }
    .post {
      background: white;
      border-radius: 10px;
      padding: 15px;
      margin-bottom: 20px;
      box-shadow: 0 2px 5px rgb(0 0 0 / 0.1);
    }
    .profile-img, .profile-img svg {
      width: 40px;
      height: 40px;
      border-radius: 50%;
      object-fit: cover;
      background-color: #ccc;
      display: inline-block;
    }
    .profile-img svg path {
      fill: #6c757d;
    }
    .like-comment {
      cursor: pointer;
      color: #555;
      font-weight: 600;
      margin-right: 15px;
    }
    .like-comment:hover {
      color: #007bff;
    }
    .sidebar {
      background: white;
      padding: 15px;
      border-radius: 10px;
      box-shadow: 0 2px 5px rgb(0 0 0 / 0.1);
      margin-top: 20px;
    }
    .navbar-brand {
      font-weight: 700;
      font-size: 1.5rem;
    }
    .media-files img, .media-files video {
      max-width: 100%;
      margin-top: 10px;
      border-radius: 8px;
    }
    .media-files a {
      display: inline-block;
      margin-top: 10px;
      text-decoration: none;
      color: #0d6efd;
      font-weight: 600;
    }
  </style>
</head>
<body>
  <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm mb-4">
    <div class="container d-flex justify-content-between align-items-center">
      <a class="navbar-brand" href="#">Sosial Media</a>
      <a href="http://127.0.0.1:8000/login" class="btn btn-primary btn-sm">Upload Konten</a>
    </div>
  </nav>

  <div class="container">
    <div class="row">
      <!-- Feed -->
      <div class="col-lg-8">
        @foreach($jadwals as $jadwal)
        <div class="post">
          <div class="d-flex align-items-center mb-3">
            @if($jadwal->user && $jadwal->user->profile_photo_url)
              <img src="{{ $jadwal->user->profile_photo_url }}" alt="User" class="profile-img me-2" />
            @else
              <svg xmlns="http://www.w3.org/2000/svg" class="profile-img me-2" fill="currentColor" viewBox="0 0 16 16">
                <path d="M8 9a3 3 0 1 0 0-6 3 3 0 0 0 0 6z"/>
                <path fill-rule="evenodd" d="M14 14s-1-1.5-6-1.5S2 14 2 14s1-4 6-4 6 4 6 4z"/>
              </svg>
            @endif
            <div>
              <strong>{{ $jadwal->user->name ?? 'User tidak ditemukan' }}</strong><br />
              <small class="text-muted">{{ \Carbon\Carbon::parse($jadwal->tanggal_publikasi)->diffForHumans() }}</small>
            </div>
          </div>

          {{-- Kategori di atas judul --}}
          <p><span class="badge bg-secondary">{{ $jadwal->kategori->nama_kategori ?? '-' }}</span></p>

          {{-- Judul konten --}}
          <p><strong>{{ $jadwal->judul_konten }}</strong></p>

          {{-- Platform di bawah judul --}}
          <p><span>{{ $jadwal->platform ?? '-' }}</span></p>

          {{-- Tampilkan file konten (gambar/video/pdf) --}}
          @if($jadwal->fileKontens && $jadwal->fileKontens->count())
          <div class="media-files">
            @foreach($jadwal->fileKontens as $file)
              @php
                $url = asset('storage/' . $file->url_file);
              @endphp

              @if(str_contains($file->tipe_file, 'image'))
                <img src="{{ $url }}" alt="{{ $file->nama_file }}" />
              @elseif(str_contains($file->tipe_file, 'video'))
                <video controls>
                  <source src="{{ $url }}" type="{{ $file->tipe_file }}" />
                  Browser Anda tidak mendukung video.
                </video>
              @else
                <a href="{{ $url }}" target="_blank" rel="noopener">{{ $file->nama_file }}</a>
              @endif
            @endforeach
          </div>
          @endif
        </div>
        @endforeach
      </div>

      <!-- Sidebar -->
      <div class="col-lg-4">
        <div class="sidebar">
          <h6>Jadwal Terdekat</h6>
          <ul class="list-unstyled">
            @foreach($jadwals->take(3) as $j)
              <li><strong>{{ \Carbon\Carbon::parse($j->tanggal_publikasi)->format('d M Y') }}</strong> - {{ $j->judul_konten }}</li>
            @endforeach
          </ul>
        </div>
      </div>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
