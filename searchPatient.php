<!DOCTYPE html>
<html>
    <?php
        session_start();
        if(isset($_SESSION["username"])) {
    ?>
    <head>
        <title>Search Patient</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="wellness.css">
        <link rel="stylesheet" href="bootstrap.css">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    </head>
        <?php
            $kw = $_POST["keyword"];
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
        <body>
            <nav class="navbar sticky-top navbar-expand-sm bg-dark navbar-dark">
                <div class="container-sm">
                    <ul class="navbar-nav">
                        <li class="nav-item">
                            <a class="nav-link" href="homepage.php">Home</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active" href="viewPatient.php">Patients</a>
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
            <h1 style='color: white;'>Patients</h1>
            <br>
            <form method="post" style="text-align: center;">
                <input type="text" placeholder="MRN/Name/IC/Passport/Email/Telephone" name="keyword" value="<?php echo $kw;?>">
                <button formaction="searchPatient.php" class="btn btn-primary">Search</button>
            </form>
            <div class="text-center" style='color: white;'>
                Click <a href="viewRecords.php">here</a> if you want to search for patient's record.
            </div>
            <br>
            <div style="text-align: right;" id="filtering">
                <form method="post">
                    <span style="color: white;">Filter:</span>
                    <select id="disease" name="filterDisease" class="btn filter">
                        <option value="" selected hidden>By Disease</option>
                        <option value="">Any</option>
                        <option value="smoker">Smoker</option>
                        <option value="asthma">Asthma</option>
                        <option value="diabetes">Diabetes</option>
                        <option value="heart_disease">Heart Disease</option>
                        <option value="hypertension">Hypertension</option>
                        <option value="stroke">Stroke</option>
                        <option value="cancer">Cancer</option>
                        <option value="tuberculosis">Tuberculosis</option>
                        <option value="skin_disease">Skin Disease</option>
                        <option value="kidneyp">Kidney Problem</option>
                        <option value="fits_psychiatric">Fits & Psychiatric</option>
                    </select>        
                    <select id="sex" name="filterSex" class="btn filter">
                        <option value="" selected hidden>By Sex</option>
                        <option value="">Any</option>
                        <option value="Male">Male</option>
                        <option value="Female">Female</option>
                    </select>
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
                    <input type="hidden" name="keyword" value="<?php echo $kw;?>">
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
                                Address
                            </th>
                            <th rowspan="2">
                                Email
                            </th>
                            <th rowspan="2">
                                Telephone
                            </th>
                            </th>
                            <th rowspan="2">
                                Registered On
                            </th>
                            <th rowspan="2">
                                Package
                            </th>
                            <th rowspan="2">
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
                        if (isset($_POST["filter"])){
                            $filterDisease = $_POST["filterDisease"];
                            $filterSex = $_POST["filterSex"];
                            $filterPackage = $_POST["filterPackage"];
                            if (!empty($filterDisease) AND !empty($filterSex) AND !empty($filterPackage)){
                                $query =    "SELECT mrn, name, ic_passport, address, email, telephone, registeredOn, package
                                            FROM patient 
                                            WHERE $filterDisease = 'Yes' AND sex = '".$filterSex."' AND package = '".$filterPackage."' AND (mrn LIKE '%$kw%' OR name LIKE '%$kw%' OR ic_passport LIKE '%$kw%' OR email LIKE '%$kw%' OR telephone LIKE '%$kw%')
                                            ORDER BY registeredOn 
                                            DESC LIMIT ". $start_from. ", " .$per_page_record;
                            }
                            elseif (!empty($filterDisease) AND !empty($filterSex) AND empty($filterPackage)){
                                $query =    "SELECT mrn, name, ic_passport, address, email, telephone, registeredOn, package
                                            FROM patient 
                                            WHERE $filterDisease = 'Yes' AND sex = '".$filterSex."' AND (mrn LIKE '%$kw%' OR name LIKE '%$kw%' OR ic_passport LIKE '%$kw%' OR email LIKE '%$kw%' OR telephone LIKE '%$kw%')
                                            ORDER BY registeredOn 
                                            DESC LIMIT ". $start_from. ", " .$per_page_record;
                            }
                            elseif (!empty($filterDisease) AND empty($filterSex) AND empty($filterPackage)){
                                $query =    "SELECT mrn, name, ic_passport, address, email, telephone, registeredOn, package
                                            FROM patient 
                                            WHERE $filterDisease = 'Yes' AND (mrn LIKE '%$kw%' OR name LIKE '%$kw%' OR ic_passport LIKE '%$kw%' OR email LIKE '%$kw%' OR telephone LIKE '%$kw%')
                                            ORDER BY registeredOn 
                                            DESC LIMIT ". $start_from. ", " .$per_page_record;
                            }
                            elseif (empty($filterDisease) AND !empty($filterSex) AND !empty($filterPackage)){
                                $query =    "SELECT mrn, name, ic_passport, address, email, telephone, registeredOn, package
                                            FROM patient 
                                            WHERE sex = '".$filterSex."' AND package = '".$filterPackage."' AND (mrn LIKE '%$kw%' OR name LIKE '%$kw%' OR ic_passport LIKE '%$kw%' OR email LIKE '%$kw%' OR telephone LIKE '%$kw%')
                                            ORDER BY registeredOn 
                                            DESC LIMIT ". $start_from. ", " .$per_page_record;
                            }
                            elseif (empty($filterDisease) AND empty($filterSex) AND !empty($filterPackage)){
                                $query =    "SELECT mrn, name, ic_passport, address, email, telephone, registeredOn, package
                                            FROM patient 
                                            WHERE package = '".$filterPackage."' AND (mrn LIKE '%$kw%' OR name LIKE '%$kw%' OR ic_passport LIKE '%$kw%' OR email LIKE '%$kw%' OR telephone LIKE '%$kw%')
                                            ORDER BY registeredOn 
                                            DESC LIMIT ". $start_from. ", " .$per_page_record;
                            }
                            elseif (!empty($filterDisease) AND empty($filterSex) AND !empty($filterPackage)){
                                $query =    "SELECT mrn, name, ic_passport, address, email, telephone, registeredOn, package
                                            FROM patient 
                                            WHERE $filterDisease = 'Yes' AND package = '".$filterPackage."' AND (mrn LIKE '%$kw%' OR name LIKE '%$kw%' OR ic_passport LIKE '%$kw%' OR email LIKE '%$kw%' OR telephone LIKE '%$kw%')
                                            ORDER BY registeredOn 
                                            DESC LIMIT ". $start_from. ", " .$per_page_record;
                            }
                            elseif (empty($filterDisease) AND !empty($filterSex) AND empty($filterPackage)){
                                $query =    "SELECT mrn, name, ic_passport, address, email, telephone, registeredOn, package
                                            FROM patient 
                                            WHERE sex = '".$filterSex."' AND (mrn LIKE '%$kw%' OR name LIKE '%$kw%' OR ic_passport LIKE '%$kw%' OR email LIKE '%$kw%' OR telephone LIKE '%$kw%')
                                            ORDER BY registeredOn 
                                            DESC LIMIT ". $start_from. ", " .$per_page_record;
                            }
                            else{
                                $query =    "SELECT mrn, name, ic_passport, address, email, telephone, registeredOn, package 
                                            FROM patient 
                                            WHERE mrn LIKE '%$kw%' OR name LIKE '%$kw%' OR ic_passport LIKE '%$kw%' OR email LIKE '%$kw%' OR telephone LIKE '%$kw%' 
                                            ORDER BY registeredOn DESC LIMIT ". $start_from. ", " .$per_page_record;
                            }
    
                        }
                        else{     
                            $query =    "SELECT mrn, name, ic_passport, address, email, telephone, registeredOn, package 
                                        FROM patient 
                                        WHERE mrn LIKE '%$kw%' OR name LIKE '%$kw%' OR ic_passport LIKE '%$kw%' OR email LIKE '%$kw%' OR telephone LIKE '%$kw%' 
                                        ORDER BY registeredOn DESC LIMIT ". $start_from. ", " .$per_page_record;
                        }
                        
                        $rs_result = mysqli_query ($conn, $query);     

                        while ($row = mysqli_fetch_array($rs_result)) { 
                    ?> 
                    
                        <tr>
                            <td><?php echo $row['mrn'];?></td>
                            <td><?php echo $row['name'];?></td>
                            <td><?php echo $row['ic_passport'];?></td>
                            <td><?php echo nl2br($row['address']);?></td>
                            <td><?php echo $row['email'];?></td>
                            <td><?php echo $row['telephone'];?></td>
                            <td><?php echo $row['registeredOn'];?></td>
                            <td><?php echo $row['package'];?></td>
                            <td>
                                <form method="post">
                                <input type="hidden" name="mrn" value="<?php echo $row['mrn'];?>">
                                <button formaction="selectRecord.php" class="btn btn-primary">View</button>
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
                $filterDisease = $_POST["filterDisease"];
                $filterSex = $_POST["filterSex"];
                $filterPackage = $_POST["filterPackage"];
                if (!empty($filterDisease) AND !empty($filterSex) AND !empty($filterPackage)){
                    $query =    "SELECT COUNT(*)
                                FROM patient 
                                WHERE $filterDisease = 'Yes' AND sex = '".$filterSex."' AND package = '".$filterPackage."' AND (mrn LIKE '%$kw%' OR name LIKE '%$kw%' OR ic_passport LIKE '%$kw%' OR email LIKE '%$kw%' OR telephone LIKE '%$kw%')
                                ORDER BY registeredOn 
                                DESC LIMIT ". $start_from. ", " .$per_page_record;
                }
                elseif (!empty($filterDisease) AND !empty($filterSex) AND empty($filterPackage)){
                    $query =    "SELECT COUNT(*)
                                FROM patient 
                                WHERE $filterDisease = 'Yes' AND sex = '".$filterSex."' AND (mrn LIKE '%$kw%' OR name LIKE '%$kw%' OR ic_passport LIKE '%$kw%' OR email LIKE '%$kw%' OR telephone LIKE '%$kw%')
                                ORDER BY registeredOn 
                                DESC LIMIT ". $start_from. ", " .$per_page_record;
                }
                elseif (!empty($filterDisease) AND empty($filterSex) AND empty($filterPackage)){
                    $query =    "SELECT COUNT(*)
                                FROM patient 
                                WHERE $filterDisease = 'Yes' AND (mrn LIKE '%$kw%' OR name LIKE '%$kw%' OR ic_passport LIKE '%$kw%' OR email LIKE '%$kw%' OR telephone LIKE '%$kw%')
                                ORDER BY registeredOn 
                                DESC LIMIT ". $start_from. ", " .$per_page_record;
                }
                elseif (empty($filterDisease) AND !empty($filterSex) AND !empty($filterPackage)){
                    $query =    "SELECT COUNT(*)
                                FROM patient 
                                WHERE sex = '".$filterSex."' AND package = '".$filterPackage."' AND (mrn LIKE '%$kw%' OR name LIKE '%$kw%' OR ic_passport LIKE '%$kw%' OR email LIKE '%$kw%' OR telephone LIKE '%$kw%')
                                ORDER BY registeredOn 
                                DESC LIMIT ". $start_from. ", " .$per_page_record;
                }
                elseif (empty($filterDisease) AND empty($filterSex) AND !empty($filterPackage)){
                    $query =    "SELECT COUNT(*)
                                FROM patient 
                                WHERE package = '".$filterPackage."' AND (mrn LIKE '%$kw%' OR name LIKE '%$kw%' OR ic_passport LIKE '%$kw%' OR email LIKE '%$kw%' OR telephone LIKE '%$kw%')
                                ORDER BY registeredOn 
                                DESC LIMIT ". $start_from. ", " .$per_page_record;
                }
                elseif (!empty($filterDisease) AND empty($filterSex) AND !empty($filterPackage)){
                    $query =    "SELECT COUNT(*)
                                FROM patient 
                                WHERE $filterDisease = 'Yes' AND package = '".$filterPackage."' AND (mrn LIKE '%$kw%' OR name LIKE '%$kw%' OR ic_passport LIKE '%$kw%' OR email LIKE '%$kw%' OR telephone LIKE '%$kw%')
                                ORDER BY registeredOn 
                                DESC LIMIT ". $start_from. ", " .$per_page_record;
                }
                elseif (empty($filterDisease) AND !empty($filterSex) AND empty($filterPackage)){
                    $query =    "SELECT COUNT(*)
                                FROM patient 
                                WHERE sex = '".$filterSex."' AND (mrn LIKE '%$kw%' OR name LIKE '%$kw%' OR ic_passport LIKE '%$kw%' OR email LIKE '%$kw%' OR telephone LIKE '%$kw%')
                                ORDER BY registeredOn 
                                DESC LIMIT ". $start_from. ", " .$per_page_record;
                }
                else{
                    $query =    "SELECT COUNT(*)
                                FROM patient 
                                WHERE mrn LIKE '%$kw%' OR name LIKE '%$kw%' OR ic_passport LIKE '%$kw%' OR email LIKE '%$kw%' OR telephone LIKE '%$kw%' 
                                ORDER BY registeredOn DESC LIMIT ". $start_from. ", " .$per_page_record;
                }

            }
            else{     
                $query =    "SELECT COUNT(*)
                            FROM patient 
                            WHERE mrn LIKE '%$kw%' OR name LIKE '%$kw%' OR ic_passport LIKE '%$kw%' OR email LIKE '%$kw%' OR telephone LIKE '%$kw%' 
                            ORDER BY registeredOn DESC LIMIT ". $start_from. ", " .$per_page_record;
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
                echo "<span style='color: white;'>Showing " .$start. '-' .$end. ' of ' . $total_records . " result(s).</span>";
                echo "</br>"; 
            }  
            $pagLink = "";       

            echo "<nav aria-label='page nav'>";
            echo "<ul class='pagination justify-content-center'>";
            if($page>=2){   
                echo "<li class='page-item'><form method='post'><input type='hidden' value='$kw' name='keyword'><button class='page-link' formaction='searchPatient.php?page=".($page-1)."'>  Prev </button></form></li>";   
            }       
                    
            for ($i=1; $i<=$total_pages; $i++) {   
            if ($i == $page) {   
                $pagLink .= "<li class='page-item active'><form method='post'><input type='hidden' value='$kw' name='keyword'><button class ='page-link active' formaction='searchPatient.php?page=" .$i."'>".$i." </button></form></li>"; 
                                                      
            }               
            else  {   
                $pagLink .= "<li class='page-item'><form method='post'><input type='hidden' value='$kw' name='keyword'><button class ='page-link' formaction='searchPatient.php?page=".$i."'> ".$i." </button></form></li>";  
                                                         
            }   
            };     
            echo $pagLink;   
    
            if($page<$total_pages){   
                echo "<li class='page-item'><form method='post'><input type='hidden' value='$kw' name='keyword'><button class='page-link' formaction='searchPatient.php?page=".($page+1)."'>  Next </button></form></li>";   
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