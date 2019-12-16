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
            color: blueviolet;

        }

        table, th, td {
            border: 1px solid black;
            border-collapse: collapse;
        }

        th, td {
            padding: 10px;
            text-align: center;
        }

        #head {
            background-color: #A450C9;
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
$op = $_POST['Operation'];
if (strcmp($op, "Insert") == 0) {
    ShowInsertPrompt();
} elseif (strcmp($op, "Delete") == 0) {
    ShowDeletePrompt();
} else {
    Update();
}
function ShowInsertPrompt()
{
    print "
<h1>Please enter the new student's information</h1>
<form method=\"POST\" action=\"end.php\">";
    print "<input type=\"hidden\" name=\"Operation\" value=\"Insert\"/>";
    print "
<span style=\"color:blueviolet\">First Name: <input type=\"text\" name=\"fname\" required ></span>
<br>
<br>
<span style=\"color:blueviolet\">Last Name: <input type=\"text\" name=\"lname\"required ></span>
<br>
<br>
<span style=\"color:blueviolet\">Red Id: <input type=\"text\" name=\"rid\" required></span>
<br>
<br>
<span style=\"color:blueviolet\">Email: <input type=\"text\" name=\"email\" ></span>
<br>
<br>
<span style=\"color:blueviolet\">GPA: <input type=\"number\" step=\"0.01\" name=\"gpa\" ></span>
<br>
<br>
<span style=\"color:blueviolet\">Street Number: <input type=\"number\" name=\"sNumber\" required></span>
<br>
<br>
<span style=\"color:blueviolet\">Street Name: <input type=\"text\" name=\"sName\" required></span>
<br>
<br>
<span style=\"color:blueviolet\">City: <input type=\"text\" name=\"city\" required></span>
<br>
<br>
<span style=\"color:blueviolet\">State: <input type=\"text\" name=\"state\" required></span>
<br>
<br>
<span style=\"color:blueviolet\">Zip: <input type=\"text\" name=\"zip\" required></span>
  <div><input type=Submit value=Submit></div>
</form>";
}

function ShowDeletePrompt()
{
    print "<div>
<h2>Use the checkboxes to choose a student(s) to remove from the class</h2>
    </div>
    <div>
<form method=\"POST\" action=\"end.php\">
   <input type=\"hidden\" name=\"Operation\" value=\"Delete\">";
    print"
    <div class=\"container\">
    <div class=\"tab tab-1\">
        <table id=\"table\">
            <tr>
                <td id=\"head\" colspan=\"15\"><h1>503 Class List</h1></td>
            </tr>
            <tr>
                <th>Delete</th>
                <th>First Name</th>
                <th>Last Name</th>
                <th>Red ID</th>
                <th>Email</th>
                <th>GPA</th>
                <th>Street Number</th>
                <th>Street Name</th>
                <th>City</th>
                <th>State</th>
                <th>Zip</th>
            </tr>
            ";
    $host = "127.0.0.1";
    $user = "root";
    $db = "project";
    $password = "password";
    $mysqli = new mysqli($host, $user, $password, $db);
    if ($mysqli->connect_errno > 0) {
        die('Unable to connect to Database ' . $db . ' [' . $mysqli->connect_error . ']');
    }
    $sql = 'SELECT * from student JOIN address ON address.redID = student.redID JOIN city c ON address.Zip = c.Zip;';
    $result = $mysqli->query($sql);
    if (!$result) {
        die("Query to show all the values in the database failed.");
    }
    $i = 0;
    $id =1;
    print "<input type=\"hidden\" name=\"num_rows\" value=\"{$result->num_rows}\">";
    while ($row = mysqli_fetch_assoc($result)) {
        print "<tr>
                <td><input type=\"checkbox\" name=\"row{$i}\" value=\"{$row['redID']}\">Student #{$id}</td>
                 <td>{$row['first_name']}</td>
                <td>{$row['last_name']}</td>
                <td>{$row['redID']}</td>
                <td>{$row['email']}</td>
                <td>{$row['GPA']}</td>
                <td>{$row['streetNumber']}</td>
                <td>{$row['streetName']}</td>
                <td>{$row['city']}</td>
                <td>{$row['State']}</td>
                <td>{$row['Zip']}</td>
            </tr>";
        $i++;
        $id++;
    }
    print "</table>
            <br>
            <div style='text-align: center'>
            <input type=Submit value=Submit id=\"btn_s\">
            </div>
            </form>
            </div>
            </div>
            </div>
            ";
}

