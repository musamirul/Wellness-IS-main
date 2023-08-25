<!DOCTYPE html>
<html>
    <?php
    session_start();
    if(isset($_SESSION["username"])) {

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
    else{
        $select = "SELECT name from patient WHERE mrn = '".$mrn."'";
        $data = $conn->query($select);
    }
    ?>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Medical History Form</title>
        <link rel="stylesheet" href="wellness.css">
        <link rel="stylesheet" href="bootstrap.css">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
        <script>
            function confirm_reset() {
                return confirm("Are you sure you want to reset all input?");
            }
        </script>
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
        <br>
        <h1 style='color: white;'>Past Medical History</h1>
        <br>
        <?php
        if ($data->num_rows>0)
        {
            while($row=$data->fetch_assoc()){
        ?>
        <div class="container">
            <form method="post" action="selectRecord.php" style="margin-bottom: 20px;">
                <input type="submit" value="Back" class="btn btn-danger" style="position: relative;">
                <input type="hidden" value="<?php echo $mrn;?>" name="mrn">
            </form>
            <form action="insertHistory.php" method="post">
            <div class="info">
                <dl class="row h5">
                    <dt class="col-sm-3">Name: </dt>
                    <dd class="col-sm-9 text-uppercase"><?php echo $row["name"];?></dd>
                    <dt class="col-sm-3">MRN: </dt>
                    <dd class="col-sm-9 text-uppercase"><?php echo $mrn;?></dd>
                </dl>
            </div>
                <h2>Medical History</h2>
                <hr>
            <div class="row">
                <div class="col">
                        <label class="inline">Smoker/Non Smoker:</label>
                        <div class="radio">
                            <input type="radio" class="form-check-input" id="yes" name="smoker" value="Yes" required>
                            <label class="inline-radio" for="yes">Smoker</label>
                            <input type="radio" class="form-check-input" id="no" name="smoker" value="No">
                            <label class="inline-radio" for="no">Non Smoker</label>
                        </div>
                </div>
            </div>
            <div class="row">
                <div class="col">
                        <label class="inline">Diabetes:</label>
                        <div class="radio">
                            <input type="radio" class="form-check-input" id="yes" name="diabetes" value="Yes" required>
                            <label class="inline-radio" for="yes">Yes</label>
                            <input type="radio" class="form-check-input" id="no" name="diabetes" value="No">
                            <label class="inline-radio" for="no">No</label>
                            <input type="radio" class="form-check-input" id="unknown" name="diabetes" value="Unknown">
                            <label class="inline-radio" for="unknown">Unknown</label>
                        </div>
                </div>
                <div class="col">
                        <label class="inline">Heart Disease:</label>
                        <div class="radio">
                            <input type="radio" class="form-check-input" id="yes" name="heart_disease" value="Yes" required>
                            <label class="inline-radio" for="yes">Yes</label>
                            <input type="radio" class="form-check-input" id="no" name="heart_disease" value="No">
                            <label class="inline-radio" for="no">No</label>
                            <input type="radio" class="form-check-input" id="unknown" name="heart_disease" value="Unknown">
                            <label class="inline-radio" for="unknown">Unknown</label>
                        </div>
                </div>
            </div>
            <div class="row">
                <div class="col">
                            <label class="inline">Hypertension:</label>
                            <div class="radio">
                                <input type="radio" class="form-check-input" id="yes" name="hypertension" value="Yes" required>
                                <label class="inline-radio" for="yes">Yes</label>
                                <input type="radio" class="form-check-input" id="no" name="hypertension" value="No">
                                <label class="inline-radio" for="no">No</label>
                                <input type="radio" class="form-check-input" id="unknown" name="hypertension" value="Unknown">
                                <label class="inline-radio" for="unknown">Unknown</label>
                            </div>
                </div>
                <div class="col">
                            <label class="inline">Stroke:</label>
                            <div class="radio">
                                <input type="radio" class="form-check-input" id="yes" name="stroke" value="Yes" required>
                                <label class="inline-radio" for="yes">Yes</label>
                                <input type="radio" class="form-check-input" id="no" name="stroke" value="No">
                                <label class="inline-radio" for="no">No</label>
                                <input type="radio" class="form-check-input" id="unknown" name="stroke" value="Unknown">
                                <label class="inline-radio" for="unknown">Unknown</label>
                            </div>
                </div>
            </div>
            <div class="row">
                <div class="col">
                        <label class="inline">Asthma:</label>
                        <div class="radio">
                            <input type="radio" class="form-check-input" id="yes" name="asthma" value="Yes" required>
                            <label class="inline-radio" for="yes">Yes</label>
                            <input type="radio" class="form-check-input" id="no" name="asthma" value="No">
                            <label class="inline-radio" for="no">No</label>
                            <input type="radio" class="form-check-input" id="unknown" name="asthma" value="Unknown">
                            <label class="inline-radio" for="unknown">Unknown</label>
                        </div>
                </div>
                <div class="col">
                        <label class="inline">Tuberculosis:</label>
                        <div class="radio">
                            <input type="radio" class="form-check-input" id="yes" name="tuberculosis" value="Yes" required>
                            <label class="inline-radio" for="yes">Yes</label>
                            <input type="radio" class="form-check-input" id="no" name="tuberculosis" value="No">
                            <label class="inline-radio" for="no">No</label>
                            <input type="radio" class="form-check-input" id="unknown" name="tuberculosis" value="Unknown">
                            <label class="inline-radio" for="unknown">Unknown</label>
                        </div>
                </div>
            </div>
            <div class="row">
                <div class="col">
                        <label class="inline">Skin Disesase:</label>
                        <div class="radio">
                            <input type="radio" class="form-check-input" id="yes" name="skin_disease" value="Yes" required>
                            <label class="inline-radio" for="yes">Yes</label>
                            <input type="radio" class="form-check-input" id="no" name="skin_disease" value="No">
                            <label class="inline-radio" for="no">No</label>
                            <input type="radio" class="form-check-input" id="unknown" name="skin_disease" value="Unknown">
                            <label class="inline-radio" for="unknown">Unknown</label>
                        </div>
                </div>
                <div class="col">
                        <label class="inline">Kidney Problem:</label>
                        <div class="radio">
                            <input type="radio" class="form-check-input" id="yes" name="kidneyp" value="Yes" required>
                            <label class="inline-radio" for="yes">Yes</label>
                            <input type="radio" class="form-check-input" id="no" name="kidneyp" value="No">
                            <label class="inline-radio" for="no">No</label>
                            <input type="radio" class="form-check-input" id="unknown" name="kidneyp" value="Unknown">
                            <label class="inline-radio" for="unknown">Unknown</label>
                        </div>
                </div>
            </div>
            <div class="row">
                <div class="col">
                        <label class="inline">Fits/Psychiatric:</label>
                        <div class="radio">
                            <input type="radio" class="form-check-input" id="yes" name="fits_psychiatric" value="Yes" required>
                            <label class="inline-radio" for="yes">Yes</label>
                            <input type="radio" class="form-check-input" id="no" name="fits_psychiatric" value="No">
                            <label class="inline-radio" for="no">No</label>
                            <input type="radio" class="form-check-input" id="unknown" name="fits_psychiatric" value="Unknown">
                            <label class="inline-radio" for="unknown">Unknown</label>
                        </div>
                </div>
                <div class="col">
                        <label class="inline">Cancer:</label>
                        <div class="radio">
                            <input type="radio" class="form-check-input" id="yes" name="cancer" value="Yes" required>
                            <label class="inline-radio" for="yes">Yes</label>
                            <input type="radio" class="form-check-input" id="no" name="cancer" value="No">
                            <label class="inline-radio" for="no">No</label>
                            <input type="radio" class="form-check-input" id="unknown" name="cancer" value="Unknown">
                            <label class="inline-radio" for="unknown">Unknown</label>
                        </div>
                </div>
            </div>
                <h2>Family History</h2>
                <hr>
                <div>
                    <label class="inline" for="father_history">Father: </label>
                    <input type="text" id="father_history" name="father_history" maxlength="30" required>
                </div>
                <div>
                    <label class="inline" for="mother_history">Mother: </label>
                    <input type="text" id="mother_history" name="mother_history" maxlength="30" required>
                </div>
                <div>
                    <label class="inline" for="siblings_history">Siblings: </label>
                    <input type="text" id="siblings_history" name="siblings_history" maxlength="30" required>
                </div>
                <div>
                    <label class="inline" for="habits">Habits: </label>
                    <input type="text" id="habits" name="habits" maxlength="30" required>
                </div>
                <div>
                    <label class="inline" for="allergy">Allergy: </label>
                    <input type="text" id="allergy" name="allergy" maxlength="30" required>
                </div>
                <div>
                    <label class="inline" for="others">Others: </label>
                    <input type="text" id="others" name="others" maxlength="30" required>
                </div>
                <div>
                    <label class="inline" for="medication">Medication: </label>
                    <textarea id="medication" name="medication" rows="5" cols="100" required></textarea>
                </div><br><br>
                <div style="text-align: center;">
                    <input type="reset" class="btn btn-danger" value="Reset" onclick="return confirm_reset();">
                    <input type="submit" class="btn btn-primary" value="Update Info">
                    <input type="hidden" name="mrn" value="<?php echo $mrn; ?>">
                </div>
            
            </form>
            <?php
                }
            }
            else{
            ?>
            <div class="container">
                <form method="post">
                    <p>
                        Patient does not exist, register <button formaction="homepage.php" class="unstyled-button">here</button> 
                    </p>
                        <input type="hidden" name="mrn" value="<?php echo $mrn;?>">
                        <input type="hidden" name="check" value="">
                </form>
            </div>
            <?php
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