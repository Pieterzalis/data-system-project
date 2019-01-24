<?php
session_start();
require_once 'database/Model_User.php';


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['username']) && isset($_POST['password']) && !empty($_POST['username']) && !empty($_POST['password'])) {

        $mysqli = DB::get();
        $myusername = mysqli_real_escape_string($mysqli, $_POST['username']);
        $mypassword = mysqli_real_escape_string($mysqli, $_POST['password']);

        // Query to check the given username and password and match with accounts in DB
        // Note this is not very secure!
        $sql = "SELECT `user_id`, `user_role_id`, user_firstname, user_lastname_prefix, user_lastname
                FROM `user`
                WHERE `user_username` = '$myusername' 
                AND `user_password` = '$mypassword'";
        $result = DB::query($sql);
        $count = DB::count();

        if ($count === 1){

            $user_fullname = '';
            if (is_null($result[0]["user_lastname_prefix"])) {
                $user_fullname = $result[0]["user_firstname"] . ' ' . $result[0]["user_lastname"];
            } else {
                $user_fullname = $result[0]["user_firstname"] . ' ' . $result[0]["user_lastname_prefix"] . ' ' . $result[0]["user_lastname"];
            }
            // Found a user with this username and password
            if (isUserExpert($result[0]["user_id"])) {
                // User is an expert, redirect to question overview page
                $_SESSION['login_username'] = $myusername;
                $_SESSION['login_fullname'] = $user_fullname;
                $_SESSION['login_id'] = $result[0]["user_id"];
                header("location: overzicht.php");
            } else {
                // User is a different role, do nothing now.
                $_SESSION['login_username'] = $myusername;
                $_SESSION['login_fullname'] = $user_fullname;
                $_SESSION['login_id'] = $result[0]["user_id"];
                header("location: distribution-main.php");
            }
        } else {
            // Did not found a user or a single user
            $error = "Uw gebruikersnaam of wachtwoord is ongeldig";
        }
    }
}


?>

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
                    <div class="row logorow justify-content-center">
                        <div class="logo justify-content-center">
                            <img src="assets/img/logologin.jpg"
                                 alt="">
                        </div>
                    </div>
                    <div class="row justify-content-center">
                        <div class="formcontainer">
                            <form action="" method="post">
                                <h1 class="text-center title">Log in</h1>
                                <div class="form-group row">
                                    <label for="inputUser"
                                           class="col-sm-1 col-form-label text-center">
                                        <i class="fa fa-user-circle"
                                           aria-hidden="true"></i>
                                    </label>
                                    <div class="col-sm">
                                        <input type="text"
                                               class="form-control"
                                               id="inputUser"
                                               name="username"
                                               placeholder="Gebruikersnaam">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="inputPassword"
                                           class="col-sm-1 col-form-label">
                                        <i class="fa fa-lg fa-lock"
                                           aria-hidden="true"></i>
                                    </label>
                                    <div class="col-sm">
                                        <input type="password"
                                               class="form-control"
                                               id="inputPassword"
                                               name="password"
                                               placeholder="Wachtwoord">
                                    </div>
                                </div>
                                <div class="form-group row flex-column">
                                    <label for="inputPassword"
                                           class="col-sm-12 col-form-label align-self-end text-right">
                                    </label>
                                </div>
                                <?php if (!empty($error)) { ?>
                                <div class="justify-content-center" style ="color:#cc0000; margin:10px 0 10px 0"><?php echo $error; ?></div>
                                <?php } ?>
        
                                <div class="form-group row justify-content-center">
                                    <input class="btn btn-lg btn-outline-dark" type = "submit" value = "Log in "/>
<!--                                    <a type="submit" class="btn btn-lg btn-outline-dark">Log in</a>-->
                                </div>
        
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</body>

</html>