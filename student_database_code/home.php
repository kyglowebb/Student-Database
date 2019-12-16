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
            font-size: 12pt;

        }

        table, th, td {
            border: 1px solid black;
            border-collapse: collapse;
        }

        th, td {
            padding: 10px;
            text-align: center;
        }

        th {
            background-color: mediumpurple;
            color: white;
        }

        tr:nth-child(even) {
            background-color: #FDECFF;
        }

        tr:nth-child(odd) {
            background-color: #FFFAFF;
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

        .tab-2 {
            margin-left: 50px;
            color: #68e51b;
        }

        .tab-2 input {
            display: block;
        }
    </style>
</head>
<body>
<div class="container">
    <div class="tab tab-1">
        <table id="table">
            <tr>
                <td id="head" colspan="15"><h1>503 Class List</h1></td>
            </tr>
            <tr>
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
            <?php
            $host = "127.0.0.1";
            $user = "root";
            $password = "password";
            $db = "project";
            $mysqli = new mysqli($host, $user, $password, $db);
            if ($mysqli->connect_errno > 0) {
                die('Unable to connect to Database ' . $db . ' [' . $mysqli->connect_error . ']');
            }
            $sql = 'SELECT * from student JOIN address ON address.redID = student.redID JOIN city c ON address.Zip = c.Zip;';
            $result = $mysqli->query($sql);
            if (!$result) {
                die("Query to show all the values in the database failed.");
            }
            while ($row = mysqli_fetch_assoc($result)) {
                print "<tr>
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
            }
            print "</table>
    </div>
</div>
    <div>
        <br/>
        <h1>Choose what you want to do:</h1>
        <form action=during.php method=POST>
            <select required name=Operation size=1 Font size=+6>
                <option value=\"\" disabled=\"disabled\" selected=\"selected\">Please choose</option>
                <option value=Insert>Insert</option>";
            if ($result->num_rows > 0) {
                print "<option value=Delete>Delete</option>
                <option value=Update>Update</option>";
            }
            print"</select>
            <div><input type=Submit value=Submit></div>
        </form>
        <h2><strong>Insert</strong> : Inserts a new student into the student table of the database.</h2>
        <h2><strong>Delete</strong> : Deletes a student from the database.</h2>
        <h2><strong>Update</strong> : Updates a students's information in the Database</h2>
    </div>"; ?>
</body>
</html>
