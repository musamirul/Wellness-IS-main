<?php
echo $recordID = $_POST['recordID'];
echo $mrn = $_POST['mrn'];
echo $visits = $_POST['visits'];
echo $ic = $_POST['ic'];

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

$display = "SELECT * FROM record WHERE recordID = '$recordID'";
$result = mysqli_query($conn,$display);
while($row=mysqli_fetch_array($result)){
    echo $row['mrn'];
    echo "<br/>";
    echo $row['mrn'];
    echo "<br/>";
    echo $row['mrn'];
    echo "<br/>";
}

$query1 = "SELECT * FROM patient
                    INNER JOIN record
                    ON patient.ic_passport = record.fk_patient_ic WHERE patient.ic_passport = '$ic' AND record.recordID='$recordID'
                    ";
$result1 = mysqli_query($conn,$display);
while($row1=mysqli_fetch_array($result1)){
    echo $row1['recordID'];
    echo $row1['address'];
    echo $row1['mrn'];
    echo $row1['date_of_birth'];
}
                        
/*$queryRec = "SELECT * FROM record WHERE fk_patient_ic = '9106305124321'";
$resultRec = mysqli_query($conn,$queryRec);
if ($resultRec->num_rows > 0) {
    $currentID = $row['recordID'];
    while($row=mysqli_fetch_array($resultRec)){
        if($row['recordID'] > $currentID){
            $currentID = $row['recordID'];
        }
        
    }
}

echo $currentID;

$display = "SELECT * FROM record WHERE recordID = '37' AND visits = '3'";
$query = mysqli_query($conn,$display);
while($row = mysqli_fetch_array($query)){
    echo $row['mrn'];
}*/
?>