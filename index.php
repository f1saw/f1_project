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
                        <li>
                            <a href="#"><img src=https://static.vecteezy.com/ti/vettori-gratis/p1/4568682-shop-open-line-icon-vettoriale.jpg" width="25" height="25"
                                    alt="Logo shop" style="position: relative; top: 5px"></a>
                        </li>
                        <!--Implementare scomparsa con js-->
                        <form class="d-flex d-lg-none" role="search">
                            <input class="form-control me-2" style="width: 100px;height: 30px" type="search" placeholder="Search" aria-label="Search">
                            <button class="btn btn-outline-success d-flex align-items-center justify-content-center" style="width: 50px;height: 30px; overflow:hidden; text-overflow: ellipsis;" type="submit">Go</button>
                        </form>
                    </ul>
                    <form class="d-none d-lg-flex" style="position: absolute; right:0;" role="search" name="search_bar">
                        <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
                        <button class="btn btn-outline-success" type="submit">Search</button>
                    </form>
                </div>
            </div>
        </div>
    </nav>

    <h2 style="font-family: Verdana">Welcome in f1 page</h2>

    <div id="Indicators" class="carousel slide" data-bs-ride="carousel">
        <div class="carousel-indicators">
            <button type="button" data-bs-target="#Indicators" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
            <button type="button" data-bs-target="#Indicators" data-bs-slide-to="1" aria-label="Slide 2"></button>
            <button type="button" data-bs-target="#Indicators" data-bs-slide-to="2" aria-label="Slide 3"></button>
        </div>
        <div class="carousel-inner">
            <div class="carousel-item active">
                <img src="images/wp9002050-4k-f1-desktop-wallpapers.jpg" class="d-block w-100" alt="...">
            </div>
            <div class="carousel-item">
                <img src="images/wp12074925-mercedes-formula-1-4k-wallpapers.jpg" class="d-block w-100" alt="...">
            </div>
            <div class="carousel-item">
                <img src="images/wp12405472-ferrari-f1-4k-wallpapers.jpg" class="d-block w-100" alt="...">
            </div>
        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#Indicators" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#Indicators" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
        </button>
    </div>
    <p style="text-align: left; font-family: 'Times New Roman'; font-size: 20px">
        On this site you will be able to analyze the circuits in which the grand prix are contested; for each circuit you can
        view the best times, the fastest laps in qualifying and the race for each season and the drivers who participated
        at the GP.
        <br>
        If you are an enthusiast you will also be able to access our online shop, where you will have the opportunity to buy
        gadgets, t-shirts, pants, hats and more!
    </p>

    <h3 style="font-family: Verdana">Information on formula 1</h3>
    <p style="text-align: left; font-family: 'Times New Roman'; font-size: 20px">
        Formula One is the highest class of international racing for open-wheel single-seater formula racing cars sanctioned by the Fédération Internationale de l'Automobile (FIA).
        The FIA Formula One World Championship has been one of the premier forms of racing around the world since its inaugural season in 1950.
        The word formula in the name refers to the set of rules to which all participants' cars must conform.
        A Formula One season consists of a series of races, known as Grands Prix.
        Grands Prix take place in multiple countries and continents around the world on either purpose-built circuits or closed public roads.
        <br>
        A points system is used at Grands Prix to determine two annual World Championships: one for the drivers, and one for the constructors (the teams).
        Each driver must hold a valid Super Licence, the highest class of racing licence issued by the FIA, and the races must be held on tracks graded "1",
        the highest grade-rating issued by the FIA for tracks.
        <br>
        Formula One cars are the fastest regulated road-course racing cars in the world, owing to very high cornering speeds achieved through generating large amounts of aerodynamic downforce.
        Much of this downforce is generated by front and rear wings, which have the side effect of causing severe turbulence behind each car.
        The turbulence reduces the downforce generated by the cars following directly behind, making it hard to overtake.
        Major changes made to the cars for the 2022 season have resulted in greater use of ground effect aerodynamics and modified wings to reduce the turbulence behind the cars,
        with the goal of making overtaking easier.[3] The cars are dependent on electronics, aerodynamics, suspension and tyres.
        Traction control, launch control, and automatic shifting, plus other electronic driving aids, were first banned in 1994.
        They were briefly reintroduced in 2001, and have more recently been banned since 2004 and 2008, respectively.
        <br>
        With the average annual cost of running a team – designing, building, and maintaining cars, pay, transport – being approximately £220,000,000 (or $265,000,000),
        its financial and political battles are widely reported. On 23 January 2017, Liberty Media completed its acquisition of the Formula One Group,
        from private-equity firm CVC Capital Partners for £6.4bn ($8bn).
    </p>

</main>
</body>
</html>