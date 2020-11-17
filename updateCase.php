<?php

if (isset($_POST['submit'])) {

  require_once("conn.php");

  $cnum = $_POST['cnum'];
  $cstatus = $_POST['cstatus'];

  $query = "CALL updateStatus(:cnum, :cstatus)";

  try {
    $prepared_stmt = $dbo->prepare($query);
    $prepared_stmt->bindValue(':cnum', $cnum, PDO::PARAM_STR);
    $prepared_stmt->bindValue(':cstatus', $cstatus, PDO::PARAM_STR);
    $prepared_stmt->execute();
    $result = $prepared_stmt->fetchAll();
  } catch (PDOException $ex) { // Error in database processing.
    echo $sql . "<br>" . $error->getMessage(); // HTTP 500 - Internal Server Error
  }
} else if (isset($_POST['submit2'])) {
  require_once("conn.php");

  $cnum = $_POST['cnum'];
  $agent_name = $_POST['agent_name'];
  $agent_city = $_POST['agent_city'];
  $agent_state = $_POST['agent_state'];

  $query = "CALL updateAgent(:cnum, :agent_name, :agent_city, :agent_state)";

  try {
    $prepared_stmt = $dbo->prepare($query);
    $prepared_stmt->bindValue(':cnum', $cnum, PDO::PARAM_STR);
    $prepared_stmt->bindValue(':agent_name', $agent_name, PDO::PARAM_STR);
    $prepared_stmt->bindValue(':agent_city', $agent_city, PDO::PARAM_STR);
    $prepared_stmt->bindValue(':agent_state', $agent_state, PDO::PARAM_STR);
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

  <h1> Update H1B Application </h1>


<BODY background = "DJI_0373.JPG">

  <form method="post">

    <table>
      <tr>
        <th colspan="3">
            <span for="cnum">Case Number(Required*):</span>
            <input type="text" name="cnum" id="cnum" required>
        </th>
      </tr>
      <tr>
        <td colspan="3"><span for="cstatus",div style="color:white">Case Status:</span>
          <select id="cstatus" name="cstatus">
            <option value="WITHDRAWN">WITHDRAWN</option>
            <option value="CERTIFIED">CERTIFIED</option>
            <option value="DENIED">DENIED</option>
            <option value="CERTIFIED-WITHDRAWN">CERTIFIED-WITHDRAWN</option>
            <option value="INPROGRESS">INPROGRESS</option>
          </select> <input type="submit" name="submit" value="Update Status" class="btn">
        </td>

      </tr>
      <tr>
        <td><span for="agent_name",div style="color:white">Agent Attorney Name:</span>
          <input type="text" name="agent_name"> <br></td>
        <td><span for="agent_city",div style="color:white">Agent Attorney City:</span>
          <input type="text" name="agent_city"> <br></td>
        <td> <span for="agent_state",div style="color:white">Agent Attorney State:</span>

          <select id="agent_state" name="agent_state" size='1'>
            <option value="AL">AL</option>
            <option value="AK">AK</option>
            <option value="AR">AR</option>
            <option value="AZ">AZ</option>
            <option value="CA">CA</option>
            <option value="CO">CO</option>
            <option value="CT">CT</option>
            <option value="DC">DC</option>
            <option value="DE">DE</option>
            <option value="FL">FL</option>
            <option value="GA">GA</option>
            <option value="HI">HI</option>
            <option value="IA">IA</option>
            <option value="ID">ID</option>
            <option value="IL">IL</option>
            <option value="IN">IN</option>
            <option value="KS">KS</option>
            <option value="KY">KY</option>
            <option value="LA">LA</option>
            <option value="MA">MA</option>
            <option value="MD">MD</option>
            <option value="ME">ME</option>
            <option value="MI">MI</option>
            <option value="MN">MN</option>
            <option value="MO">MO</option>
            <option value="MS">MS</option>
            <option value="MT">MT</option>
            <option value="NC">NC</option>
            <option value="NE">NE</option>
            <option value="NH">NH</option>
            <option value="NJ">NJ</option>
            <option value="NM">NM</option>
            <option value="NV">NV</option>
            <option value="NY">NY</option>
            <option value="ND">ND</option>
            <option value="OH">OH</option>
            <option value="OK">OK</option>
            <option value="OR">OR</option>
            <option value="PA">PA</option>
            <option value="RI">RI</option>
            <option value="SC">SC</option>
            <option value="SD">SD</option>
            <option value="TN">TN</option>
            <option value="TX">TX</option>
            <option value="UT">UT</option>
            <option value="VT">VT</option>
            <option value="VA">VA</option>
            <option value="WA">WA</option>
            <option value="WI">WI</option>
            <option value="WV">WV</option>
            <option value="WY">WY</option>
          </select>
          <input type="submit" name="submit2" value="Update Attorney Info" class="btn"></td>
      </tr>
    </table>

  </form>
      <?php
  if (isset($_POST['submit'])) {
          if ($result && $prepared_stmt->rowCount() > 0) { ?>
                <table>
                  <thead>
                    <tr>
                      <th>Update Status</th>

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
                    Update is unsuccesful to ID: <?php echo $_POST['cnum']; ?>.
                  <?php }
      } ?>








</body>

</html>