<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Coures</title>

    <link rel="stylesheet" type="text/css" href="css/bootstrap.css">
    <link rel="stylesheet" type="text/css" href="css/bootstrap-select.css"/>
    <link rel="stylesheet" type="text/css" href="css/main.css"/>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <!-- // <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script> -->

    <script src="js/bootstrap-select.js"/></script>
    <script src="js/bootstrap.min.js"></script>
</head>
<body>
    <?php
    // Database information
    require_once 'includes/db_connect.php';
    require_once 'includes/functions.php';

    // POST variables
    $courseid = validate_input($_POST['courseid']);
    $classname = validate_input($_POST['classname']);
    $units = $_POST['units'];
    $oldCourseId = validate_input($_POST['oldCourseId']);
    
    $Web_Content = $_POST['Web_Content'];
    
    if(isset($_FILES['Course'])){
             // Set File placement folder
            $target_dir = "uploads\Courses\\";
        // Get file path
        $target_file = $target_dir . basename($_FILES["Course"]["name"]);  
        
        
        if (!file_exists($_FILES["Course"]["tmp_name"])) {
            $resMessage = array(
                "status" => "alert-danger",
                "message" => "Course Doesn't exist."
            );
            //exit;
        } else {
            if (move_uploaded_file($_FILES["Course"]["tmp_name"], $target_file)) {
                //echo $target_file;
                $Course = $target_file;
            } else {
                $resMessage = array(
                    "status" => "alert-danger",
                    "message" => "Course coudn't be uploaded."
                );
                exit;
            }}}

            if(isset($_FILES['Book'])){
            // Set file placement folder
                $target_dir = "uploads\Books\\";
                // Get file path
                $target_file = $target_dir . basename($_FILES["Book"]["name"]);  
                
                
                if (!file_exists($_FILES["Book"]["tmp_name"])) {
                    $resMessage = array(
                        "status" => "alert-danger",
                        "message" => "Book Doesn't exist."
                    );
                    //exit;
                } else {
                    if (move_uploaded_file($_FILES["Book"]["tmp_name"], $target_file)) {
                       // echo $target_file;
                        $Book = $target_file;
                    } else {
                        $resMessage = array(
                            "status" => "alert-danger",
                            "message" => "Book coudn't be uploaded."
                        );
                        exit;
                    }}
                }

    if (isset($_POST['prereqs'])) {
        $prereqs = $_POST['prereqs'];
    }
    if (isset($_POST['coreqs'])) {
        $coreqs = $_POST['coreqs'];
    }

    // calculate the term
    $term = "";
    if (isset($_POST['fall'])) {
        $term .= "1";
    } else {
        $term .= "0";
    }

    if (isset($_POST['spring'])) {
        $term .= "1";
    } else {
        $term .= "0";
    }

    if (isset($_POST['summer'])) {
        $term .= "1";
    } else {
        $term .= "0";
    }

    if(!empty($Book) && !empty($Course)){
        $updateCourse = "UPDATE courses 
                    SET courseid = ?, classname = ?, units = ?, term = ?, Course=?, Book=?, Web_Content=?
                    WHERE courseid = ?;";
        $updateCourseStmt = $connection->prepare($updateCourse);
    $updateCourseStmt->bind_param('ssisssss', $courseid, $classname, $units, $term, $Course,$Book,$Web_Content ,$oldCourseId);
    }elseif(!empty($Book) &&empty($Course)){
        
        $updateCourse = "UPDATE courses 
        SET courseid = ?, classname = ?, units = ?, term = ?, Book=?, Web_Content=?
        WHERE courseid = ?;";

            $updateCourseStmt = $connection->prepare($updateCourse);
            $updateCourseStmt->bind_param('ssissss', $courseid, $classname, $units, $term,$Book,$Web_Content ,$oldCourseId);
    }elseif(empty($Book) &&!empty($Course)){
        $updateCourse = "UPDATE courses 
        SET courseid = ?, classname = ?, units = ?, term = ?, Course=?, Web_Content=?
        WHERE courseid = ?;";

            $updateCourseStmt = $connection->prepare($updateCourse);
            $updateCourseStmt->bind_param('ssissss', $courseid, $classname, $units, $term,$Course,$Web_Content ,$oldCourseId);
    }else{
        $updateCourse = "UPDATE courses 
                    SET courseid = ?, classname = ?, units = ?, term = ?
                    WHERE courseid = ?;";

    $updateCourseStmt = $connection->prepare($updateCourse);
    $updateCourseStmt->bind_param('ssiss', $courseid, $classname, $units, $term, $oldCourseId);
    }

    if ($updateCourseStmt->execute() == TRUE) {
        // Delete all prereqs and coreqs so we can re-add them.
        // Or remove them if they were unselected.
        $sql = "DELETE FROM prereq
            WHERE courseid = '$oldCourseId'";
        $connection->query($sql);

        $sql = "DELETE FROM coreq
            WHERE courseid = '$oldCourseId'";
        $connection->query($sql);


        // Re-add all new prereqs and coreqs
        if (isset($prereqs) && !empty($prereqs)) {
            foreach ($prereqs as $prereq) {
                $sql = "INSERT INTO prereq (courseid, prereqid)
                        VALUES ('$courseid', '$prereq')";
                $connection->query($sql);
            }
        }
        if (isset($coreqs) && !empty($coreqs)) {
            foreach ($coreqs as $coreq) {
                $sql = "INSERT INTO coreq (courseid, coreqid)
                        VALUES ('$courseid', '$coreq')";
                $connection->query($sql);
            }
        } ?>
        <div class="container">
            <div class="row">
                <div class="col-md-4">
                </div>
                <div class="col-md-4 text-center">
                    <h2 class='success'>&#x2713; Course Updated Successfully!</h2>
                    <p>Click <a href='searchcourse.php'>here</a> to view all courses.</p>
                </div>
                <div class="col-md-4">
                </div>
            </div>  
        </div>
    <?php } else { ?>
        <div class="container">
            <div class="row">
                <div class="col-md-4">
                </div>
                <div class="col-md-4 text-center">
                    <h2 class='success'>&#x2717; Uh-oh! There was an error updating the class!</h2>
                    <p>Click <a href='javascript:history.back()'>here</a> to try again.</p>
                </div>
                <div class="col-md-4">
                </div>
            </div>  
        </div>
    <?php }


    $connection->close();
    ?>
    <!-- include footer -->
    <div class="row text-center extra-top">
        <?php include_once "footer.php" ?>
    </div>
</body>
</html>