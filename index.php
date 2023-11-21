<!DOCTYPE html>
<html lang="en">
<head>
    <title>home</title>
    <link rel="stylesheet"
          href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css"
          integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65"
          crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL"
            crossorigin="anonymous">
    </script>
    <meta charset="UTF-8">
</head>
<body>
<main class="container-fluid text-center">
    <nav class="navbar navbar-expand-lg bg-light">
        <div class="container-fluid d-flex justify-content-end">
            <img style="position: absolute; left:0;" src="https://www.dinamikamente.net/wp-content/uploads/2017/11/nuovo-logo-formula-1.png" width="35" height="35"
                 alt="Logo f1">
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <div class="collapse navbar-collapse d-flex justify-content-center" id="navbarNav">

                    <ul class="navbar-nav">
                        <li class="nav-item">
                            <a class="nav-link active" aria-current="page" href="#">Circuit</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">Features</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">Login</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link disabled">Registration</a>
                        </li>
                        <!--Implementare scomparsa con js-->
                        <form class="d-flex d-lg-none" role="search">
                            <input class="form-control me-2" style="width: 100px;height: 30px" type="search" placeholder="Search" aria-label="Search">
                            <button class="btn btn-outline-success d-flex align-items-center justify-content-center" style="width: 50px;height: 30px; overflow:hidden; text-overflow: ellipsis;" type="submit">Go</button>
                        </form>
                    </ul>

                    <form class="d-none d-lg-flex" style="position: absolute; right:0;" role="search">
                        <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
                        <button class="btn btn-outline-success" type="submit">Search</button>
                    </form>
                </div>
            </div>
        </div>
    </nav>
    <h2>Welcome in f1 page</h2>
</main>
</body>
</html>