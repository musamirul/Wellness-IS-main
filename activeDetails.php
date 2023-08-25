<!DOCTYPE html>
<html>
    <?php
        session_start();
        if(isset($_SESSION["username"])) {
    ?>
    <head>
        <title>Patient's Report</title>
        <style type="text/css">
            @page {
              size: A4;
              margin: 40px; 
            }
            th{
                font-weight: 700;
            }
            span{
                margin-left: 5px;
            }
        </style> 
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="wellness.css">
        <link rel="stylesheet" href="bootstrap.css">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
        <?php
            $mrn = $_POST['mrn'];
            
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

            $query = "SELECT ic_passport, name FROM patient WHERE mrn = '$mrn'";
            $result = mysqli_query($conn,$query);
            while($row = mysqli_fetch_array($result)){
                $ic = $row['ic_passport'];
                $name = $row['name'];
            }
        ?>
    </head>
        <body>
            <?php
   
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
                <h1  id="top" style="margin-top: 40px; color: white;">Patient's Report</h1>
                <br>
                <div class="container">
                    <form method="post" style="text-align: center;">
                        <label for="mrn">Enter Patient's MRN</label><br>
                        <input type="text" id="mrn" name="mrn" maxlength="10" required autofocus>
                        <button formaction="selectRecord.php" class="btn btn-primary">Search</button>
                    </form>
                    <div class="text-center">
                      
                        <h5><?php echo $name; ?> &nbsp; [ MRN: <?php echo $mrn;?> ]</h5>
                        <form method="post" style="text-align: center;" class="btn-group">
                            <button formaction="selectRecord.php" class="btn btn-primary">View Record</button>
                            <button formaction="activeDetails.php" class="btn btn-primary active">Latest Details</button>
                            <button formaction="editProfile.php" class="btn btn-primary">Edit Profile</button>
                            <button formaction="checkHistoryForm.php" class="btn btn-primary">Check Medical History</button>
                             
                            <input type="hidden" name="mrn" value="<?php echo $mrn;?>">
                            <input type="hidden" name="ic" value="<?php echo $ic;?>">
                            
                            
                            <div class="btn-group" role="group">
                                <button id="btnGroupDrop" type="button" class="btn btn-primary dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                                    Insert
                                </button>
                                <ul class="dropdown-menu dropdown-menu-dark" aria-labelledby="btnGroupDrop">
                                    <li>
                                    <?php
                                        if($_SESSION["type"] == "admin" or $_SESSION["type"] == "doctor"){
                                    ?>

                                    <?php
                                        }
                                    ?>
                                    </li>
									<li>
                                        <button class="dropdown-item" formaction="recordForm.php">Screening Record</button>
                                    </li>
                                    <li>
                                        <button class="dropdown-item" formaction="physicalExam.php">Physical Examination</button>
                                    </li>
                                    <li>
                                        <button class="dropdown-item" formaction="historyForm.php">Medical History</button>
                                    </li>
                                </ul>
                            </div>
                        </form>
                    </div>
                    <hr>
                        <?php
                        $display = "SELECT * FROM patient WHERE mrn = '".$mrn."'";
                        $data = $conn->query($display);
                            if ($data->num_rows > 0)
                            {
                                while ($row = $data->fetch_assoc())
                                {
                        ?>
                            <div class="accordion" id="accordionDetails">
                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="headingOne">
                                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                            Patient's Information
                                        </button>
                                    </h2>  
                                    <div id="collapseOne" class="accordion-collapse collapse" aria-labelledby="headingOne" data-bs-parent="#accordionDetails">
                                        <div class="accordion-body">
                                            <dl class="row">
                                                <dt class="col-sm-3"> MRN: </dt>
                                                <dd class="col-sm-9"><?php echo $row['mrn'];?></dd>
                                                <dt class="col-sm-3">Name: </dt>
                                                <dd class="col-sm-9 text-uppercase"><?php echo $row['name'];?></dd>
                                                <dt class="col-sm-3">IC No/Passport: </dt>
                                                <dd class="col-sm-9"><?php echo $row['ic_passport'];?></dd>
                                                <dt class="col-sm-3">Date of Birth: </dt>
                                                <dd class="col-sm-9"><?php echo $row['date_of_birth'];?></dd>
                                                <dt class="col-sm-3">Home Address: </dt>
                                                <dd class="col-sm-9  text-uppercase"><?php echo nl2br($row['address']);?></dd>
                                                <dt class="col-sm-3">Email: </dt>
                                                <dd class="col-sm-9"><?php echo $row['email'];?></dd>
                                                <dt class="col-sm-3">Telephone: </dt>
                                                <dd class="col-sm-9"><?php echo $row['telephone'];?></dd>
                                                <dt class="col-sm-3">Sex: </dt>
                                                <dd class="col-sm-9  text-uppercase"><?php echo $row['sex'];?></dd>
                                                <dt class="col-sm-3">Occupation: </dt>
                                                <dd class="col-sm-9  text-uppercase"><?php echo $row['occupation'];?></dd>
                                                <dt class="col-sm-3">Race: </dt>
                                                <dd class="col-sm-9  text-uppercase"><?php echo $row['race'];?></dd>
                                                <dt class="col-sm-3">Religion: </dt>
                                                <dd class="col-sm-9  text-uppercase"><?php echo $row['religion'];?></dd>
                                                <dt class="col-sm-3">Marital Status: </dt>
                                                <dd class="col-sm-9  text-uppercase"><?php echo $row['marital_status'];?></dd>
                                                <dt class="col-sm-3">Next of Kin: </dt>
                                                <dd class="col-sm-9  text-uppercase"><?php echo $row['next_of_kin'];?></dd>
                                                <dt class="col-sm-3">Relationship: </dt>
                                                <dd class="col-sm-9  text-uppercase"><?php echo $row['relationship'];?></dd>
                                                <dt class="col-sm-3">Telephone: </dt>
                                                <dd class="col-sm-9"><?php echo $row['telephone_nok'];?></dd>
                                                <dt class="col-sm-3">Package: </dt>
                                                <dd class="col-sm-9  text-uppercase"><?php echo $row['package'];?></dd>
                                                <dt class="col-sm-3">Additional Test: </dt>
                                                <dd class="col-sm-9  text-uppercase"><?php echo nl2br($row['addons']);?></dd>
                                                <dt class="col-sm-3">Registered On: </dt>
                                                <dd class="col-sm-9"><?php echo $row['registeredOn'];?></dd>
                                                <dt class="col-sm-3">Last Edit By: </dt>
                                                <dd class="col-sm-9"><?php echo $row['pic'];?></dd>
                                                <dt class="col-sm-3">Last Edited On: </dt>
                                                <dd class="col-sm-9"><?php echo $row['lastUpdateOn'];?></dd>
                                            </dl>    
                                        </div>
                                    </div>
                                </div>
                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="headingTwo">
                                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                            Medical History
                                        </button>
                                    </h2>
                                    <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#accordionDetails">
                                        <div class="accordion-body">
                                            <dl class="row">
                                                <dt class="col-sm-3">Smoker/Non Smoker: </dt>
                                                <dd class="col-sm-9  text-uppercase"><?php echo $row['smoker'];?></dd>
                                                <dt class="col-sm-3">Asthma: </dt>
                                                <dd class="col-sm-9  text-uppercase"><?php echo $row['asthma'];?></dd>
                                                <dt class="col-sm-3">Diabetes: </dt>
                                                <dd class="col-sm-9  text-uppercase"><?php echo $row['diabetes'];?></dd>
                                                <dt class="col-sm-3">Heart Disease: </dt>
                                                <dd class="col-sm-9  text-uppercase"><?php echo $row['heart_disease'];?></dd>
                                                <dt class="col-sm-3">Hypertension: </dt>
                                                <dd class="col-sm-9  text-uppercase"><?php echo $row['hypertension'];?></dd>
                                                <dt class="col-sm-3">Stroke: </dt>
                                                <dd class="col-sm-9  text-uppercase"><?php echo $row['stroke'];?></dd>
                                                <dt class="col-sm-3">Cancer: </dt>
                                                <dd class="col-sm-9  text-uppercase"><?php echo $row['cancer'];?></dd>
                                                <dt class="col-sm-3">Tuberculosis: </dt>
                                                <dd class="col-sm-9  text-uppercase"><?php echo $row['tuberculosis'];?></dd>
                                                <dt class="col-sm-3">Skin Disease: </dt>
                                                <dd class="col-sm-9  text-uppercase"><?php echo $row['skin_disease'];?></dd>
                                                <dt class="col-sm-3">Kidney Problem: </dt>
                                                <dd class="col-sm-9  text-uppercase"><?php echo $row['kidneyp'];?></dd>
                                                <dt class="col-sm-3">Fits/Psychiatric: </dt>
                                                <dd class="col-sm-9  text-uppercase"><?php echo $row['fits_psychiatric'];?></dd>
                                            </dl>
                                            <h3>Family History</h3>
                                            <dl class="row">
                                                <dt class="col-sm-3">Father: </dt>
                                                <dd class="col-sm-9  text-uppercase"><?php echo $row['father_history'];?></dd>
                                                <dt class="col-sm-3">Mother: </dt>
                                                <dd class="col-sm-9  text-uppercase"><?php echo $row['mother_history'];?></dd>
                                                <dt class="col-sm-3">Siblings: </dt>
                                                <dd class="col-sm-9  text-uppercase"><?php echo $row['siblings_history'];?></dd>
                                                <dt class="col-sm-3">Habits: </dt>
                                                <dd class="col-sm-9  text-uppercase"><?php echo $row['habits'];?></dd>
                                                <dt class="col-sm-3">Allergy: </dt>
                                                <dd class="col-sm-9  text-uppercase"><?php echo $row['allergy'];?></dd>
                                                <dt class="col-sm-3">Others: </dt>
                                                <dd class="col-sm-9  text-uppercase"><?php echo $row['others'];?></dd>
                                                <dt class="col-sm-3">Medication: </dt>
                                                <dd class="col-sm-9  text-uppercase"><?php echo $row['medication'];?></dd>
                                                <dt class="col-sm-3">Last Updated On: </dt>
                                                <dd class="col-sm-9"><?php echo $row['lastUpdateMH'];?></dd>
                                            </dl>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="headingThree">
                                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                                            Physical Examination
                                        </button>
                                    </h2>
                                    <div id="collapseThree" class="accordion-collapse collapse" aria-labelledby="headingThree" data-bs-parent="#accordionDetails">
                                        <div class="accordion-body">   
                                            <dl class="row">
                                                <dt class="col-sm-3">General Appearance: </dt>
                                                <dd class="col-sm-9  text-uppercase"><?php echo $row['appearance'];?></dd>
                                                <dt class="col-sm-3">Weight: </dt>
                                                <dd class="col-sm-9"><?php echo $row['weight'];?></dd>
                                                <dt class="col-sm-3">Height: </dt>
                                                <dd class="col-sm-9"><?php echo $row['height'];?></dd>
                                                <dt class="col-sm-3">BMI: </dt>
                                                <dd class="col-sm-9"><?php echo $row['bmi'];?></dd>
                                                <dt class="col-sm-3">Blood Pressure: </dt>
                                                <dd class="col-sm-9"><?php echo $row['systolic'];?>/<?php echo $row['diastolic'];?></dd>
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
                                                <tbody>
                                                <tr>
                                                    <th>Visual Acuity(Aided)</th>
                                                    <td><?php  echo $row['va_aidedl'];?></td>
                                                    <td><?php echo $row['va_aidedr'];?></td>
                                                </tr>
                                                <tr>
                                                    <th>Visual Acuity(Unaided)</th>
                                                    <td><?php echo $row['va_unaidedl'];?></td>
                                                    <td><?php echo $row['va_unaidedr'];?></td>
                                                </tr>
                                                <tr>
                                                    <th>Colour</th>
                                                    <td><?php echo $row['colour_l'];?></td>
                                                    <td><?php echo $row['colour_r'];?></td>
                                                </tr>
                                                <tr>
                                                    <th>Fundoscopy</th>
                                                    <td><?php echo $row['fundoscopy_l'];?></td>
                                                    <td><?php echo $row['fundoscopy_r'];?></td>
                                                </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                
                                <?php

                                
                                            $queryRec = "SELECT * FROM record WHERE fk_patient_ic = '$ic'";
                                            $resultRec = mysqli_query($conn,$queryRec);
                                            if ($resultRec->num_rows > 0) {
                                                $currentID = $row['recordID'];
                                                while($row=mysqli_fetch_array($resultRec)){
                                                    if($row['recordID'] > $currentID){
                                                        $currentID = $row['recordID'];
                                                    }
                                                    
                                                }
                                            }
                                            $currentID;

                                            $query2 ="SELECT * FROM record WHERE fk_patient_ic = '$ic'";
                                            $result2 = mysqli_query($conn,$query2);
                                            $row=mysqli_fetch_array($result2);
                                                
                                            
                                        ?>
								 <div class="accordion-item">
                                    <h2 class="accordion-header" id="headingFour">
                                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFour" aria-expanded="true" aria-controls="collapseFour">
                                            Screening Record
                                        </button>
                                    </h2>
                                    <div id="collapseFour" class="accordion-collapse collapse" aria-labelledby="headingFour" data-bs-parent="#accordionDetails">
                                        
                                        <div class="accordion-body">

                                        <h3>EARS</h3>
                                            <table style="table-layout: fixed; width:50%;" class="table table-striped text-uppercase">
                                                <thead class="table-dark" style="text-align:center;">
                                                    <tr>
                                                        <th></th>
                                                        <th>Left</th>
                                                        <th>Right</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                <tr>
                                                    <th>External Canal</th>
                                                    <td><?php  echo $row['excanal_l'];?></td>
                                                    <td><?php echo $row['excanal_r'];?></td>
                                                </tr>
                                                <tr>
                                                    <th>Ear Drum</th>
                                                    <td><?php echo $row['eardrum_l'];?></td>
                                                    <td><?php echo $row['eardrum_r'];?></td>
                                                </tr>
                                                <tr>
                                                    <th>Discharged</th>
                                                    <td><?php echo $row['discharged_l'];?></td>
                                                    <td><?php echo $row['discharged_r'];?></td>
                                                </tr>
                                                </tbody>
                                            </table>

                                            <dl class="row">
                                                <dt class="col-sm-3">Nose: </dt>
                                                <dd class="col-sm-9  text-uppercase"><?php echo $row['nose'];?></dd>
                                                <dt class="col-sm-3">Throat: </dt>
                                                <dd class="col-sm-9  text-uppercase"><?php echo $row['throat'];?></dd>
                                                <dt class="col-sm-3">Neck: </dt>
                                                <dd class="col-sm-9  text-uppercase"><?php echo $row['neck'];?></dd>
                                                <dt class="col-sm-3">Skin: </dt>
                                                <dd class="col-sm-9  text-uppercase"><?php echo $row['skin'];?></dd>
                                            </dl>
                                            
                                            <h3><u>Cardiovascular System</u></h3>
                                            <div>
                                                <dl class="row">
                                                    <dt class="col-sm-3">Sound: </dt>
                                                    <dd class="col-sm-9  text-uppercase"><?php echo $row['sound'];?></dd>
                                                    <dt class="col-sm-3">Murmur: </dt>
                                                    <dd class="col-sm-9  text-uppercase"><?php echo $row['murmur'];?></dd>
                                                </dl>
                                            </div>    
                                            <h3><u>Respiratory System</u></h3>
                                            <div>
                                                <dl class="row">
                                                    <dt class="col-sm-3">Air Entry: </dt>
                                                    <dd class="col-sm-9  text-uppercase"><?php echo $row['airentry'];?></dd>
                                                    <dt class="col-sm-3">Chest Expansion: </dt>
                                                    <dd class="col-sm-9  text-uppercase"><?php echo $row['chestexp'];?></dd>
                                                    <dt class="col-sm-3">Breath Sound: </dt>
                                                    <dd class="col-sm-9  text-uppercase"><?php echo $row['breathsound'];?></dd>
                                                </dl>
                                            </div>
                                            <h3><u>Gastrointestinal System</u></h3>
                                            <div>
                                                <dl class="row">
                                                    <dt class="col-sm-3">Liver: </dt>
                                                    <dd class="col-sm-9  text-uppercase"><?php echo $row['liver'];?></dd>
                                                    <dt class="col-sm-3">Spleen: </dt>
                                                    <dd class="col-sm-9  text-uppercase"><?php echo $row['spleen'];?></dd>
                                                    <dt class="col-sm-3">Kidney: </dt>
                                                    <dd class="col-sm-9  text-uppercase"><?php echo $row['kidney'];?></dd>
                                                </dl>
                                            </div>
                                            <h3><u>Central Nervous System</u></h3>
                                            <div>
                                                <dl class="row">
                                                    <dt class="col-sm-3">Mental Function: </dt>
                                                    <dd class="col-sm-9  text-uppercase"><?php echo $row['mentalfunct'];?></dd>
                                                    <dt class="col-sm-3">Coordination: </dt>
                                                    <dd class="col-sm-9  text-uppercase"><?php echo $row['coordination'];?></dd>
                                                    <dt class="col-sm-3">Gait: </dt>
                                                    <dd class="col-sm-9  text-uppercase"><?php echo $row['gait'];?></dd>
                                                </dl>
                                            </div>
                                            <h3><u>Genitourinary System</u></h3>
                                            <div>
                                                <dl class="row">
                                                    <dt class="col-sm-3">Genitalia: </dt>
                                                    <dd class="col-sm-9  text-uppercase"><?php echo $row['genitalia'];?></dd>
                                                    <dt class="col-sm-3">Rectal Examination: </dt>
                                                    <dd class="col-sm-9  text-uppercase"><?php echo $row['rectal'];?></dd>
                                                </dl>
                                            </div>
                                            <h3><u>Musculoskeletal System</u></h3>
                                            <table style="table-layout: fixed; width:100%;" class="table table-striped text-uppercase">
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
                                                    <td><?php echo $row['lpow_l'];?></td>
                                                    <td><?php echo $row['lpow_r'];?></td>
                                                </tr>
                                                <tr>
                                                    <th>Reflex</th>
                                                    <td><?php echo $row['lref_l'];?></td>
                                                    <td><?php echo $row['lref_r'];?></td>
                                                </tr>
                                                <tr>
                                                    <th>Sensation</th>
                                                    <td><?php echo $row['lsen_l'];?></td>
                                                    <td><?php echo $row['lsen_r'];?></td>
                                                </tr>
                                            </tbody>
                                            </table><br>
                                            <table style="table-layout: fixed; width:100%;" class="table table-striped text-uppercase">
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
                                                        <td><?php echo $row['upow_l'];?></td>
                                                        <td><?php echo $row['upow_r'];?></td>
                                                    </tr>
                                                    <tr>
                                                        <th>Reflex</th>
                                                        <td><?php echo $row['uref_l'];?></td>
                                                        <td><?php echo $row['uref_r'];?></td>
                                                    </tr>
                                                    <tr>
                                                        <th>Sensation</th>
                                                        <td><?php echo $row['usen_l'];?></td>
                                                        <td><?php echo $row['usen_r'];?></td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                            <?php
                                                //if($row['sex'] == "Female"){
                                            ?>
											<br>
											<br>
                                            <h3><u>For Female</u></h3>
                                            <div>
                                                <dl class="row">
                                                    <dt class="col-sm-3">Breast: </dt>
                                                    <dd class="col-sm-9  text-uppercase"><?php echo $row['breast'];?></dd>
                                                    <dt class="col-sm-3">Last Menstrual Period: </dt>
                                                    <dd class="col-sm-9  text-uppercase"><?php echo $row['lmp'];?></dd>
                                                    <dt class="col-sm-3  ">Gynaecology History: </dt>
                                                    <dd class="col-sm-9  text-uppercase"><?php echo $row['gynaecology'];?></dd>
                                                    <dt class="col-sm-3">Last Pap Smear: </dt>
                                                    <dd class="col-sm-9  text-uppercase"><?php echo $row['lastps'];?></dd>
                                                </dl>
                                            </div>
                                            <?php
                                                //}
                                            ?>
                                            <h3><u>Investigation</u></h3>
                                            <div>
                                                <dl class="row">
                                                    <dt class="col-sm-3">Chest X-Ray: </dt>
                                                    <dd class="col-sm-9  text-uppercase"><?php echo $row['cxr'];?></dd>
                                                    <dt class="col-sm-3">Electrocardiogram: </dt>
                                                    <dd class="col-sm-9  text-uppercase"><?php echo $row['ecg'];?></dd>
                                                    <?php
                                                        //if($row['packageUsed'] == "Custom")
														//{
                                                    ?>
                                                    <dt class="col-sm-3">Mammogram: </dt>
                                                    <dd class="col-sm-9  text-uppercase"><?php echo $row['mammogram'];?></dd>
                                                    <dt class="col-sm-3">Ultrasound Breast: </dt>
                                                    <dd class="col-sm-9  text-uppercase"><?php echo $row['us_breast'];?></dd>
                                                    <dt class="col-sm-3">Pure Tone Audiometry: </dt>
                                                    <dd class="col-sm-9  text-uppercase"><?php echo $row['pta'];?></dd>
                                                    <dt class="col-sm-3">Lung Function Test: </dt>
                                                    <dd class="col-sm-9  text-uppercase"><?php echo $row['lft'];?></dd>
                                                    <?php
                                                       // }
                                                        //if($row['packageUsed'] == "Premium" || $row['packageUsed'] == "Comprehensive" || $row['packageUsed'] == "Custom")
														//{
                                                    ?>
                                                    <dt class="col-sm-3">Ultrasound Abdomen Pelvis: </dt>
                                                    <dd class="col-sm-9"><?php echo $row['us_abdopel'];?></dd>
                                                    <?php
                                                       // }
                                                        //if($row['packageUsed'] == "Custom" || $row['packageUsed'] == "Premium")
														//{
                                                    ?>
                                                    <dt class="col-sm-3">Stress Test: </dt>
                                                    <dd class="col-sm-9"><?php echo $row['stresstest'];?></dd>
                                                    <?php
                                                        //}
                                                    ?>
                                                    <dt class="col-sm-3">Urine: </dt>
                                                    <dd class="col-sm-9  text-uppercase"><?php echo $row['urine'];?></dd>
                                                    <dt class="col-sm-3">Blood: </dt>
                                                    <dd class="col-sm-9  text-uppercase"><?php echo $row['blood'];?></dd>
                                                    <dt class="col-sm-3">Impression: </dt>
                                                    <dd class="col-sm-9  text-uppercase"><?php echo nl2br($row['impression']);?></dd>
                                                    <dt class="col-sm-3">Recommendation: </dt>
                                                    <dd class="col-sm-9  text-uppercase"><?php echo nl2br($row['recommendation']);?></dd>
                                                    <dt class="col-sm-3">Last Updated On: </dt>
                                                    <dd class="col-sm-9  text-uppercase"><?php echo $row['lastUpdate'];?></dd>
                                                </dl>
                                            </div>
                                            <br>
                                            <a href="#top" class="top">Back to Top</a>
                                            <script>
                                                print(){
                                                    window.print();
                                                }
                                            </script>
                                        </div>
                                       <?php
                                            
                                       ?>
                                    </div>
                                        </div>
                                    </div>
                                </div>
                                
                            </div>
                        </div>
                        <?php
                            }
                        }
                            else{
                                echo "<div class='fail text-center'>Patient does not exist in system.</div>";
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
        </body>