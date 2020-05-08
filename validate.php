<?php

include 'db_connection.php';
$conn = OpenConn();


function validateMember()
{
    $valid = true;
    $errorMessage = array();
    foreach ($_POST as $key => $value) {
        if (empty($_POST[$key])) {
            $valid = false;
        }
    }
    
    if($valid == true) {
        if ($_POST['password'] != $_POST['confirm_password']) {
            $errorMessage[] = 'Passwords should be same.';
            $valid = false;
        }
        
        if (! isset($error_message)) {
            if (! filter_var($_POST["userEmail"], FILTER_VALIDATE_EMAIL)) {
                $errorMessage[] = "Invalid email address.";
                $valid = false;
            }
        }
    }
    else {
        $errorMessage[] = "All fields are required.";
    }
    
    if ($valid == false) {
        return $errorMessage;
    }
    return;
}

function ifMemberExists($username, $email)
    {
        $conn = OpenConn();
        
        $query = "SELECT * FROM Users WHERE username = '".$username."' OR email = '".$email."'";
        $result = $conn->query($query);
        $memberCount = $result->num_rows;

        return $memberCount;
    }

function insertUser($username, $displayName, $password, $email){
    $conn = OpenConn();
    $query = "INSERT INTO Users (username, display_name, password, email) VALUES ('".$username."', '".$displayName."', '".$password."', '".$email."')";
    $result = $conn->query($query);

    return $result;
}

function isGoodCredentials($username, $password){
    $conn = OpenConn();
    $query = "SELECT * FROM Users WHERE username = '".$username."' AND password = '".$password."'";
    $result = $conn->query($query);
    $memberCount = $result->num_rows;

    return $memberCount;
}

function validateNumber($input){
    $valid = true;
    $errorMessage = array();
    if (! filter_var($input, FILTER_VALIDATE_INT)) {
        $errorMessage[] = "Invalid number input";
        $valid = false;
    }

    if ($valid == false) {
        return $errorMessage;
    }

    return;
}

function insertCals($username, $calories, $date){
    $conn = OpenConn();
    $query = "INSERT INTO Calories (username, calorie_amt, date) VALUES ('".$username."', '".$calories."', '".$date."')";
    $result = $conn->query($query);

    return $result;
}

function insertExerciseCals($username, $calories, $date){
    $conn = OpenConn();
    $query = "INSERT INTO exercise_cals (username, calorie_amt, date) VALUES ('".$username."', '".$calories."', '".$date."')";
    $result = $conn->query($query);

    return $result;
}

function getGoalCals($username){
    $conn = OpenConn();
    $query = "SELECT goal_calories FROM goals WHERE username = '".$username."'";
    $result = $conn->query($query);
    
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $cals =  $row["goal_calories"];
        }
    } else {
        echo "0 results";
    }

    return $cals;
}

function getDailyFoodCals($username, $date){
    $conn = OpenConn();
    $query = "SELECT calorie_amt FROM calories WHERE username = '".$username."' AND date = '".$date."'";
    $result = $conn->query($query);

    $food_cals = 0;

    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $food_cals +=  $row["calorie_amt"];
        }
    }

    return $food_cals;

}

function getDailyExerciseCals($username, $date){
    $conn = OpenConn();
    $query = "SELECT calorie_amt FROM exercise_cals WHERE username = '".$username."' AND date = '".$date."'";
    $result = $conn->query($query);

    $ex_cals = 0;

    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $ex_cals +=  $row["calorie_amt"];
        }
    }

    return $ex_cals;
}

function getFoodDictionary($username){
    $conn = OpenConn();
    $query = "SELECT * FROM foods WHERE username = '".$username."'";
    $result = $conn->query($query);

    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $id = $row["id"];
            $foodname =  $row["food_name"];
            $size =  $row["size"];
            $calories =  $row["calories"];
            $descr =  $row["descriptiom"];


                echo '
                <tr id="'.$foodname.'">
                <form class="table1" name="frmDict" method="post" action="">
                <td><div contenteditable>'.$id.'</div></td>
                <td >'.$foodname.'</td> 
                <td>'.$size.'</td> 
                <td>'.$descr.'</td> 
                <td><input class="apply-btn" type="submit" name="apply-food" value="'.$calories.'">Apply Today</input></td> 
                <td><input class="apply-btn" type="submit" name="delete-food" value="'.$id.'">Delete</input></td> 
                </form>
                </tr>'
               ;
        }
    }
}

function addFood($username, $food_name, $size, $calories, $description){
    $conn = OpenConn();
    $query = "INSERT INTO foods (username, food_name, size, calories, descriptiom) VALUES ('".$username."','".$food_name."', '".$size."', '".$calories."', '".$description."')";
    $result = $conn->query($query);

    return $result;
}

function deleteFood($username, $id){
    $conn = OpenConn();
    $query = "DELETE FROM foods WHERE username = '".$username."' AND id = '".$id."'";
    $result = $conn->query($query);

    return $result;
}

function addExercise($username, $exercise, $duration, $calories, $description){
    $conn = OpenConn();
    $query = "INSERT INTO exercises (username, exercise, duration, calories, description) VALUES ('".$username."','".$exercise."', '".$duration."', '".$calories."', '".$description."')";
    $result = $conn->query($query);

    return $result;
}

function getExerciseDictionary($username){
    $conn = OpenConn();
    $query = "SELECT * FROM exercises WHERE username = '".$username."'";
    $result = $conn->query($query);

    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $id = $row["id"];
            $exercise =  $row["exercise"];
            $duration =  $row["duration"];
            $calories =  $row["calories"];
            $descr =  $row["description"];


                echo '
                <tr id="'.$exercise.'">
                <form class="table1" name="frmExDict" method="post" action="">
                <td><div contenteditable>'.$id.'</div></td>
                <td >'.$exercise.'</td> 
                <td>'.$duration.'</td> 
                <td>'.$descr.'</td> 
                <td><input class="apply-btn" type="submit" name="apply-exercise" value="'.$calories.'">Apply Today</input></td> 
                <td><input class="apply-btn" type="submit" name="delete-exercise" value="'.$id.'">Delete</input></td> 
                </form>
                </tr>'
               ;
        }
    }
}

function deleteExercise($username, $id){
    $conn = OpenConn();
    $query = "DELETE FROM exercises WHERE username = '".$username."' AND id = '".$id."'";
    $result = $conn->query($query);

    return $result;
}


?>