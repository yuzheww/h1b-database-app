<?php

if (isset($_POST['submit'])) {

  require_once("conn.php");

  $cnum = $_POST['cnum'];

  $query = "CALL deleteCase(:cnum)";

  try {
    $prepared_stmt = $dbo->prepare($query);
    $prepared_stmt->bindValue(':cnum', $cnum, PDO::PARAM_STR);
    $prepared_stmt->execute();
  } catch (PDOException $ex) { // Error in database processing.
    echo $sql . "<br>" . $error->getMessage(); // HTTP 500 - Internal Server Error
  }
}

?>

<html>

<head>
  <link rel="stylesheet" type="text/css" href="project.css" />
</head>

<body>
  <div id="navbar">
    <ul>
      <li><a href="index.html"> Home </a></li>
      <li><a href="updateCase.php"> Update Application </a></li>
      <li><a href="insertCase.php"> Insert Application </a></li>
      <li><a href="deleteCase.php"> Delete Application </a></li>
    </ul>
  </div>

  <h1> Delete a Case </h1>

  <form method="post">

    <span for="cnum">Case Number(*):</span>
    <input type="text" name="cnum" id="cnum" required>

    <input type="submit" name="submit" value="Delete Case" class ="btn">
  </form>



</body>

</html>