<!DOCTYPE html>
<html>
    <?php
        session_start();
        if(isset($_SESSION["username"])) {
    ?>
    <head>
        <title>Medical History Form</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="wellness.css">
        <link rel="stylesheet" href="bootstrap.css">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    </head>
    <?php
        $mrn = $_POST["mrn"];
        $smoker = $_POST["smoker"];
        $asthma = $_POST["asthma"];
        $diabetes = $_POST["diabetes"];
        $heart = $_POST["heart_disease"];
        $hypertension = $_POST["hypertension"];
        $stroke = $_POST["stroke"];
        $cancer = $_POST["cancer"];
        $tb = $_POST["tuberculosis"];
        $skin = $_POST["skin_disease"];
        $kidneyp = $_POST["kidneyp"];
        $fits = $_POST["fits_psychiatric"];
        $father = $_POST["father_history"];
        $mother = $_POST["mother_history"];
        $siblings = $_POST["siblings_history"];
        $habits = $_POST["habits"];
        $allergy = $_POST["allergy"];
        $others = $_POST["others"];
        $medication = $_POST["medication"];
    ?>
    <body>
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
        <h1 style='color: white;'>Medical History</h1>
        <br>
        <div class="container">
        <h3>Past Medical History</h3>
            <div>
            <dl class="row">
                <dt class="col-sm-3">Smoker/Non Smoker: </dt>
                <dd class="col-sm-9"><?php echo $smoker;?></dd>
                <dt class="col-sm-3">Asthma: </dt>
                <dd class="col-sm-9"><?php echo $asthma;?></dd>
                <dt class="col-sm-3">Diabetes: </dt>
                <dd class="col-sm-9"><?php echo $diabetes;?></dd>
                <dt class="col-sm-3">Heart Disease: </dt>
                <dd class="col-sm-9"><?php echo $heart;?></dd>
                <dt class="col-sm-3">Hypertension: </dt>
                <dd class="col-sm-9"><?php echo $hypertension;?></dd>
                <dt class="col-sm-3">Stroke: </dt>
                <dd class="col-sm-9"><?php echo $stroke;?></dd>
                <dt class="col-sm-3">Cancer: </dt>
                <dd class="col-sm-9"><?php echo $cancer;?></dd>
                <dt class="col-sm-3">Tuberculosis: </dt>
                <dd class="col-sm-9"><?php echo $tb;?></dd>
                <dt class="col-sm-3">Skin Disease: </dt>
                <dd class="col-sm-9"><?php echo $skin;?></dd>
                <dt class="col-sm-3">Kidney Problem: </dt>
                <dd class="col-sm-9"><?php echo $kidneyp;?></dd>
                <dt class="col-sm-3">Fits/Psychiatric: </dt>
                <dd class="col-sm-9"><?php echo $fits;?></dd>
            </dl>
            </div>
            <h3>Family History</h3>
            <div>
            <dl class="row">
                <dt class="col-sm-3">Father: </dt>
                <dd class="col-sm-9 text-uppercase"><?php echo $father;?></dd>
                <dt class="col-sm-3">Mother: </dt>
                <dd class="col-sm-9 text-uppercase"><?php echo $mother;?></dd>
                <dt class="col-sm-3">Siblings: </dt>
                <dd class="col-sm-9 text-uppercase"><?php echo $siblings;?></dd>
                <dt class="col-sm-3">Habits: </dt>
                <dd class="col-sm-9 text-uppercase"><?php echo $habits;?></dd>
                <dt class="col-sm-3">Allergy: </dt>
                <dd class="col-sm-9 text-uppercase"><?php echo $allergy;?></dd>
                <dt class="col-sm-3">Others: </dt>
                <dd class="col-sm-9 text-uppercase"><?php echo $others;?></dd>
                <dt class="col-sm-3">Medication: </dt>
                <dd class="col-sm-9 text-uppercase"><?php echo $medication;?></dd>
            </dl>
            </div>
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
        
        $insert = "UPDATE patient SET smoker = '".$smoker."', asthma = '".$asthma."', diabetes = '".$diabetes."', heart_disease = '".$heart."', hypertension = '".$hypertension."', stroke = '".$stroke."', cancer = '".$cancer."', tuberculosis = '".$tb."', skin_disease = '".$skin."', kidneyp = '".$kidneyp."', fits_psychiatric = '".$fits."',
        father_history = '".$father."', mother_history = '".$mother."', siblings_history = '".$siblings."', habits = '".$habits."', allergy = '".$allergy."', others = '".$others."', medication = '".$medication."', lastUpdateMH = '".$date."' WHERE mrn = '".$mrn."'";
        if ($conn->query($insert) === TRUE)
        {
            echo "<p class='success'>Successfully updated medical history";
        }
        else
        {
            echo "Error: " . $insert . "<br>" . $conn->error;
        }
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
        <br><br><button class="btn btn-primary" onclick="window.location.href='homepage.php'">Back to Home Page</button>
        <form method="post">
            <input type="hidden" value="<?php echo $mrn;?>" name="mrn">
            <button formaction="physicalExam.php" class="btn btn-primary">Fill Physical Examination</button>
            <button formaction="activeDetails.php" class="btn btn-primary">View</button>
        </form>
        </div>
    </body>
</html>