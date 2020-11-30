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
}
?>
<?php
if (isset($_POST['submit2'])) {
  require_once("conn.php");
  $low = $_POST['low'];
  $high = $_POST['high'];

  $query = "CALL queryInterval(:low, :high)";

  try {
    $prepared_stmt = $dbo->prepare($query);
    $prepared_stmt->bindValue(':low', $low, PDO::PARAM_STR);
    $prepared_stmt->bindValue(':high', $high, PDO::PARAM_STR);
    $prepared_stmt->execute();
    $result = $prepared_stmt->fetchAll();
    echo "<script>alert('Searching!')</script>";
  } catch (PDOException $ex) { // Error in database processing.
    echo $sql . "<br>" . $error->getMessage(); // HTTP 500 - Internal Server Error
  }
}
?>
<?php
if (isset($_POST['submit3'])) {
  require_once("conn.php");
  $stat = $_POST['stat'];

  $query = "CALL queryPercentage(:stat)";

  try {
    $prepared_stmt = $dbo->prepare($query);
    $prepared_stmt->bindValue(':stat', $stat, PDO::PARAM_STR);
    $prepared_stmt->execute();
    $result = $prepared_stmt->fetchAll();
  } catch (PDOException $ex) { // Error in database processing.
    echo $sql . "<br>" . $error->getMessage(); // HTTP 500 - Internal Server Error
  }
}
?>
<?php
if (isset($_POST['submit4'])) {
  require_once("conn.php");
  $emp = $_POST['emp'];

  $query = "CALL queryEmployer(:emp)";

  try {
    $prepared_stmt = $dbo->prepare($query);
    $prepared_stmt->bindValue(':emp', $emp, PDO::PARAM_STR);
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

  <h1> Query a Case by case number</h1>
  <form method="post">

    <span for="cnum" ,div>Case Number(*):</span>
    <input type="text" name="cnum">
    <input type="submit" name="submit" value="Submit" class="btn">
  </form>

  <?php
  if (isset($_POST['submit'])) {
    if ($result && $prepared_stmt->rowCount() > 0) { ?>
      <h2,div>Main Results</h2>
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
                <td>
                  <div><?php echo $row["case_number"]; ?>
                </td>
                <td>
                  <div><?php echo $row["case_status"]; ?>
                </td>
                <td>
                  <div><?php echo $row["case_submitted"]; ?>
                </td>
                <td>
                  <div><?php echo $row["decision_date"]; ?>
                </td>
                <td>
                  <div><?php echo $row["visa_class"]; ?>
                </td>
                <td>
                  <div><?php echo $row["employment_start_date"]; ?>
                </td>
                <td>
                  <div><?php echo $row["employment_end_date"]; ?>
                </td>
                <td>
                  <div><?php echo $row["employer_name"]; ?>
                </td>

              </tr>
            <?php } ?>
          </tbody>
        </table>
      <?php } else { ?>
        Sorry No results found for <?php echo $_POST['cnum']; ?>.
    <?php }
  } ?>
    <form method="post">

      <span for="low">Search total wage from </span>
      <input type="double" name="low">
      <span for="high"> to </span>
      <input type="double" name="high">
      <input type="submit" name="submit2" value="Submit" class="btn">
    </form>
    <?php
    if (isset($_POST['submit2'])) {
      if ($result && $prepared_stmt->rowCount() > 0) { ?>
        <h3>Here</h3>
        <table>
          <thead>
            <tr>
              <th>Case Number</th>
              <th>Case Status</th>
              <th>Job Title</th>
              <th>Total Wage</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($result as $row) { ?>
              <tr>
                <td>
                  <div><?php echo $row["case_number"]; ?>
                </td>
                <td>
                  <div><?php echo $row["case_status"]; ?>
                </td>
                <td>
                  <div><?php echo $row["job_title"]; ?>
                </td>
                <td>
                  <div><?php echo $row["total_wage"]; ?>
                </td>
              </tr>
            <?php } ?>
          </tbody>
        </table>
      <?php } else { ?>
        Sorry No results found for the given range<?php echo $_POST['']; ?>.
    <?php }
    } ?>
    <form method="post">

      <span for="stat">Status of cases </span>
      <select id="stat" name="stat" size='1'>
        <option value="CERTIFIED-WITHDRAWN">CERTIFIED-WITHDRAWN</option>
        <option value="CERTIFIED">CERTIFIED</option>
        <option value="DENIED">DENIED</option>
        <option value="WITHDRAWN">WITHDRAWN</option>
      </select>
      <input type="submit" name="submit3" value="Submit" class="btn">
    </form>
    <?php
    if (isset($_POST['submit3'])) {
      if ($result && $prepared_stmt->rowCount() > 0) { ?>
        <h3>Result</h3>
        <table>
          <thead>
            <tr>
              <th>Total case number</th>

            </tr>
          </thead>
          <tbody>
            <?php foreach ($result as $row) { ?>
              <tr>
                <td>
                  <div><?php echo $row["tot"]; ?>
                </td>

              </tr>
            <?php } ?>
          </tbody>
        </table>
      <?php } else { ?>
        Sorry No results found for <?php echo $_POST['stat']; ?>.
    <?php }
    } ?>

    <form method="post">

      <span for="emp">Search Employer by </span>
      <input type="text" name="emp">
      <input type="submit" name="submit4" value="Submit" class="btn">
    </form>
    <?php
    if (isset($_POST['submit4'])) {
      if ($result && $prepared_stmt->rowCount() > 0) { ?>
        <h3>Here</h3>
        <table>
          <thead>
            <tr>
              <th>Employer Name</th>
              <th>City</th>
              <th>State Abbreviation</th>
              <th>State Fullname</th>
              <th>State and City</th>
              <th>Postal Code</th>
              <th>Country</th>
              <th>Phone Number</th>
              <th>NAIC Code</th>

            </tr>
          </thead>
          <tbody>
            <?php foreach ($result as $row) { ?>
              <tr>
                <td><?php echo $row["employer_name"]; ?></td>
                <td><?php echo $row["employer_city"]; ?></td>
                <td><?php echo $row["emp_state_abb"]; ?></td>
                <td><?php echo $row["emp_state_full"]; ?></td>
                <td><?php echo $row["emp_state_and_city"]; ?></td>
                <td><?php echo $row["employer_postal_code"]; ?></td>
                <td><?php echo $row["employer_country"]; ?></td>
                <td><?php echo $row["employer_phone"]; ?></td>
                <td><?php echo $row["naic_code"]; ?></td>
              </tr>
            <?php } ?>
          </tbody>
        </table>
      <?php } else { ?>
        Sorry No results found for <?php echo $_POST['emp']; ?>.
    <?php }
    } ?>
</body>

</html>