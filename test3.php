<!DOCTYPE htmL>
<html>
    <?php
        session_start();
        //if(isset($_SESSION["username"])) {
    ?>
    <head>
        <title>Health Screening Record Form</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <!--<link rel="stylesheet" href="wellness.css">-->
        <!--<link rel="stylesheet" href="bootstrap.css">-->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
        <?php
            
            $servername = "localhost";
            $username = "root";
            $password = "";
            $db = "wellness_is";
            date_default_timezone_set("Asia/Kuala_Lumpur");
            $date = date("Y-m-d H:i:s");

            $conn = new mysqli($servername, $username, $password, $db);

            if ($conn->connect_error)
            {
                die("Connection failed: " . $conn->connect_error);
            }
        ?>
    </head>
    
    <body>
            <?php 
                $query = "SELECT * FROM patient WHERE mrn = '1234'";
                $result = mysqli_query($conn,$query);
                while($row=mysqli_fetch_array($result)){
                    echo $row['mrn'];
                    echo $row['diabetes'];

                    if($row['diabetes']=="YES"){
                        echo "yessss";
                    }
                }

                
            ?>
            
    </body>
</html>