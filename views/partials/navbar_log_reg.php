<style>
    ul {
        padding: 0 !important;
        position: absolute;
        right: 0;
    }

    @media screen and (max-width: 768px){
        ul {
            top: 11px;
        }
    }

    @media screen and (max-width: 350px){
        ul {
            position: relative;
        }
    }
</style>

<nav id="navbar" class="w-100 navbar">
    <div class="container-fluid px-4">
        <a id="navbar-logo" class="navbar-brand px-5" href="/f1_project/views/public/index_news.php"></a>
        <div style="padding-left: 0" class="d-md-flex justify-content-end align-items-center">
            <ul class="navbar-nav mb-2 mb-lg-0 p-2 d-flex flex-row gap-5">
                <li class="nav-item" style="position: relative; right: -40px;">
                    <a href="/f1_project/views/public/who.php" class="my_outline_animation p-2 text-decoration-none text-white d-flex align-items-center justify-content-center gap-2">
                        <span class="material-symbols-outlined text-danger">groups</span>
                        Chi siamo
                    </a>
                </li>
                <li class="nav-item">
                    <a href="/f1_project/views/public/where.php" class="my_outline_animation p-2 text-decoration-none text-white d-flex align-items-center justify-content-center gap-2">
                        <span class="material-symbols-outlined text-danger">map</span>
                        Dove
                    </a>
                </li>
            </ul>
        </div>
    </div>
</nav>