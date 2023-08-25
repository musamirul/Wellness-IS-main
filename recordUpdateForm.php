<!DOCTYPE html>
<html>
    <?php
        session_start();
        if(isset($_SESSION["username"])) {
    ?>
    <head>
        <title>Update Screening Record</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="wellness.css">
        <link rel="stylesheet" href="bootstrap.css">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    </head>
    
    <body>
    <?php
        $mrn = $_POST["mrn"];
        $visits = $_POST["visits"];
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
        else{
            $select = "SELECT * from patient a, record b WHERE a.mrn = '".$mrn."' AND b.mrn = '".$mrn."' AND visits = '".$visits."'";
            $data = $conn->query($select);
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
        <h1 style="margin-top: 40px; color: white;">Patient's Report</h1>
        <br>
        <div class="container">
        <form method="post" action="selectRecord.php">
            <input type="submit" value="View All Record" class="btn btn-danger" style="position: absolute;">
            <input type="hidden" value="<?php echo $mrn;?>" name="mrn">
        </form>
        <form method="post" style="text-align: center;">
                <label class="inline" for="mrn">Enter Patient's MRN</label><br>
                <input type="text" id="mrn" name="mrn" maxlength="10" required autofocus><br>
                <button formaction="selectRecord.php" class="btn btn-primary">Search</button>
    <?php
        if ($data->num_rows>0)
        {
            while($row=$data->fetch_assoc()){
    ?>
        
                <input type="hidden" name="sex" value="<?php echo $row["sex"];?>">
                <input type="hidden" name="packageUsed" value="<?php echo $row["packageUsed"];?>">
                
        </form>
        <br>
        <form method="post" style="text-align:center;">
            <div class="btn-group" style="width:100%;">
                <input type="hidden" name="mrn" value="<?php echo $mrn;?>">
                <input type="hidden" name="visits" value="<?php echo $row["visits"];?>">
                <button formaction="viewDetails.php" class="btn btn-primary">View Patient's Report</button>
                <?php
                    if($_SESSION["type"] == "doctor" || $_SESSION["type"] == "admin"){
                ?>
                <button formaction="recordUpdateForm.php" class="btn btn-primary active">Update Patient's Record</button>
                <?php
                    }
                ?>     
            </div>    
        </form>
        <br>
        <dl class="row h5">
            <dt class="col-sm-3">Name: </dt>
            <dd class="col-sm-9"><?php echo $row["name"];?></dd>
            <dt class="col-sm-3">MRN: </dt>
            <dd class="col-sm-9"><?php echo $mrn;?></dd>
            <dt class="col-sm-3">Package: </dt>
            <dd class="col-sm-9"><?php echo $row["packageUsed"];?></dd>
            <dt class="col-sm-3">Done by: </dt>
            <dd class="col-sm-9"><?php echo $row["doneBy"];?></dd>
        </dl>  
        <form action="updateRecord.php" method="post">
            <label class="inline" for="appearance">General Appearance: </label>
            <input type="text" id="appearance" name="appearance" value="<?php echo $row["appearanceUsed"];?>" required><br>
            <label class="inline" for="weight">Weight: </label>
            <input type="number" id="weight" step=".1" name="weight" value="<?php echo $row["weightUsed"];?>" required>kg<br>
            <label class="inline" for="height">Height: </label>
            <input type="number" id="height" step=".1" name="height" value="<?php echo $row["heightUsed"];?>" required>cm<br>
            <label class="inline" for="systolic">Systolic: </label>
            <input type="number" id="systolic" step="1" name="systolic" value="<?php echo $row["systolicUsed"];?>" required><br>
            <label class="inline" for="diastolic">Diastolic: </label>
            <input type="number" id="diastolic" step="1" name="diastolic" value="<?php echo $row["diastolicUsed"];?>" required><br>
            <label class="inline" for="pulse">Pulse: </label>
            <input type="number" id="pulse" step="1" name="pulse" value="<?php echo $row["pulseUsed"];?>" required><br>
        <div class="lrcol">
            <h3>Eyes</h3>
            Visual Acuity (Aided)<br>
            <label class="inline" for="va_aidedl">Left: </label>
            <input type="text" id="va_aidedl" name="va_aidedl" value="<?php echo $row["va_aidedlUsed"];?>" required>
            <label class="inline" for="va_aidedr">Right: </label>
            <input type="text" id="va_aidedr" name="va_aidedr" value="<?php echo $row["va_aidedrUsed"];?>" required>
            <br>Visual Acuity (Unaided)<br>
            <label class="inline" for="va_unaidedl">Left: </label>
            <input type="text" id="va_unaidedl" name="va_unaidedl" value="<?php echo $row["va_unaidedlUsed"];?>" required>
            <label class="inline" for="va_unaidedr">Right: </label>
            <input type="text" id="va_unaidedr" name="va_unaidedr" value="<?php echo $row["va_unaidedrUsed"];?>" required>
            <br>Colour<br>
            <label class="inline" for="colour_l">Left: </label>
            <input type="text" id="colour_l" name="colour_l" value="<?php echo $row["colour_lUsed"];?>" required>
            <label class="inline" for="colour_r">Right: </label>
            <input type="text" id="colour_r" name="colour_r" value="<?php echo $row["colour_r"];?>" required>
            <br>Fundoscopy<br>
            <label class="inline" for="fundoscopy_l">Left: </label>
            <input type="text" id="fundoscopy_l" name="fundoscopy_l" value="<?php echo $row["fundoscopy_lUsed"];?>" required>
            <label class="inline" for="fundoscopy_r">Right: </label>
            <input type="text" id="fundoscopy_r"name="fundoscopy_r" value="<?php echo $row["fundoscopy_rUsed"];?>" required>   
            <br><br>
        </div>
            <label class="inline" for="nose">Nose: </label>
            <input type="text" id="nose" name="nose" value="<?php echo $row["nose"];?>" required><br>
            <label class="inline" for="throat">Throat: </label>
            <input type="text" id="throat" name="throat" value="<?php echo $row["throat"];?>" required><br>
            <label class="inline" for="neck">Neck: </label>
            <input type="text" id="neck" name="neck" value="<?php echo $row["neck"];?>" required><br>
            <label class="inline" for="skin">Skin: </label>
            <input type="text" id="skin" name="skin" value="<?php echo $row["skin"];?>" required><br>
        <div class="lrcol">
            <h3>Ears</h3>
            External Canal<br>
            <label class="inline" for="excanal_l">Left: </label>
            <input type="text" id="excanal_l" name="excanal_l" value="<?php echo $row["excanal_l"];?>" required>
            <label class="inline" for="excanal_r">Right: </label>
            <input type="text" id="excanal_r" name="excanal_r" value="<?php echo $row["excanal_r"];?>" required>
            <br>Ear Drum<br>
            <label class="inline" for="eardrum_l">Left: </label>
            <input type="text" id="eardrum_l" name="eardrum_l" value="<?php echo $row["eardrum_l"];?>" required>
            <label class="inline" for="eardrum_r">Right: </label>
            <input type="text" id="eardrum_r" name="eardrum_r" value="<?php echo $row["eardrum_r"];?>" required>
            <br>Discharged<br>
            <label class="inline" for="discharged_l">Left: </label>
            <input type="text" id="discharged_l" name="discharged_l" value="<?php echo $row["discharged_l"];?>" required>
            <label class="inline" for="discharged_r">Right: </label>
            <input type="text" id="discharged_r" name="discharged_r" value="<?php echo $row["discharged_r"];?>" required>
        </div>
            <h3>Cardiovascular System</h3>
            <label class="inline" for="sound">Sound: </label>
            <input type="text" id="sound" name="sound" value="<?php echo $row["sound"];?>" required><br>
            <label class="inline" for="murmur">Murmur: </label>
            <input type="text" id="murmur" name="murmur" value="<?php echo $row["murmur"];?>" required><br>
            <h3>Respiratory System</h3>
            <fieldset>
                <legend>Air Entry</legend>
                <input type="radio" class="form-check-input" id="normal" name="airentry" value="Normal" required <?php if ($row['airentry'] == "Normal") echo "checked"; ?>>
                <label class="inline-radio" for="normal">Normal</label>
                <input type="radio" class="form-check-input" id="abnormal" name="airentry" value="Abnormal" required <?php if ($row['airentry']== "Abnormal") echo "checked"; ?>>
                <label class="inline-radio" for="abnormal">Abnormal</label>
            </fieldset>
            <fieldset>
                <legend>Chest Expansion</legend>
                <input type="radio" class="form-check-input" id="normal" name="chestexp" value="Normal" required <?php if ($row['chestexp'] == "Normal") echo "checked"; ?>>
                <label class="inline-radio" for="normal">Normal</label>
                <input type="radio" class="form-check-input" id="abnormal" name="chestexp" value="Abnormal" required <?php if ($row['chestexp']== "Abnormal") echo "checked"; ?>>
                <label class="inline-radio" for="abnormal">Abnormal</label>
            </fieldset>
            <fieldset>
                <legend>Breath Sound</legend>
                <input type="radio" class="form-check-input" id="normal" name="breathsound" value="Normal" required <?php if ($row['breathsound'] == "Normal") echo "checked"; ?>>
                <label class="inline-radio" for="normal">Normal</label>
                <input type="radio" class="form-check-input" id="abnormal" name="breathsound" value="Abnormal" required <?php if ($row['breathsound']== "Abnormal") echo "checked"; ?>>
                <label class="inline-radio" for="abnormal">Abnormal</label>
            </fieldset>
            <h3>Gastrointestinal System</h3>
            <fieldset>
                <legend>Liver</legend>
                <input type="radio" class="form-check-input" id="palpable" name="liver" value="Palpable" required <?php if ($row['liver'] == "Palpable") echo "checked"; ?>>
                <label class="inline-radio" for="palpable">Palpable</label>
                <input type="radio" class="form-check-input" id="notpalpable" name="liver" value="Not Palpable" required <?php if ($row['liver'] == "Not Palpable") echo "checked"; ?>>
                <label class="inline-radio" for="notpalpable">Not Palpable</label>
            </fieldset>
            <fieldset>
                <legend>Spleen</legend>
                <input type="radio" class="form-check-input" id="palpable" name="spleen" value="Palpable" required <?php if ($row['spleen'] == "Palpable") echo "checked"; ?>>
                <label class="inline-radio" for="palpable">Palpable</label>
                <input type="radio" class="form-check-input" id="notpalpable" name="spleen" value="Not Palpable" required <?php if ($row['spleen'] == "Not Palpable") echo "checked"; ?>>
                <label class="inline-radio" for="notpalpable">Not Palpable</label>
            </fieldset>
            <fieldset>
                <legend>Kidney</legend>
                <input type="radio" class="form-check-input" id="palpable" name="kidney" value="Palpable" required <?php if ($row['kidney'] == "Palpable") echo "checked"; ?>>
                <label class="inline-radio" for="palpable">Palpable</label>
                <input type="radio" class="form-check-input" id="notpalpable" name="kidney" value="Not Palpable" required <?php if ($row['kidney'] == "Not Palpable") echo "checked"; ?>>
                <label class="inline-radio" for="notpalpable">Not Palpable</label>
            </fieldset>
            <h3>Central Nervous System</h3>
            <fieldset>
                <legend>Mental Function</legend>
                <input type="radio" class="form-check-input" id="normal" name="mentalfunct" value="Normal" required <?php if ($row['mentalfunct'] == "Normal") echo "checked"; ?>>
                <label class="inline-radio" for="normal">Normal</label>
                <input type="radio" class="form-check-input" id="abnormal" name="mentalfunct" value="Abnormal" required <?php if ($row['mentalfunct']== "Abnormal") echo "checked"; ?>>
                <label class="inline-radio" for="abnormal">Abnormal</label>
            </fieldset>
            <fieldset>
                <legend>Coordination</legend>
                <input type="radio" class="form-check-input" id="normal" name="coordination" value="Normal" required <?php if ($row['coordination'] == "Normal") echo "checked"; ?>>
                <label class="inline-radio" for="normal">Normal</label>
                <input type="radio" class="form-check-input" id="abnormal" name="coordination" value="Abnormal" required <?php if ($row['coordination']== "Abnormal") echo "checked"; ?>>
                <label class="inline-radio" for="abnormal">Abnormal</label>
            </fieldset>                
            <fieldset>
                <legend>Gait</legend>
                <input type="radio" class="form-check-input" id="normal" name="gait" value="Normal" required <?php if ($row['gait'] == "Normal") echo "checked"; ?>>
                <label class="inline-radio" for="normal">Normal</label>
                <input type="radio" class="form-check-input" id="abnormal" name="gait" value="Abnormal" required <?php if ($row['gait']== "Abnormal") echo "checked"; ?>>
                <label class="inline-radio" for="abnormal">Abnormal</label>
            </fieldset>
            <h3>Genitourinary System</h3>
            <fieldset>
                <legend>Genitalia</legend>
                <input type="radio" class="form-check-input" id="normal" name="genitalia" value="Normal" required <?php if ($row['genitalia'] == "Normal") echo "checked"; ?>>
                <label class="inline-radio" for="normal">Normal</label>
                <input type="radio" class="form-check-input" id="abnormal" name="genitalia" value="Abnormal" required <?php if ($row['genitalia']== "Abnormal") echo "checked"; ?>>
                <label class="inline-radio" for="abnormal">Abnormal</label>
                <input type="radio" class="form-check-input" id="unknown" name="genitalia" value="Unknown" required <?php if ($row['genitalia']== "Unknown") echo "checked"; ?>>
                <label class="inline-radio" for="unknown">Unknown</label>
            </fieldset>
            <fieldset>
                <legend>Rectal Examinantion</legend>
                <input type="radio" class="form-check-input" id="normal" name="rectal" value="Normal" required <?php if ($row['rectal'] == "Normal") echo "checked"; ?>>
                <label class="inline-radio" for="normal">Normal</label>
                <input type="radio" class="form-check-input" id="abnormal" name="rectal" value="Abnormal" required <?php if ($row['rectal']== "Abnormal") echo "checked"; ?>>
                <label class="inline-radio" for="abnormal">Abnormal</label>
                <input type="radio" class="form-check-input" id="unknown" name="rectal" value="Unknown" required <?php if ($row['genitalia']== "Unknown") echo "checked"; ?>>
                <label class="inline-radio" for="unknown">Unknown</label>
            </fieldset>
        <div class="lrcol">
            <h3>Musculoskeletal System</h3>
            <h4>Lower Limb</h4>
            Power<br>
            <label class="inline" for="lpow_l">Left: </label>
            <input type="text" id="lpow_l" name="lpow_l" value="<?php echo $row["lpow_l"];?>" required>
            <label class="inline" for="lpow_r">Right: </label>
            <input type="text" id="lpow_r" name="lpow_r" value="<?php echo $row["lpow_r"];?>" required>
            <br>Reflex<br>
            <label class="inline" for="lref_l">Left: </label>
            <input type="text" id="lref_l" name="lref_l" value="<?php echo $row["lref_l"];?>" required>
            <label class="inline" for="lref_r">Right: </label>
            <input type="text" id="lref_r" name="lref_r" value="<?php echo $row["lref_r"];?>" required>
            <br>Sensantion<br>
            <label class="inline" for="lsen_l">Left: </label>
            <input type="text" id="lsen_l" name="lsen_l" value="<?php echo $row["lsen_l"];?>" required>
            <label class="inline" for="lsen_r">Right: </label>
            <input type="text" id="lsen_r" name="lsen_r" value="<?php echo $row["lsen_r"];?>" required>
            <h4>Upper Limb</h4>
            Power<br>
            <label class="inline" for="upow_l">Left: </label>
            <input type="text" id="upow_l" name="upow_l" value="<?php echo $row["upow_l"];?>" required>
            <label class="inline" for="upow_r">Right: </label>
            <input type="text" id="upow_r" name="upow_r" value="<?php echo $row["upow_r"];?>" required>
            <br>Reflex<br>
            <label class="inline" for="uref_l">Left: </label>
            <input type="text" id="uref_l" name="uref_l" value="<?php echo $row["uref_l"];?>" required>
            <label class="inline" for="uref_r">Right: </label>
            <input type="text" id="uref_r" name="uref_r" value="<?php echo $row["uref_r"];?>" required>
            <br>Sensantion<br>
            <label class="inline" for="usen_l">Left: </label>
            <input type="text" id="usen_l" name="usen_l" value="<?php echo $row["usen_l"];?>" required>
            <label class="inline" for="usen_r">Right: </label>
            <input type="text" id="usen_r" name="usen_r" value="<?php echo $row["usen_r"];?>" required>
        </div>
            <?php
                if ($row["sex"] == 'Female' ){
            ?>
            <h3>For Female</h3>
            <label class="inline" for="breast">Breast: </label>
            <input type="text" id="breast" name="breast" value="<?php echo $row["breast"];?>" required><br>
            <label class="inline" for="lmp">Last Menstrual Period: </label>
            <input type="text" id="lmp" name="lmp" value="<?php echo $row["lmp"];?>" required><br>
            <label class="inline" for="gynaecology">Gynaecology History: </label>
            <input type="text" id="gynaecology" name="gynaecology" value="<?php echo $row["gynaecology"];?>" required><br>
            <label class="inline" for="lastps">Last Pap Smear: </label>
            <input type="text" id="lastps" name="lastps" value="<?php echo $row["lastps"];?>" required><br>
            <?php
                }
            ?>
            <h3>Investigation</h3>
            <label class="inline" for="cxr">Chest X-Ray: </label>
            <input type="text" id="cxr" name="cxr" value="<?php echo $row["cxr"];?>" required><br>
            <label class="inline" for="ecg">Electrocardiogram: </label>
            <input type="text" id="ecg" name="ecg" value="<?php echo $row["ecg"];?>" required><br>
            <?php
                if ($row["packageUsed"] == "Custom"){
            ?>
            <label class="inline" for="mmg">Mammogram: </label>
            <input type="text" id="mmg" name="mammogram" value="<?php echo $row["mammogram"];?>" required><br>
            <label class="inline" for="us_breast">Ultrasound Breast: </label>
            <input type="text" id="us_breast" name="us_breast" value="<?php echo $row["us_breast"];?>" required><br>
            <?php
                }
                if ($row["packageUsed"] == "Comprehensive" || $row["packageUsed"] == "Premium" || $row["packageUsed"] == "Custom"){
            ?>
            <label class="inline" for="us_abdopel">Ultrasound Abdomen Pelvis: </label>
            <input type="text" id="us_abdopel" name="us_abdopel" value="<?php echo $row["us_abdopel"];?>" required><br>
            <?php
                }
                if ($row["packageUsed"] == "Premium" || $row["packageUsed"] == "Custom"){
            ?>
            <label class="inline" for="stress">Stress Test: </label>
            <input type="text" id="stress" name="stresstest" value="<?php echo $row["stresstest"];?>" required><br>
            <?php
                }
                if ($row["packageUsed"] == "Custom"){
            ?>
            <label class="inline" for="pta">Pure Tone Audiometry: </label>
            <input type="text" id="pta" name="pta" value="<?php echo $row["pta"];?>" required><br>
            <label class="inline" for="lft">Lung Function Test: </label>
            <input type="text" id="lft" name="lft" value="<?php echo $row["lft"];?>" required><br>
            <?php
                }
            ?>
            <label class="inline" for="urine">Urine: </label>
            <input type="text" id="urine" name="urine" value="<?php echo $row["urine"];?>" required><br>
            <label class="inline" for="blood">Blood: </label>
            <input type="text" id="blood" name="blood" value="<?php echo $row["blood"];?>" required><br>
            <label class="inline" for="impression">Impression: </label>
            <textarea id="impression" name="impression" rows="5" cols="100" required><?php echo $row["impression"];?></textarea><br>
            <label class="inline" for="recommendation">Recommendation: </label>
            <textarea id="recommendation" name="recommendation" rows="5" cols="100" required><?php echo $row["recommendation"];?></textarea><br>
            <br>
            <input type="submit" class="btn btn-primary" value="Submit Record">
            <input type="hidden" name="mrn" value="<?php echo $mrn;?>">
            <input type="hidden" name="sex" value="<?php echo $row["sex"];?>">
            <input type="hidden" name="packageUsed" value="<?php echo $row["packageUsed"];?>">
            <input type="hidden" name="visits" value="<?php echo $row["visits"];?>">
            <input type="hidden" name="addonsUsed" value="<?php echo $row["addonsUsed"];?>">
        </form>
        <br>
    <?php
            }
        }
        else{   
            echo "</form>Patient does not exist in system.";
        }
    ?>
    </div>
    </body>
    <?php
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
</html>