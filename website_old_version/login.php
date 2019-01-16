<!DOCTYPE html>
<html>

<head>
    <title>Login</title>
    <?php include_once("templates/template_head.php") ?>
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