<?php
include "../actions/actions.php";
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
    <link rel="stylesheet" type="text/css" href="../css/style.css" />
    <link href="../css/register.css" rel="stylesheet" type="text/css" />
    </head>
<body style="background-image: url('../img/veggies.jpg');
    background-repeat: no-repeat;
    background-size: 100% ;">
    
    <!-- BEGIN navabr.php INCLUDE -->
    <?php include "../common/navbar.php"; ?>
    <!-- END navbar.php INCLUDE -->

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
