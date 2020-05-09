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


if (! empty($_POST["apply-food"]) && ! empty($_SESSION['username']) && $_SESSION['loggedin']==true) {
    $username = $_SESSION['username'];
    $calories = $_POST['apply-food'];
    $date = date("m/d/Y");

    // validate integer
    $errorMessage = validateNumber($_POST['apply-food']);
    
    // if no error
    if (empty($errorMessage)) {
        // add the calories to DB
        $retval = insertCals($username, $calories, $date );

        if(! empty($retval)){
            echo 'added calories';
        }
    }
    header("Location: food_dict.php");

}

if (! empty($_POST["delete-food"]) && ! empty($_SESSION['username']) && $_SESSION['loggedin']==true) {
    $username = $_SESSION['username'];
    $id = $_POST['delete-food'];

    $retval = deleteFood($username, $id);

    // if no error
    if(! empty($retval)){
        echo 'deleted food';
    }

    header("Location: food_dict.php");
}
?>

<html>
    <head>
    <link rel="stylesheet" type="text/css" href="../css/style.css" />
    <link href="../css/register.css" rel="stylesheet" type="text/css" />
    <link href="../css/popup.css" rel="stylesheet" type="text/css" />

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
<body style="background-image: url('../img/fruits.jpg');
    background-repeat: no-repeat;
    background-size: 100% 100%;
    background-position: 0% 0%;">

    <!-- BEGIN navabr.php INCLUDE -->
    <?php include "../common/navbar.php"; ?>
   
    <div class="title" style="border-style: groove; background-color:white; opacity:0.8;">
    <!-- BEGIN navbar.php INCLUDE -->
    <?php include "../common/dailyheader.php"; ?>
    </div>
    
    <div class="title" style="background-color:white; opacity:0.6; color: blue; width: 200px" >
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
            <input type="text" class="search-box" id="searchInput" onkeyup="search()" placeholder="Search for food.." title="Type in a name">
            </td>
            <td>
                <div class="container" style="margin-left:150px">
                    <button class="open-button" onclick="openForm()">ADD NEW FOOD</button>
                </div>
            </td>
        </tr>
    </table>
    <br><br/>

    <table class="table1" id="foodTable">
        <tr>
            <th>ID</th>
            <th>Food</th>
            <th>Serving size</th>
            <th>Description</th>
            <th>Calories</th>
            <th>Edit</th>
        </tr>
        <?php getFoodDictionary($_SESSION['username']); ?>
    </table>
    <br><br/><br><br/>

    <script>

    function openForm() {
    document.getElementById("myForm").style.display = "block";
    }

    function closeForm() {
    document.getElementById("myForm").style.display = "none";
    }

    function search() {
    var input, filter, table, tr, td, i, txtValue;
    input = document.getElementById("searchInput");
    filter = input.value.toUpperCase();
    table = document.getElementById("foodTable");
    tr = table.getElementsByTagName("tr");
    for (i = 0; i < tr.length; i++) {
        td = tr[i].getElementsByTagName("td")[1];
        if (td) {
        txtValue = td.textContent || td.innerText;
        if (txtValue.toUpperCase().indexOf(filter) > -1) {
            tr[i].style.display = "";
        } else {
            tr[i].style.display = "none";
        }
        }       
    }
    }
    </script>

</body>
</html>    
