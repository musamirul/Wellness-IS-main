<!DOCTYPE html>
<html>
    <?php
        session_start();
        if(isset($_SESSION["username"])) {
    ?>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Edit Patient's Profile</title>
        <link rel="stylesheet" href="wellness.css">
        <link rel="stylesheet" href="bootstrap.css">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    </head>
    <body>
        <?php
            $mrn = $_POST["mrn"];
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

            $display = "SELECT * FROM patient WHERE mrn = '".$mrn."'";
            $data = $conn->query($display);
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
            <h1 style='color: white;'>Edit Patient's Profile</h1>
            <br>
            <div class="container">
                <form method="post" style="text-align: center;">
                    <label for="mrn">Enter Patient's MRN</label><br>
                    <input type="text" id="mrn" name="mrn" maxlength="10" required autofocus>
                    <button formaction="selectRecord.php" class="btn btn-primary">Search</button>
                </form>
                <br>
                <?php
                    if($data->num_rows > 0){
                        while($row = $data->fetch_assoc()){
                ?>
                <div class="text-center">
                    <h5><?php echo $row['name'];?> &nbsp; [ MRN: <?php echo $mrn;?> ]</h5>
                    <form method="post" style="text-align: center;" class="btn-group">
                        <button formaction="selectRecord.php" class="btn btn-primary">View Record</button>
                        <button formaction="activeDetails.php" class="btn btn-primary">Latest Details</button>
                        <button formaction="editProfile.php" class="btn btn-primary active">Edit Profile</button>
                        <button formaction="checkHistoryForm.php" class="btn btn-primary">Check Medical History</button>  
                        <input type="hidden" name="mrn" value="<?php echo $mrn;?>">
                        <div class="btn-group" role="group">
                            <button id="btnGroupDrop" type="button" class="btn btn-primary dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                                Insert
                            </button>
                            <ul class="dropdown-menu dropdown-menu-dark" aria-labelledby="btnGroupDrop">
                                <li>
                                <?php
                                    if($_SESSION["type"] == "admin" or $_SESSION["type"] == "doctor"){
                                ?>
                                    <button class="dropdown-item" formaction="recordForm.php">Screening Record</button>
                                <?php
                                    }
                                ?>
                                </li>
                                <li>
                                    <button class="dropdown-item" formaction="physicalExam.php">Physical Examinantion</button>
                                </li>
                                <li>
                                    <button class="dropdown-item" formaction="historyForm.php">Medical History</button>
                                </li>
								<li>
								<button class="dropdown-item" formaction="recordForm.php">Screening Record</button>
								</li>
                            </ul>
                        </div>
                    </form>
                </div>  
                <hr>
                <form action="updateDetails.php" method="post">
                
                    <h5>Patient's Information</h5>
                    <div>
                        <label class="inline" for="mrn">MRN: </label>
                        <input type="text" id="mrn" maxlength="10" name="mrn" value="<?php echo $row["mrn"]?>" required disabled>
                    </div>
                    <div>
                        <label class="inline" for="name">Name: </label>
                        <input type="text" id="name" maxlength="70" name="name" value="<?php echo $row["name"]?>" required>
                    </div>
                    <div>
                        <label class="inline" for="icpp">I/C No / Passport: </label>
                        <input type="text" id="icpp"maxlength="14" name="icpp" value="<?php echo $row["ic_passport"]?>" required><span style="color: #7575a0; font-size: 14px; margin: 0px;"> *IC Format: 00000-00-0000</span>
                    </div>
                    <div>
                        <label class="inline" for="dob">Date of Birth: </label>
                        <input type="date" id="dob" name="dob" value="<?php echo $row["date_of_birth"]?>" required>
                    </div>
                    <div class="textfield">
                        <label class="inline" for="address">Home Address:</label>
                        <textarea type="text" id="address" maxlength="100" name="address" rows="4" cols="50" required><?php echo $row["address"]?></textarea>
                    </div>
                    <div>
                        <label class="inline" for="email">E-mail Address: </label>
                        <input type="email" id="email" maxlength="320" name="email" value="<?php echo $row["email"]?>">
                    </div>
                    <div>
                        <label class="inline" for="telephone">Mobile Phone: </label>
                        <input type="tel" id="telephone" maxlength="15" name="tel" value="<?php echo $row["telephone"]?>"><span style="color: #7575a0; font-size: 14px; margin: 0px;"> *Format: 601XXXXXXXXX.</span>
                    </div>
                    <div class="select">
                        <label class="inline" for="sex">Sex: </label>
                        <select id="sex" name="sex">
                            <option value="Male" <?php if ($row['sex'] == "Male") echo "selected"?> required>MALE</option>
                            <option value="Female" <?php if ($row['sex'] == "Female") echo "selected"?> required>FEMALE</option>
                        </select>
                    </div>
                    <div>
                        <label class="inline" for="occupation">Occupation: </label>
                        <input type="text" id="occupation" name="occupation" maxlength="30" value="<?php echo $row["occupation"]?>">
                    </div>
                    <div class="select">
                        <label class="inline" for="race">Race: </label>
                        <select id="race" name="race" required>
                            <option value="" selected disabled hidden>--Please Select--</option>
                            <option value="Malay" <?php if ($row['race'] == "Malay") echo "selected"?>>MALAY</option>
                            <option value="Chinese" <?php if ($row['race'] == "Chinese") echo "selected"?>>CHINESE</option>
                            <option value="Indian" <?php if ($row['race'] == "Indian") echo "selected"?>>INDIAN</option>
                            <option value="Other" <?php if ($row['race'] == "Other") echo "selected"?>>OTHER</option>
                        </select>
                    </div>
                    <div class="select">
                        <label class="inline" for="religion">Religion: </label>
                        <select id="religion" name="religion" required>
                            <option value="" selected disabled hidden>--Please Select--</option>
                            <option value="Muslim" <?php if ($row['religion'] == "Muslim") echo "selected"?>>MUSLIM</option>
                            <option value="Buddhist" <?php if ($row['religion'] == "Buddhist") echo "selected"?>>BUDDHIST</option>
                            <option value="Hindu" <?php if ($row['religion'] == "Hindu") echo "selected"?>>HINDU</option>
                            <option value="Christian" <?php if ($row['religion'] == "Christian") echo "selected"?>>CHRISTIAN</option>
                            <option value="Other" <?php if ($row['religion'] == "Other") echo "selected"?>>OTHER</option>
                        </select>
                    </div>
                    <div class="select">
                        <label class="inline" for="marital_status">Marital Status: </label>
                        <select id="marital_status" name="marital_status">
                            <option value="" selected disabled hidden>--Please Select--</option>
                            <option value="Married" <?php if ($row['marital_status'] == "Married") echo "selected"?>>MARRIED</option>
                            <option value="Widowed" <?php if ($row['marital_status'] == "Widowed") echo "selected"?>>WIDOWED</option>
                            <option value="Seperated" <?php if ($row['marital_status'] == "Seperated") echo "selected"?>>SEPERATED</option>
                            <option value="Divorced" <?php if ($row['marital_status'] == "Divorced") echo "selected"?>>DIVORCED</option>
                            <option value="Single" <?php if ($row['marital_status'] == "Single") echo "selected"?>>SINGLE</option>
                        </select>
                    </div>
                    <hr>
                    <h5>Next Of Kin</h5>
                    <hr>
                    <div>       
                        <label class="inline" for="next_of_kin">Name: </label>
                        <input type="text" id="next_of_kin" maxlength="70" name="next_of_kin" value="<?php echo $row["next_of_kin"]?>" required>
                    </div>
                    <div>
                        <label class="inline" for="relationship">Relationship: </label>
                        <input type="text" id="relationship" name="relationship" maxlength="20" value="<?php echo $row["relationship"]?>">
                    </div>
                    <div>
                        <label class="inline" for="telephone_nok">Telephone: </label>
                        <input type="tel" id="telephone_nok" name="telephone_nok" maxlength="15" value="<?php echo $row["telephone_nok"]?>"><span style="color: #7575a0; font-size: 14px; margin: 0px;"> *Format: 601XXXXXXXXX.</span>
                    </div>
                    <div>
                    <label class="inline" for="package">Package</label>
                        <select id="package" name="package" required>
                            <option value = "" selected disabled hidden>--Please Select--</option>
							 <option value = "Preemployment" <?php if ($row['package'] == "Preemployment") echo "selected"?>>PRE-EMPLOYMENT</option>
                            <option value = "Essential" <?php if ($row['package'] == "Essential") echo "selected"?>>ESSENTIAL</option>
                            <option value = "Comprehensive" <?php if ($row['package'] == "Comprehensive") echo "selected"?>>COMPREHENSIVE</option>
                            <option value = "Premium" <?php if ($row['package'] == "Premium") echo "selected"?>>PREMIUM</option>
                            <option value = "Custom" <?php if ($row['package'] == "Custom") echo "selected"?>>CUSTOM</option>
                        </select>
                    </div>
                    <br>
                    <div class="textfield">
                        <label class="inline" for="addons">Additional Test: </label>
                        <textarea type="text" id="addons" maxlength="100" placeholder="*IF CUSTOM, MENTION THE PACKAGE CHOSEN" name="addons" rows="4" cols="50"><?php echo $row["addons"]?></textarea>
                    </div>
                    <br><br>
                    <div style="text-align: center;">
                        <input type="reset" class="btn btn-danger" value="Reset">
                        <input type="submit" class="btn btn-primary" value="Submit"> 
                        <input type="hidden" name="mrn" value="<?php echo $mrn;?>">                                                   
                    </div>
                    <br>
            </form>
            
            <?php
                    }
                }
                else{
                    echo "<div style='text-align:center;'>Patient does not exist in system.</div>";
                }
            }
            else
            {
                echo "<script type='text/javascript'>";
                echo "alert('Session does not exist. Please login again');";
                echo "window.location.href = 'index.html';";
                echo "</script>";
            }   
            ?>
        </div>
    </body>
</html>