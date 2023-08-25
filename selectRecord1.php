<!DOCTYPE html>
<html>
    <?php
        session_start();
        if(isset($_SESSION["username"])) {
    ?>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Patient's Overview</title>
        <link rel="stylesheet" href="wellness.css">
        <link rel="stylesheet" href="bootstrap.css">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
        <style>
            .unstyled-button {
                border: none;
                padding: 0;
                background: none;
                text-decoration: underline;
                color: blue;
            }
        </style>
    </head>
    <body>
        <?php
            //$mrn = $_POST["mrn"];
            $mrn = '12345678';

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
        ?>
        <nav class="navbar sticky-top navbar-expand-sm bg-dark navbar-dark">
                <div class="container-sm">
                    <ul class="navbar-nav">
                        <li class="nav-item">
                            <a class="nav-link" href="homepage.php">Home</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="viewPatient.php">Patients</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="viewRecords.php">Records</a>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" id="analysis" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                Analysis
                            </a>
                            <ul class="dropdown-menu" aria-labelledby="analysis">
                                <li><a class="dropdown-item" href="patientAnalysis.php">Patient's Analysis</a></li>
                                <li><a class="dropdown-item" href="recordAnalysis.php">Record's Analysis</a></li>
                            </ul>
                        </li>
                        <?php
                        if($_SESSION["type"] == "admin"){
                        ?>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" id="adminTools" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                Administrator
                            </a>
                            <ul class="dropdown-menu" aria-labelledby="adminTools">
                                <li><a class="dropdown-item" href="viewUser.php">View User</a></li>
                                <li><a class="dropdown-item" href="managePatient.php">Manage Patients</a></li>
                                <li><a class="dropdown-item" href="manageRecords.php">Manage Records</a></li>
                            </ul>
                        </li>
                        <?php
                            }
                        ?>
                    </ul>
                    <form class="d-flex" method="post" style="margin-left: 400px;">
                        <input type="search" class="form-control me-2" placeholder="Search" aria-label="Search" name="mrn">
                        <button class="btn btn-outline-success" formaction="selectRecord.php">Search</button>
                    </form>
                </div>
                <a class="btn btn-danger" href="logout.php" style="color: white; font-weight: 700; margin-right: 30px">Logout</a>
            </nav>
        <br>
        <h1 style='color: white;'>Patient's Overview</h1>
        <br>
        <div class="container" style=" height: 250px;">
            <form method="post" style="text-align: center;">
                <label for="mrn">Enter Patient's MRN</label><br>
                <input type="text" id="mrn" name="mrn" maxlength="10" required autofocus>
                <button formaction="selectRecord.php" class="btn btn-primary">Search</button>
            </form>
            <?php 
                $check ="SELECT mrn FROM patient WHERE mrn = '".$mrn."'";
                $data = $conn->query($check);

                if($data->num_rows > 0)
                {
                    while ($row = $data->fetch_assoc())
                    {
            ?>
                        <div class="text-center">
                            <h5>MRN: <?php echo $mrn;?></h5>
                            <form method="post" style="text-align: center;" class="btn-group">
                                <button formaction="selectRecord.php" class="btn btn-primary active">View Record</button>
                                <button formaction="activeDetails.php" class="btn btn-primary">Latest Details</button>
                                <button formaction="editProfile.php" class="btn btn-primary">Edit Profile</button>
                                <button formaction="checkHistoryForm.php" class="btn btn-primary">Check Medical History</button>  
                                <input type="hidden" name="mrn" value="<?php echo $mrn;?>">
                                <div class="btn-group" role="group">
                                    <button id="btnGroupDrop" type="button" class="btn btn-primary dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                                        Insert
                                    </button>
                                    <ul class="dropdown-menu dropdown-menu-dark" aria-labelledby="btnGroupDrop">
                                        <li>
                                        <?php
                                            //if($_SESSION["type"] == "admin" or $_SESSION["type"] == "doctor")
											{
                                        ?>
                                                <button class="dropdown-item" formaction="recordForm.php">Screening Record</button>
                                        <?php
                                            }
                                        ?>
                                        </li>

                                        <li>
                                            <button class="dropdown-item" formaction="historyForm.php">Medical History</button>
                                        </li>
										   <li>
                                            <button class="dropdown-item" formaction="physicalExam.php">Physical Examinantion</button>
                                        </li>

                                    </ul>
                                </div>
                            </form>
                        </div>
            </div>
            <br>
            <h3 style="text-align: center; margin-top: -5px; color: white;">Records History</h3>
            <table style="width: 100%;" class="table table-striped">
                <thead class="table-dark" style="text-align:center;">
                    <tr>
                        <th rowspan="2">
                            No.
                        </th>
                        <th rowspan="2">
                            MRN
                        </th>
                        <th rowspan="2">
                            Name
                        </th>
                        <th rowspan="2">
                            I/C No/Passport
                        </th>
                        <th rowspan="2">
                            Additional Test
                        </th>
                        <th rowspan="2">
                            Screening Date
                        </th>
                        <th rowspan="2">
                            Package
                        </th>
                        <th rowspan="2">
                            Visits
                        </th>
                        <th rowspan="2" style="text-align: right;">
                            Actions
                        </th>
                    </tr>
                </thead>
                <tbody style="background-color: white;">
                <?php
                    $per_page_record = 10;  // Number of entries to show in a page.   
                    // Look for a GET variable page if not found default is 1.        
                    if (isset($_GET["page"])) {    
                        $page  = $_GET["page"];    
                    }    
                    else {    
                    $page=1;    
                    }    
                
                    $start_from = ($page-1) * $per_page_record;     
					//$query1 = "SELECT a.mrn, name, ic_passport, 
                    //addonsUsed, lastUpdate, packageUsed, visits  
                    //FROM patient a, record b WHERE a.mrn = '$mrn' 
                    //AND b.mrn = '$mrn'";
                    /*$query2 = "
                    SELECT a.mrn, a.name, a.ic_passport, 
                    a.package, a.lastUpdateMH, a.registeredOn, a.lastUpdateOn, 
                    a.addons FROM patient a, record b WHERE a.mrn = '$mrn'";*/

                $query3 = "SELECT patient.mrn, patient.name, patient.ic_passport,
                record.mrn, record.lastUpdate, record.visits, record.packageUsed, record.addonsUsed
                FROM patient
                INNER JOIN record
                ON patient.ic_passport = record.fk_patient_ic WHERE patient.ic_passport = '12345678945612'
                ";
                    
					$rs_result = mysqli_query ($conn, $query3);     
                    $i = 1;
					
                    while ($row = mysqli_fetch_array($rs_result)) {  
					
                ?> 
                    <tr>
                        <td>
                            <?php echo $i;?>
                        </td>
                        <td>
                            <?php echo $row["mrn"];?>
                        </td>
                        <td>
                            <?php echo $row["name"];?>
                        </td>
                        <td>
                            <?php echo $row["ic_passport"];?>
                        </td>
                        <td>
                            <?php echo nl2br($row["addonsUsed"]);?>
                        </td>
                        <td>
                            <?php echo $row["visits"];?>
                        </td>
                        <td>
                            <?php echo $row["packageUsed"];?>
                        </td>
                        <td>
                            <?php echo $row["lastUpdateOn"];?>
                        </td>
                        <td style="text-align: right;">
                            <form method="post">
                                <input type="hidden" name="mrn" value="<?php echo $row['mrn'];?>">
                                <input type="hidden" name="visits" value="<?php echo $row["visits"];?>">
                                <button formaction="viewDetails.php" class="btn btn-primary">View</button>
                            </form>
                        </td>
                    </tr>
                <?php
                    $i++;
                    }
                ?>
                </tbody>
            </table>

            <h3 style="text-align: center; margin-top: -5px; color: white;">Records History</h3>
            <table style="width: 100%;" class="table table-striped">
                <thead class="table-dark" style="text-align:center;">
                    <tr>
                        <th rowspan="2">
                            No.
                        </th>
                        <th rowspan="2">
                            MRN
                        </th>
                        <th rowspan="2">
                            Name
                        </th>
                        <th rowspan="2">
                            I/C No/Passport
                        </th>
                        <th rowspan="2">
                            Additional Test
                        </th>
                        <th rowspan="2">
                            Screening Date
                        </th>
                        <th rowspan="2">
                            Package
                        </th>
                        <th rowspan="2">
                            Visits
                        </th>
                        <th rowspan="2" style="text-align: right;">
                            Actions
                        </th>
                    </tr>
                </thead>
                <tbody style="background-color: white;">
                <?php
                    $per_page_record = 10;  // Number of entries to show in a page.   
                    // Look for a GET variable page if not found default is 1.        
                    if (isset($_GET["page"])) {    
                        $page  = $_GET["page"];    
                    }    
                    else {    
                    $page=1;    
                    }    
                
                    $start_from = ($page-1) * $per_page_record;     
					//$query1 = "SELECT a.mrn, name, ic_passport, addonsUsed, lastUpdate, packageUsed, visits  FROM patient a, record b WHERE a.mrn = '$mrn' AND b.mrn = '$mrn'";
                    $query1 = "SELECT a.mrn, name, ic_passport, addonsUsed, lastUpdate, packageUsed, visits  FROM patient a, record b WHERE a.mrn = '$mrn' AND b.mrn = '$mrn' ORDER BY lastUpdate DESC LIMIT ". $start_from. ", " .$per_page_record;
                    
					$rs_result = mysqli_query ($conn, $query1);     
                    $i = 1;
					
                    while ($row = mysqli_fetch_array($rs_result)) {  
					echo $row['mrn'];
					echo $row['name'];
					echo $mrn;
                ?> 
                    <tr>
                        <td>
                            <?php echo $i;?>
                        </td>
                        <td>
                            <?php echo $row["mrn"];?>
                        </td>
                        <td>
                            <?php echo $row["name"];?>
                        </td>
                        <td>
                            <?php echo $row["ic_passport"];?>
                        </td>
                        <td>
                            <?php echo nl2br($row["addonsUsed"]);?>
                        </td>
                        <td>
                            <?php echo $row["lastUpdate"];?>
                        </td>
                        <td>
                            <?php echo $row["packageUsed"];?>
                        </td>
                        <td>
                            <?php echo $row["visits"];?>
                        </td>
                        <td style="text-align: right;">
                            <form method="post">
                                <input type="hidden" name="mrn" value="<?php echo $row['mrn'];?>">
                                <input type="hidden" name="visits" value="<?php echo $row["visits"];?>">
                                <button formaction="viewDetails.php" class="btn btn-primary">View</button>
                            </form>
                        </td>
                    </tr>
                <?php
                    $i++;
                    }
                ?>
                </tbody>
            </table>
        </div>
            <?php
                $query = "SELECT COUNT(*) FROM record WHERE mrn = '$mrn'";     
                $rs_result = mysqli_query($conn, $query);     
                $row = mysqli_fetch_row($rs_result);     
                $total_records = $row[0];     
                $total_pages = ceil($total_records / $per_page_record);
                $start = "";
                $end = "";
                if($total_records == 0){
                    echo "<span class='text-center' style='color: white;'>No Record Found</span>";
                }
                else{
                    $start = $per_page_record * ($page-1) + 1;
                    if($total_records%$per_page_record != 0){
                        if($page == $total_pages){
                            $end = $total_records;
                        }
                        else{
                            $end = $per_page_record * ($page);
                        }
                    }
                    else{
                        $end = $per_page_record * ($page);
                    }
                    echo "<span style='color: white;'>Showing " .$start. '-' .$end. ' of ' . $total_records . " result(s).</span>";
                    echo "</br>"; 
                }       
                $pagLink = "";       

                echo "<nav aria-label='page nav'>";
                echo "<ul class='pagination justify-content-center'>";
                if($page>=2){   
                    echo "<li class='page-item'><form method='post'><input type='hidden' value='$mrn' name='mrn'><button class='page-link' formaction='selectRecord.php?page=".($page-1)."'>  Prev </button></form></li>";   
                }       
                        
                for ($i=1; $i<=$total_pages; $i++) {   
                if ($i == $page) {   
                    $pagLink .= "<li class='page-item active'><form method='post'><input type='hidden' value='$mrn' name='mrn'><button class='page-link active' formaction='selectRecord.php?page=" .$i."'>".$i." </button></form></li>"; 
                                                          
                }               
                else  {   
                    $pagLink .= "<li class='page-item'><form method='post'><input type='hidden' value='$mrn' name='mrn'><button class='page-link' formaction='selectRecord.php?page=".$i."'> ".$i." </button></form></li>";  
                                                             
                }   
                };     
                echo $pagLink;   
        
                if($page<$total_pages){   
                    echo "<li class='page-item'><form method='post'><input type='hidden' value='$mrn' name='mrn'><button class='page-link' formaction='selectRecord.php?page=".($page+1)."'>  Next </button></form></li>";   
                }  
                echo "</ul>";
                echo "</nav>";
            ?>
            <?php
                    }
                }
                        else
                        {
            ?>
                        <form method="post">
                            <p class="text-center" style="margin: 20px;">
                            MRN <?php echo $mrn;?> not found.
                            </p>
                            <p class="text-center" style="margin: 20px;">
                                Patient does not exist, register <button formaction="homepage.php" class="unstyled-button">here</button>
                            </p>
                                <input type="hidden" name="mrn" value="<?php echo $mrn;?>">
                                <input type="hidden" name="check" value="">
                        </form>
            <?php 
                        }
            ?>
    </body>
    <?php
        }
        else
        {
            echo "<script type='text/javascript'>";
            echo "alert('Session does not exist. Please login again');";
            echo "window.location.href = 'index.html';";
            echo "</script>";
        }
    ?>
</html>