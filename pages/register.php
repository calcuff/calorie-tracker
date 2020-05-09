<?php
include "../actions/actions.php";
if (! empty($_POST["register-user"])) {
    $username = ($_POST["userName"]);
    $displayName = ($_POST["firstName"]);
    $password = ($_POST["password"]);
    $email = ($_POST["userEmail"]);
    echo $username;
    echo $displayName;
    echo $password;
    echo $email;

    $errorMessage = validateMember($username, $displayName, $password, $email);

    if (empty($errorMessage)) {
        $memberCount = ifMemberExists($username, $email);
        echo $memberCount;

        if ($memberCount == 0) {
            $retval = insertUser($username, $displayName, $password, $email);
            if(! empty($retval)){
                session_start();
                $_SESSION['loggedin'] = true;
                $_SESSION['username'] = $username;
                header("Location: index.php"); 
            }
        }
        else{
            $errorMessage[] = "User already exists.";
        }

    }
}
?>


<html>
<head>
<title>PHP User Registration Form</title>
<link href="../css/register.css" rel="stylesheet" type="text/css" />
<link href="../css/style.css" rel="stylesheet" type="text/css" />
</head>

<body style="background-image: url('../img/veggies.jpg');
    background-repeat: no-repeat;
    background-size: 100% ;">
    <!-- BEGIN navbar.php INCLUDE -->
    <?php include "../common/navbar.php"; ?>
    <!-- END navbar.php INCLUDE -->

    <form name="frmRegistration" method="post" action="">
        <div class="demo-table">
        <div class="form-head">Sign Up</div>
            
<?php
if (! empty($errorMessage) && is_array($errorMessage)) {
    ?>	
            <div class="error-message">
            <?php 
            foreach($errorMessage as $message) {
                echo $message . "<br/>";
            }
            ?>
            </div>
<?php
}
?>
            <div class="field-column">
                <label>Username</label>
                <div>
                    <input type="text" class="demo-input-box"
                        name="userName"
                        value="<?php if(isset($_POST['userName'])) echo $_POST['userName']; ?>">
                </div>
            </div>
            
            <div class="field-column">
                <label>Password</label>
                <div><input type="password" class="demo-input-box"
                    name="password" value=""></div>
            </div>
            <div class="field-column">
                <label>Confirm Password</label>
                <div>
                    <input type="password" class="demo-input-box"
                        name="confirm_password" value="">
                </div>
            </div>
            <div class="field-column">
                <label>Display Name</label>
                <div>
                    <input type="text" class="demo-input-box"
                        name="firstName"
                        value="<?php if(isset($_POST['firstName'])) echo $_POST['firstName']; ?>">
                </div>

            </div>
            <div class="field-column">
                <label>Email</label>
                <div>
                    <input type="text" class="demo-input-box"
                        name="userEmail"
                        value="<?php if(isset($_POST['userEmail'])) echo $_POST['userEmail']; ?>">
                </div>
            </div>
                <div>
                    <input type="submit"
                        name="register-user" value="Register"
                        class="btnRegister">
                </div>
            </div>
        </div>
    </form>
</body>
</html>