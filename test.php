<!DOCTYPE html>
<html>
    <head>
        
    </head>
    <body>
        <?php
            


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
        
            
					//$query1 = "SELECT a.mrn, name, ic_passport, 
                    //addonsUsed, lastUpdate, packageUsed, visits  
                    //FROM patient a, record b WHERE a.mrn = '$mrn' 
                    //AND b.mrn = '$mrn'";
                    /*$query2 = "
                    SELECT a.mrn, a.name, a.ic_passport, 
                    a.package, a.lastUpdateMH, a.registeredOn, a.lastUpdateOn, 
                    a.addons FROM patient a, record b WHERE a.mrn = '$mrn'";
                    $query3 = "
                    SELECT patient.mrn, patient.name, patient.ic_passport, 
                    record.lastUpdate,record.visits, record.packageUsed, record.addonsUsed,  
                    FROM patient 
                    INNER JOIN record
                    ON patient.mrn=record.mrn";
                    
                    $result = mysqli_query($conn, $query3);
                    while($row2 = mysqli_fetch_array($result)){
                        echo $row2['mrn'];
                    }

                    $query2 = "
                    SELECT patient.mrn, patient.name, patient.ic_passport, 
                    record.lastUpdate,record.visits, record.packageUsed, record.addonsUsed,  
                    FROM patient 
                    INNER JOIN record
                    ON patient.mrn = record.mrn WHERE patient.mrn = '$mrn'";
                    
					$rs_result = mysqli_query ($conn, $query2);     
                    $i = 1;
					
                    while ($row = mysqli_fetch_array($rs_result)) {  
					echo $row['mrn'];
					echo $row['name'];
					echo $mrn;
                    };*/

 
                $query = "SELECT patient.mrn, patient.name, patient.ic_passport,
                record.mrn, record.nose, record.throat
                FROM patient
                LEFT JOIN record
                ON patient.mrn = record.mrn WHERE patient.mrn = '10000'
                ";

                $result = mysqli_query($conn, $query);
                while($row = mysqli_fetch_array($result)){
                    echo $row['throat'];
                }


                $query = "SELECT patient.mrn, patient.name, patient.ic_passport,
                record.mrn, record.nose, record.throat
                FROM record
                INNER JOIN patient
                ON patient.ic_passport = record.fk_mrn WHERE patient.ic_passport = '12345678945612'
                ";

                $result = mysqli_query($conn, $query);
                while($row = mysqli_fetch_array($result)){
                    echo $row['mrn'];
                    echo '<br />';
                    echo $row['name'];
                    echo '<br />';
                    echo $row['ic_passport'];
                    echo '<br />';
                    echo $row['throat'];
                    echo '<br />';
                    echo $row['mrn'];
                }


                $query = "SELECT patient.mrn, patient.name, patient.ic_passport,
                record.mrn, record.nose, record.throat, record.lastUpdate, record.visits, record.packageUsed
                FROM patient
                INNER JOIN record
                ON patient.ic_passport = record.fk_mrn WHERE patient.ic_passport = '12345678945612'
                ";

                $result = mysqli_query($conn, $query);
                while($row = mysqli_fetch_array($result)){
                    echo $row['mrn'];
                    echo '<br />';
                    echo $row['name'];
                    echo '<br />';
                    echo $row['ic_passport'];
                    echo '<br />';
                    echo $row['nose'];
                    echo '<br />';
                    echo $row['throat'];
                    echo '<br />';
                    echo $row['lastUpdate'];
                    echo '<br />';
                    echo $row['visits'];
                    echo '<br />';
                    echo $row['packageUsed'];
                }
        ?>
                    
    </body>
</html>