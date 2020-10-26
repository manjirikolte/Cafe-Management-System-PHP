<!doctype html>
<html>

<head>
    <title>CAFE </title>
    <!-- Bootstrap CDN -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css"
        integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <!-- Custom Css -->
    <link rel="stylesheet" type="text/css" href="./css/login-page.css">

</head>

<body>
    <header>

        <div class="main-content-header">
            <div class="container">
                <div class="row">
                    <div class="col-6 my-5">
                        <div class="row py-4">
                            <div class="col-2">
                                <img src="./logo.png" height="50" width="50" alt="">
                            </div>
                            <div class="col-4">
                                <h2 class="text-white">CAFE TIME</h2>
                            </div>

                        </div>

                        <h1>WELCOME TO <span class="colorchange"> CAFE TIME</span><br>
                            HOUSE OF CAKE LOVERS OO YES</H1>


                    </div>
                    <div class="col-4 ">

                        <!-- PHP CODE START -->
                        <form action="login.php" method="post">
                            <div class="blurred-box">
                                 <!-- Error Code -->
                                <?php if (isset($_GET['error'])) { ?>
                                <p class="error"><?php echo $_GET['error']; ?></p>
                                <?php } ?>
                                <!-- Error Code -->
                                <h2 class="m-3 text-white"> Admin Login</h2>
                                <div class="p-4 mx-4" style="width: 80%;">
                                    <input type="text" name="uname" class="form-control" placeholder="Username">
                                    <div class="my-4">
                                        <input type="password" name="password" class="form-control"
                                            placeholder="Password">
                                    </div>
                                </div>

                                <button type="submit" class="login-btn text-center mx-5 mb-5">
                                    <span class=""> LOGIN </span>
                                </button>

                            </div>
                        </form>
                    <!-- PHP CODE END -->

                    </div>
                </div>
            </div>


        </div>
    </header>

</body>

</html>