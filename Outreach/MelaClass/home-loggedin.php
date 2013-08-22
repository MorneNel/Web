<!DOCTYPE html>
<?php
/*
// configuration
$dbtype		= "sqlite";
$dbhost 	= "localhost";
$dbname		= "authexample";
$dbuser		= "root";
$dbpass		= "";

// database connection
$conn = new PDO("mysql:host=$dbhost;dbname=$dbname",$dbuser,$dbpass);*/
?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Welcome</title>
<meta http-equiv="Content-Type" content="text/html;charset=utf-8" />

<link href="css/reset.css" rel="stylesheet" type="text/css" />
<link href="css/login_style.css" rel="stylesheet" type="text/css" />
</head>

<body>
<div class="logo"></div>
<div class="form">
	You're currently logged in as <strong><?php echo $auth->Username; ?></strong>.

	<?php
	// Count number of active sessions for particular licence
	$licenceID = 1;
	/*$query = $conn->prepare("SELECT uid FROM sessions WHERE licence = $licenceID");
        //$query->execute(array($licenceID));
	$query->execute();
        $row = $query->fetchAll(\PDO::FETCH_ASSOC);*/
	$sessions = 0;
	
	$connect = odbc_connect('DRIVER={4D v11 ODBC Driver};SSL=false;SERVER=192.168.2.44;PORT=19812;UID=_Mela Solutions Ltd.;PWD=bach',"","");
        $query = "SELECT uid FROM sessions WHERE licence = $licenceID";
        $update = odbc_exec($connect, $query);
        while ($row = odbc_fetch_array($update)) $sessions++; // Simply count()ing rows worked with PDO but not with ODBC so this loop needs to be implemented instead
	
	echo "<br /><p>There are currently <h1>".$sessions."</h1> active sessions for licence <h1>$licenceID</h1></p>";
	?>
</div>
<div class="small">
	<a href="?page=change-password">Change Password</a><br/>
	<a href="?page=change-email">Change Email</a><br/>
	<a href="?page=logout">Logout</a>
</div>
</body>
</html>