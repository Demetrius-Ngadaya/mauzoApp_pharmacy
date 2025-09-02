<?php
include('dbcon.php');
$store_id = $_SESSION['store_id'];
// Check if the form is submitted
if (isset($_POST['go'])) {
    // Retrieve form data
    $expenditure_name = $_POST['expenditure_name'];
    $expenditure_amount = $_POST['expenditure_amount'];
    $expenditure_description = $_POST['expenditure_description'];
    $created_at = date('Y-m-d'); // Current date in YYYY-MM-DD format

    // Retrieve the current logged-in user from the session
    if (isset($_SESSION['user_session'])) {
        $created_by = $_SESSION['user_session']; // Assuming 'user_session' stores the username or user ID
    } else {
        die("Error: User not logged in."); // Handle the case where the user is not logged in
    }

    // Insert data into the database
    $query = "INSERT INTO expenditure (expenditure_name, expenditure_amount, expenditure_description, created_at, created_by, store_id) 
              VALUES ('$expenditure_name', '$expenditure_amount', '$expenditure_description', '$created_at', '$created_by' ,'$store_id')";

    if (mysqli_query($con, $query)) {
        echo "Expenditure added successfully!";
    } else {
        echo "Error: " . mysqli_error($con);
    }
}
?>

<!-- Modal HTML -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <div class="">
                    <strong>
                        <center>
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            &nbsp;&nbsp;Andika tumizi ulilofanya Dukani &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            &nbsp;&nbsp;&nbsp;
                        </center>
                    </strong>
                </div>
            </div>
            <div class="modal-body">
                <form method="post" enctype="multipart/form-data">
                    <hr>
                    <div class="control-group">
                        <label class="control-label" for="inputEmail">Jina la Tumizi:</label>
                        <input type="text" name="expenditure_name" placeholder="mfn: umeme" class="form-control" required>
                    </div>
                    <div class="control-group">
                        <label class="control-label" for="inputEmail">Kiasi cha pesa:</label>
                        <input type="number" name="expenditure_amount" placeholder="mfn: 5000" class="form-control" required>
                    </div>
                    <div class="control-group">
                        <label class="control-label" for="inputEmail">Maelezo kuhusu tumizi:</label>
                        <input type="text" name="expenditure_description" placeholder="mfn: malipo ya umeme" class="form-control" required>
                    </div>
                    <div class="modal-footer">
                        <button name="go" class="btn btn-primary">Hifadhi</button>
                        <button type="button" class="btn btn-default" data-dismiss="modal">Kata</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>