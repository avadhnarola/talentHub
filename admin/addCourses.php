<?php

include 'header.php';
include '../db.php';

if (!isset($_SESSION['admin_id'])) {
    header("Location: ./index.php");
    exit();
}

$course_id = null;
$u_data = [];

// Fetch existing course data if editing
if (isset($_GET['u_id'])) {
    $course_id = (int) $_GET['u_id'];
    $result = mysqli_query($con, "SELECT * FROM courses WHERE id=$course_id");
    $u_data = mysqli_fetch_assoc($result);
}

// Handle form submission
if (isset($_POST['submit'])) {
    $category = mysqli_real_escape_string($con, $_POST['category']);
    $title = mysqli_real_escape_string($con, $_POST['title']);
    $description = mysqli_real_escape_string($con, $_POST['description']);
    $duration = (int) $_POST['duration'];
    $price = (float) $_POST['price'];
    $start_date = $_POST['start_date'];

    // Calculate end date based on duration
    $end_date = date('Y-m-d', strtotime($start_date . " +$duration weeks"));

    // Handle PDF upload for course material
    $material_url = $u_data['material_url'] ?? '';
    if (isset($_FILES['material_url']) && $_FILES['material_url']['error'] == 0) {
        $allowedExt = ['pdf'];
        $fileExt = strtolower(pathinfo($_FILES['material_url']['name'], PATHINFO_EXTENSION));

        if (in_array($fileExt, $allowedExt)) {
            $materialName = time() . "_" . basename($_FILES['material_url']['name']);
            $materialPath = "materials/" . $materialName;

            if (!is_dir("materials")) {
                mkdir("materials", 0777, true);
            }
            move_uploaded_file($_FILES['material_url']['tmp_name'], $materialPath);
            $material_url = $materialName;
        } else {
            echo "<script>alert('Only PDF files are allowed for course material!');</script>";
        }
    }

    // Handle image upload
    $img = $u_data['image'] ?? '';
    if (isset($_FILES['image']) && $_FILES['image']['error'] === 0) {
        $imgName = time() . "_" . basename($_FILES['image']['name']);
        $imgPath = "image/" . $imgName;

        if (!is_dir("image")) {
            mkdir("image", 0777, true);
        }

        move_uploaded_file($_FILES['image']['tmp_name'], $imgPath);
        $img = $imgName;
    }

    if ($course_id) {
        // Update existing course
        $query = "UPDATE courses SET 
            category='$category', 
            title='$title', 
            description='$description', 
            image='$img', 
            duration='$duration', 
            price='$price', 
            material_url='$material_url',
            start_date='$start_date', 
            end_date='$end_date'
            WHERE id=$course_id";
        mysqli_query($con, $query);
        $_SESSION['success_msg'] = "Course updated successfully!";
        header("Location: viewCourses.php");
        exit();
    } else {
        // Insert new course
        $query = "INSERT INTO courses 
            (category, title, description, image, duration, price, material_url, start_date, end_date)
            VALUES 
            ('$category', '$title', '$description', '$img', '$duration', '$price', '$material_url', '$start_date', '$end_date')";
        mysqli_query($con, $query);
        $_SESSION['success_msg'] = "New course added successfully!";
        header("Location: addCourse.php");
        exit();
    }
}
?>

<div class="content-wrapper">
    <div class="container-xxl flex-grow-1 container-p-y">



        <h4 class="fw-bold py-3 mb-4">
            <span class="text-muted fw-light">Course /</span> <?php echo $course_id ? "Edit Course" : "Add Course"; ?>
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
                                    <textarea class="form-control" name="description" required><?php echo htmlspecialchars($u_data['description'] ?? ''); ?></textarea>
                                </div>
                            </div>

                            <!-- Category -->
                            <div class="row mb-3">
                                <label class="col-sm-2 col-form-label">Category</label>
                                <div class="col-sm-10">
                                    <select name="category" class="form-control" required>
                                        <option value="Architecture" <?php if (($u_data['category'] ?? '') == 'Architecture') echo 'selected'; ?>>Architecture</option>
                                        <option value="Medical" <?php if (($u_data['category'] ?? '') == 'Medical') echo 'selected'; ?>>Medical</option>
                                        <option value="Science" <?php if (($u_data['category'] ?? '') == 'Science') echo 'selected'; ?>>Science</option>
                                        <option value="Technology" <?php if (($u_data['category'] ?? '') == 'Technology') echo 'selected'; ?>>Technology</option>
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

                            <!-- Material PDF -->
                            <div class="row mb-3">
                                <label class="col-sm-2 col-form-label">Course Material (PDF)</label>
                                <div class="col-sm-10">
                                    <input type="file" class="form-control" name="material_url" accept="application/pdf" <?php echo $course_id ? '' : 'required'; ?>>
                                    <?php if (!empty($u_data['material_url'])): ?>
                                        <small>Current Material: 
                                            <a href="materials/<?php echo $u_data['material_url']; ?>" target="_blank">View PDF</a>
                                        </small>
                                    <?php endif; ?>
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
                                    <input type="file" class="form-control" name="image" accept="image/*" <?php echo $course_id ? '' : 'required'; ?>>
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
</div>

<?php include 'footer.php'; ?>

<script>
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
