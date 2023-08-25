<?php
$username = $_POST['username']; 
$password = $_POST['password'];

//declare DB connection variables
$servername = "localhost"; //host name
$user = "root"; //database userid 
$pass = ""; //database pwd
$db = "wellness_is";
date_default_timezone_set("Asia/Kuala_Lumpur");// please write your DB name 

// Create connection
$conn = new mysqli($servername, $user, $pass, $db);

// Check connection
if ($conn->connect_error) { 
 //to check if DB connection IS NOT OK
 die("Connection failed: " . $conn->connect_error); 
}
else
{ 
//connection OK - get records for the selected User account

$queryCheck = "SELECT * FROM user WHERE username = '".$username."'";

$resultCheck = $conn->query($queryCheck); 

    if ($resultCheck->num_rows == 0) 
    { //if no record match
?>
        <script type="text/javascript">
            alert("Incorrect Username");
            window.location.href = "index.html";
        </script>
<?php
	}
	else
    {	// record matched, get the data
	    while($row = $resultCheck->fetch_assoc()) {
		
	        if( $row["password"] == $password ) 
            {
                session_start();
                $_SESSION["username"] = $username ;
                $_SESSION["type"] = $row["type"];
                $_SESSION["name"] = $row["name"];
                //redirect to page homepage.php
                header("Location:homepage.php");
		    }
            else
            {
?>
                <script type="text/javascript">
                    alert("Incorrect Password");
                    window.location.href = "index.html";
                </script>
<?php
            }
        }
    }
}
$conn->close();
?>
