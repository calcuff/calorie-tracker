<?php
include "../actions/actions.php";
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
            // echo "<script type='text/javascript'>alert('Added calories!');</script>";
            echo 'added calories';
        }
    }
    header("Location: index.php");

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
            // echo "<script type='text/javascript'>alert('Added exercise calories!');</script>";
            echo 'added exercise';
        }
    }
    header("Location: index.php");
}
?>



<html>
    <head>
    <link rel="stylesheet" type="text/css" href="../css/style.css" />
    <link href="../css/register.css" rel="stylesheet" type="text/css" />
   
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
<body style="background-image: url('../img/veggies.jpg');
    background-repeat: no-repeat;
    background-size: cover ;">
    <!-- BEGIN navbar.php INCLUDE -->
    <?php include "../common/navbar.php"; ?>
    <!-- END navbar.php INCLUDE -->
    
    <br><br/>

    <div style="margin: 20px; padding-left:16px; font-size:24px; border-style: groove; background-color:white; opacity:0.8;">
    <h2>
        <?php
        if(! empty($_SESSION['username']) && $_SESSION['loggedin']==true){
            echo "Welcome back, "; 
            echo $_SESSION['username'];
            
        }
        else{
            echo '
                <h2>Be your best self today</h2>
                <a href="login.php">Login</a> or 
                <a href="register.php">Signup</a> to start tracking calories Today!
                ';
        }
    ?>
    </h2>
        <!--- BEGIN dailyheader.php -->
      <?php include "../common/dailyheader.php"; ?>
    </div>

    <br><br/>
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

    <br><br/>
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

    <br><br/><br><br/>

</body>
</html>
