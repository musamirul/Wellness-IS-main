<!DOCTYPE htmL>
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
        <?php
            $mrn = $_POST["mrn"];
            $ic = $_POST["ic"];
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
    </head>
    
    <body>
            
        <?php
        $check = "SELECT * FROM patient WHERE mrn = '".$mrn."'";
        $data = $conn->query($check);
        if ($data->num_rows>0)
        {
            while($row=$data->fetch_assoc())
            {
                $smoker = $row["smoker"];
                $asthma = $row["asthma"];
                $diabetes = $row["diabetes"];
                $heart_disease = $row["heart_disease"];
                $hypertension = $row["hypertension"];
                $stroke = $row["stroke"];
                $cancer = $row["cancer"];
                $tb = $row["tuberculosis"];
                $skin_disease = $row["skin_disease"];
                $kidneyp = $row["kidneyp"];
                $fits = $row["fits_psychiatric"];
                $father = $row["father_history"];
                $mother = $row["mother_history"];
                $siblings = $row["siblings_history"];
                $habits = $row["habits"];
                $allergy = $row["allergy"];
                $others = $row["others"];
                $medication = $row["medication"];
                $historyDate = $row["lastUpdateMH"];
                $appearance = $row["appearance"];
                $weight = $row["weight"];
                $height = $row["height"];
                $systolic = $row["systolic"];
                $diastolic = $row["diastolic"];
                $pulse = $row["pulse"];
                $va_aidedl = $row["va_aidedl"];
                $va_aidedr = $row["va_aidedr"];
                $va_unaidedl = $row["va_unaidedl"];
                $va_unaidedr = $row["va_unaidedr"];
                $colour_l = $row["colour_l"];
                $colour_r = $row["colour_r"];
                $fundoscopy_l = $row["fundoscopy_l"];
                $fundoscopy_r = $row["fundoscopy_r"];
                $bmi = $row["bmi"];
                $addons = $row["addons"];
                $package = $row["package"];
            }
        }
            $sex = $_POST["sex"];  
            $nose = $_POST["nose"];
            $throat = $_POST["throat"];
            $neck = $_POST["neck"];
            $skin = $_POST["skin"];
            $excanal_l = $_POST["excanal_l"];
            $excanal_r = $_POST["excanal_r"];
            $eardrum_l = $_POST["eardrum_l"];
            $eardrum_r = $_POST["eardrum_r"];
            $discharged_l = $_POST["discharged_l"];
            $discharged_r = $_POST["discharged_r"];
            $sound = $_POST["sound"];
            $murmur = $_POST["murmur"];
            $airentry = $_POST["airentry"];
            $chestexp = $_POST["chestexp"];
            $breathsound = $_POST["breathsound"];
            $liver = $_POST["liver"];
            $spleen = $_POST["spleen"];
            $kidney = $_POST["kidney"];
            $mentalfunct = $_POST["mentalfunct"];
            $coordination = $_POST["coordination"];
            $gait = $_POST["gait"];
            $genitalia = $_POST["genitalia"];
            $rectal = $_POST["rectal"];
            $lpow_l = $_POST["lpow_l"];
            $lpow_r = $_POST["lpow_r"];
            $lref_l = $_POST["lref_l"];
            $lref_r = $_POST["lref_r"];
            $lsen_l = $_POST["lsen_l"];
            $lsen_r = $_POST["lsen_r"];
            $upow_l = $_POST["upow_l"];
            $upow_r = $_POST["upow_r"];
            $uref_l = $_POST["uref_l"];
            $uref_r = $_POST["uref_r"];
            $usen_l = $_POST["usen_l"];
            $usen_r = $_POST["usen_r"];
            if($sex == "Female"){
                $breast = $_POST["breast"];
                $lmp = $_POST["lmp"];
                $gynaecology = $_POST["gynaecology"];
                $lastps = $_POST["lastps"];
            }
            $cxr = $_POST["cxr"];
            $ecg = $_POST["ecg"];
            if ($package == "Custom"){
                $mammogram = $_POST["mammogram"];
                $us_breast = $_POST["us_breast"];
                $pta = $_POST["pta"];
                $lft = $_POST["lft"];
            }
            if ($package == "Comprehensive" || $package == "Premium" || $package == "Custom"){
                $us_abdopel = $_POST["us_abdopel"];
            }
            if ($package == "Premium" || $package == "Custom"){
                $stresstest = $_POST["stresstest"];
            }
            $urine = $_POST["urine"];
            $blood = $_POST["blood"];
            $impression = $_POST["impression"];
            $recommendation = $_POST["recommendation"];
            $doneBy = $_SESSION["name"];

            $select = "SELECT visits FROM record WHERE mrn = '".$mrn."' ORDER BY visits DESC LIMIT 1";
            $data = $conn->query($select);

            if ($data->num_rows>0)
            {
                while($row=$data->fetch_assoc())
                {
                    $visits = $row["visits"]+1;
                }
            }
            else{
                $visits = 1;
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
            <h1 style='color: white;'>Patient's Report</h1>
            <br>
            <div class="container">
            <h3>Physical Examination</h3>
            <dl class="row h5">
                <dt class="col-sm-3">MRN: </dt>
                <dd class="col-sm-9 text-uppercase"><?php echo $mrn;?></dd>
                <dt class="col-sm-3">IC: </dt>
                <dd class="col-sm-9 text-uppercase"><?php echo $ic;?></dd>
                <dt class="col-sm-3">Done by: </dt>
                <dd class="col-sm-9 text-uppercase"><?php echo $_SESSION["name"];?></dd>
            </dl>
            <div>
            <dl class="row">
                <dt class="col-sm-3">General Appearance: </dt>
                <dd class="col-sm-9"><?php echo $appearance;?></dd>
                <dt class="col-sm-3">Weight: </dt>
                <dd class="col-sm-9"><?php echo $weight;?></dd>
                <dt class="col-sm-3">Height: </dt>
                <dd class="col-sm-9"><?php echo $height;?></dd>
                <dt class="col-sm-3">BMI: </dt>
                <dd class="col-sm-9"><?php echo $bmi;?></dd>
                <dt class="col-sm-3">Blood Pressure: </dt>
                <dd class="col-sm-9"><?php echo $systolic;?>/<?php echo $diastolic;?></dd>
                <dt class="col-sm-3">Nose: </dt>
                <dd class="col-sm-9"><?php echo $nose;?></dd>
                <dt class="col-sm-3">Throat: </dt>
                <dd class="col-sm-9"><?php echo $throat;?></dd>
                <dt class="col-sm-3">Neck: </dt>
                <dd class="col-sm-9"><?php echo $neck;?></dd>
                <dt class="col-sm-3">Skin: </dt>
                <dd class="col-sm-9"><?php echo $skin;?></dd>
            </dl>
            </div>
            <h3>Eyes</h3>
                <table style="table-layout: fixed; width:100%;" class="table table-striped">
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
				<br>
            <h3>Cardiovascular System</h3>
            <div>
            <dl class="row">
                <dt class="col-sm-3">Sound: </dt>
                <dd class="col-sm-9 text-uppercase"><?php echo $sound;?></dd>
                <dt class="col-sm-3">Murmur: </dt>
                <dd class="col-sm-9 text-uppercase"><?php echo $murmur;?></dd>
            </dl>
            </div>    
			<br>
            <h3>Respiratory System</h3>
            <div>
            <dl class="row">
                <dt class="col-sm-3">Air Entry: </dt>
                <dd class="col-sm-9 text-uppercase"><?php echo $airentry;?></dd>
                <dt class="col-sm-3">Chest Expansion: </dt>
                <dd class="col-sm-9 text-uppercase"><?php echo $chestexp;?></dd>
                <dt class="col-sm-3">Breath Sound: </dt>
                <dd class="col-sm-9 text-uppercase"><?php echo $breathsound;?></dd>
            </dl>
            </div>
            <h3>Gastrointestinal System</h3>
            <div>
            <dl class="row">
                <dt class="col-sm-3">Liver: </dt>
                <dd class="col-sm-9 text-uppercase"><?php echo $liver;?></dd>
                <dt class="col-sm-3">Spleen: </dt>
                <dd class="col-sm-9 text-uppercase"><?php echo $spleen;?></dd>
                <dt class="col-sm-3">Kidney: </dt>
                <dd class="col-sm-9 text-uppercase"><?php echo $kidney;?></dd>
            </dl>
            </div>
            <h3>Central Nervous System</h3>
            <div>
            <dl class="row">
                <dt class="col-sm-3">Mental Function: </dt>
                <dd class="col-sm-9 text-uppercase"><?php echo $mentalfunct;?></dd>
                <dt class="col-sm-3">Coordination: </dt>
                <dd class="col-sm-9 text-uppercase"><?php echo $coordination;?></dd>
                <dt class="col-sm-3">Gait: </dt>
                <dd class="col-sm-9 text-uppercase"><?php echo $gait;?></dd>
            </dl>
            </div>
            <h3>Genitourinary System</h3>
            <div>
            <dl class="row">
                <dt class="col-sm-3">Genitalia: </dt>
                <dd class="col-sm-9 text-uppercase"><?php echo $genitalia;?></dd>
                <dt class="col-sm-3">Rectal Examination: </dt>
                <dd class="col-sm-9 text-uppercase"><?php echo $rectal;?></dd>
            </dl>
            </div>
            <h3>Musculoskeletal System</h3>
            <table style="table-layout: fixed; width:100%;" class="table table-striped">
                    <thead class="table-dark" style="text-align:center;">
                    <tr>
                        <th>Lower Limb</th>
                        <th>Left</th>
                        <th>Right</th>
                    </tr>
                </thead>
                <tbody style="background-color: white;">
                    <tr>
                        <th>Power</th>
                        <td><?php echo $lpow_l;?></td>
                        <td><?php echo $lpow_r;?></td>
                    </tr>
                    <tr>
                        <th>Reflex</th>
                        <td><?php echo $lref_l;?></td>
                        <td><?php echo $lref_r;?></td>
                    </tr>
                    <tr>
                        <th>Sensation</th>
                        <td><?php echo $lsen_l;?></td>
                        <td><?php echo $lsen_r;?></td>
                    </tr>
                </tbody>
                </table><br>
                <table style="table-layout: fixed; width:100%;" class="table table-striped">
                    <thead class="table-dark" style="text-align:center;">
                        <tr>
                            <th>Upper Limb</th>
                            <th>Left</th>
                            <th>Right</th>
                        </tr>
                    </thead>
                    <tbody style="background-color: white;">
                        <tr>
                            <th>Power</th>
                            <td><?php echo $upow_l;?></td>
                            <td><?php echo $upow_r;?></td>
                        </tr>
                        <tr>
                            <th>Reflex</th>
                            <td><?php echo $uref_l;?></td>
                            <td><?php echo $uref_r;?></td>
                        </tr>
                        <tr>
                            <th>Sensation</th>
                            <td><?php echo $usen_l;?></td>
                            <td><?php echo $usen_r;?></td>
                        </tr>
                    </tbody>
                </table>
                <?php
                    if($sex == "Female"){
                ?>
                <h3>For Female</h3>
                <div>
                <dl class="row">
                    <dt class="col-sm-3">Breast: </dt>
                    <dd class="col-sm-9 text-uppercase"><?php echo $breast;?></dd>
                    <dt class="col-sm-3">Last Menstrual Period: </dt>
                    <dd class="col-sm-9 text-uppercase"><?php echo $lmp;?></dd>
                    <dt class="col-sm-3">Gynaecology History: </dt>
                    <dd class="col-sm-9 text-uppercase"><?php echo $gynaecology;?></dd>
                    <dt class="col-sm-3">Last Pap Smear: </dt>
                    <dd class="col-sm-9 text-uppercase"><?php echo $lastps;?></dd>
                </dl>
                </div>
                <?php
                    }
                ?>
                <h3>Investigation</h3>
                <div>
                <dl class="row">
                    <dt class="col-sm-3">Chest X-Ray: </dt>
                    <dd class="col-sm-9 text-uppercase"><?php echo $cxr;?></dd>
                    <dt class="col-sm-3">Electrocardiogram: </dt>
                    <dd class="col-sm-9 text-uppercase"><?php echo $ecg;?></dd>
                    <?php
                        if($package == "Custom"){
                    ?>
                    <dt class="col-sm-3">Mammogram: </dt>
                    <dd class="col-sm-9 text-uppercase"><?php echo $mammogram;?></dd>
                    <dt class="col-sm-3">Ultrasound Breast: </dt>
                    <dd class="col-sm-9 text-uppercase"><?php echo $us_breast;?></dd>
                    <dt class="col-sm-3">Pure Tone Audiometry: </dt>
                    <dd class="col-sm-9 text-uppercase"><?php echo $pta;?></dd>
                    <dt class="col-sm-3">Lung Function Test: </dt>
                    <dd class="col-sm-9 text-uppercase"><?php echo $lft;?></dd>
                    <?php
                        }
                        if($package == "Premium" || $package == "Comprehensive" || $package == "Custom"){
                    ?>
                    <dt class="col-sm-3">Ultrasound Abdomen Pelvis: </dt>
                    <dd class="col-sm-9 text-uppercase"><?php echo $us_abdopel;?></dd>
                    <?php
                        }
                        if($package == "Custom" || $package == "Premium"){
                    ?>
                    <dt class="col-sm-3">Stress Test: </dt>
                    <dd class="col-sm-9 text-uppercase"><?php echo $stresstest;?></dd>
                    <?php
                        }
                    ?>
                    
                    <dt class="col-sm-3">Urine: </dt>
                    <dd class="col-sm-9 text-uppercase"><?php echo $urine;?></dd>
                    <dt class="col-sm-3">Blood: </dt>
                    <dd class="col-sm-9 text-uppercase"><?php echo $blood;?></dd>
                    <dt class="col-sm-3">Impression: </dt>
                    <dd class="col-sm-9 text-uppercase"><?php echo nl2br($impression);?></dd>
                    <dt class="col-sm-3">Recommendation: </dt>
                    <dd class="col-sm-9 text-uppercase"><?php echo nl2br($recommendation);?></dd>
                </dl>
                </div>
            
            <?php
                if($sex == "Female"){
                    if ($package == "Custom"){
                        $insert = "INSERT INTO record (mrn, smokerUsed, asthmaUsed, diabetesUsed, heart_diseaseUsed, hypertensionUsed, strokeUsed, cancerUsed, tuberculosisUsed, skin_diseaseUsed, kidneypUsed, fits_psychiatricUsed, fatherUsed, motherUsed, siblingsUsed, habitsUsed, allergyUsed, othersUsed, 
                        medicationUsed, historyDate, appearanceUsed, weightUsed, heightUsed, bmiUsed, systolicUsed, diastolicUsed, pulseUsed, va_aidedrUsed, va_aidedlUsed, va_unaidedrUsed, va_unaidedlUsed, colour_rUsed, colour_lUsed, fundoscopy_rUsed, fundoscopy_lUsed, nose, throat, neck, skin, 
                        excanal_r, excanal_l, eardrum_r, eardrum_l, discharged_r, discharged_l, sound, murmur, airentry, chestexp, breathsound, liver, spleen, kidney, mentalfunct, coordination, gait, genitalia, rectal, lpow_r, lpow_l, lref_r, lref_l, lsen_r, lsen_l, upow_r, upow_l, uref_r, uref_l, usen_r,
                        usen_l, breast, lmp, gynaecology, lastps, cxr, ecg, mammogram, us_breast, us_abdopel, stresstest, pta, lft, urine, blood, impression, recommendation, lastUpdate, visits, doneBy, packageUsed, addonsUsed, fk_patient_ic) VALUES
                        ('".$mrn."', '".$smoker."', '".$asthma."', '".$diabetes."', '".$heart_disease."', '".$hypertension."', '".$stroke."', '".$cancer."', '".$tb."', '".$skin_disease."', '".$kidneyp."', '".$fits."', '".$father."', '".$mother."', '".$siblings."', '".$habits."', '".$allergy."', '".$others."', 
                        '".$medication."', '".$historyDate."', '".$appearance."', '".$weight."', '".$height."', '".$bmi."', '".$systolic."', '".$diastolic."', '".$pulse."', '".$va_aidedr."', '".$va_aidedl."', '".$va_unaidedr."', '".$va_unaidedl."', '".$colour_r."', '".$colour_l."',
                        '".$fundoscopy_r."', '".$fundoscopy_l."', '".$nose."', '".$throat."', '".$neck."', '".$skin."', '".$excanal_r."', '".$excanal_l."', '".$eardrum_r."', '".$eardrum_l."', '".$discharged_r."', '".$discharged_l."', '".$sound."', '".$murmur."',
                        '".$airentry."', '".$chestexp."', '".$breathsound."', '".$liver."', '".$spleen."', '".$kidney."', '".$mentalfunct."', '".$coordination."', '".$gait."', '".$genitalia."', '".$rectal."', '".$lpow_r."', '".$lpow_l."', '".$lref_r."', '".$lref_l."', 
                        '".$lsen_r."', '".$lsen_l."', '".$upow_r."', '".$upow_l."', '".$uref_r."', '".$uref_l."', '".$usen_r."',  '".$usen_l."', '".$breast."', '".$lmp."', '".$gynaecology."', '".$lastps."', '".$cxr."', '".$ecg."', '".$mammogram."', '".$us_breast."', 
                        '".$us_abdopel."', '".$stresstest."', '".$pta."', '".$lft."', '".$urine."', '".$blood."', '".$impression."', '".$recommendation."', '".$date."', '".$visits."', '".$doneBy."', '".$package."', '".$addons."', '".$ic."')";
                    }
                    elseif ($package == "Premium"){
                        $insert = "INSERT INTO record (mrn, smokerUsed, asthmaUsed, diabetesUsed, heart_diseaseUsed, hypertensionUsed, strokeUsed, cancerUsed, tuberculosisUsed, skin_diseaseUsed, kidneypUsed, fits_psychiatricUsed, fatherUsed, motherUsed, siblingsUsed, habitsUsed, allergyUsed, othersUsed, 
                        medicationUsed, historyDate, appearanceUsed, weightUsed, heightUsed, bmiUsed, systolicUsed, diastolicUsed, pulseUsed, va_aidedrUsed, va_aidedlUsed, va_unaidedrUsed, va_unaidedlUsed, colour_rUsed, colour_lUsed, fundoscopy_rUsed, fundoscopy_lUsed, nose, throat, neck, skin, 
                        excanal_r, excanal_l, eardrum_r, eardrum_l, discharged_r, discharged_l, sound, murmur, airentry, chestexp, breathsound, liver, spleen, kidney, mentalfunct, coordination, gait, genitalia, rectal, lpow_r, lpow_l, lref_r, lref_l, lsen_r, lsen_l, upow_r, upow_l, uref_r, uref_l, usen_r,
                        usen_l, breast, lmp, gynaecology, lastps, cxr, ecg, mammogram, us_breast, us_abdopel, stresstest, pta, lft, urine, blood, impression, recommendation, lastUpdate, visits, doneBy, packageUsed, addonsUsed, fk_patient_ic) VALUES
                        ('".$mrn."', '".$smoker."', '".$asthma."', '".$diabetes."', '".$heart_disease."', '".$hypertension."', '".$stroke."', '".$cancer."', '".$tb."', '".$skin_disease."', '".$kidneyp."', '".$fits."', '".$father."', '".$mother."', '".$siblings."', '".$habits."', '".$allergy."', '".$others."', 
                        '".$medication."', '".$historyDate."', '".$appearance."', '".$weight."', '".$height."', '".$bmi."', '".$systolic."', '".$diastolic."', '".$pulse."', '".$va_aidedr."', '".$va_aidedl."', '".$va_unaidedr."', '".$va_unaidedl."', '".$colour_r."', '".$colour_l."',
                        '".$fundoscopy_r."', '".$fundoscopy_l."', '".$nose."', '".$throat."', '".$neck."', '".$skin."', '".$excanal_r."', '".$excanal_l."', '".$eardrum_r."', '".$eardrum_l."', '".$discharged_r."', '".$discharged_l."', '".$sound."', '".$murmur."',
                        '".$airentry."', '".$chestexp."', '".$breathsound."', '".$liver."', '".$spleen."', '".$kidney."', '".$mentalfunct."', '".$coordination."', '".$gait."', '".$genitalia."', '".$rectal."', '".$lpow_r."', '".$lpow_l."', '".$lref_r."', '".$lref_l."', 
                        '".$lsen_r."', '".$lsen_l."', '".$upow_r."', '".$upow_l."', '".$uref_r."', '".$uref_l."', '".$usen_r."',  '".$usen_l."', '".$breast."', '".$lmp."', '".$gynaecology."', '".$lastps."', '".$cxr."', '".$ecg."', NULL, NULL, 
                        '".$us_abdopel."', '".$stresstest."', NULL, NULL, '".$urine."', '".$blood."', '".$impression."', '".$recommendation."', '".$date."', '".$visits."', '".$doneBy."', '".$package."', '".$addons."','".$ic."')";
                    }
                    elseif ($package == "Comprehensive"){
                        $insert = "INSERT INTO record (mrn, smokerUsed, asthmaUsed, diabetesUsed, heart_diseaseUsed, hypertensionUsed, strokeUsed, cancerUsed, tuberculosisUsed, skin_diseaseUsed, kidneypUsed, fits_psychiatricUsed, fatherUsed, motherUsed, siblingsUsed, habitsUsed, allergyUsed, othersUsed, 
                        medicationUsed, historyDate, appearanceUsed, weightUsed, heightUsed, bmiUsed, systolicUsed, diastolicUsed, pulseUsed, va_aidedrUsed, va_aidedlUsed, va_unaidedrUsed, va_unaidedlUsed, colour_rUsed, colour_lUsed, fundoscopy_rUsed, fundoscopy_lUsed, nose, throat, neck, skin, 
                        excanal_r, excanal_l, eardrum_r, eardrum_l, discharged_r, discharged_l, sound, murmur, airentry, chestexp, breathsound, liver, spleen, kidney, mentalfunct, coordination, gait, genitalia, rectal, lpow_r, lpow_l, lref_r, lref_l, lsen_r, lsen_l, upow_r, upow_l, uref_r, uref_l, usen_r,
                        usen_l, breast, lmp, gynaecology, lastps, cxr, ecg, mammogram, us_breast, us_abdopel, stresstest, pta, lft, urine, blood, impression, recommendation, lastUpdate, visits, doneBy, packageUsed, addonsUsed, fk_patient_ic) VALUES
                        ('".$mrn."', '".$smoker."', '".$asthma."', '".$diabetes."', '".$heart_disease."', '".$hypertension."', '".$stroke."', '".$cancer."', '".$tb."', '".$skin_disease."', '".$kidneyp."', '".$fits."', '".$father."', '".$mother."', '".$siblings."', '".$habits."', '".$allergy."', '".$others."', 
                        '".$medication."', '".$historyDate."', '".$appearance."', '".$weight."', '".$height."', '".$bmi."', '".$systolic."', '".$diastolic."', '".$pulse."', '".$va_aidedr."', '".$va_aidedl."', '".$va_unaidedr."', '".$va_unaidedl."', '".$colour_r."', '".$colour_l."',
                        '".$fundoscopy_r."', '".$fundoscopy_l."', '".$nose."', '".$throat."', '".$neck."', '".$skin."', '".$excanal_r."', '".$excanal_l."', '".$eardrum_r."', '".$eardrum_l."', '".$discharged_r."', '".$discharged_l."', '".$sound."', '".$murmur."',
                        '".$airentry."', '".$chestexp."', '".$breathsound."', '".$liver."', '".$spleen."', '".$kidney."', '".$mentalfunct."', '".$coordination."', '".$gait."', '".$genitalia."', '".$rectal."', '".$lpow_r."', '".$lpow_l."', '".$lref_r."', '".$lref_l."', 
                        '".$lsen_r."', '".$lsen_l."', '".$upow_r."', '".$upow_l."', '".$uref_r."', '".$uref_l."', '".$usen_r."',  '".$usen_l."', '".$breast."', '".$lmp."', '".$gynaecology."', '".$lastps."', '".$cxr."', '".$ecg."', NULL, NULL, 
                        '".$us_abdopel."', NULL, NULL, NULL, '".$urine."', '".$blood."', '".$impression."', '".$recommendation."', '".$date."', '".$visits."', '".$doneBy."', '".$package."', '".$addons."','".$ic."')";
                    }
                    else{
                        $insert = "INSERT INTO record (mrn, smokerUsed, asthmaUsed, diabetesUsed, heart_diseaseUsed, hypertensionUsed, strokeUsed, cancerUsed, tuberculosisUsed, skin_diseaseUsed, kidneypUsed, fits_psychiatricUsed, fatherUsed, motherUsed, siblingsUsed, habitsUsed, allergyUsed, othersUsed, 
                        medicationUsed, historyDate, appearanceUsed, weightUsed, heightUsed, bmiUsed, systolicUsed, diastolicUsed, pulseUsed, va_aidedrUsed, va_aidedlUsed, va_unaidedrUsed, va_unaidedlUsed, colour_rUsed, colour_lUsed, fundoscopy_rUsed, fundoscopy_lUsed, nose, throat, neck, skin, 
                        excanal_r, excanal_l, eardrum_r, eardrum_l, discharged_r, discharged_l, sound, murmur, airentry, chestexp, breathsound, liver, spleen, kidney, mentalfunct, coordination, gait, genitalia, rectal, lpow_r, lpow_l, lref_r, lref_l, lsen_r, lsen_l, upow_r, upow_l, uref_r, uref_l, usen_r,
                        usen_l, breast, lmp, gynaecology, lastps, cxr, ecg, mammogram, us_breast, us_abdopel, stresstest, pta, lft, urine, blood, impression, recommendation, lastUpdate, visits, doneBy, packageUsed, addonsUsed, fk_patient_ic) VALUES
                        ('".$mrn."', '".$smoker."', '".$asthma."', '".$diabetes."', '".$heart_disease."', '".$hypertension."', '".$stroke."', '".$cancer."', '".$tb."', '".$skin_disease."', '".$kidneyp."', '".$fits."', '".$father."', '".$mother."', '".$siblings."', '".$habits."', '".$allergy."', '".$others."', 
                        '".$medication."', '".$historyDate."', '".$appearance."', '".$weight."', '".$height."', '".$bmi."', '".$systolic."', '".$diastolic."', '".$pulse."', '".$va_aidedr."', '".$va_aidedl."', '".$va_unaidedr."', '".$va_unaidedl."', '".$colour_r."', '".$colour_l."',
                        '".$fundoscopy_r."', '".$fundoscopy_l."', '".$nose."', '".$throat."', '".$neck."', '".$skin."', '".$excanal_r."', '".$excanal_l."', '".$eardrum_r."', '".$eardrum_l."', '".$discharged_r."', '".$discharged_l."', '".$sound."', '".$murmur."',
                        '".$airentry."', '".$chestexp."', '".$breathsound."', '".$liver."', '".$spleen."', '".$kidney."', '".$mentalfunct."', '".$coordination."', '".$gait."', '".$genitalia."', '".$rectal."', '".$lpow_r."', '".$lpow_l."', '".$lref_r."', '".$lref_l."', 
                        '".$lsen_r."', '".$lsen_l."', '".$upow_r."', '".$upow_l."', '".$uref_r."', '".$uref_l."', '".$usen_r."',  '".$usen_l."', '".$breast."', '".$lmp."', '".$gynaecology."', '".$lastps."', '".$cxr."', '".$ecg."', NULL, NULL, 
                        NULL, NULL, NULL, NULL, '".$urine."', '".$blood."', '".$impression."', '".$recommendation."', '".$date."', '".$visits."', '".$doneBy."', '".$package."', '".$addons."','".$ic."')";
                    }
                }
                else{
                    if ($package == "Custom"){
                        $insert = "INSERT INTO record (mrn, smokerUsed, asthmaUsed, diabetesUsed, heart_diseaseUsed, hypertensionUsed, strokeUsed, cancerUsed, tuberculosisUsed, skin_diseaseUsed, kidneypUsed, fits_psychiatricUsed, fatherUsed, motherUsed, siblingsUsed, habitsUsed, allergyUsed, othersUsed, 
                        medicationUsed, historyDate, appearanceUsed, weightUsed, heightUsed, bmiUsed, systolicUsed, diastolicUsed, pulseUsed, va_aidedrUsed, va_aidedlUsed, va_unaidedrUsed, va_unaidedlUsed, colour_rUsed, colour_lUsed, fundoscopy_rUsed, fundoscopy_lUsed, nose, throat, neck, skin, 
                        excanal_r, excanal_l, eardrum_r, eardrum_l, discharged_r, discharged_l, sound, murmur, airentry, chestexp, breathsound, liver, spleen, kidney, mentalfunct, coordination, gait, genitalia, rectal, lpow_r, lpow_l, lref_r, lref_l, lsen_r, lsen_l, upow_r, upow_l, uref_r, uref_l, usen_r,
                        usen_l, breast, lmp, gynaecology, lastps, cxr, ecg, mammogram, us_breast, us_abdopel, stresstest, pta, lft, urine, blood, impression, recommendation, lastUpdate, visits, doneBy, packageUsed, addonsUsed, fk_patient_ic) VALUES
                        ('".$mrn."', '".$smoker."', '".$asthma."', '".$diabetes."', '".$heart_disease."', '".$hypertension."', '".$stroke."', '".$cancer."', '".$tb."', '".$skin_disease."', '".$kidneyp."', '".$fits."', '".$father."', '".$mother."', '".$siblings."', '".$habits."', '".$allergy."', '".$others."', 
                        '".$medication."', '".$historyDate."', '".$appearance."', '".$weight."', '".$height."', '".$bmi."', '".$systolic."', '".$diastolic."', '".$pulse."', '".$va_aidedr."', '".$va_aidedl."', '".$va_unaidedr."', '".$va_unaidedl."', '".$colour_r."', '".$colour_l."',
                        '".$fundoscopy_r."', '".$fundoscopy_l."', '".$nose."', '".$throat."', '".$neck."', '".$skin."', '".$excanal_r."', '".$excanal_l."', '".$eardrum_r."', '".$eardrum_l."', '".$discharged_r."', '".$discharged_l."', '".$sound."', '".$murmur."',
                        '".$airentry."', '".$chestexp."', '".$breathsound."', '".$liver."', '".$spleen."', '".$kidney."', '".$mentalfunct."', '".$coordination."', '".$gait."', '".$genitalia."', '".$rectal."', '".$lpow_r."', '".$lpow_l."', '".$lref_r."', '".$lref_l."', 
                        '".$lsen_r."', '".$lsen_l."', '".$upow_r."', '".$upow_l."', '".$uref_r."', '".$uref_l."', '".$usen_r."',  '".$usen_l."', NULL, NULL, NULL, NULL, '".$cxr."', '".$ecg."', '".$mammogram."', '".$us_breast."', 
                        '".$us_abdopel."', '".$stresstest."', '".$pta."', '".$lft."', '".$urine."', '".$blood."', '".$impression."', '".$recommendation."', '".$date."', '".$visits."', '".$doneBy."', '".$package."', '".$addons."','".$ic."')";
                    }
                    elseif ($package == "Premium"){
                        $insert = "INSERT INTO record (mrn, smokerUsed, asthmaUsed, diabetesUsed, heart_diseaseUsed, hypertensionUsed, strokeUsed, cancerUsed, tuberculosisUsed, skin_diseaseUsed, kidneypUsed, fits_psychiatricUsed, fatherUsed, motherUsed, siblingsUsed, habitsUsed, allergyUsed, othersUsed, 
                        medicationUsed, historyDate, appearanceUsed, weightUsed, heightUsed, bmiUsed, systolicUsed, diastolicUsed, pulseUsed, va_aidedrUsed, va_aidedlUsed, va_unaidedrUsed, va_unaidedlUsed, colour_rUsed, colour_lUsed, fundoscopy_rUsed, fundoscopy_lUsed, nose, throat, neck, skin, 
                        excanal_r, excanal_l, eardrum_r, eardrum_l, discharged_r, discharged_l, sound, murmur, airentry, chestexp, breathsound, liver, spleen, kidney, mentalfunct, coordination, gait, genitalia, rectal, lpow_r, lpow_l, lref_r, lref_l, lsen_r, lsen_l, upow_r, upow_l, uref_r, uref_l, usen_r,
                        usen_l, breast, lmp, gynaecology, lastps, cxr, ecg, mammogram, us_breast, us_abdopel, stresstest, pta, lft, urine, blood, impression, recommendation, lastUpdate, visits, doneBy, packageUsed, addonsUsed, fk_patient_ic) VALUES
                        ('".$mrn."', '".$smoker."', '".$asthma."', '".$diabetes."', '".$heart_disease."', '".$hypertension."', '".$stroke."', '".$cancer."', '".$tb."', '".$skin_disease."', '".$kidneyp."', '".$fits."', '".$father."', '".$mother."', '".$siblings."', '".$habits."', '".$allergy."', '".$others."', 
                        '".$medication."', '".$historyDate."', '".$appearance."', '".$weight."', '".$height."', '".$bmi."', '".$systolic."', '".$diastolic."', '".$pulse."', '".$va_aidedr."', '".$va_aidedl."', '".$va_unaidedr."', '".$va_unaidedl."', '".$colour_r."', '".$colour_l."',
                        '".$fundoscopy_r."', '".$fundoscopy_l."', '".$nose."', '".$throat."', '".$neck."', '".$skin."', '".$excanal_r."', '".$excanal_l."', '".$eardrum_r."', '".$eardrum_l."', '".$discharged_r."', '".$discharged_l."', '".$sound."', '".$murmur."',
                        '".$airentry."', '".$chestexp."', '".$breathsound."', '".$liver."', '".$spleen."', '".$kidney."', '".$mentalfunct."', '".$coordination."', '".$gait."', '".$genitalia."', '".$rectal."', '".$lpow_r."', '".$lpow_l."', '".$lref_r."', '".$lref_l."', 
                        '".$lsen_r."', '".$lsen_l."', '".$upow_r."', '".$upow_l."', '".$uref_r."', '".$uref_l."', '".$usen_r."',  '".$usen_l."', NULL, NULL, NULL, NULL, '".$cxr."', '".$ecg."', NULL, NULL, 
                        '".$us_abdopel."', '".$stresstest."', NULL, NULL, '".$urine."', '".$blood."', '".$impression."', '".$recommendation."', '".$date."', '".$visits."', '".$doneBy."', '".$package."', '".$addons."','".$ic."')";
                    }
                    elseif ($package == "Comprehensive"){
                        $insert = "INSERT INTO record (mrn, smokerUsed, asthmaUsed, diabetesUsed, heart_diseaseUsed, hypertensionUsed, strokeUsed, cancerUsed, tuberculosisUsed, skin_diseaseUsed, kidneypUsed, fits_psychiatricUsed, fatherUsed, motherUsed, siblingsUsed, habitsUsed, allergyUsed, othersUsed, 
                        medicationUsed, historyDate, appearanceUsed, weightUsed, heightUsed, bmiUsed, systolicUsed, diastolicUsed, pulseUsed, va_aidedrUsed, va_aidedlUsed, va_unaidedrUsed, va_unaidedlUsed, colour_rUsed, colour_lUsed, fundoscopy_rUsed, fundoscopy_lUsed, nose, throat, neck, skin, 
                        excanal_r, excanal_l, eardrum_r, eardrum_l, discharged_r, discharged_l, sound, murmur, airentry, chestexp, breathsound, liver, spleen, kidney, mentalfunct, coordination, gait, genitalia, rectal, lpow_r, lpow_l, lref_r, lref_l, lsen_r, lsen_l, upow_r, upow_l, uref_r, uref_l, usen_r,
                        usen_l, breast, lmp, gynaecology, lastps, cxr, ecg, mammogram, us_breast, us_abdopel, stresstest, pta, lft, urine, blood, impression, recommendation, lastUpdate, visits, doneBy, packageUsed, addonsUsed, fk_patient_ic) VALUES
                        ('".$mrn."', '".$smoker."', '".$asthma."', '".$diabetes."', '".$heart_disease."', '".$hypertension."', '".$stroke."', '".$cancer."', '".$tb."', '".$skin_disease."', '".$kidneyp."', '".$fits."', '".$father."', '".$mother."', '".$siblings."', '".$habits."', '".$allergy."', '".$others."', 
                        '".$medication."', '".$historyDate."', '".$appearance."', '".$weight."', '".$height."', '".$bmi."', '".$systolic."', '".$diastolic."', '".$pulse."', '".$va_aidedr."', '".$va_aidedl."', '".$va_unaidedr."', '".$va_unaidedl."', '".$colour_r."', '".$colour_l."',
                        '".$fundoscopy_r."', '".$fundoscopy_l."', '".$nose."', '".$throat."', '".$neck."', '".$skin."', '".$excanal_r."', '".$excanal_l."', '".$eardrum_r."', '".$eardrum_l."', '".$discharged_r."', '".$discharged_l."', '".$sound."', '".$murmur."',
                        '".$airentry."', '".$chestexp."', '".$breathsound."', '".$liver."', '".$spleen."', '".$kidney."', '".$mentalfunct."', '".$coordination."', '".$gait."', '".$genitalia."', '".$rectal."', '".$lpow_r."', '".$lpow_l."', '".$lref_r."', '".$lref_l."', 
                        '".$lsen_r."', '".$lsen_l."', '".$upow_r."', '".$upow_l."', '".$uref_r."', '".$uref_l."', '".$usen_r."',  '".$usen_l."', NULL, NULL, NULL, NULL, '".$cxr."', '".$ecg."', NULL, NULL, 
                        '".$us_abdopel."', NULL, NULL, NULL, '".$urine."', '".$blood."', '".$impression."', '".$recommendation."', '".$date."', '".$visits."', '".$doneBy."', '".$package."', '".$addons."','".$ic."')";
                    }
                    else{
                        $insert = "INSERT INTO record (mrn, smokerUsed, asthmaUsed, diabetesUsed, heart_diseaseUsed, hypertensionUsed, strokeUsed, cancerUsed, tuberculosisUsed, skin_diseaseUsed, kidneypUsed, fits_psychiatricUsed, fatherUsed, motherUsed, siblingsUsed, habitsUsed, allergyUsed, othersUsed, 
                        medicationUsed, historyDate, appearanceUsed, weightUsed, heightUsed, bmiUsed, systolicUsed, diastolicUsed, pulseUsed, va_aidedrUsed, va_aidedlUsed, va_unaidedrUsed, va_unaidedlUsed, colour_rUsed, colour_lUsed, fundoscopy_rUsed, fundoscopy_lUsed, nose, throat, neck, skin, 
                        excanal_r, excanal_l, eardrum_r, eardrum_l, discharged_r, discharged_l, sound, murmur, airentry, chestexp, breathsound, liver, spleen, kidney, mentalfunct, coordination, gait, genitalia, rectal, lpow_r, lpow_l, lref_r, lref_l, lsen_r, lsen_l, upow_r, upow_l, uref_r, uref_l, usen_r,
                        usen_l, breast, lmp, gynaecology, lastps, cxr, ecg, mammogram, us_breast, us_abdopel, stresstest, pta, lft, urine, blood, impression, recommendation, lastUpdate, visits, doneBy, packageUsed, addonsUsed, fk_patient_ic) VALUES
                        ('".$mrn."', '".$smoker."', '".$asthma."', '".$diabetes."', '".$heart_disease."', '".$hypertension."', '".$stroke."', '".$cancer."', '".$tb."', '".$skin_disease."', '".$kidneyp."', '".$fits."', '".$father."', '".$mother."', '".$siblings."', '".$habits."', '".$allergy."', '".$others."', 
                        '".$medication."', '".$historyDate."', '".$appearance."', '".$weight."', '".$height."', '".$bmi."', '".$systolic."', '".$diastolic."', '".$pulse."', '".$va_aidedr."', '".$va_aidedl."', '".$va_unaidedr."', '".$va_unaidedl."', '".$colour_r."', '".$colour_l."',
                        '".$fundoscopy_r."', '".$fundoscopy_l."', '".$nose."', '".$throat."', '".$neck."', '".$skin."', '".$excanal_r."', '".$excanal_l."', '".$eardrum_r."', '".$eardrum_l."', '".$discharged_r."', '".$discharged_l."', '".$sound."', '".$murmur."',
                        '".$airentry."', '".$chestexp."', '".$breathsound."', '".$liver."', '".$spleen."', '".$kidney."', '".$mentalfunct."', '".$coordination."', '".$gait."', '".$genitalia."', '".$rectal."', '".$lpow_r."', '".$lpow_l."', '".$lref_r."', '".$lref_l."', 
                        '".$lsen_r."', '".$lsen_l."', '".$upow_r."', '".$upow_l."', '".$uref_r."', '".$uref_l."', '".$usen_r."',  '".$usen_l."', NULL, NULL, NULL, NULL, '".$cxr."', '".$ecg."', NULL, NULL, 
                        NULL, NULL, NULL, NULL, '".$urine."', '".$blood."', '".$impression."', '".$recommendation."', '".$date."', '".$visits."', '".$doneBy."', '".$package."', '".$addons."','".$ic."')";
                    }
                }
                if ($conn->query($insert) === TRUE)
                {
                    echo "<p class='success'>Successfully Inserted medical report";
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
            <div>
                <button class="btn btn-primary"  style="margin: 5px;" onclick="window.location.href='homepage.php'">Back to Home Page</button>
                <form method="post">
                    <input type="hidden" value="<?php echo $mrn;?>" name="mrn">
                    <button formaction="selectRecord.php"  style="margin: 5px;"  class="btn btn-primary">View</button>
                </form>
                
            </div>
    </body>
</html>