<!DOCTYPE html>
<html>
<head>
    <title>Project</title>
    <style>
        body {
            font-family: sans-serif;
            font-size: 12pt;
            background-color: #FAEBFF;

        }

        h1 {
            color: hotpink;

        }

        h2 {
            color: white;

        }

        table, th, td {
            border: 1px solid black;
            border-collapse: collapse;
            opacity: 0.95;
        }

        th, td {
            padding: 10px;
            text-align: center;
        }

        th {
            background-color: red;
            color: white;
        }

        tr:nth-child(even) {
            background-color: #e8e8e8;
        }

        tr:nth-child(odd) {
            background-color: white;
        }

        #head {
            background-color: black;
            color: white;
        }

        .container {
            overflow: hidden
        }

        .tab {
            float: left;
        }

        #btn_s {
            width: 100px;
        }

        #btn_i {
            width: 125px;
        }

        #formbox {
            width: 400px;
            margin: auto 0;
            text-align: center;
        }

        .tab-2 input {
            display: block;
        }
    </style>
</head>
<body>
<?php
$host = "127.0.0.1";
$user = "root";
$db_name = "project";
$mysqli = new mysqli($host, $user, "password", "project");
if ($mysqli->connect_errno > 0) {
    die('Unable to connect to Database ' . $db_name . ' [' . $mysqli->connect_error . ']');
}
$op = $_POST['Operation'];
$query = "";
if (strcmp($op, "Insert") == 0) {
    $fname = $_POST['fname'];
    $lname = $_POST['lname'];
    $rid = $_POST['rid'];
    $email = $_POST['email'];
    $gpa = $_POST['gpa'];
    $snumber = $_POST['sNumber'];
    $sname =$_POST['sName'];
    $city = $_POST['city'];
    $state = $_POST['state'];
    $zip = $_POST['zip'];
    $query = "INSERT INTO student (redID,first_name,last_name,email,GPA) VALUES ({$rid},'{$fname}','{$lname}','{$email}',{$gpa})";
    $query1 = "INSERT INTO address (redID,streetNumber, streetName, Zip) VALUES ({$rid},{$snumber},'{$sname}',{$zip})";
    $query2 =  "INSERT IGNORE INTO city (Zip, city, State) VALUES ({$zip},'{$city}','{$state}');";
    $result = $mysqli->query($query);
    if (!$result) {
        die("Could not insert record" . "[{$mysqli->error}");
    } else {
        $result = $mysqli->query($query2);
        if (!$result) {
            die("Could not insert record" . "[{$mysqli->error}");
        } else {
            $result = $mysqli->query($query1);
            if (!$result) {
                die("Could not insert record" . "[{$mysqli->error}");
            } else {
                $message = "Student with redID: {$rid} has been successfully added";
                echo "<script type='text/javascript'>alert('$message');</script>";
            }
        }
    }



} else if (strcmp($op, "Delete") == 0) {
    $num_rows = $_POST['num_rows'];
    $myArray = [];
    $indexArray = [];
    $query .= "DELETE FROM student ";
    $j = 1;
    $count = 0;
    for ($i = 0; $i < $num_rows; $i++) {
        if (isset($_POST["row{$i}"])) {
            $myArray[] = $query . "WHERE redID = \"{$_POST["row{$i}"]}\";";
            $indexArray[] = $j;
            $j++;
            $count++;
        }
    }
    $i = 0;
    foreach ($myArray as $q) {
        $result = $mysqli->query($q);
        if (!$result) {
            die("Could not delete Record" . "[{$mysqli->error}");
        } else {
            $message = "Student #{$indexArray[$i++]} has been deleted Successfully";
            echo "<script type='text/javascript'>alert('$message');</script>";
        }
        if ($count == 1)
            $message = "{$count} row affected";
        else
            $message = "{$count} rows affected";
        echo "<script type='text/javascript'>alert('$message');</script>";
    }
}
else{
    $query = /** @lang text */
        "UPDATE student SET ";
    $query1 = "UPDATE address SET ";
    $query2 =  "UPDATE city SET";
    $count=0;
    $first =1;
    $first1 =1;
    $first2 =1;
    $one=0;$two=0;$three=0;
    $rid = $_POST['rid'];
    $zip = $_POST['zip'];
    if(isset($_POST['u_fname'])){
        $one =1;
        $fname = $_POST['fname'];
        if($first) {
            $query .= "`first_name` = '{$fname}' ";
            $first=0;
        }
        else{
            $query .= ", `first_name` = '{$fname}' ";
        }
        $count++;
    }
    if(isset($_POST['u_lname'])){
        $one =1;
        $lname = $_POST['lname'];
        if($first) {
            $query .= "`last_name` = '{$lname}' ";
            $first = 0;
        }
        else{
            $query .= ", `last_name` = '{$lname}' ";
        }
        $count++;
    }
    if(isset($_POST['u_email'])){
        $one =1;
        $email = $_POST['email'];
        if($first) {
            $query .= "`email` = '{$email}' ";
            $first=0;
        }
        else
            $query .= ", `email` = '{$email}' ";
        $count++;

    }
    if(isset($_POST['u_gpa'])){
        $one =1;
        $gpa = $_POST['gpa'];
        if($first) {
            $query .= "`GPA` = '{$gpa}' ";
            $first=0;
        }
        else
            $query .= ", `GPA` = '{$gpa}' ";
        $count++;

    }
    if(isset($_POST['u_snumber'])){
        $two = 1;
        $snumber = $_POST['sNumber'];
        if($first1) {
            $query1 .= "`streetNumber` = {$snumber} ";
            $first1 = 0;
        }
        else
            $query1 .= ", `streetNumber` = {$snumber} ";
        $count++;
    }
    if(isset($_POST['u_sname'])){
        $two = 1;
        $sname =$_POST['sName'];
        if($first1) {
            $query1 .= " `streetName` = '{$sname}' ";
            $first1=0;
        }
        else
            $query1 .= ", `streetName` = '{$sname}' ";
        $count++;
    }
    if(isset($_POST['u_city'])){
        $three =1;
        $city = $_POST['city'];
        if($first2) {
            $query2 .= "`city` = '{$city}' ";
            $first2 = 0;
        }
        else
            $query2 .= ", `city` = '{$city}' ";
        $count++;
    }
    if(isset($_POST['u_state'])){
        $three =1;
        $state = $_POST['state'];
        if($first2) {
            $query2 .= "`State` = '{$state}' ";
            $first2 = 0;
        }
        else
            $query2 .= ", `State` = '{$state}' ";
        $count++;

    }

    if($one){
        $query .= "where `redId` = {$rid};";
        $result = $mysqli->query($query);
        if(!$result){
            die("Could not update record" . "[{$mysqli->error}");
        }
        else{
            $message = "Student with redID: {$rid} record updated";
            echo "<script type='text/javascript'>alert('$message');</script>";
        }
    }
    if($two){
        $query1 .= "where `redId` = {$rid};";
        $result = $mysqli->query($query1);
        if(!$result){
            die("Could not update record" . "[{$mysqli->error}");
        }
        else{
            $message = "address of student with redID: {$rid} was updated";
            echo "<script type='text/javascript'>alert('$message');</script>";
        }
    }
    if($three){
        $query2 .= "where `Zip` = {$zip};";
        $result = $mysqli->query($query2);
        if(!$result){
            die("Could not update record" . "[{$mysqli->error}");
        }
        else{
            $message = "city with zipcode: {$zip} was updated";
            echo "<script type='text/javascript'>alert('$message');</script>";
        }
    }


}
print "<div style='text-align: center'> 
<form action=\"home.php\">
    <input type=\"submit\" value=\"Home\" />
</form>
</div>";
?>


