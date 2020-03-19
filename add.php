<?php
require_once "pdo.php";
session_start();

$stmt = $pdo->query("SELECT name, food, user_id FROM favorites");
$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

if (isset($_POST['cancel'])) {
    header("Location:index.php");
    return;
}
//try to post and analise data
if (isset($_POST['name'])  &&  isset($_POST['food'])    &&   isset($_POST['vote'])) {

    if (
        strlen($_POST['name']) < 1 || strlen($_POST['food']) < 1        
        //if any of the fields are not filled in
    ) {
        $_SESSION["error"] = "All fields are required";
        header('Location:add.php'); //redirect to self so refresh doesnt post data again
        return;
    }
    if (!is_numeric($_POST['vote'])) {
        $_SESSION["error"] = "Vote must be numeric (1-5)";
        header('Location:add.php'); //redirect to self so refresh doesnt post data again
        return;
    }

    $sql = "INSERT INTO favorites (name, food, vote) 
        VALUES (:name, :food, :vote)";
    //echo ("<pre>\n" . $sql . "\n</pre>\n");
    $stmt = $pdo->prepare($sql);
    $stmt->execute(
        array(
            ':name' => $_POST['name'],
            ':food' => $_POST['food'], //htmlentities() only works here in prepaired statement
            ':vote' => $_POST['vote']
        )
    );
    $_SESSION["success"] = "Record Added";
    header('Location:index.php'); 
    return;
}
?>

<html>
<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">

<!-- Optional theme -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap-theme.min.css" integrity="sha384-fLW2N01lMqjakBkx3l/M9EahuwpSfeNvV63J5ezn3uZzapT0u7EYsXMjQV+0En5r" crossorigin="anonymous">


<head>
    <title>toby Think Tank Add</title>
</head>

<body>

    <div class="container">
        <h1>
          Add favorited here with your vote (1-5)
        </h1>
        <p>
            <?php
            if (isset($_SESSION["success"])) {
                echo ('<p style="color:green">'  . htmlentities($_SESSION["success"]) . "</p>\n");
                unset($_SESSION["success"]); //unset our flash msg var
            } else {
                if (isset($_SESSION["error"])) {
                    echo ('<p style="color:red">' . htmlentities($_SESSION["error"]) . "</p>\n");
                    unset($_SESSION["error"]); //unset our flash msg var
                }
            }

            ?>
        </p>

        <p>Add food</p>

        <form method="post" accept-charset="UTF-8">
            <p>Your Name:
                <input type="text" name="name">
            </p>
            <p>Favorite food:
                <input type="text" name="food">
            </p>
            <p>Vote (1-5):
                <input type="text" name="vote">
            </p>
            
            <input type="submit" value="Add">
            <input type="submit" name="cancel" value="Cancel">
        </form>



    </div>

</body>