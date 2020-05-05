<?php
include "validate.php";
// include "foodactions.php";
session_start();

if (! empty($_SESSION['username']) && $_SESSION['loggedin']==true) {
    $user = $_SESSION['username'];
    $date = date("m/d/Y");

    $goal_cals = getGoalCals($user);
    $food_cals = getDailyFoodCals($user, $date);
    $ex_cals = getDailyExerciseCals($user, $date);
}

if (! empty($_POST["foodsearched"]) && ! empty($_SESSION['username']) && $_SESSION['loggedin']==true) {
    $username = $_SESSION['username'];
    $foodName = $_POST['foodSearchInput'];
    echo $foodName;
    // $date = date("m/d/Y");

    // // validate integer
    // $errorMessage = validateNumber($_POST['calorieInput']);
    
    // // if no error
    // if (empty($errorMessage)) {
    //     // add the calories to DB
    //     $retval = insertCals($username, $calories, $date );

    //     if(! empty($retval)){
    //         echo "Added calories";
    //     }
    // }

}

if(! empty($_POST["add-food"])){
    $username = $_SESSION['username'];
    $foodname = $_POST['foodname'];
    $size = $_POST['size'];
    $calories = $_POST['calories'];
    $description = $_POST['description'];

    $retval = addFood($username, $foodname, $size, $calories, $description);
        if(! empty($retval)){
            echo "Added food";
        }
        header("Location: food_dict.php");
}
?>

<html>
    <head>
    <link rel="stylesheet" type="text/css" href="./css/style.css" />
    <link href="./css/register.css" rel="stylesheet" type="text/css" />
    <link href="./css/popup.css" rel="stylesheet" type="text/css" />
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
    <!-- BEGIN navabr.php INCLUDE -->
    <?php include "./navbar.php"; ?>
    <!-- END navbar.php INCLUDE -->

    <div class="title" style="border-style: groove;">
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
    
    <div class="title" style="color: blue" >
    <h2 >My Foods</h2></div>

    <div class="form-popup" id="myForm">
        <form name="frmFoodAdd" method="post" action="" class="form-container">
            <h1>Add Food</h1>

            <label for="foodname"><b>Food</b></label>
            <input type="text" placeholder="Enter food name" name="foodname" required
            value="<?php if(isset($_POST['foodname'])) echo $_POST['foodname']; ?>">

            <label for="size"><b>Serving Size</b></label>
            <input type="text" placeholder="Enter serving size" name="size" required
            value="<?php if(isset($_POST['size'])) echo $_POST['size']; ?>">

            <label for="calories"><b>Calories</b></label>
            <input type="number" placeholder="Enter calories" name="calories" required
            value="<?php if(isset($_POST['calories'])) echo $_POST['calories']; ?>">
             
            <br><br/>
            <label for="description"><b>Description</b></label>
            <input type="text" placeholder="Enter brief description" name="description"
            value="<?php if(isset($_POST['description'])) echo $_POST['description']; ?>">

            <div>
                <input type="submit"
                    name="add-food" value="Add"
                    class="btnRegister">
            </div>
            <br/>
            <button type="button" class="btn cancel" onclick="closeForm()" name="add-food">Cancel</button>
        </form>
    </div>
    
    <table >
        <tr>
            <td>
                <form name="frmFoodSearch" method="post" action="">
                    <div class="demo-table" style="width:500px; margin-left: 100px;">
                        <div class="form-head">Search For Existing Food</div>
                        <div class="field-column">
                            <input type="text" class="search-box"
                                name="foodSearchInput"
                                value="<?php if(isset($_POST['foodSearchInput'])) echo $_POST['foodSearchInput']; ?>">
                            <input type="submit"
                                style="width: 85px;"  
                                name="foodsearched" 
                                value="Search"
                                class="btnRegister">
                        </div>
                    </div>
                </form>
            </td>
            <td>
                <div class="container" style="margin-left:50px">
                    <button class="open-button" onclick="openForm()">ADD NEW FOOD</button>
                </div>
            </td>
        </tr>
    </table>

    <table class="table1">
        <tr>
            <th>Food</th>
            <th>Serving size</th>
            <th>Calories</th>
            <th>Description</th>
            <th>Apply</th>
            <th>Edit</th>
        </tr>
        <?php getFoodDictionary($_SESSION['username']); ?>
    </table>
    <script>

function openForm() {
  document.getElementById("myForm").style.display = "block";
}

function closeForm() {
  document.getElementById("myForm").style.display = "none";
}
</script>

    </body>
</html>    
