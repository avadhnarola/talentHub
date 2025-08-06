<?php
include 'header.php';
include '../db.php';

if (!$_SESSION['admin_id']) {
    header("Location: ./index.php");
    exit();
}

if (isset($_GET['u_id'])) {
    $event_id = $_GET['u_id'];
    $u_data = mysqli_query($con, "select * from events where id=$event_id");
    $u_data = mysqli_fetch_assoc($u_data);

}

if (isset($_POST['submit'])) {
    $time = $_POST['time'];
    $date = $_POST['date'];
    $title = $_POST['title'];
    $location = $_POST['location'];

    if ($event_id) {
        mysqli_query($con, "UPDATE events SET title='$title', time='$time', location='$location', date='$date' WHERE id=$event_id");
        header("Location: ./viewEvents.php");
    } else {

        mysqli_query($con, "INSERT INTO Events (title,time,location, date) VALUES ('$title', '$time', '$location','$date')");
        header("Location: ./viewEvents.php");
        echo "<script>alert('Course added successfully!');</script>";
        exit();
    }
}




?>

<div class="content-wrapper">
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="fw-bold py-3 mb-4">
            <span class="text-muted fw-light">Course /</span> Add Course
        </h4>

        <div class="row">
            <!-- Basic Layout -->
            <div class="col-xxl">
                <div class="card mb-4">
                    <div class="card-header d-flex align-items-center justify-content-between">
                        <h5 class="mb-0">Add Events</h5>
                    </div>
                    <div class="card-body">
                        <form method="POST" enctype="multipart/form-data">
                            <!-- Category Dropdown -->

                            <!-- Title Input -->
                            <div class="row mb-3">
                                <label class="col-sm-2 col-form-label" for="basic-default-company">Title</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="basic-default-company"
                                        placeholder="Enter Event Title..." name="title" value="<?php echo @$u_data['title']; ?>"
                                        required />
                                </div>
                            </div>

                            <!-- Description Textarea -->
                            <div class="row mb-3">
                                <label class="col-sm-2 col-form-label" for="basic-default-message">Time</label>
                                <div class="col-sm-10">
                                    <input type="time" class="form-control" id="basic-default-time"
                                        placeholder="Enter time" name="time" value="<?php echo @$u_data['time']; ?>"
                                        required />
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label class="col-sm-2 col-form-label" for="Location">Location</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="basic-default-company"
                                        placeholder="Enter Location..." name="location"
                                        value="<?php echo @$u_data['location']; ?>" required />
                                </div>
                            </div>

                            <!-- Course Image Upload -->
                            <div class="row mb-3">
                                <label class="col-sm-2 col-form-label" for="date">Date</label>
                                <div class="col-sm-10">
                                    <input type="date" class="form-control" id="date" placeholder="Enter date"
                                        name="date" value="<?php echo @$u_data['date']; ?>" required />
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label class="col-sm-2 col-form-label" for="basic-default-message">Description</label>
                                <div class="col-sm-10">
                                <textarea id="basic-default-message" class="form-control" placeholder="Enter description ..." required name="description"><?php echo @$u_data['description']; ?></textarea>

                                </div>
                            </div>        
                    
                            
                            <div class="row mb-3">
                                <label class="col-sm-2 col-form-label" for="Event-image">Event Image</label>
                                <div class="col-sm-10">
                                    <input type="file" class="form-control" id="Event-image" name="image" required>
                                </div>
                            </div>     
                            <!-- Submit Button -->
                            <div class="row justify-content-end">
                                <div class="col-sm-10">
                                    <input type="submit" class="btn btn-primary" name="submit" value="Add Event" />
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php include 'footer.php'; ?>