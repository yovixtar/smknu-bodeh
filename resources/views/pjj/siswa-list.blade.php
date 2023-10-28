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
    </div>
    <div class="container mb-4">
        <div class="row">
            <div class="col-md-12">
                <a href="/pjj/logout" class="btn btn-danger mb-4">Logout</a>
                <h1>Daftar File Materi</h1>
                <ul class="list-group">
                    @foreach ($fileGroups as $class => $fileGroup)
                        <li class="list-group-item">
                            <strong>{{ $class }}</strong>
                            <ul>
                                @foreach ($fileGroup as $day => $files)
                                    <li>
                                        {{ $day }}
                                        <ul>
                                            @foreach ($files as $file)
                                                <li><a href="{{ $file['link'] }}"
                                                        target="_blank">{{ $file['name'] }}</a></li>
                                            @endforeach
                                        </ul>
                                    </li>
                                @endforeach
                            </ul>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-qKXV1j0HvMUeCBQ+QVp7JcfGl760yU08IQ+GpUo5hlbpg51QRiuqHAJz8+BrxE/N" crossorigin="anonymous">
    </script>
</body>

</html>
