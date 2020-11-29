<?php

if (isset($_POST['submit'])) {

  require_once("conn.php");

  $cnum = $_POST['cnum'];

  $query = "CALL deleteCase(:cnum)";

  try {
    $prepared_stmt = $dbo->prepare($query);
    $prepared_stmt->bindValue(':cnum', $cnum, PDO::PARAM_STR);
    $prepared_stmt->execute();
    $result = $prepared_stmt->fetchAll();
  } catch (PDOException $ex) { // Error in database processing.
    echo $sql . "<br>" . $error->getMessage(); // HTTP 500 - Internal Server Error
  }
}

?>

<html>

<head>
  <link rel="stylesheet" type="text/css" href="style.css" />
</head>

<body>
  <div id="navbar">
    <ul>
      <li><a href="index.html"> Home </a></li>
			<li><a href="record.php"> View Record </a></li>
			<li><a href="updateCase.php"> Update Application </a></li>
			<li><a href="insertCase.php"> Insert Application </a></li>
			<li><a href="deleteCase.php"> Delete Application </a></li>
    </ul>
  </div>

  <h1> Delete H1B Application </h1>

  <form method="post">

    <span for="cnum">Case Number(*):</span>
    <input type="text" name="cnum" id="cnum" required>

    <input type="submit" name="submit" value="Delete Case" class = "btn">
  </form>
  
  <?php
      if (isset($_POST['submit'])) {
        if ($result && $prepared_stmt->rowCount() > 0) { ?>
    
              <h2>Results</h2>

              <table>
                <thead>
                  <tr>
                    <th>delete status</th>
                  </tr>
                </thead>
                <tbody>
            
                  <?php foreach ($result as $row) { ?>
                
                    <tr>
                      <td><?php echo $row["msg"]; ?></td>
                    </tr>
                  <?php } ?>
                </tbody>
            </table>
  
        <?php } else { ?>
          Sorry No results found for <?php echo $_POST['cnum']; ?>.
        <?php }
    } ?>

</body>

</html>