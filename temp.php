
else if (isset($_POST['submit2'])){
  require_once("conn.php");

  $cnum = $_POST['cnum'];
  $agent_name = $_POST['agent_name'];
  $agent_city = $_POST['agent_city'];
  $agent_state = $_POST['agent_state'];

  $query = "CALL updateAgent(:cnum, :agent_name, :agent_city, :agent_state)";
  
  try
  {
    $prepared_stmt = $dbo->prepare($query);
    $prepared_stmt->bindValue(':cnum', $cnum, PDO::PARAM_STR);
    $prepared_stmt->bindValue(':agent_name', $agent_name, PDO::PARAM_STR);
    $prepared_stmt->bindValue(':agent_city', $agent_city, PDO::PARAM_STR);
    $prepared_stmt->bindValue(':agent_state', $agent_state, PDO::PARAM_STR);
    $prepared_stmt->execute();

  }
  catch (PDOException $ex)
  { // Error in database processing.
    echo $sql . "<br>" . $error->getMessage(); // HTTP 500 - Internal Server Error
  }
}


<form method="post">

      <label for="case_status">Case Number:</label>
      <input type="text" name="case_status">

          <label for="title">Status of Application:</label>
          <select id="status" name="status">
            <option value="withdrawn">WITHDRAWN</option>
            <option value="certified">CERTIFIED</option>
            <option value="denied">DENIED</option>
            <option value="certifed-withdrawn">CERTIFIED-WITHDRAWN</option>
            <option value="inprogress">INPROGRESS</option>
          </select>
          <input type="submit" name="submit" value="Update Status" class = "submit-btn">
            
          <label for="agent_name">Agent Attorney Name</label>
            <input type="text" name="agent_name">
            <label for="agent_city">Agent Attorney City</label>
            <input type="text" name="agent_city">
            <label for="agent_state">Agent Attorney State</label>
            <input type="text" name="agent_state"></td>
          <input type="submit" name="submit2" value="Update Attorney Info" class = "submit-btn">

      
      
    </form>


    <select id="status1" name="status1">
            <option value="withdrawn">WITHDRAWN</option>
            <option value="certified">CERTIFIED</option>
            <option value="denied">DENIED</option>
            <option value="certifed-withdrawn">CERTIFIED-WITHDRAWN</option>
            <option value="inprogress">INPROGRESS</option>
          </select>