function Update()
{print "
<h1>Please Enter Updated Student Information</h1>
<form method=\"POST\" action=\"end.php\">";
    print "<input type=\"hidden\" name=\"Operation\" value=\"Update\"/>";
    print "
<span style=\"color:blueviolet\"><input type=\"checkbox\" name=\"u_fname\">
First Name: <input type=\"text\" name=\"fname\" ></span>
<br>
<br>
  <span style=\"color:blueviolet\"><input type=\"checkbox\" name=\"u_lname\">
  Last Name: <input type=\"text\" name=\"lname\" ></span>
  <br>
<br>
  <span style=\"color:blueviolet\">
  
  Red Id: <select required name=rid size=1 Font size=+6>
                <option value=\"\" disabled=\"disabled\" selected=\"selected\">Please select redID</option>";
    $host = "127.0.0.1";
    $user = "root";
    $db = "project";
    $password = "password";
    $mysqli = new mysqli($host, $user, $password, $db);

    if ($mysqli->connect_errno > 0) {
        die('Unable to connect to Database ' . $db . ' [' . $mysqli->connect_error . ']');
    }
    $sql = 'SELECT student.`redID` from student';
    $result = $mysqli->query($sql);
    if (!$result) {
        die("Query to show all primary keys in the table student failed");
    }
    while($row = mysqli_fetch_assoc($result)){
        print "<option value={$row['redID']}>{$row['redID']}</option>";
    }
    print"</select>
</span>
   <br>
<br>
  <span style=\"color:blueviolet\"><input type=\"checkbox\" name=\"u_email\">
  Email: <input type=\"text\" name=\"email\" >
  </span>
   <br>
<br>
  <span style=\"color:blueviolet\"><input type=\"checkbox\" name=\"u_gpa\">
  GPA: <input type=\"number\" step=\"0.01\" name=\"gpa\" ></span>
  <br>
<br>
   <span style=\"color:blueviolet\"><input type=\"checkbox\" name=\"u_snumber\">
   Street Number: <input type=\"number\" name=\"sNumber\" ></span>
     <br>
<br>
  <span style=\"color:blueviolet\"><input type=\"checkbox\" name=\"u_sname\">
  Street Name: <input type=\"text\" name=\"sName\" ></span>
     <br>
<br>
    <span style=\"color:blueviolet\"><input type=\"checkbox\" name=\"u_city\">
    City: <input type=\"text\" name=\"city\" ></span>
    <br>
<br>
    <span style=\"color:blueviolet\"><input type=\"checkbox\" name=\"u_state\">
    State: <input type=\"text\" name=\"state\" ></span>
    <br>
    <br>
    <span style=\"color:blueviolet\">
    Zip: <select required name=zip size=1 Font size=+6>
                <option value=\"\" disabled=\"disabled\" selected=\"selected\">Please select zipCode</option>\";";
    $host = "127.0.0.1";
    $user = "root";
    $db = "project";
    $password = "password";
    $mysqli = new mysqli($host, $user, $password, $db);

    if ($mysqli->connect_errno > 0) {
        die('Unable to connect to Database ' . $db . ' [' . $mysqli->connect_error . ']');
    }
    $sql = 'Select `Zip` from city';
    $result = $mysqli->query($sql);
    if (!$result) {
        die("Query to show all the zip codes from city table failed");
    }
    while($row = mysqli_fetch_assoc($result)){
        print "<option value={$row['Zip']}>{$row['Zip']}</option>";
    }
    print"</select>
</span></span>
  <div><input type=Submit value=Submit></div>
</form>";
}

?>
</body>

