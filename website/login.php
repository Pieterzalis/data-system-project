<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible"
          content="IE=edge">
    <title>Login</title>
    <meta name="viewport"
          content="width=device-width, initial-scale=1">
    <link rel="stylesheet"
          type="text/css"
          media="screen"
          href="assets/style.css" />
    <link rel="stylesheet"
          type="text/css"
          media="screen"
          href="bootstrap/css/bootstrap.min.css" />
    <link rel="stylesheet"
          href="assets/icon-font/css/font-awesome.min.css">

    <script src="https://cdn.bootcss.com/jquery/3.2.1/jquery.slim.min.js"
            integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN"
            crossorigin="anonymous"></script>

    <script src="https://cdn.bootcss.com/popper.js/1.12.9/umd/popper.min.js"
            integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q"
            crossorigin="anonymous"></script>

    <script src="assets/js/index.js"></script>
    <script src="bootstrap/js/bootstrap.min.js"></script>

</head>

<body class="page_login">
    <!-- 此处显示demo图作为参考 -->
    <div class="demopage hidden">
        <img src="assets/demo/login.png"
             alt="">
    </div>
    <div class="container">
        <div class="row justify-content-md-center">
            <div class="col-sm-12 col-md-7 col-lg-6 col-xl-5">
                <div class="login-form">
                    <div class="logo">
                        <img src="assets/img/logo.png"
                             alt="">
                    </div>
                    <form>
                        <h1 class="text-center title">Log in</h1>
                        <div class="form-group row">
                            <label for="inputUser"
                                   class="col-sm-6 col-form-label">
                                <i class="fa fa-user-circle"
                                   aria-hidden="true"></i>
                                Gebruikersnaam
                            </label>
                            <div class="col-sm">
                                <input type="text"
                                       class="form-control"
                                       id="inputUser"
                                       placeholder="">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="inputPassword"
                                   class="col-sm-6 col-form-label">
                                <i class="fa fa-lock"
                                   aria-hidden="true"></i>
                                Wachtwoord
                            </label>
                            <div class="col-sm">
                                <input type="password"
                                       class="form-control"
                                       id="inputPassword"
                                       placeholder="">
                            </div>
                        </div>
                        <div class="form-group row flex-column">
                            <label for="inputPassword"
                                   class="col-sm-12 col-form-label align-self-end text-right">
                                <a href="">Wachtwoord vergeten?</a>
                            </label>
                        </div>
                        <div class="form-group row justify-content-center">
                            <a href="search_engine"
                               class="btn btn-lg btn-outline-dark">Log in</a>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>

</body>

</html>