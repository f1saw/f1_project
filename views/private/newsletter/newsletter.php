<?php
if (!set_include_path("{$_SERVER['DOCUMENT_ROOT']}"))
    error("500", "set_include_path()");
?>
<!DOCTYPE html>
<html lang="en">
<!--xmlns="http://www.w3.org/1999/html"-->
<head>
    <title>Newsletter</title>
    <meta charset="UTF-8">

    <link rel="stylesheet" href="/f1_project/assets/css/style.css">

    <?php include("views/partials/head.php"); ?>
    <?php require_once("auth/auth.php") ?>
    <style>
        main {
            max-width: 90%;
            margin: auto;
        }

        .flex-container {
            position: relative;
            height: 85vh;
            width: 100%;
            display: -webkit-flex;
            display: flex;
            overflow: hidden;
            border-radius: 10px;
        }

        .container-element{
            position: relative;
            backdrop-filter: blur(5px);
            max-height: 55%;
            width: 40%;
            height: 100%;
            border-radius: 10px;
            top: 100px;
            border-style: solid;
            border-color: #ff1300;
            overflow: auto;
            overflow-x: hidden;
        }

        .container-element::-webkit-scrollbar {
            width: 0;
        }

        .text-box{
            margin-left: 20px;
            margin-right: 20px;
        }

        #button {
            position: relative;
            bottom: -30px;
        }

        #newsletter {
            position: relative;
            top: 12px;
        }
    </style>
</head>

<?php if(session_status() == PHP_SESSION_NONE) session_start(); ?>

<body class="bg-dark">
    <div class="container-fluid">

        <!-- Nav -->
        <?php include("views/partials/navbar.php");?>
        <main>
            <div class="flex-container d-flex justify-content-center">
                <div class="container-element">
                    <form id="newsletter" action="send_email.php" method="post">
                        <span class="d-flex justify-content-center">
                            <label for="subject" class="form-label" >Subject</label>
                        </span>
                        <div class="input-group">
                            <textarea class="form-control text-box" id="subject" name="subject" rows="1" cols="50"></textarea>
                        </div>
                        <br>
                        <span class="d-flex justify-content-center">
                            <label for="text" class="form-label" >Text email</label>
                        </span>
                        <div class="input-group">
                            <textarea class="form-control text-box" id="text" name="text" rows="5" cols="50"></textarea>
                        </div>
                        <div class="row mb-3 d-flex justify-content-center button">
                            <button id="button" type="submit" class="btn btn-danger col-6 col-sm-6 col-md-5 d-flex align-items-center justify-content-center">Send</button>
                        </div>
                    </form>
                </div>
            </div>
        </main>
    </div>
</body>
</html>
