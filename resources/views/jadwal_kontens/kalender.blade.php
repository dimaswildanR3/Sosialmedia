@extends('layouts.admin')

@section('content')
<h4>Kalender Jadwal Bulan 
  <a href="#" data-toggle="modal" data-target="#pilihBulanModal" style="text-decoration: underline; cursor: pointer;">
    {{ \Carbon\Carbon::createFromDate($tahun, $bulan)->translatedFormat('F Y') }}
  </a>
</h4>

<div class="d-flex justify-content-between mb-3">
    <a href="{{ route('jadwal_kontens.kalender', ['bulan' => \Carbon\Carbon::createFromDate($tahun, $bulan)->subMonth()->format('m'), 'tahun' => \Carbon\Carbon::createFromDate($tahun, $bulan)->subMonth()->format('Y')]) }}" class="btn btn-sm btn-outline-secondary">← Bulan Sebelumnya</a>
    <a href="{{ route('jadwal_kontens.kalender', ['bulan' => \Carbon\Carbon::createFromDate($tahun, $bulan)->addMonth()->format('m'), 'tahun' => \Carbon\Carbon::createFromDate($tahun, $bulan)->addMonth()->format('Y')]) }}" class="btn btn-sm btn-outline-secondary">Bulan Berikutnya →</a>
</div>

<!-- Modal Pilih Bulan -->
<div class="modal fade" id="pilihBulanModal" tabindex="-1" role="dialog" aria-labelledby="pilihBulanModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <form id="formPilihBulan" method="GET" action="{{ route('jadwal_kontens.kalender') }}">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="pilihBulanModalLabel">Pilih Bulan dan Tahun</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Tutup">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="form-group">
            <label for="bulan">Bulan</label>
            <select id="bulan" name="bulan" class="form-control" required>
              @foreach(range(1,12) as $b)
                <option value="{{ $b }}" @if($b == $bulan) selected @endif>
                  {{ \Carbon\Carbon::create()->month($b)->translatedFormat('F') }}
                </option>
              @endforeach
            </select>
          </div>
          <div class="form-group">
            <label for="tahun">Tahun</label>
            <select id="tahun" name="tahun" class="form-control" required>
              @php
                $tahunMulai = date('Y') - 5;
                $tahunAkhir = date('Y') + 5;
              @endphp
              @for($t = $tahunMulai; $t <= $tahunAkhir; $t++)
                <option value="{{ $t }}" @if($t == $tahun) selected @endif>{{ $t }}</option>
              @endfor
            </select>
          </div>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-primary">Tampilkan</button>
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
        </div>
      </div>
    </form>
  </div>
</div>

<style>
    .calendar-grid {
        display: grid;
        grid-template-columns: repeat(7, 1fr);
        gap: 1px;
        background-color: #ccc;
    }
    .calendar-cell {
        background-color: #fff;
        min-height: 120px;
        padding: 8px;
        border: 1px solid #e0e0e0;
        font-size: 14px;
    }
    .calendar-cell .date-label {
        font-weight: bold;
    }
    .jadwal-item {
        color: white;
        font-size: 12px;
        padding: 3px 6px;
        border-radius: 4px;
        margin-top: 5px;
        /* background-color diatur inline */
    }
    .calendar-header {
        text-align: center;
        font-weight: bold;
        background-color: #f1f1f1;
        padding: 5px 0;
    }
</style>

@php
    use Carbon\Carbon;

    $hariPertama = $startOfMonth->copy()->dayOfWeek; // 0 = Minggu, 1 = Senin, ...
    $jumlahHari = $startOfMonth->daysInMonth;
    $currentDate = $startOfMonth->copy();
    $printed = 0;
@endphp

<div class="calendar-grid">
    {{-- Header hari --}}
    @foreach(['Minggu','Senin','Selasa','Rabu','Kamis','Jumat','Sabtu'] as $day)
        <div class="calendar-header">{{ $day }}</div>
    @endforeach

    {{-- Kosongkan cell sebelum tanggal 1 --}}
    @for($i = 0; $i < $hariPertama; $i++)
        <div class="calendar-cell"></div>
        @php $printed++; @endphp
    @endfor

    {{-- Tanggal aktif --}}
    @for($i = 1; $i <= $jumlahHari; $i++)
        @php
            $tanggalStr = $currentDate->format('Y-m-d');
        @endphp
        <div class="calendar-cell">
            <div class="date-label">{{ $i }}</div>
            @if(isset($jadwals[$tanggalStr]))
                @foreach($jadwals[$tanggalStr] as $jadwal)
                    <div class="jadwal-item" style="background-color: {{ $jadwal->kategori->warna ?? '#fd6bc5' }};">
                        {{ $jadwal->judul_konten }}<br>
                        <small>{{ $jadwal->kategori->nama_kategori ?? '-' }}</small>
                    </div>
                @endforeach
            @endif
        </div>
        @php
            $currentDate->addDay();
            $printed++;
        @endphp
    @endfor

    {{-- Kosongkan sisa sel di minggu terakhir --}}
    @for($i = $printed; $i % 7 != 0; $i++)
        <div class="calendar-cell"></div>
    @endfor
</div>
@endsection
