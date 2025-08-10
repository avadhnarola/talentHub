<?php
include 'header.php';
include '../db.php';

if (!$_SESSION['admin_id']) {
  header("Location: ./index.php");
  exit();
}

$course_id = null;
$u_data = [];

if (isset($_GET['u_id'])) {
  $course_id = $_GET['u_id'];
  $result = mysqli_query($con, "SELECT * FROM courses WHERE id=$course_id");
  $u_data = mysqli_fetch_assoc($result);
}

if (isset($_POST['submit'])) {
  $category = $_POST['category'];
  $title = $_POST['title'];
  $description = $_POST['description'];
  $duration = $_POST['duration']; // weeks
  $price = $_POST['price'];
  $start_date = $_POST['start_date'];

  // Calculate end date from start date + duration
  $end_date = date('Y-m-d', strtotime($start_date . " +$duration weeks"));

  // Handle image upload
  $img = $_FILES['image']['name'];
  if (!empty($img)) {
    move_uploaded_file($_FILES['image']['tmp_name'], "image/$img");
  } else {
    $img = $u_data['image'] ?? ''; // keep old image if editing
  }

  if ($course_id) {
    mysqli_query($con, "UPDATE courses 
      SET category='$category', title='$title', description='$description', image='$img',
          duration='$duration', price='$price', start_date='$start_date', end_date='$end_date'
      WHERE id=$course_id");
    header("Location: ./viewCourses.php");
  } else {
    mysqli_query($con, "INSERT INTO courses 
      (category, title, description, image, duration, price, start_date, end_date) 
      VALUES ('$category', '$title', '$description', '$img', '$duration', '$price', '$start_date', '$end_date')");
    header("Location: ./viewCourses.php");
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
      <div class="col-xxl">
        <div class="card mb-4">
          <div class="card-header d-flex align-items-center justify-content-between">
            <h5 class="mb-0"><?php echo $course_id ? 'Edit Course' : 'Add Course'; ?></h5>
          </div>
          <div class="card-body">
            <form method="POST" enctype="multipart/form-data">

              <!-- Title -->
              <div class="row mb-3">
                <label class="col-sm-2 col-form-label">Title</label>
                <div class="col-sm-10">
                  <input type="text" class="form-control" name="title"
                    value="<?php echo htmlspecialchars($u_data['title'] ?? ''); ?>" required />
                </div>
              </div>

              <!-- Description -->
              <div class="row mb-3">
                <label class="col-sm-2 col-form-label">Description</label>
                <div class="col-sm-10">
                  <textarea class="form-control" name="description"
                    required><?php echo htmlspecialchars($u_data['description'] ?? ''); ?></textarea>
                </div>
              </div>

              <!-- Category -->
              <div class="row mb-3">
                <label class="col-sm-2 col-form-label">Category</label>
                <div class="col-sm-10">
                  <select name="category" class="form-control" required>
                    <option value="Architecture" <?php if (($u_data['category'] ?? '') == 'Architecture')
                      echo 'selected'; ?>>Architecture</option>
                    <option value="Medical" <?php if (($u_data['category'] ?? '') == 'Medical')
                      echo 'selected'; ?>>
                      Medical</option>
                    <option value="Science" <?php if (($u_data['category'] ?? '') == 'Science')
                      echo 'selected'; ?>>
                      Science</option>
                    <option value="Technology" <?php if (($u_data['category'] ?? '') == 'Technology')
                      echo 'selected'; ?>>
                      Technology</option>
                  </select>
                </div>
              </div>

              <!-- Duration -->
              <div class="row mb-3">
                <label class="col-sm-2 col-form-label">Duration (Weeks)</label>
                <div class="col-sm-10">
                  <input type="number" min="1" class="form-control" id="duration" name="duration"
                    value="<?php echo htmlspecialchars($u_data['duration'] ?? ''); ?>" required />
                </div>
              </div>

              <!-- Price -->
              <div class="row mb-3">
                <label class="col-sm-2 col-form-label">Price ($)</label>
                <div class="col-sm-10">
                  <input type="number" class="form-control" name="price" step="0.01"
                    value="<?php echo htmlspecialchars($u_data['price'] ?? ''); ?>" required />
                </div>
              </div>

              <!-- Start Date -->
              <div class="row mb-3">
                <label class="col-sm-2 col-form-label">Start Date</label>
                <div class="col-sm-10">
                  <input type="date" class="form-control" id="start_date" name="start_date"
                    value="<?php echo htmlspecialchars($u_data['start_date'] ?? ''); ?>" required />
                </div>
              </div>

              <!-- End Date (Auto) -->
              <div class="row mb-3">
                <label class="col-sm-2 col-form-label">End Date</label>
                <div class="col-sm-10">
                  <input type="date" class="form-control" id="end_date" name="end_date"
                    value="<?php echo htmlspecialchars($u_data['end_date'] ?? ''); ?>" readonly />
                </div>
              </div>

              <!-- Image -->
              <div class="row mb-3">
                <label class="col-sm-2 col-form-label">Course Image</label>
                <div class="col-sm-10">
                  <input type="file" class="form-control" name="image" <?php echo $course_id ? '' : 'required'; ?>>
                  <?php if (!empty($u_data['image'])): ?>
                    <small>Current Image: <img src="image/<?php echo $u_data['image']; ?>" height="50"></small>
                  <?php endif; ?>
                </div>
              </div>

              <!-- Submit -->
              <div class="row justify-content-end">
                <div class="col-sm-10">
                  <input type="submit" class="btn btn-primary" name="submit"
                    value="<?php echo $course_id ? 'Update Course' : 'Add Course'; ?>" />
                </div>
              </div>

            </form>
          </div>
        </div>
      </div>
    </div>
  </div>

  <?php include 'footer.php'; ?>

  <script>
    // Auto-calculate end date in browser
    document.getElementById('start_date').addEventListener('change', updateEndDate);
    document.getElementById('duration').addEventListener('input', updateEndDate);

    function updateEndDate() {
      let startDate = document.getElementById('start_date').value;
      let weeks = parseInt(document.getElementById('duration').value);
      if (startDate && weeks > 0) {
        let start = new Date(startDate);
        start.setDate(start.getDate() + (weeks * 7));
        document.getElementById('end_date').value = start.toISOString().split('T')[0];
      }
    }
  </script>