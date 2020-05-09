<?php
    include "../actions/actions.php";
    session_start();

    if (! empty($_SESSION['username']) && $_SESSION['loggedin']==true) {
        $user = $_SESSION['username'];
        $result = getGoals($user);

        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                $db_goal_cals =  $row["goal_calories"];
                $db_goal_weight =  $row["goal_weight"];
                $db_current_weight =  $row["current_weight"];
                $db_activity_level =  $row["activity_level"];
            }
        }
    }

    if(! empty($_POST["edit-ex"])){
        $username = $_SESSION['username'];
        
        if ( !empty($_POST['currentweight'])){
            $currentweight = $_POST['currentweight'];
        }else{
            $currentweight = $db_current_weight;
        }
       
        if ( !empty($_POST['goalweight'])){
            $goalweight = $_POST['goalweight'];
        } else{
            $goalweight = $db_goal_weight;
        }
        
        if ( !empty($_POST['activitylevel'])){
            $activitylevel = $_POST['activitylevel'];
        } else{
            $activitylevel = $db_activity_level;
        }

        if ( !empty($_POST['dailycalories'])){
            $dailycalories = $_POST['dailycalories'];
        } else{
            $dailycalories = $db_goal_cals;
        }

        $retval = editGoals($username, $currentweight, $goalweight, $activitylevel, $dailycalories);
            if(! empty($retval)){
                echo "Editted Goals";
               
            }
            header("Location: profile.php");
    }

?>
<html>
<head>
    <link rel="stylesheet" type="text/css" href="../css/style.css" />
    <link href="../css/register.css" rel="stylesheet" type="text/css" />
    <link href="../css/popup.css" rel="stylesheet" type="text/css" />

    <script type="text/javascript">
        window.onload = function(){
            var current_weight = '<?php echo $db_current_weight?>';
            var goal_weight = '<?php echo $db_goal_weight?>';
            var activity_level = '<?php echo $db_activity_level?>'; 
            var cals = parseInt('<?php echo $db_goal_cals?>');
            
            document.getElementById("current").innerHTML = current_weight;
            document.getElementById("goal").innerHTML = goal_weight;
            document.getElementById("activity").innerHTML = activity_level;
            document.getElementById("daily").innerHTML = cals;
        }
    </script>

</head>
<body style="background-image: url('../img/rope.jpg');
    background-repeat: no-repeat;
    background-size: cover ;">

    <!-- BEGIN navbar.php INCLUDE -->
    <?php include "../common/navbar.php"; ?>
    
    <table>
        <tr>
            <td>
            <div class="title" style="border-style: groove; background-color:white; opacity:0.8; width: 500px; margin-left: 10%;">   
            <h1>My Profile</h1>
            <img src="../img/img_avatar.png" alt="Avatar" class="avatar" >
            
            <h1 >
                <?php
                    if(! empty($_SESSION['username']) && $_SESSION['loggedin']==true){
                        echo $_SESSION['username'];
                    }
                ?>
            </h1>
            </div>
            </td>
            <td>
              <br></br><br></br>
                <div style="border-style: groove; background-color:white; opacity:0.8; width: 700px; margin-left: 45%;">
                <h1 class=>My Goals</h1>
                <br></br>
                    <table class="interactive">
                        <tbody>
                            <tr>
                                <td><div> Current Weight: </div></td>
                                <td><p id="current"> 220 </p></td>
                            </tr>
                            <tr>
                                <td><div> Goal Weight: </div></td>
                                <td><p id="goal"> 200 </p></td>
                            </tr>
                            <tr>
                                <td> <div> Activity Level: </div></td>
                                <td><p id="activity"> Very active </p></td>
                            </tr>
                            <tr>
                                <td><div> Daily Calories: </div></td>
                                <td><p id="daily"> 2200 </p></td>
                            </tr>
                            <tr>
                                <td style=" background-color: white;">
                                    <div style="margin-left:150px;   background-color: white;">
                                    <button class="open-button" onclick="openForm()">EDIT GOALS</button>
                                </div>
                            </td>
                            </tr>
                        </tbody>
                    </table>
                </div> 
            </td>
        </tr>
    </table>

     <div class="form-popup" id="myForm">
        <form name="frmGoalEdit" method="post" action="" class="form-container">
            <h1>Edit Goals</h1>

            <label for="currentweight"><b>Current Weight</b></label>
            <input type="text" placeholder="Enter current weight" name="currentweight" 
            value="<?php if(isset($_POST['currentweight'])) echo $_POST['currentweight']; ?>">

            <label for="goalweight"><b>Goal Weight</b></label>
            <input type="text" placeholder="Enter goal weight" name="goalweight" 
            value="<?php if(isset($_POST['goalweight'])) echo $_POST['goalweight']; ?>">

            <label for="activitylevel"><b>Activity Level</b></label>
            <input type="text" placeholder="Enter activity level" name="activitylevel" 
            value="<?php if(isset($_POST['activitylevel'])) echo $_POST['activitylevel']; ?>">
    
            <label for="dailycalories"><b>Daily Calories</b></label>
            <input type="text" placeholder="Enter daily calories" name="dailycalories"
            value="<?php if(isset($_POST['dailycalories'])) echo $_POST['dailycalories']; ?>">

            <div>
                <input type="submit"
                    name="edit-ex" value="Edit"
                    class="btnRegister">
            </div>
            <br/>
            <button type="button" class="btn cancel" onclick="closeForm()" name="add-ex">Cancel</button>
        </form>
    </div>
    <br></br><br></br><br></br><br></br>

    <script>
        function openForm() {
        document.getElementById("myForm").style.display = "block";
        }

        function closeForm() {
        document.getElementById("myForm").style.display = "none";
        }

    </script>
    
<style>
h1 {
  font-size:3em; 
  font-weight: 300;
  line-height:1em;
  text-align: center;
  color: #4DC3FA;
}
</style>

</body>
</html>