<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Kelulusan SMK NU Bodeh</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@1,500&display=swap" rel="stylesheet">
    <link rel="icon" type="image/x-icon" href="assets/images/logo_smk_nu_bodeh.png">
    <style>
        .glow {
          color: #fff;
          text-align: center;
          animation: glow 1s ease-in-out infinite alternate;
        }

        @-webkit-keyframes glow {
          from {
            text-shadow: 0 0 10px #fff, 0 0 20px #fff, 0 0 30px #00e676, 0 0 40px #00e676, 0 0 50px #00e676, 0 0 60px #00e676, 0 0 70px #00e676;
          }

          to {
            text-shadow: 0 0 20px #fff, 0 0 30px #33ff99, 0 0 40px #33ff99, 0 0 50px #33ff99, 0 0 60px #33ff99, 0 0 70px #33ff99, 0 0 80px #33ff99;
          }
        }
        </style>
</head>

<body
    style="font-family: 'Montserrat', sans-serif;background-image: url('assets/images/gradient.png');overflow-x: hidden;">

    @forelse ($siswas as $siswa)
    <div class="row">
        <div class="col-10 mx-auto my-5" style="">
            <div class="text-center mb-5">
                <h1 class="mb-4 text-white">SELAMAT DAN SUKSES !</h1>
                <a href="/lulus">
                    <img src="assets/images/logo_smk_nu_bodeh.png" width="150px" />
                </a>
                <h1 class="mt-4 text-white">{{$siswa->nama}}</h1>
                <h2 class="text-white">{{$siswa->nisn}}</h2>
                <h3 class="my-4 text-white">Peserta Didik Kelas XII {{$siswa->kelas}} SMK NU Bodeh Tahun Pelajaran 2022/2023</h3>
                <h3 class="my-4 text-white">Dinyatakan</h3>
                <div class="p-3 mb-4" style="background-color: #0A4D68">
                    <h1 class="my-0 glow">{{$siswa->keterangan}}</h1>
                </div>
                <a href="/assets/doc/SK Pengumuman Kelulusan.pdf" target="_BLANK">
                    <button class="btn btn-primary">Download SK Pengumuman Kelulusan</button>
                </a>
                <br />
                <a href="/lulus">
                    <button class="btn btn-warning mt-4">Kembali</button>
                </a>
            </div>
        </div>
    </div>
    @empty
    <div class="row">
        <div class="col-10 mx-auto my-5" style="">
            <div class="text-center mb-5">
                <h1 class="mb-4 text-white">DATA TIDAK DITEMUKAN</h1>
                <h3 class="mb-4 text-white">Pastikan anda memasukan NISN dengan benar</h3>
                <a href="/lulus">
                    <button class="btn btn-warning">Kembali</button>
                </a>
            </div>
        </div>
    </div>
    @endforelse
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
