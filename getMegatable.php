<?php

if (isset($_POST['submit2'])) {

    require_once("conn.php");

    $director = $_POST['case_status'];

    $query = "SELECT * FROM big_table WHERE case_status = :case_status";

try
    {
      $prepared_stmt = $dbo->prepare($query);
      $prepared_stmt->bindValue(':case_status', $director, PDO::PARAM_STR);
      $prepared_stmt->execute();
      $result = $prepared_stmt->fetchAll();
    }
    catch (PDOException $ex)
    { // Error in database processing.
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
        <li><a href="index.html">Home</a></li>
        <li><a href="getMegatable.php"> Test Megatable </a></li>
      </ul>
    </div>
    
    <h1> Test Megatable </h1>

    <form method="post">

      <label for="case_status">case status</label>
      <input type="text" name="case_status">
      
      <input type="submit" name="submit3" value="Submit" class="btn">
    </form>
    <?php
      if (isset($_POST['submit2'])) {
        if ($result && $prepared_stmt->rowCount() > 0) { ?>
    
              <h2>Results</h2>

              <table>
                <thead>
                  <tr>
                    <th>case number</th>
                    <th>case status</th>
                    <th>case submitted</th>
                    <th>decision date</th>
                  </tr>
                </thead>
                <tbody>
            
                  <?php foreach ($result as $row) { ?>
                
                    <tr>
                      <td><?php echo $row["case_number"]; ?></td>
                      <td><?php echo $row["case_status"]; ?></td>
                      <td><?php echo $row["case_submitted"]; ?></td>
                      <td><?php echo $row["decision_date"]; ?></td>
                    </tr>
                  <?php } ?>
                </tbody>
            </table>
  
        <?php } else { ?>
          Sorry No results found for <?php echo $_POST['director']; ?>.
        <?php }
    } ?>


    
  </body>
</html>






