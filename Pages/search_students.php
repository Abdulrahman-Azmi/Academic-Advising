<!DOCTYPE html>
<?php 
	session_start();

	//open database
	require_once 'includes/db_connect.php';
	require_once 'includes/functions.php';

	if (!logged_in() || !isset($_SESSION['advid'])) {
  		if(!isset($_SESSION['AdminID'])) header("Location: index.php");
	}
?>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title><?php echo $_SESSION['fname'] . " " . $_SESSION['lname'] ?> | Home</title>

    <link rel="stylesheet" type="text/css" href="css/bootstrap.css">
    <link rel="stylesheet" type="text/css" href="css/main.css"/>

    <script src="js/jquery.searchable-1.1.0.min.js"></script>
    <script src="js/searchable.js"></script>
    <script   src="https://code.jquery.com/jquery-1.12.3.js"   integrity="sha256-1XMpEtA4eKXNNpXcJ1pmMPs8JV+nwLdEqwiJeCQEkyc="   crossorigin="anonymous"></script>
   <script src="js/bootstrap.min.js"></script>
</head>
<body class="Home">
    <nav class="navbar navbar-default navbar-custom">
        <div class="container-fluid"> 
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1"></button>
                <a class="navbar-brand" href="advisor_home.php">Advisor</a>
            </div>
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav">
                    <li> </li>
                    <li> </li>
                </ul>
                <ul class="nav navbar-nav navbar-right">
                    <li><a href="advisor_home.php">
                    <?php   
                        echo $_SESSION['fname'];
                        echo " ";
                        echo $_SESSION['lname']; 
                    ?>
                    </a></li>
                    <li>&nbsp;</li>
                    <li><a><?php echo $_SESSION['advid']; ?></a></li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container">
        <div class="row text-center" style="margin-top: 20px;">
            <div class="col-md-2"></div>
            <div class="col-md-8">
                <div class="row">
                    <div class="col-md-4"></div>
                    <div class="col-md-4">
                        <input type="search" id="search" value="" class="form-control" placeholder="Search for students">
                    </div>
                    <div class="col-md-4"></div>
                </div>
                <div class="row extra-top">
                    <div class="col-md-12 overflowing">
                        <table id="studentList" class="table">
                            <thead>
                                <tr>
                                    <th>Student ID</th>
                                    <th>First Name</th>
                                    <th>Last Name</th>
                                    <th>major</th>
                                    <th>Advisor</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                    require_once 'includes/functions.php';
                                    require_once 'includes/db_connect.php';
        
                                    $advid = $_SESSION['advid'];
        
                                    $sql = " SELECT student.fname AS fname, student.lname AS lname, studentid, major, advisor.fname AS advFname, advisor.lname AS advLname 
                                             FROM student JOIN advisor
                                             ON student.advid = advisor.advid;";
        
                                    $result = $connection->query($sql);
        
                                    if ($result->num_rows > 0) {
                                        while ($row = $result->fetch_assoc()) {
                                            // print_r($row);
                                            $fname = $row['fname'];
                                            $lname = $row['lname'];
                                            $studentid = $row['studentid'];
                                            $major = $row['major'];
                                            $advisorName = $row['advFname'] . " " . $row['advLname'];
                                            echo "<tr>";
                                            echo "<td><a class='logout' href=advisor_form.php?studentid=",urlencode($studentid),">$studentid</a></td>";
                                            echo "<td>$fname</td>";
                                            echo "<td>$lname</td>";
                                            echo "<td>$major</td>";
                                            echo "<td>$advisorName</td>";
                                            echo "</tr>";
                                        }
                                    }
                                    $connection->close();
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="col-md-2"></div>
        </div>
        <div class="row text-center">
            <div class="extra-top">
                     <a href="includes/logout.php" class="logout">Logout</a>
            </div>
        </div>
    </div>       
         <!-- include footer -->
    <center>
      <?php include 'footer.php'; ?>
    </center>

</body>
</html>