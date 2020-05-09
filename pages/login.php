<?php
include "../actions/actions.php";
if (! empty($_POST["login-user"])) {
    $username = ($_POST["userName"]);
    $password = ($_POST["password"]);

    $retval = isGoodCredentials($username, $password);
    if (! empty($retval)){
        session_start();
        $_SESSION['loggedin'] = true;
        $_SESSION['username'] = $username;
        header("Location: index.php"); 
    }
    else{
        ?>
        <div class="error-message">
        <?php
        echo "Invalid username/password";
        ?>
        </div>
        <?php
    }
}
?>

<html>
    <head>
    <link rel="stylesheet" type="text/css" href="../css/style.css" />
    <link rel="stylesheet" type="text/css" href="../css/register.css" />
    </head>
<body style="background-image: url('../img/veggies.jpg');
    background-repeat: no-repeat;
    background-size: 100% ;">
    <!-- BEGIN navbar.php INCLUDE -->
    <?php include "../common/navbar.php"; ?>
    <!-- END navbar.php INCLUDE -->
    
    <div class="header1" style="color: white; background-color: #adaeb3; text-align: center;">
        <h2>Welcome Back!</h2>
        New users click <a href="register.php">here</a> to create an account
    </div>

    <form name="frmLogin" method="post" action="">
        <div class="demo-table">
        <div class="form-head">
            Login
        </div>

        <div class="field-column">
            <label>Username</label>
            <div>
                <input type="text" class="demo-input-box" name="userName"
                    value="<?php if(isset($_POST['userName'])) echo $_POST['userName']; ?>">
            </div>
            </div>
            
            <div class="field-column">
                <label>Password</label>
                <div><input type="password" class="demo-input-box"
                    name="password" value=""></div>
            </div>

            <div>
                <input type="submit"
                    name="login-user" value="Login"
                    class="btnRegister">
            </div>
</form>



</body>
</html>
