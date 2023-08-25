<!DOCTYPE html>
<html>
    <?php
        session_start();
        if(isset($_SESSION["username"])) {
    ?>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Records List</title>
        <link rel="stylesheet" href="wellness.css">
        <link rel="stylesheet" href="bootstrap.css">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    </head>
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
        ?>
    <body style="text-align: center;">
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
                        <a class="nav-link active" href="viewRecords.php">Records</a>
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
        <h1 style='color: white; margin-bottom: 30px;'>Records</h1>
            <form method="post" style="text-align: center; color: white;">
                Between <input type="date" name="startDate"> And
                <input type="date" name="endDate">
                <button formaction="searchRecords.php" class="btn btn-primary">Search</button>
            </form>
            <div class="text-center" style="color: white;">
                Click <a href="viewPatient.php">here</a> if you want to view patients list.
            </div>
        <br>
            <div style="text-align: right;" id="filtering">
                <form method="post">
                    <select id="package" name="filterPackage" class="btn filter">
                        <option value="" selected hidden>By Package</option>
                        <option value="">Any</option>
                        <option value="Essential">Essential</option>
                        <option value="Comprehensive">Comprehensive</option>
                        <option value="Premium">Premium</option>
                        <option value="Custom">Custom</option>
                    </select>
                    <button formaction="<?php echo htmlentities($_SERVER['PHP_SELF']);?>" style="border: none;">
                        <img src="filter.svg" style="height: 30px; width:15px; float:center; text-align: center">
                    </button>
                    <input type="hidden" name="filter" value="">
                </form>
            </div>
            <table style="width: 100%;" height="100%" class="table table-striped">
                <thead class="table-dark" style="text-align:center;">
                    <tr>
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
                        <th colspan="6">
                            Last Updated On
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
                    <tr>
                        <th colspan="2">
                            Medical History
                        </th>
                        <th colspan="2">
                            Report Form
                        </th>
                        <th colspan="2">
                            Physical Exam On
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
                    
                    if (isset($_POST["filter"])){
                        $filterPackage = $_POST["filterPackage"];
                        if (!empty($filterPackage)){
                            $query =    "SELECT a.mrn, name, ic_passport, addonsUsed, lastUpdateMH, lastUpdate, phyExam, packageUsed, visits 
                                        FROM patient a, record b 
                                        WHERE a.mrn = b.mrn AND packageUsed = '".$filterPackage."'
                                        ORDER BY lastUpdate 
                                        DESC LIMIT ". $start_from. ", " .$per_page_record;
                        }else{
                            $query =    "SELECT a.mrn, name, ic_passport, addonsUsed, lastUpdateMH, lastUpdate, phyExam, packageUsed, visits 
                                        FROM patient a, record b   
                                        WHERE a.mrn = b.mrn
                                        ORDER BY lastUpdate DESC LIMIT ". $start_from. ", " .$per_page_record;
                        }
                    }else{
                        $query =    "SELECT a.mrn, name, ic_passport, addonsUsed, lastUpdateMH, lastUpdate, phyExam, packageUsed, visits 
                                    FROM patient a, record b   
                                    WHERE a.mrn = b.mrn 
                                    ORDER BY lastUpdate DESC LIMIT ". $start_from. ", " .$per_page_record;
                    }
                    $rs_result = mysqli_query ($conn, $query);     


                    while ($row = mysqli_fetch_array($rs_result)) {  
                ?> 
                
                    <tr>
                        <td><?php echo $row['mrn'];?></td>
                        <td><?php echo $row['name'];?></td>
                        <td><?php echo $row['ic_passport'];?></td>
                        <td><?php echo nl2br($row['addonsUsed']);?></td>
                        <td colspan="2"><?php echo $row['lastUpdateMH'];?></td>
                        <td colspan="2"><?php echo $row['lastUpdate'];?></td>
                        <td colspan="2"><?php echo $row['phyExam'];?></td>
                        <td><?php echo $row['packageUsed'];?></td>
                        <td><?php echo $row['visits'];?></td>
                        <td style="text-align: right;">
                            <form method="post">
                            <input type="hidden" name="mrn" value="<?php echo $row['mrn'];?>">
                            <input type="hidden" name="visits" value="<?php echo $row["visits"];?>">
                            <button formaction="viewDetails.php" class="btn btn-primary">View</button>
                            </form>
                        </td>
                    </tr>
                
            <?php
            }  
            ?>
                </tbody>
            </table>
                <?php
                
                if (isset($_POST["filter"])){
                    $filterPackage = $_POST["filterPackage"];
                    if (!empty($filterPackage)){
                        $query =    "SELECT COUNT(*) 
                                    FROM patient a, record b 
                                    WHERE a.mrn = b.mrn AND packageUsed = '".$filterPackage."'
                                    ORDER BY registeredOn 
                                    DESC LIMIT ". $start_from. ", " .$per_page_record;
                    }else{
                        $query =    "SELECT COUNT(*)
                                    FROM patient a, record b   
                                    WHERE a.mrn = b.mrn
                                    ORDER BY lastUpdate DESC LIMIT ". $start_from. ", " .$per_page_record;
                    }
                }else{
                    $query =    "SELECT COUNT(*)
                                FROM patient a, record b   
                                WHERE a.mrn = b.mrn 
                                ORDER BY lastUpdate DESC LIMIT ". $start_from. ", " .$per_page_record;
                }    
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
                    echo "<span style='color: white; text-align: left;'>Showing " .$start. '-' .$end. ' of ' . $total_records . " result(s).</span>";
                    echo "</br>"; 
                }            
                $pagLink = "";       

                echo "<nav aria-label='page nav'>";
                echo "<ul class='pagination justify-content-center'>";
                if($page>=2){   
                    echo "<li class='page-item'><a class='page-link' href='viewRecords.php?page=".($page-1)."'>  Prev </a></li>";   
                }       
                        
                for ($i=1; $i<=$total_pages; $i++) {   
                if ($i == $page) {   
                    $pagLink .= "<li class='page-item active'><a class ='page-link' href='viewRecords.php?page=" .$i."'>".$i." </a> </li>"; 
                                                          
                }               
                else  {   
                    $pagLink .= "<li class='page-item'><a class='page-link' href='viewRecords.php?page=".$i."'> ".$i." </a> </li>";  
                                                             
                }   
                };     
                echo $pagLink;   
        
                if($page<$total_pages){   
                    echo "<li class='page-item'><a class='page-link' href='viewRecords.php?page=".($page+1)."'>  Next </a></li>";   
                }  
                echo "</ul>";
                echo "</nav>";

                $conn->close();
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