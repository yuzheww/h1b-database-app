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
  <link rel="stylesheet" type="text/css" href="project.css" />
</head>
<BODY background = "DJI_0373.JPG">
<body>
  <div id="navbar">
    <ul>
      <li><a href="index.html", div style = "color:white"> Home </a></li>
      <li><a href="record.php", div style = "color:white"> View Record </a></li>
      <li><a href="updateCase.php", div style = "color:white"> Update Application </a></li>
      <li><a href="insertCase.php", div style = "color:white"> Insert Application </a></li>

    </ul>
  </div>

  <h1> Delete a Case </h1>

  <form method="post">

    <span for="cnum", div style = "color:white">Case Number(*):</span>
    <input type="text" name="cnum" id="cnum" required>

    <input type="submit" name="submit" value="Delete Case">
  </form>
     <?php
      if (isset($_POST['submit'])) {
              if ($result && $prepared_stmt->rowCount() > 0) { ?>
                    <table>
                      <thead>
                        <tr>
                          <th>Delete Status</th>

                        </tr>
                      </thead>
                      <tbody>

                        <?php foreach ($result as $row) { ?>

                          <tr>
                            <td><div style="color:white"><?php echo $row["ret"];?></td>
                          </tr>
                        <?php } ?>
                      </tbody>
                  </table>
              <?php } else { ?>
                        Delete is unsuccesful to ID: <?php echo $_POST['cnum']; ?>.
                      <?php }
          } ?>


</body>

</html>