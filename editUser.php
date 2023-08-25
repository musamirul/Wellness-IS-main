<!DOCTYPE html>
<html>
    <?php
    session_start();
    if(isset($_SESSION["username"])) {

    $id = $_POST["id"];

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
        $select = "SELECT * from user WHERE ID = '".$id."'";
        $data = $conn->query($select);
    }
    ?>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Edit User</title>
        <link rel="stylesheet" href="wellness.css">
        <link rel="stylesheet" href="bootstrap.css">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
        <script>
            function confirm_reset() {
                return confirm("Are you sure you want to reset all input?");
            }
        </script>
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
        <h1 style='color: white;'>Edit User</h1>
        <br>
        <div class="container">
    <?php
    if ($data->num_rows>0)
    {
        while($row=$data->fetch_assoc()){
    ?>
        <form action="updateUser.php" method="post">
        <dl class="row">
            <dt class="col-sm-3">Username: </dt>
            <dd class="col-sm-9"><input type="text" name="username" value="<?php echo $row["username"];?>"></dd>
            <dt class="col-sm-3">Name: </dt>
            <dd class="col-sm-9"><input type="text" name="name" value="<?php echo $row["name"];?>"></dd>
            <dt class="col-sm-3">User Type: </dt>
            <dd class="col-sm-9"><input type="text" name="type" value="<?php echo $row["type"];?>"></dd>
            <dt class="col-sm-3">Password: </dt>
            <dd class="col-sm-9"><input type="text" name="pw" value="<?php echo $row["password"];?>"></dd>
            </dl>
        </dl>
        <div style="text-align: center;">
            <input type="reset" class="btn btn-danger" value="Reset" onclick="return confirm_reset();">
            <input type="submit" class="btn btn-primary" value="Update Info">
            <input type="hidden" name="id" value="<?php echo $id;?>">
        </div>
        </form>
        <?php
            }
        }
        else{
            echo "User does not exist in system.";
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