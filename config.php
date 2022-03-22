
<?php
//Get Heroku ClearDB connection information
$cleardb_url = parse_url(getenv("mysql://b4419a43f84a15:e234a7ad@us-cdbr-east-05.cleardb.net/heroku_a9d23032b80af2a?reconnect=true"));
$cleardb_server = $cleardb_url["us-cdbr-east-05.cleardb.net"];
$cleardb_username = $cleardb_url["b4419a43f84a15"];
$cleardb_password = $cleardb_url["e234a7ad"];
$cleardb_db = substr($cleardb_url["path"],1);
$active_group = 'default';
$query_builder = TRUE;
// Connect to DB
$conn = mysqli_connect($cleardb_server, $cleardb_username, $cleardb_password, $cleardb_db);
?>