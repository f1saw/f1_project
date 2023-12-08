<nav id="navbar" class="w-100 navbar navbar-expand-lg mb-3 mb-lg-0">
    <div class="container-fluid px-4">
        <a id="navbar-logo" class="navbar-brand px-5" href="/f1_project/views/public/index.php"></a>

        <button class="navbar-toggler text-light" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="material-symbols-outlined">menu</span>
        </button>

        <div class="collapse navbar-collapse d-lg-flex justify-content-lg-between align-items-center" id="navbarNav">
            <form class="d-none d-lg-flex" role="search" name="search_bar">
                <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
                <button class="btn btn-outline-danger" type="submit">Search</button>
            </form>

            <div class="navbar-nav d-flex flex-column align-items-end gap-4 flex-lg-row justify-content-lg-end gap-lg-5">
                <div class="d-flex flex-column align-items-end gap-4 flex-lg-row gap-lg-4 mt-4 mt-lg-0">
                    <div class="nav-item d-flex align-items-end">
                        <a href="#" class="my_outline_animation text-decoration-none hover-red d-flex align-items-end pb-2 gap-2">
                            <span class="material-symbols-outlined">shopping_bag</span>
                            <span>Store</span>
                        </a>
                    </div>


                    <style>
                        .pull-left {
                            float: left;
                        }

                        .icon-headernav {
                            color: #ff6200;
                            font-size: 16px;
                        }

                        .button-header {
                            cursor: pointer;
                        }


                        /*.notification-dot {
                            height: 6px;
                            width: 6px;
                            background-color: #525199;
                            border-radius: 50%;
                            border: 1px solid white;
                            display: inline-block;
                            position: relative;
                            top: -8px;
                            left: -8px;
                        } */

                        .notification-dot {
                            color: red;
                            width: fit-content;
                            font-size: 12px;
                            padding: 0;
                            margin: 0;
                            border: 0;
                        }
                    </style>
                    <div class="nav-item d-flex align-items-end">
                        <a href="#" class="my_outline_animation text-decoration-none hover-red d-flex align-items-end pb-2 gap-2">

                            <label id="cart-tooltip" onmouseover="Showtt(this, 1)" class="form-check-label mx-1 d-flex align-items-center justify-content-start gap-2" for="newsletter" data-bs-toggle="tooltip" data-bs-html="true" data-bs-placement="bottom" data-bs-trigger="manual" title="Shopping cart">
                                <span class="d-flex justify-content-center">
                                    <span class="material-symbols-outlined align-self-end">shopping_cart</span>
                                    <span id="cart-notification-dot" class="btn btn-circle notification-dot align-self-start"></span>
                                </span>
                                <span>Shopping cart</span>
                            </label>
                        </a>
                    </div>
                </div>

                <div class="d-flex gap-3">
                    <?php
                    [$login_allowed, $user] = check_cookie();
                    if (!check_user_auth($user)) {
                        set_session($user);?>
                        <li class="nav-item">
                            <a class="nav-link btn btn-danger text-light px-4 d-flex gap-2" href="/f1_project/views/public/login_form.php">
                                <span class="material-symbols-outlined">login</span>
                                <span>Login</span>
                            </a>
                        </li>
                        <li class="nav-item my_outline_animation">
                            <a class="nav-link text-light d-flex gap-2" href="/f1_project/views/public/registration_form.php">
                                <span class="material-symbols-outlined">how_to_reg</span>
                                <span>Registration</span>
                            </a>
                        </li>
                    <?php } else { ?>
                        <li class="nav-item">
                            <a class="my_outline_animation text-decoration-none hover-red d-flex align-items-end pb-2 gap-2" href="">

                                <?php if(isset($_SESSION["img_url"]) && $_SESSION["img_url"] != NULL){ ?>
                                    <img class="profile-img" src="<?php echo $_SESSION["img_url"]; ?>" alt="Profile">
                                <?php } else{ ?>
                                    <img class="profile-img" src="../../assets/images/foto-profilo.jpg" alt="Profile">
                                <?php }?>

                                <span>My profile</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="my_outline_animation text-decoration-none hover-red d-flex align-items-end pb-2 gap-2" href="../private/logout.php">
                                <span class="material-symbols-outlined">logout</span>
                                <span>Logout</span>
                            </a>
                        </li>
                    <?php } if (check_admin_auth($user)){ ?>
                        <li class="nav-item">
                            <a class="my_outline_animation text-decoration-none hover-red d-flex align-items-end pb-2 gap-2" href="../private/dashboard.php">
                                <span class="material-symbols-outlined">table_rows</span>
                                <span>Table users</span>
                            </a>
                        </li>
                    <?php } ?>
                </div>
                <form class="d-flex flex-row d-lg-none" role="search" name="search_bar">
                    <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
                    <button class="btn btn-outline-danger" type="submit">Search</button>
                </form>
            </div>
        </div>
    </div>
</nav>


<script src="/f1_project/assets/js/tooltip.js"></script>
<script>
    const curr_cart = JSON.parse(localStorage.getItem("cart"))
    if (curr_cart)
        $("#cart-notification-dot").text(curr_cart.length)
</script>
