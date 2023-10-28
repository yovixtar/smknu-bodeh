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
    <div class="mx-auto text-center my-4">
        <h1 class="mb-4">Pelajaran Jarak Jauh - SMK NU Bodeh</h1>
        <a href="/pjj/login" class="btn btn-primary">Login Google</a>
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
