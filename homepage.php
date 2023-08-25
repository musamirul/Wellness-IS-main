<!DOCTYPE html>
<html>
    <?php
        session_start();
        if(isset($_SESSION["username"])) {
    ?>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <style>
            .unstyled-button {
                border: none;
                padding: 0;
                background: none;
                text-decoration: underline;
                color: blue;
            }
        </style>
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
                        <a class="nav-link active" href="homepage.php">Home</a>
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
        <h1 style="color: white;">KPJ Klang Wellness Information System</h1>
        <h2 style="text-align:center; color: white;">Register Patient</h2>
        <br>
        <div class="container">
            <form action="<?php echo htmlentities($_SERVER['PHP_SELF']);?>" method="post" style="margin-left: 40px;">
                <label class="inline" for="mrn">MRN: </label>
                <input type="text" id="mrn" maxlength="10" placeholder="MRN" name="mrn" required autofocus>
                <input type="submit" name="check" class="btn btn-primary" value="Check"><br>
            </form>
        <?php
            if(isset($_POST["check"])){
                $mrn = $_POST["mrn"];
                $check = "SELECT mrn FROM patient WHERE mrn = '".$mrn."'";
                $data = $conn->query($check);
                if ($data->num_rows>0)
                {
                    while($row=$data->fetch_assoc())
                    {
        ?>
                    <br>
                    <form method="post">
                        <p>MRN <?php echo $mrn;?> is already registered view <button class="unstyled-button" formaction="selectRecord.php">here</button></p>
                        <input type="hidden" name="mrn" value="<?php echo $mrn?>">
                    </form>
        <?php
                    }
                }
                else
                {
        ?>
            
            <?php
                if(isset($mrn)){    
            ?>
            <form action="insertRegister.php" id="register" method="post">
                <hr>
                <h5>Patient's Information</h5>
                <hr>
                <div>
                    <label for="mrn" class="inline">MRN:</label>
                    <input type="text" value="<?php echo $mrn;?>" name="mrn" id="mrn" disabled>
                </div>
                <div>
                    <label class="inline" for="name">Name: </label>
                    <input type="text" id="name" maxlength="70" placeholder="Name" name="name" required>
                </div>
                <div>
                    <label class="inline" for="icpp" style="margin-top  : 5px;">IC No or Passport:</label>
                    <input type="text" id="icpp" maxlength="14" placeholder="IC / Passport" name="icpp" required><span style="color: #7575a0; font-size: 14px; margin: 0px;"> *IC Format:00000000000</span>
                </div>
                <div>
                    <label class="inline" for="dob">Date of Birth: </label>
                    <input type="date" id="dob" name="dob" required>
                </div>
                <div class="textfield">
                    <label class="inline" for="address">Home Address:</label>
                    <textarea type="text" id="address" maxlength="100" placeholder="Address" name="address" rows="4" cols="50" required></textarea><br>
                </div>
                <div>
                    <label class="inline" for="email">E-mail Address: </label>
                    <input type="email" id="email" maxlength="320" placeholder="Email" name="email">
                </div>
                <div>
                    <label class="inline" for="telephone">Telephone: </label>
                    <input type="tel" id="telephone" name="telephone" placeholder="Telephone" maxlength="15"><span style="color: #7575a0; font-size: 14px; margin: 0px;"> *Format: 601XXXXXXXXX.</span>
                </div>
                <div class="select">
                <label class="inline" for="sex">Sex:</label> 
                    <select id="sex" name="sex" required>
                        <option value="" selected disabled hidden>--Please Select--</option>
                        <option value="Male">MALE</option>
                        <option value="Female">FEMALE</option>
                    </select>
                </div>
                <div>
                    <label class="inline" for="occupation">Occupation: </label>
                    <input type="text" id="occupation" name="occupation" placeholder="Occupation" maxlength="30">
                </div>
                <div class="select">
                    <label class="inline" for="race">Race: </label>
                    <select id="race" name="race" required>
                        <option value="" selected disabled hidden>--Please Select--</option>
                        <option value="Malay">MALAY</option>
                        <option value="Chinese">CHINESE</option>
                        <option value="Indian">INDIAN</option>
                        <option value="Other">OTHER</option>
                    </select>
                </div>
                <div class="select">
                    <label class="inline" for="religion">Religion: </label>
                    <select id="religion" name="religion" required>
                        <option value="" selected disabled hidden>--Please Select--</option>
                        <option value="Muslim">MUSLIM</option>
                        <option value="Buddhist">BUDDHIST</option>
                        <option value="Hindu">HINDU</option>
                        <option value="Christian">CHRISTIAN</option>
                        <option value="Other">OTHER</option>
                    </select>
                </div>
                <div class="select">
                    <label class="inline" for="marital_status">Marital Status: </label>
                    <select id="marital_status" name="marital_status" required>
                        <option value="" selected disabled hidden>--Please Select--</option>
                        <option value="Married">MARRIED</option>
                        <option value="Widowed">WIDOWED</option>
                        <option value="Seperated">SEPERATED</option>
                        <option value="Divorced">DIVORCED</option>
                        <option value="Single">SINGLE</option>
                    </select>
                </div>
                <hr>
                <h5>Next of Kin</h5>
                <hr>
                <div>
                    <label class="inline" for="next_of_kin">Name: </label>
                    <input type="text" id="next_of_kin" maxlength="70" placeholder="Next of kin Name" name="next_of_kin" required>
                </div>
                <div>
                    <label class="inline" for="relationship">Relationship: </label>
                    <input type="text" id="relationship" name="relationship" placeholder="Relationship" maxlength="20">
                </div>
                <div>
                    <label class="inline" for="telephone_nok">Telephone: </label>
                    <input type="tel" id="telephone_nok" name="telephone_nok" placeholder="Telephone" maxlength="15"><span style="color: #7575a0; font-size: 14px; margin: 0px;"> *Format: 601XXXXXXXXX.</span>
                </div>
                <div>
                    <label class="inline" for="package">Package</label>
                    <select id="package" name="package" required>
                        <option value = "" selected disabled hidden>--Please Select--</option>
                        <option value = "Essential">ESSENTIAL</option>
                        <option value = "Comprehensive">COMPREHENSIVE</option>
                        <option value = "Premium">PREMIUM</option>
						<option value = "Pre">PRE-EMPLOYEMENT</option>
                        <option value = "Custom">CUSTOM / COMPANY</option>
                    </select>
                </div>
                <div class="textfield" style="margin-top: 10px;">
                    <label class="inline" for="addons">Additional Test: </label>
                    <textarea type="text" id="addons" placeholder="*IF CUSTOM, MENTION THE ADDS-ON / COMPANY NAME" maxlength="100" name="addons" rows="4" cols="50"></textarea>
                </div>
                <br><br>
                <div style="text-align: center;">
                    <input type="reset" class="btn btn-danger" value="Reset">
                    <input type="submit" class="btn btn-primary" value="Register">
                    <input type="hidden" name="mrn" value="<?php echo $mrn;?>">
                </div>  
            </form>
        <?php
                }
            }
        ?>
        
            <?php
                }
            ?>
        </div>
        <br><br>
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