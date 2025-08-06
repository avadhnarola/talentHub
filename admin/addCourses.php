<?php
include 'header.php';
include '../db.php';

if (!$_SESSION['admin_id']) {
  header("Location: ./index.php");
  exit();
}

if (isset($_GET['u_id'])) {
  $course_id = $_GET['u_id'];
  $u_data = mysqli_query($con, "select * from courses where id=$course_id");
  $u_data = mysqli_fetch_assoc($u_data);

}

if (isset($_POST['submit'])) {
  $category = $_POST['category'];
  $title = $_POST['title'];
  $description = $_POST['description'];
  $img = $_FILES['image']['name'];
  move_uploaded_file($_FILES['image']['tmp_name'], "image/$img");
  if ($course_id) {
    mysqli_query($con, "UPDATE courses SET category='$category', title='$title', description='$description', image='$img' WHERE id=$course_id");
    header("Location: ./viewCourses.php");
  } else {

    mysqli_query($con, "INSERT INTO courses (category, title, description, image) VALUES ('$category', '$title', '$description', '$img')");
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
      <!-- Basic Layout -->
      <div class="col-xxl">
        <div class="card mb-4">
          <div class="card-header d-flex align-items-center justify-content-between">
            <h5 class="mb-0">Add Courses</h5>
          </div>
          <div class="card-body">
            <form method="POST" enctype="multipart/form-data">
              <!-- Category Dropdown -->

              <!-- Title Input -->
              <div class="row mb-3">
                <label class="col-sm-2 col-form-label" for="basic-default-company">Title</label>
                <div class="col-sm-10">
                  <input type="text" class="form-control" id="basic-default-company" placeholder="ACME Inc."
                    name="title" value="<?php echo @$u_data['title']; ?>" required />
                </div>
              </div>

              <!-- Description Textarea -->
              <div class="row mb-3">
                <label class="col-sm-2 col-form-label" for="basic-default-message">Description</label>
                <div class="col-sm-10">
                  <textarea id="basic-default-message" class="form-control" placeholder="Enter description ..." required name="description"><?php echo @$u_data['description']; ?></textarea>

                </div>
              </div>
              <div class="row mb-3">
                <label class="col-sm-2 col-form-label" for="category">Category</label>
                <div class="col-sm-10">
                  <select id="category" name="category" class="form-control" required>
                    <option value="Architecture" <?php if (@$u_data['category'] == 'Architecture')
                      echo 'selected'; ?>>
                      Architecture</option>
                    <option value="Medical" <?php if (@$u_data['category'] == 'Medical')
                      echo 'selected'; ?>>Medical
                    </option>
                    <option value="Science" <?php if (@$u_data['category'] == 'Science')
                      echo 'selected'; ?>>Science
                    </option>
                    <option value="Technology" <?php if (@$u_data['category'] == 'Technology')
                      echo 'selected'; ?>>
                      Technology</option>
                  </select>

                </div>
              </div>

              <!-- Course Image Upload -->
              <div class="row mb-3">
                <label class="col-sm-2 col-form-label" for="course-image">Course Image</label>
                <div class="col-sm-10">
                  <input type="file" class="form-control" id="course-image" name="image" required>
                </div>
              </div>

              <!-- Submit Button -->
              <div class="row justify-content-end">
                <div class="col-sm-10">
                  <input type="submit" class="btn btn-primary" name="submit" value="Add Course" />
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>

  <?php include 'footer.php'; ?>