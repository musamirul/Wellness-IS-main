
<html>
    <?php
        session_start();
        if(isset($_SESSION["username"])) {
    ?>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>KPJ Klang Wellness IS</title>
        <link rel="stylesheet" href="wellness.css">
        <link rel="stylesheet" href="bootstrap.css">
    </head>
    <body>
        <?php
            $mrn = $_POST["mrn"];
            $newmrn = $_POST["newmrn"];
            $servername = "localhost";
            $username = "root";
            $password = "";
            $db = "wellness_is";
            date_default_timezone_set("Asia/Kuala_Lumpur");

            $conn = new mysqli($servername, $username, $password, $db);

            if ($conn->connect_error)
            {
                die("Connection failed: " . $conn->connect_error);
            }

            $update = "UPDATE patient SET mrn = '".$newmrn."' WHERE mrn = '".$mrn."'";
            $data = $conn->query($update);

            if ($data === TRUE) 
            {
                echo "<script type='text/javascript'>";
                echo "alert('Changes Successful');";
                echo "window.location.href = 'managePatient.php';";
                echo "</script>";
            }
            else
            {
                echo "<script type='text/javascript'>";
                echo "alert('Changes Failed. MRN alredy exist');";
                echo "window.location.href = 'managePatient.php';";
                echo "</script>";
            }
            }
            else
            {
                echo "<script type='text/javascript'>";
                echo "alert('Session does not exist. Please login again');";
                echo "window.location.href = 'index.html';";
                echo "</script>";
            }   
            ?>
    </body>
</html>