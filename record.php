<?php

if (isset($_POST['submit'])) {

  require_once("conn.php");

  $cnum = $_POST['cnum'];

  $query = "CALL queryNum(:cnum)";

  try {
    $prepared_stmt = $dbo->prepare($query);
    $prepared_stmt->bindValue(':cnum', $cnum, PDO::PARAM_STR);
    $prepared_stmt->execute();
    $result = $prepared_stmt->fetchAll();
  } catch (PDOException $ex) { // Error in database processing.
    echo $sql . "<br>" . $error->getMessage(); // HTTP 500 - Internal Server Error
  }
}else if (isset($_POST['submit2'])) {
   require_once("conn.php");

   $low = $_POST['low'];
   $high = $_POST['high'];

   $query = "CALL queryInterval(:low, :high)";

   try {
     $prepared_stmt = $dbo->prepare($query);
     $prepared_stmt->bindValue(':low', $low, PDO::PARAM_STR);
     $prepared_stmt->bindValue(':high', $high, PDO::PARAM_STR);
     $prepared_stmt->execute();
     echo "<script>alert('update is successful!')</script>";
   } catch (PDOException $ex) { // Error in database processing.
     echo $sql . "<br>" . $error->getMessage(); // HTTP 500 - Internal Server Error
     echo "<script>alert('The update is unsuccesful')</script>";
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

  <h1> Query a Case by case number</h1>
  <form method="post">

    <span for="cnum">Case Number(*):</span>
    <input type="text" name="cnum">
          <input type="submit" name="submit" value="Submit">
  </form>

    <?php
if (isset($_POST['submit'])) {
        if ($result && $prepared_stmt->rowCount() > 0) { ?>
              <h2>Main Results</h2>
              <table>
                <thead>
                  <tr>
                    <th>Case Number</th>
                    <th>Case Status</th>
                    <th>Date Submitted</th>
                    <th>Decision Date</th>
                    <th>visa_class</th>
                    <th>Employment Start Date</th>
                    <th>Employment End Date</th>
                    <th>Employer Name</th>

                  </tr>
                </thead>
                <tbody>

                  <?php foreach ($result as $row) { ?>

                    <tr>
                      <td><div><?php echo $row["case_number"];?></td>
                      <td><div><?php echo $row["case_status"]; ?></td>
                      <td><div><?php echo $row["case_submitted"]; ?></td>
                      <td><div><?php echo $row["decision_date"]; ?></td>
                      <td><div><?php echo $row["visa_class"]; ?></td>
                      <td><div><?php echo $row["employment_start_date"]; ?></td>
                      <td><div><?php echo $row["employment_end_date"]; ?></td>
                      <td><div><?php echo $row["employer_name"]; ?></td>

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