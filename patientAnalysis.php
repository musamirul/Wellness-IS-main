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
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
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

            $select =   "SELECT COUNT(mrn) AS total,
                        sum(case when package = 'Essential' then 1 else 0 end) AS essCnt,
                        sum(case when package = 'Comprehensive' then 1 else 0 end) AS compCnt,
                        sum(case when package = 'Premium' then 1 else 0 end) AS premCnt,
                        sum(case when package = 'Custom' then 1 else 0 end) AS custCnt,
                        sum(case when race = 'Malay' then 1 else 0 end) AS malayCnt,
                        sum(case when race = 'Chinese' then 1 else 0 end) AS chineseCnt,
                        sum(case when race = 'Indian' then 1 else 0 end) AS indianCnt,
                        sum(case when race = 'Other' then 1 else 0 end) AS otherRaceCnt,
                        sum(case when sex = 'Male' then 1 else 0 end) AS maleCnt,
                        sum(case when sex = 'Female' then 1 else 0 end) AS femaleCnt,
                        sum(case when smoker != 'NULL' then 1 else 0 end) AS totalMH, 
                        sum(case when smoker = 'Yes' then 1 else 0 end) AS smokerCnt,
                        sum(case when diabetes = 'Yes' then 1 else 0 end) AS diabetesCnt,
                        sum(case when asthma = 'Yes' then 1 else 0 end) AS asthmaCnt,
                        sum(case when heart_disease = 'Yes' then 1 else 0 end) AS heart_diseaseCnt,
                        sum(case when hypertension = 'Yes' then 1 else 0 end) AS hypertensionCnt,
                        sum(case when stroke = 'Yes' then 1 else 0 end) AS strokeCnt,
                        sum(case when cancer = 'Yes' then 1 else 0 end) AS cancerCnt,
                        sum(case when tuberculosis = 'Yes' then 1 else 0 end) AS tbCnt,
                        sum(case when skin_disease = 'Yes' then 1 else 0 end) AS skindCnt,
                        sum(case when kidneyp = 'Yes' then 1 else 0 end) AS kidneypCnt,
                        sum(case when fits_psychiatric = 'Yes' then 1 else 0 end) AS fitsCnt
                        FROM patient";
            $data = mysqli_query ($conn, $select);     
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
                            <li><a class="dropdown-item active" href="patientAnalysis.php">Patient's Analysis</a></li>
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
        <h1 style="color: white;">KPJ Klang Wellness Information System</h1>
        <h2 style="text-align:center; color: white;">Patient's Details Analysis</h2>
        <?php 
                    while ($row = mysqli_fetch_array($data)) 
                    { 
                ?>
        <br>
        <form method="post" style="text-align: center; color: white;">
            Between <input type="date" name="startDate"> And
            <input type="date" name="endDate">
            <button formaction=".php" class="btn btn-primary">Search</button>
        </form>
        <h4 style="color: white">Patients Analysis</h4>
        <div id="fullAnalysis">
            <table style="width: 100%;" height="100%" class="table table-striped">
                <thead class="table-dark" style="text-align:center;">
                    <tr>
                        <th rowspan="2">Patient Registered</th>
                        <th colspan="3">Race</th>
                        <th colspan="2">Sex</th>
                        <th colspan="4">Package</th>
                    </tr>
                    <tr>
                        <th>Malay</th>
                        <th>Chinese</th>
                        <th>Indian</th>
                        <th>Male</th>
                        <th>Female</th>
                        <th>Essential</th>
                        <th>Comprehensive</th>
                        <th>Premium</th>
                        <th>Custom</th>
                    </tr>
                </thead>
                <tbody style="background-color: white; text-align: center;">
                    <tr>
                        <td><?php echo $row["total"];?></td>
                        <td><?php echo $row["malayCnt"];?></td>
                        <td><?php echo $row["chineseCnt"];?></td>
                        <td><?php echo $row["indianCnt"];?></td>
                        <td><?php echo $row["maleCnt"];?></td>
                        <td><?php echo $row["femaleCnt"];?></td>
                        <td><?php echo $row["essCnt"];?></td>
                        <td><?php echo $row["compCnt"];?></td>
                        <td><?php echo $row["premCnt"];?></td>
                        <td><?php echo $row["custCnt"];?></td>
                    </tr>
                </tbody>
            </table>
        </div>
        <br>
        <h4 style="color: white">Medical History Analysis</h4>
        <div id="medHistory">
            <table style="width: 100%;" height="100%" class="table table-striped">
                <thead class="table-dark" style="text-align:center;">
                    <tr>
                        <th>Patient w/ Filled Form</th>
                        <th>Smoker</th>
                        <th>w/ Diabetes</th>
                        <th>w/ Asthma</th>
                        <th>w/ Heart Disease</th>
                        <th>w/ Hypertension</th>
                        <th>w/ Stroke</th>
                        <th>w/ Cancer</th>
                        <th>w/ Tuberculosis</th>
                        <th>w/ Skin Disease</th>
                        <th>w/ Kidney Problem</th>
                        <th>w/ Fits & Psychiatric</th>
                    </tr>
                </thead>
                <tbody style="background-color: white; text-align: center;">
                    <tr>
                        <td><?php echo $row["totalMH"];?></td>
                        <td><?php echo $row["smokerCnt"];?></td>
                        <td><?php echo $row["diabetesCnt"];?></td>
                        <td><?php echo $row["asthmaCnt"];?></td>
                        <td><?php echo $row["heart_diseaseCnt"];?></td>
                        <td><?php echo $row["hypertensionCnt"];?></td>
                        <td><?php echo $row["strokeCnt"];?></td>
                        <td><?php echo $row["cancerCnt"];?></td>
                        <td><?php echo $row["tbCnt"];?></td>
                        <td><?php echo $row["skindCnt"];?></td>
                        <td><?php echo $row["kidneypCnt"];?></td>
                        <td><?php echo $row["fitsCnt"];?></td>
                    </tr>
                </tbody>
            </table>
        </div>
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