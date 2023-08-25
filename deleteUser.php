<!DOCTYPE html>
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
            $id = $_POST["id"];
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

            $delete = "DELETE FROM user WHERE ID = '".$id."'";
            $data = $conn->query($delete);

            if ($data === TRUE)
            {
                echo "<script type='text/javascript'>";
                echo "alert('User successfully deleted;";
                echo "window.location.href = 'viewUser.php';";
                echo "</script>";
            }
            else
            {
                echo "Error : " . $conn->error;
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