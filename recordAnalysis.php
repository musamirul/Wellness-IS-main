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
                            <li><a class="dropdown-item active" href="recordAnalysis.php">Record's Analysis</a></li>
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
        <h2 style="text-align:center; color: white;">Records Analysis</h2>
        <br>
        <form method="post" style="text-align: center; color: white;">
            Between <input type="date" name="startDate"> And
            <input type="date" name="endDate">
            <button formaction="<?php echo htmlentities($_SERVER['PHP_SELF']);?>" class="btn btn-primary">Search</button>
            <input type="hidden" name="filter">
        </form>
        <?php
            if(isset($_POST["filter"])){
                    $startDate = $_POST["startDate"];
                    $endDate = $_POST["endDate"];
                    $select =   "SELECT COUNT(recordID) AS total,
                                (COUNT(DISTINCT mrn)) AS totalPatient,
                                sum(case when packageUsed = 'Essential' then 1 else 0 end) AS essCnt,
                                sum(case when packageUsed = 'Comprehensive' then 1 else 0 end) AS compCnt,
                                sum(case when packageUsed = 'Premium' then 1 else 0 end) AS premCnt,
                                sum(case when packageUsed = 'Custom' then 1 else 0 end) AS custCnt,
                                (SELECT mrn FROM record WHERE lastUpdate BETWEEN '".$startDate."' AND '".$endDate."' GROUP BY mrn ORDER BY COUNT(*) DESC LIMIT 1 ) AS mostVisit,
                                (SELECT COUNT(visits) FROM record WHERE mrn = mostVisit AND lastUpdate BETWEEN '".$startDate."' AND '".$endDate."') AS maxVisit,
                                (SELECT mrn FROM record WHERE lastUpdate BETWEEN '".$startDate."' AND '".$endDate."' ORDER BY lastUpdate DESC LIMIT 1) AS mostRecentVisit,
                                (SELECT COUNT(visits) FROM record WHERE mrn = mostRecentVisit AND lastUpdate BETWEEN '".$startDate."' AND '".$endDate."' ORDER BY lastUpdate DESC LIMIT 1) AS mostRecentVisitCnt
                                FROM record
                                WHERE lastUpdate BETWEEN '".$startDate."' AND '".$endDate."'";
        ?>
        <div>
            <h6 style="color:white;">Report Between <?php echo $startDate;?> and <?php echo $endDate;?></h6>
        </div>
        <?php
                }else{
                    $select =   "SELECT COUNT(recordID) AS total,
                                (COUNT(DISTINCT mrn)) AS totalPatient,
                                sum(case when packageUsed = 'Essential' then 1 else 0 end) AS essCnt,
                                sum(case when packageUsed = 'Comprehensive' then 1 else 0 end) AS compCnt,
                                sum(case when packageUsed = 'Premium' then 1 else 0 end) AS premCnt,
                                sum(case when packageUsed = 'Custom' then 1 else 0 end) AS custCnt,
                                (SELECT mrn FROM record GROUP BY mrn ORDER BY COUNT(*) DESC LIMIT 1) AS mostVisit,
                                (SELECT COUNT(visits) FROM record WHERE mrn = mostVisit) AS maxVisit,
                                (SELECT mrn FROM record ORDER BY lastUpdate DESC LIMIT 1) AS mostRecentVisit,
                                (SELECT visits FROM record ORDER BY lastUpdate DESC LIMIT 1) AS mostRecentVisitCnt
                                FROM record";
                }
                $data = mysqli_query ($conn, $select);  
                while ($row = mysqli_fetch_array($data)) 
                { 
        ?>
        <h4 style="color: white">Records Analysis</h4>
        <div id="fullAnalysis">
            <table style="width: 100%;" height="100%" class="table table-striped">
                <thead class="table-dark" style="text-align:center;">
                    <tr>
                        <th rowspan="2">Total Records</th>
                        <th rowspan="2">Total Unique Patient</th>
                        <th colspan="4">Package</th>
                    </tr>
                    <tr>
                        <th>Essential</th>
                        <th>Comprehensive</th>
                        <th>Premium</th>
                        <th>Custom</th>
                    </tr>
                </thead>
                <tbody style="background-color: white; text-align: center;">
                    <tr>
                        <td><?php echo $row["total"];?></td>
                        <td><?php echo $row["totalPatient"];?></td>
                        <td><?php echo $row["essCnt"];?></td>
                        <td><?php echo $row["compCnt"];?></td>
                        <td><?php echo $row["premCnt"];?></td>
                        <td><?php echo $row["custCnt"];?></td>
                    </tr>
                </tbody>
            </table>
        </div>
        <br>
        <h4 style="color: white">Patient's Visits Analysis</h4>
        <div id="medHistory">
            <table style="width: 100%;" height="100%" class="table table-striped">
                <thead class="table-dark" style="text-align:center;">
                    <th>Patient with Most Visit</th>
                    <th>Visit Count</th>
                    <th>Most Recently Visited Patient</th>
                    <th>Visit Count</th>
                </thead>
                <tbody style="background-color: white; text-align: center;">
                    <td><?php echo $row["mostVisit"];?></td>
                    <td><?php echo $row["maxVisit"];?></td>
                    <td><?php echo $row["mostRecentVisit"];?></td>
                    <td><?php echo $row["mostRecentVisitCnt"];?></td>
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