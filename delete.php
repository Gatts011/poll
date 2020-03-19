<?php
require_once "pdo.php";
session_start();


if (isset($_POST['delete']) && isset($_POST['user_id'])) {
  $sql = "DELETE FROM favorites WHERE user_id = :zip";
  $stmt = $pdo->prepare($sql);
  $stmt->execute(array(':zip' => $_POST['user_id']));
  $_SESSION['success'] = 'Record deleted';
  header('Location: index.php');
  return;
}

// Guardian: Make sure that user_id is present
if (!isset($_GET['user_id'])) {
  $_SESSION['error'] = "Missing user_id";
  header('Location: index.php');
  return;
}

$stmt = $pdo->prepare("SELECT name, user_id FROM favorites where user_id = :xyz");
$stmt->execute(array(":xyz" => $_GET['user_id']));
$row = $stmt->fetch(PDO::FETCH_ASSOC);
if ($row === false) {
  $_SESSION['error'] = 'Bad value for user_id';
  header('Location: index.php');
  return;
}

?>
<html>
<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">

<!-- Optional theme -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap-theme.min.css" integrity="sha384-fLW2N01lMqjakBkx3l/M9EahuwpSfeNvV63J5ezn3uZzapT0u7EYsXMjQV+0En5r" crossorigin="anonymous">


<head>
  <title>toby c9344998</title>
</head>

<body style="font-family: sans-serif;">
  <div class="container">
    <h1>
      <p>Confirm: Deleting <?= htmlentities($row['name']) ?>s Favorite food</p> 
    </h1>

    <form method="post">
      <input type="hidden" name="user_id" value="<?= $row['user_id'] ?>">
      <input type="submit" value="Delete" name="delete">
      <a href="index.php">Cancel</a>
    </form>

  </div>
</body>

</html>