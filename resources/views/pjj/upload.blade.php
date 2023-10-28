<!DOCTYPE html>
<html>

<head>
    <title>Pelajaran Jarak Jauh</title>
    <link rel="icon" type="image/x-icon" href="assets/images/logo_smk_nu_bodeh.png">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400;500;600;700;800;900&display=swap"
        rel="stylesheet">

    <!-- Bootstrap core CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-aFq/bzH65dt+w6FI2ooMVUpc+21e0SRygnTpmBvdBgSdnuTN7QbdgL+OapgHtvPp" crossorigin="anonymous">
</head>

<body>
    <div class="row">
        <div class="col-10 mx-auto text-center my-4">
            <h1>Pelajaran Jarak Jauh - SMK NU Bodeh</h1>
            @if (session('success'))
                <p>{{ session('success') }}</p>
            @endif

            @if (session('error'))
                <p>{{ session('error') }}</p>
            @endif
        </div>
        <div class="col-11 mx-auto mb-5">
            <div class="container">
                <h2 class="mb-4">Upload File</h2>
                <form id="upload-form" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group mb-3">
                        <label for="kelas">Kelas:</label>
                        <select class="form-control" id="kelas" name="kelas">
                            <option value="X AKL">Kelas X AKL</option>
                            <option value="X TJKT">Kelas X TJKT</option>
                            <option value="X TO">Kelas X TO</option>
                            <option value="XI AKL">Kelas XI AKL</option>
                            <option value="XI TBSM">Kelas XI TBSM</option>
                            <option value="XI TKJ">Kelas XI TKJ</option>
                            <option value="XI TKRO">Kelas XI TKRO</option>
                        </select>
                    </div>
                    <div class="form-group mb-3">
                        <label for="hari">Hari:</label>
                        <select class="form-control" id="hari" name="hari">
                            <option value="Senin, 3 April">Senin, 3 April</option>
                            <option value="Selasa, 4 April">Selasa, 4 April</option>
                            <option value="Rabu, 5 April">Rabu, 5 April</option>
                            <option value="Kamis, 6 April">Kamis, 6 April</option>
                            <option value="Senin, 10 April">Senin, 10 April</option>
                            <option value="Selasa, 11 April">Selasa, 11 April</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="file">File: <br /><span class="text-danger">Pastikan nama file memiliki format : NamaMapel_NamaMateri_NamaGuru</span></label>
                        <input type="file" class="form-control mt-3" id="file" name="file">
                    </div>
                    <button type="submit" class="btn btn-primary mt-4">Upload</button>
                    <a href="/pjj/guru" class="btn btn-warning mt-4">Kembali</a>
                </form>
            </div>
        </div>

    </div>

    <script>
        document.getElementById('upload-form').addEventListener('submit', function(event) {
            const kelas = document.getElementById('kelas').value;
            const hari = document.getElementById('hari').value;
            this.action = `/pjj/upload-file/${kelas}/${hari}`;
        });
    </script>


    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-qKXV1j0HvMUeCBQ+QVp7JcfGl760yU08IQ+GpUo5hlbpg51QRiuqHAJz8+BrxE/N" crossorigin="anonymous">
    </script>
</body>

</html>
