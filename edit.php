<?php
require_once "pdo.php";

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

    $sql = "UPDATE favorites SET name = :name, food = :food, vote = :vote WHERE user_id = :user_id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(array(

        ':name' => $_POST['name'],
        ':food' => $_POST['food'],
        ':vote' => $_POST['vote'],
        ':user_id' => $_POST['user_id']

    ));

      $_SESSION["success"] = "Record Updated";
    header('Location:index.php'); 
    return;
}

// Guardian: Make sure that user_id is present
if (!isset($_GET['user_id'])) {
    $_SESSION['error'] = "Missing user_id";
    header('Location: index.php');
    return;
}

$stmt = $pdo->prepare("SELECT * FROM favorites where user_id = :xyz");
$stmt->execute(array(":xyz" => $_GET['user_id']));
$row = $stmt->fetch(PDO::FETCH_ASSOC);
if ($row === false) {
    $_SESSION['error'] = 'Bad value for user_id';
    header('Location: index.php');
    return;
}
$na = htmlentities($row['name']);
$fo = htmlentities($row['food']);
$vo = htmlentities($row['vote']);
$user_id = $row['user_id'];


?>
<html>
<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">

<!-- Optional theme -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap-theme.min.css" integrity="sha384-fLW2N01lMqjakBkx3l/M9EahuwpSfeNvV63J5ezn3uZzapT0u7EYsXMjQV+0En5r" crossorigin="anonymous">


<head>
    <title>toby Think Tank Edit</title>
</head>

<body style="font-family: sans-serif;">
    <div class="container">
        <h1>Editing Favorite foods</h1>

        <?php
        // Flash pattern
        if (isset($_SESSION['error'])) {
            echo '<p style="color:red">' . $_SESSION['error'] . "</p>\n";
            unset($_SESSION['error']);
        }

        ?>

        <form method="post">

            <p>Your Name:
                <input type="text" name="name" value="<?= $na ?>"></p>
            <p>Favore Food:
                <input type="text" name="food" value="<?= $fo ?>"></p>
            <p>Vote (1-5):
                <input type="text" name="vote" value="<?= $vo ?>"></p>


            <input type="hidden" name="user_id" value="<?= $user_id ?>">
            <p><input type="submit" value="Save" />
                <a href="index.php">Cancel</a></p>
        </form>

    </div>
</body>

</html>