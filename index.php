<?php
include "validate.php";
session_start();

if (! empty($_SESSION['username']) && $_SESSION['loggedin']==true) {
    $user = $_SESSION['username'];
    $date = date("m/d/Y");

    $goal_cals = getGoalCals($user);
    $food_cals = getDailyFoodCals($user, $date);
    $ex_cals = getDailyExerciseCals($user, $date);
  
    
}

if (! empty($_POST["caloriesadded"]) && ! empty($_SESSION['username']) && $_SESSION['loggedin']==true) {
    $username = $_SESSION['username'];
    $calories = $_POST['calorieInput'];
    $date = date("m/d/Y");

    // validate integer
    $errorMessage = validateNumber($_POST['calorieInput']);
    
    // if no error
    if (empty($errorMessage)) {
        // add the calories to DB
        $retval = insertCals($username, $calories, $date );

        if(! empty($retval)){
            echo "Added calories";
        }
    }

}


if (! empty($_POST["exerciseadded"])  && ! empty($_SESSION['username']) && $_SESSION['loggedin']==true) {
    // validate integer
    $errorMessage = validateNumber($_POST['exerciseInput']);

    $username = $_SESSION['username'];
    $calories = $_POST['exerciseInput'];
    $date = date("m/d/Y");

    // if no error
    if (empty($errorMessage)) {
        // add the calories to DB
        $retval = insertExerciseCals($username, $calories, $date );

        if(! empty($retval)){
            echo "Added exercise";
        }
    }
}
?>



<html>
    <head>
    <link rel="stylesheet" type="text/css" href="./css/style.css" />
    <link href="./css/register.css" rel="stylesheet" type="text/css" />
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <script type="text/javascript">
        window.onload = function(){
            var cals = parseInt('<?php echo $goal_cals?>');
            var food_cals = parseInt('<?php echo $food_cals?>');
            var ex_cals = parseInt('<?php echo $ex_cals?>');
            var remain = cals - food_cals + ex_cals;

            document.getElementById("total").innerHTML = cals;
            document.getElementById("food").innerHTML = food_cals;
            document.getElementById("exercise").innerHTML = ex_cals;
            document.getElementById("remain").innerHTML = remain;
        }
    </script>

    </head>
<body>
    <!-- BEGIN navbar.php INCLUDE -->
    <?php include "./navbar.php"; ?>
    <!-- END navbar.php INCLUDE -->

    <div style="margin: 20px; padding-left:16px; background-color:#adaeb3; color:white">
        <h2>Be your best self today</h2>
        <a href="login.php">Login</a> or 
        <a href="register.php">Signup</a> to start tracking calories Today!
        <p id="content">Some content..</p>
    </div>

    <div style="margin: 20px; padding-left:16px; font-size:24px; border-style: groove;">
    <h2>
        <?php
        if(! empty($_SESSION['username']) && $_SESSION['loggedin']==true){
            echo "Welcome back, "; 
            echo $_SESSION['username'];
            
        }
    ?>
    </h2>
        <h2 >Calories remaining</h2>
        <table>
            <tr style="font-size: 24px;">
                <td  style="padding-left:100px; width:75px;">
                    <p id="total">2000</p>
                </td>
                <td style="width: 25px;"> - </td>
                <td style="width: 65px;"> 
                    <p id="food"> 0 </p>
                </td>
                <td style="width: 25px;"> + </td>
                <td style="width: 75px;">
                    <p id="exercise">0</p>
                </td>
                <td style="width: 25px;">=</td>
                <td style="color: green;">
                    <p id="remain">2000 </p>
                </td>
            </tr>
            <tr style="font-size: 18px;">
                <td style="padding-left:100px;">Goal</td>
                <td></td>
                <td >Food </td>
                <td></td>
                <td >Exercise </td>
                <td > </td>
                <td style="color: green;">Remaining </td>
            </tr>
        </table>
    </div>

    <form name="frmCalories" method="post" action="">
    <div class="demo-table" style="width:500px">
        <div class="form-head">Add food</div>
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
            <label>Add Food</label>
                <div>
                    <input type="text" class="demo-input-box"
                        name="calorieInput"
                        value="<?php if(isset($_POST['calorieInput'])) echo $_POST['calorieInput']; ?>">
                </div>
        </div>
        <div>
            <input type="submit"
                name="caloriesadded" value="Add"
                class="btnRegister">
        </div>
    </div>
    </form>


    <form name="frmExercise" method="post" action="">
    <div class="demo-table" style="width:500px">
        <div class="form-head">Add exercise</div>
        <div class="field-column">
            <label>Add Exercise</label>
                <div>
                    <input type="text" class="demo-input-box"
                        name="exerciseInput"
                        value="<?php if(isset($_POST['exerciseInput'])) echo $_POST['exerciseInput']; ?>">
                </div>
        </div>
        <div>
            <input type="submit"
                name="exerciseadded" value="Add"
                class="btnRegister">
        </div>
    </div>
    </form>

</body>
</html>
