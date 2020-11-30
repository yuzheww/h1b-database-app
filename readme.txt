The order of files to use:
1. megatable.sql
(NOTE: If the load data statement does not work on your device (Our group is using windows), then use test_data.sql to populate the megatable.)
2. decomposed_tables.sql
3. DML_functions.sql

 

If you are a mac user, use this code for conn.php
<?php

$dbhost = '127.0.0.1'; // localhost
$dbuname = 'root';
$dbpass = 'root';
$dbname = 'H_info';

//$dbo = new PDO('mysql:host=abc.com;port=8889;dbname=$dbname, $dbuname, $dbpass);

$dbo = new PDO('mysql:host=' . $dbhost . ';port=3306;dbname=' . $dbname, $dbuname, $dbpass);

?>