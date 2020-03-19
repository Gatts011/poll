<?php
require_once "pdo.php";
session_start();
$stmt = $pdo->query("SELECT name, food, vote, user_id FROM favorites");
$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>
<html>
<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">

<!-- Optional theme -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap-theme.min.css" integrity="sha384-fLW2N01lMqjakBkx3l/M9EahuwpSfeNvV63J5ezn3uZzapT0u7EYsXMjQV+0En5r" crossorigin="anonymous">

<head>
    <title>toby the think tank</title>
</head>

<body style="font-family: sans-serif;">
    <div class="container">
        <h1>Insert your favorite food and vote</h1>
        <!--Should put this in controller -->


        <?php

        if (isset($_SESSION["success"])) {
            echo ('<p style="color:green">' . $_SESSION["success"] . "</p>\n");
            unset($_SESSION["success"]);
        }



        if ($rows == false) {
            echo ('<p>No rows found</p>');
        }
        if ($rows == !false) {

            echo ('<p> <table border="1">' . "\n");

            echo ('<tr>');
            echo ('<th>Name</th>');
            echo ('<th>Food</th>');
            echo ('<th>Vote</th>');
            echo ('<th>Action</th>');
            echo ('</tr>');

            foreach ($rows as $row) {
                echo "<tr><td>";
                echo (htmlentities($row['name']));
                echo ("</td><td>");
                echo (htmlentities($row['food']));
                echo ("</td><td>");
                echo (htmlentities($row['vote']));
                echo ("</td><td>");
                echo (' <a href="edit.php?user_id=' . $row['user_id'] . '" >Edit</a> / '); //anchor with get param
                echo (' <a href="delete.php?user_id=' . $row['user_id'] . '" >Delete</a>'); //anchor with get param
                echo ("</td></tr>\n");
            }
            echo ('</table>');
        }
        echo ('<p><a href="add.php">Add New Entry</a></p>');


        ?>
    </div>
</body>

</html>