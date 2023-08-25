<!DOCTYPE html>
<html>
    <?php
        session_start();
        if(isset($_SESSION["username"])) {
    ?>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Physical Examination</title>
        <link rel="stylesheet" href="wellness.css">
        <link rel="stylesheet" href="bootstrap.css">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    </head>
    <body>
    <?php
        $mrn = $_POST["mrn"];
        $appearance = $_POST["appearance"];
        $weight = $_POST["weight"];
        $height = $_POST["height"];
        $systolic = $_POST["systolic"];
        $diastolic = $_POST["diastolic"];
        $pulse = $_POST["pulse"];
        $va_aidedl = $_POST["va_aidedl"];
        $va_aidedr = $_POST["va_aidedr"];
        $va_unaidedl = $_POST["va_unaidedl"];
        $va_unaidedr = $_POST["va_unaidedr"];
        $colour_l = $_POST["colour_l"];
        $colour_r = $_POST["colour_r"];
        $fundoscopy_l = $_POST["fundoscopy_l"];
        $fundoscopy_r = $_POST["fundoscopy_r"];
        $heightm = $height/100;
        $temp = $weight/($heightm*$heightm);
        $bmi = number_format((float)$temp, 2, '.', '');

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
        <h1 style='color: white;'>Physical Examinantion</h1>
        <br>
        <div class="container">
            <dl class="row">
                <dt class="col-sm-3">General Appearance: </dt>
                <dd class="col-sm-9 text-uppercase"><?php echo $appearance;?></dd>
                <dt class="col-sm-3">Weight: </dt>
                <dd class="col-sm-9"><?php echo $weight;?></dd>
                <dt class="col-sm-3">Height: </dt>
                <dd class="col-sm-9"><?php echo $height;?></dd>
                <dt class="col-sm-3">BMI: </dt>
                <dd class="col-sm-9"><?php echo $bmi;?></dd>
                <dt class="col-sm-3">Blood Pressure: </dt>
                <dd class="col-sm-9"><?php echo $systolic;?>/<?php echo $diastolic;?></dd>
            </dl>
        
            <h3>Eyes</h3>
            <table style="table-layout: fixed; width:100%;" class="table table-striped text-uppercase">
                <thead class="table-dark" style="text-align:center;">
                    <tr>
                        <th></th>
                        <th>Left</th>
                        <th>Right</th>
                    </tr>
                </thead>
                <tbody style="background-color: white;">
                <tr>
                    <th>Visual Acuity(Aided)</th>
                    <td><?php echo $va_aidedl;?></td>
                    <td><?php echo $va_aidedr;?></td>
                </tr>
                <tr>
                    <th>Visual Acuity(Unaided)</th>
                    <td><?php echo $va_unaidedl;?></td>
                    <td><?php echo $va_unaidedr;?></td>
                </tr>
                <tr>
                    <th>Colour</th>
                    <td><?php echo $colour_l;?></td>
                    <td><?php echo $colour_r;?></td>
                </tr>
                <tr>
                    <th>Fundoscopy</th>
                    <td><?php echo $fundoscopy_l;?></td>
                    <td><?php echo $fundoscopy_r;?></td>
                </tr>
                </tbody>
            </table>
    <?php
        $insert = "UPDATE patient SET appearance = '".$appearance."', weight = '".$weight."', height = '".$height."', bmi = '".$bmi."', systolic = '".$systolic."', 
        diastolic = '".$diastolic."', pulse = '".$pulse."', va_aidedl = '".$va_aidedl."', va_aidedr = '".$va_aidedr."', va_unaidedl = '".$va_unaidedl."', va_unaidedr = '".$va_unaidedr."', 
        colour_r = '".$colour_r."', colour_l = '".$colour_l."', fundoscopy_r = '".$fundoscopy_r."', fundoscopy_l = '".$fundoscopy_l."', phyExam = '".$date."' WHERE mrn = '".$mrn."'";
        
        if ($conn->query($insert) === TRUE)
            {
    ?>
                <p class='success'>Successfully Inserted medical report</p>
                <form method="post">
                    <button class="btn btn-primary" formaction="activeDetails.php">View</button>
                    <input type="hidden" name="mrn" value="<?php echo $mrn;?>">
                </form>
    <?php
            }
            else
            {
                echo "Error: " . $insert . "<br>" . $conn->error;
            }
            $conn->close();
    ?>
        </div>
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
