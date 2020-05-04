<?php
include "validate.php";
    if (! empty($_POST["logout-user"])) {
        session_start();
            $_SESSION['loggedin'] = false;
            $_SESSION['username'] = "";
            header("Location: index.php"); 
    }
    if (! empty($_POST["nologout-user"])) {
        header("Location: index.php"); 
    }
?>

<html>
    <head>
    <link rel="stylesheet" type="text/css" href="./css/style.css" />
    <link href="./css/register.css" rel="stylesheet" type="text/css" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    </head>
<body>
    <div class="topnav">
        <a class="active" href="#home">DailyHealthPLUS</a>
        <a href="index.php"><img src="img/Rectangle 3.png" height="42" width="42"></a>
        <a href="first.php"> <img src="img/Rectangle 5.png" height="42" width="42"></a>
        <a href="#about"><img src="img/Rectangle 6.png" height="42" width="42"></a>
        <a href="#about"><img src="img/Rectangle 7.png" height="42" width="42"></a>
        <a href="#about"><img src="img/Rectangle 4.png" height="42" width="42"></a>
        <div class="dropdown">
            <button class="dropbtn"><img src="img/Rectangle 5.png" height="42" width="42"></a>
            <i class="fa fa-caret-down"></i>
            </button>
            <div class="dropdown-content">
                <button style="width:200px">
                    <a href="login.php">Login</a>
                </button>
                <button style="width:200px">
                    <a href="register.php">Sign up</a>
                </button>
                <button style="width:200px">
                    <a href="logout.php">Logout</a>
                </button>
            </div>
        </div>
    </div>

    <div class="header1" style="color: white; background-color: #adaeb3; text-align: center;">
        <h2>Are you sure you want to log out?</h2>
       
    </div>

    <form name="frmRegistration" method="post" action="">
        <div class="demo-table">
        <div class="form-head">Logout</div>
        <br>

        <div>
            <input type="submit"
                    name="logout-user" value="Yes"
                    class="btnRegister">
        </div>
    <br>
        <div>
            <input type="submit"
                    name="nologout-user" value="No"
                    class="btnRegister">
        </div>

</form>



</body>
</html>
