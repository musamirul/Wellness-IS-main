<!DOCTYPE html>
<html>
    <?php
        session_start();
        if(isset($_SESSION["username"])) {
    ?>
    <head>
        <title>Health Screening Record Form</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
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
        <h1 style='color: white;'>Patient's Report</h1>
        <br>
        <?php
            $mrn = $_POST['mrn'];
            $ic = $_POST['ic'];
            $visits = $_POST["visits"];
            $recordID = $_POST["recordID"];
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


            $check = "SELECT name, sex, package, addons, appearance FROM patient WHERE mrn = '".$mrn."'";
            $data = $conn->query($check);
            ?>
            <div class="container">
                <form method="post" action="selectRecord.php" style="margin-bottom: 20px;">
                    <input type="submit" value="Back" class="btn btn-danger" style="position: relative;">
                    <input type="hidden" value="<?php echo $mrn;?>" name="mrn">
                    <input type="hidden" name="ic" value="<?php echo $ic; ?>">
                </form>
            <?php
            $display = "SELECT * FROM record a, patient b WHERE a.mrn = $mrn AND b.mrn = $mrn AND visits = '".$visits."'";
                    $data = $conn->query($display);
                        if ($data->num_rows > 0)
                        {
                            while ($row = $data->fetch_assoc())
                            {
                                $temp = $row["lastUpdate"];
                                $lastUpdate = date("d-m-Y", strtotime($temp));
                                
            ?>
                    <div class="info">
                        <dl class="row h5">
                            <dt class="col-sm-3">Name: </dt>
                            <dd class="col-sm-9 text-uppercase"><?php echo $row["name"];?></dd>
                            <dt class="col-sm-3">MRN: </dt>
                            <dd class="col-sm-9 text-uppercase"><?php echo $mrn;?></dd>
                            <dt class="col-sm-3">IC: </dt>
                            <dd class="col-sm-9 text-uppercase"><?php echo $ic;?></dd>
                            <dt class="col-sm-3">PACKAGE: </dt>
                            <dd class="col-sm-9 text-uppercase"><?php echo $row['package'];?></dd>
                        </dl>
                    </div>
            <form action="updateScreening.php" method="post">
                <label class="inline" for="nose">Nose: </label>
                <input type="text" id="nose" name="nose" value="<?php echo $row['nose'] ?>" required><br>
                <label class="inline" for="throat">Throat: </label>
                <input type="text" id="throat" name="throat"  value="<?php echo $row['throat'] ?>" required><br>
                <label class="inline" for="neck">Neck: </label>
                <input type="text" id="neck" name="neck"  value="<?php echo $row['neck'] ?>" required><br>
                <label class="inline" for="skin">Skin: </label>
                <input type="text" id="skin" name="skin"  value="<?php echo $row['skin'] ?>" required><br>
            <div class="lrcol">
                <h3>Ears</h3>
                External Canal<br>
                <label class="inline" for="excanal_l">Left: </label>
                <input type="text" id="excanal_l" name="excanal_l"  value="<?php echo $row['excanal_l'] ?>" required>
                <label class="inline" for="excanal_r">Right: </label>
                <input type="text" id="excanal_r" name="excanal_r"  value="<?php echo $row['excanal_r'] ?>" required>
                <br>Ear Drum<br>
                <label class="inline" for="eardrum_l">Left: </label>
                <input type="text" id="eardrum_l" name="eardrum_l"  value="<?php echo $row['eardrum_l'] ?>" required>
                <label class="inline" for="eardrum_r">Right: </label>
                <input type="text" id="eardrum_r" name="eardrum_r"  value="<?php echo $row['eardrum_r'] ?>" required>
                <br>Discharged<br>
                <label class="inline" for="discharged_l">Left: </label>
                <input type="text" id="discharged_l" name="discharged_l"  value="<?php echo $row['discharged_l'] ?>" required>
                <label class="inline" for="discharged_r">Right: </label>
                <input type="text" id="discharged_r" name="discharged_r"  value="<?php echo $row['discharged_r'] ?>" required>
            </div>
                <h3>Cardiovascular System</h3>
                <label class="inline" for="sound">Sound: </label>
                <input type="text" id="sound" name="sound"  value="<?php echo $row['sound'] ?>" required><br>
                <label class="inline" for="murmur">Murmur: </label>
                <input type="text" id="murmur" name="murmur"  value="<?php echo $row['murmur'] ?>" required><br>
				<br>
                <h3>Respiratory System</h3>
                    <label class="inline">Air Entry</label>
                    <div class="radio">
                        <input type="radio" class="form-check-input" id="normal" name="airentry" value="NORMAL" <?php if($row['airentry'] == "NORMAL") echo "checked" ?> required>
                        <label class="inline-radio" for="normal">Normal</label>
                        <input type="radio" class="form-check-input" id="abnormal" name="airentry" value="ABNORMAL" <?php if($row['airentry'] == "ABNORMAL") echo "checked" ?>>
                        <label class="inline-radio" for="abnormal">Abnormal</label>
                    </div>
                    <label class="inline">Chest Expansion</label>
                    <div class="radio">
                        <input type="radio" class="form-check-input" id="normal" name="chestexp" value="NORMAL" <?php if($row['chestexp'] == "NORMAL") echo "checked" ?> required>
                        <label class="inline-radio" for="normal">Normal</label>
                        <input type="radio" class="form-check-input" id="abnormal" name="chestexp" value="ABNORMAL" <?php if($row['chestexp'] == "ABNORMAL") echo "checked" ?>>
                        <label class="inline-radio" for="abnormal">Abnormal</label>
                    </div>
                    <label class="inline">Breath Sound</label>
                    <div class="radio">
                        <input type="radio" class="form-check-input" id="normal" name="breathsound" value="NORMAL" <?php if($row['breathsound'] == "NORMAL") echo "checked" ?> required>
                        <label class="inline-radio" for="normal">Normal</label>
                        <input type="radio" class="form-check-input" id="abnormal" name="breathsound" value="ABNORMAL" <?php if($row['breathsound'] == "ABNORMAL") echo "checked" ?>>
                        <label class="inline-radio" for="abnormal">Abnormal</label>
                    </div>
					<br>
                <h3>Gastrointestinal System</h3>
                    <label class="inline">Liver</label>
                    <div class="radio">
                        <input type="radio" class="form-check-input" id="palpable" name="liver" value="PALPABLE" <?php if($row['liver'] == "PALPABLE") echo "checked" ?> required>
                        <label class="inline-radio" for="palpable">Palpable</label>
                        <input type="radio" class="form-check-input" id="notpalpable" name="liver" value="NOT PALPABLE" <?php if($row['liver'] == "NOT PALPABLE") echo "checked" ?>>
                        <label class="inline-radio" for="notpalpable">Not Palpable</label>
                    </div>
                    <label class="inline">Spleen</label>
                    <div class="radio">
                        <input type="radio" class="form-check-input" id="palpable" name="spleen" value="PALPABLE" <?php if($row['spleen'] == "PALPABLE") echo "checked" ?> required>
                        <label class="inline-radio" for="palpable">Palpable</label>
                        <input type="radio" class="form-check-input" id="notpalpable" name="spleen" value="NOT PALPABLE" <?php if($row['spleen'] == "NOT PALPABLE") echo "checked" ?>>
                        <label class="inline-radio" for="notpalpable">Not Palpable</label>
                    </div>
                    <label class="inline">Kidney</label>
                    <div class="radio">
                        <input type="radio" class="form-check-input" id="palpable" name="kidney" value="PALPABLE" <?php if($row['kidney'] == "PALPABLE") echo "checked" ?> required>
                        <label class="inline-radio" for="palpable">Palpable</label>
                        <input type="radio" class="form-check-input" id="notpalpable" name="kidney" value="NOT PALPABLE"<?php if($row['kidney'] == "NOT PALPABLE") echo "checked" ?>>
                        <label class="inline-radio" for="notpalpable">Not Palpable</label>
                    </div>
					<br>
                <h3>Central Nervous System</h3>
                    <label class="inline">Mental Function</label>
                <div class="radio">
                    <input type="radio" class="form-check-input" id="normal" name="mentalfunct" value="NORMAL" <?php if($row['mentalfunct'] == "NORMAL") echo "checked" ?> required>
                    <label class="inline-radio" for="normal">Normal</label>
                    <input type="radio" class="form-check-input" id="abnormal" name="mentalfunct" value="ABNORMAL" <?php if($row['mentalfunct'] == "ABNORMAL") echo "checked" ?>>
                    <label class="inline-radio" for="abnormal">Abnormal</label>
                </div>
                    <label class="inline">Coordination</label>
                <div class="radio">
                    <input type="radio" class="form-check-input" id="normal" name="coordination" value="NORMAL" <?php if($row['coordination'] == "NORMAL") echo "checked" ?> required>
                    <label class="inline-radio" for="normal">Normal</label>
                    <input type="radio" class="form-check-input" id="abnormal" name="coordination" value="ABNORMAL" <?php if($row['coordination'] == "ABNORMAL") echo "checked" ?>>
                    <label class="inline-radio" for="abnormal">Abnormal</label>
                </div>
                    <label class="inline">Gait</label>
                <div class="radio">
                    <input type="radio" class="form-check-input" id="normal" name="gait" value="NORMAL" <?php if($row['gait'] == "NORMAL") echo "checked" ?> required>
                    <label class="inline-radio" for="normal">Normal</label>
                    <input type="radio" class="form-check-input" id="abnormal" name="gait" value="ABNORMAL" <?php if($row['gait'] == "ABNORMAL") echo "checked" ?>>
                    <label class="inline-radio" for="abnormal">Abnormal</label>
                </div>
				<br>
                <h3>Genitourinary System</h3>
                    <label class="inline">Genitalia</label>
                <div class="radio">
                    <input type="radio" class="form-check-input" id="normal" name="genitalia" value="NORMAL" <?php if($row['genitalia'] == "NORMAL") echo "checked" ?> required>
                    <label class="inline-radio" for="normal">Normal</label>
                    <input type="radio" class="form-check-input" id="abnormal" name="genitalia" value="ABNORMAL" <?php if($row['genitalia'] == "ABNORMAL") echo "checked" ?>>
                    <label class="inline-radio" for="abnormal">Abnormal</label>
                    <input type="radio" class="form-check-input" id="unknown" name="genitalia" value="UNKNOWN" <?php if($row['genitalia'] == "UNKNOWN") echo "checked" ?>>
                    <label class="inline-radio" for="unknown">Unknown</label>
                </div>
                    <label class="inline">Rectal Examinantion</label>
                <div class="radio">
                    <input type="radio" class="form-check-input" id="normal" name="rectal" value="NORMAL" <?php if($row['rectal'] == "NORMAL") echo "checked" ?> required>
                    <label class="inline-radio" for="normal">Normal</label>
                    <input type="radio" class="form-check-input" id="abnormal" name="rectal" value="ABNORMAL" <?php if($row['rectal'] == "ABNORMAL") echo "checked" ?>>
                    <label class="inline-radio" for="abnormal">Abnormal</label>
                    <input type="radio" class="form-check-input" id="unknown" name="rectal" value="UNKNOWN" <?php if($row['rectal'] == "UNKNOWN") echo "checked" ?>>
                    <label class="inline-radio" for="unknown">Unknown</label>
                </div>
            <div class="lrcol">
			<br>
                <h3>Musculoskeletal System</h3>
                <h4>Lower Limb</h4>
                Power<br>
                <label class="inline" for="lpow_l">Left: </label>
                <input type="text" id="lpow_l" name="lpow_l"  value="<?php echo $row['lpow_l'] ?>" required>
                <label class="inline" for="lpow_r">Right: </label>
                <input type="text" id="lpow_r" name="lpow_r"  value="<?php echo $row['lpow_r'] ?>" required>
                <br>Reflex<br>
                <label class="inline" for="lref_l">Left: </label>
                <input type="text" id="lref_l" name="lref_l"  value="<?php echo $row['lref_l'] ?>" required>
                <label class="inline" for="lref_r">Right: </label>
                <input type="text" id="lref_r" name="lref_r"  value="<?php echo $row['lref_r'] ?>" required>
                <br>Sensation<br>
                <label class="inline" for="lsen_l">Left: </label>
                <input type="text" id="lsen_l" name="lsen_l"  value="<?php echo $row['lsen_l'] ?>" required>
                <label class="inline" for="lsen_r">Right: </label>
                <input type="text" id="lsen_r" name="lsen_r"  value="<?php echo $row['lsen_r'] ?>" required>
				<br>
                <h4>Upper Limb</h4>
                Power<br>
                <label class="inline" for="upow_l">Left: </label>
                <input type="text" id="upow_l" name="upow_l"  value="<?php echo $row['upow_l'] ?>" required>
                <label class="inline" for="upow_r">Right: </label>
                <input type="text" id="upow_r" name="upow_r"  value="<?php echo $row['upow_r'] ?>" required>
                <br>Reflex<br>
                <label class="inline" for="uref_l">Left: </label>
                <input type="text" id="uref_l" name="uref_l"  value="<?php echo $row['uref_l'] ?>" required>
                <label class="inline" for="uref_r">Right: </label>
                <input type="text" id="uref_r" name="uref_r"  value="<?php echo $row['uref_r'] ?>" required>
                <br>Sensation<br>
                <label class="inline" for="usen_l">Left: </label>
                <input type="text" id="usen_l" name="usen_l"  value="<?php echo $row['usen_l'] ?>" required>
                <label class="inline" for="usen_r">Right: </label>
                <input type="text" id="usen_r" name="usen_r"  value="<?php echo $row['usen_r'] ?>" required>
            </div>
    
                <h3>For Female</h3>
                <label class="inline" for="breast">Breast: </label>
                <input type="text" id="breast" name="breast"  value="<?php echo $row['breast'] ?>" required><br>
                <label class="inline" for="lmp">Last Menstrual Period: </label>
                <input type="text" id="lmp" name="lmp"  value="<?php echo $row['lmp'] ?>" required><br>
                <label class="inline" for="gynaecology">Gynaecology History: </label>
                <input type="text" id="gynaecology" name="gynaecology"  value="<?php echo $row['gynaecology'] ?>" required><br>
                <label class="inline" for="lastps">Last Pap Smear: </label>
                <input type="text" id="lastps" name="lastps"  value="<?php echo $row['lastps'] ?>" required><br>
            
                <h3>Investigation</h3>
                <label class="inline" for="cxr">Chest X-Ray: </label>
                <input type="text" id="cxr" name="cxr" value="<?php echo $row['cxr'] ?>" required><br>
				<?php
                    
                    
                ?>
							<label class="inline" for="ecg">Electrocardiogram: </label>
							<input type="text" id="ecg" name="ecg" value="<?php echo $row['ecg'] ?>" required><br>
					 
							<label class="inline" for="mmg">Mammogram: </label>
							<input type="text" id="mmg" name="mammogram"  value="<?php echo $row['mammogram'] ?>" required><br>
							<label class="inline" for="us_breast">Ultrasound Breast: </label>
							<input type="text" id="us_breast" name="us_breast" value="<?php echo $row['us_breast'] ?>" required><br>
							
							<label class="inline" for="us_abdopel">Ultrasound Abdomen Pelvis: </label>
							<input type="text" id="us_abdopel" name="us_abdopel" value="<?php echo $row['us_abdopel'] ?>" required><br>
							
							<label class="inline" for="stress">Stress Test: </label>
							<input type="text" id="stress" name="stresstest" value="<?php echo $row['stresstest'] ?>" required><br>
							
							<label class="inline" for="pta">Pure Tone Audiometry: </label>
							<input type="text" id="pta" name="pta" value="<?php echo $row['pta'] ?>" required><br>
							<label class="inline" for="lft">Lung Function Test: </label>
							<input type="text" id="lft" name="lft" value="<?php echo $row['lft'] ?>" required><br>
							
							<label class="inline" for="urine">Urine: </label>
							<input type="text" id="urine" name="urine" value="<?php echo $row['urine'] ?>" required><br>
							<label class="inline" for="blood">Blood: </label>
							<input type="text" id="blood" name="blood" value="<?php echo $row['blood'] ?>" required><br><br><br>
                            <div class="row">
                                <div class="textfield">
                        
                                    <label class="inline" for="impression">Impression:</label>
                                    <textarea id="impression" name="impression" rows="5" cols="100" required><?php echo $row['impression'] ?></textarea>
                                </div>
                            </div>
							<div class="row">
                                <div class="textfield">
                                    <label class="inline" for="recommendation">Recommendation: </label>
                                    <textarea id="recommendation" name="recommendation" rows="5" cols="100" required><?php echo $row['recommendation'] ?></textarea>
                                </div>
                            </div>
							
							
							
							<br>
                            <input type="hidden" name="mrn" value=" <?php echo $mrn;?>">
							<input type="hidden" name="sex" value="<?php echo $row["sex"];?>">
							<input type="hidden" name="package" value="<?php echo $row["package"];?>">
							<input type="hidden" name="name" value="<?php echo $row["name"];?>">
							<input type="hidden" name="addons" value="<?php echo $row["addons"];?>">
							<input type="hidden" name="recordID" value="<?php echo $recordID;?>">
                            <input type="hidden" name="ic" value="<?php echo $ic; ?>">    
							<input type="submit" class="btn btn-primary" value="Update Record">
						</form>
				
            <?php
                        }     
                    }
               
            }
            else
            {
                echo "<script type='text/javascript'>";
                echo "alert('Session does not exist. Please login again');";
                echo "window.location.href = 'index.html';";
                echo "</script>";
            }

        
        
            $conn->close();
            ?>
        </div>
    </body>
</html>