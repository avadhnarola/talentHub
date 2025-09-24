<?php
include 'header.php';
include '../db.php';

if (!$_SESSION['admin_id']) {
    header("Location: ./index.php");
    exit();
}

// Fetch courses from course table
$courses_query = mysqli_query($con, "SELECT id, title FROM courses ORDER BY title ASC");

// Handle form submission
if (isset($_POST['submit'])) {
    $course_id = $_POST['course_id'];

    // Check if at least one material set exists
    if (isset($_POST['material_url']) && is_array($_POST['material_url'])) {
        $urls = $_POST['material_url'];
        $titles = $_POST['material_title'];
        $descriptions = $_POST['material_description'];

        // Convert arrays to JSON for single-row storage
        $urls_json = json_encode($urls, JSON_UNESCAPED_UNICODE);
        $titles_json = json_encode($titles, JSON_UNESCAPED_UNICODE);
        $descs_json = json_encode($descriptions, JSON_UNESCAPED_UNICODE);

        // Insert single row into course_materials
        $stmt = $con->prepare("INSERT INTO course_materials (course_id, material_url, title, description) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("isss", $course_id, $urls_json, $titles_json, $descs_json);
        $stmt->execute();
        $stmt->close();

        echo "<script>alert('Materials added successfully!'); window.location='./viewMaterials.php';</script>";
        exit();
    } else {
        echo "<script>alert('Please add at least one material.');</script>";
    }
}
?>

<div class="content-wrapper">
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="fw-bold py-3 mb-4">
            <span class="text-muted fw-light">Materials /</span> Add Materials
        </h4>

        <div class="row">
            <div class="col-xxl">
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="mb-0">Add Materials</h5>
                    </div>
                    <div class="card-body">
                        <form method="POST">
                            <!-- Course Dropdown -->
                            <div class="row mb-3">
                                <label class="col-sm-2 col-form-label" for="course-select">Select Course</label>
                                <div class="col-sm-10">
                                    <select class="form-control" id="course-select" name="course_id" required>
                                        <option value="">-- Select Course --</option>
                                        <?php
                                        while ($course = mysqli_fetch_assoc($courses_query)) {
                                            echo "<option value='" . $course['id'] . "'>" . htmlspecialchars($course['title']) . "</option>";
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>

                            <!-- Dropdown to select number of materials -->
                            <div class="row mb-3">
                                <label class="col-sm-2 col-form-label" for="materials-count">Number of Materials</label>
                                <div class="col-sm-10">
                                    <select class="form-control" id="materials-count">
                                        <option value="">-- Select Number --</option>
                                        <option value="1">1</option>
                                        <option value="2">2</option>
                                        <option value="3">3</option>
                                        <option value="4">4</option>
                                        <option value="5">5</option>
                                    </select>
                                </div>
                            </div>

                            <!-- Container for dynamic material inputs -->
                            <div id="materials-container"></div>

                            <!-- Submit Button -->
                            <div class="row justify-content-end mt-3">
                                <div class="col-sm-10">
                                    <input type="submit" class="btn btn-primary" name="submit" value="Add Material" />
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.getElementById('materials-count').addEventListener('change', function () {
            const container = document.getElementById('materials-container');
            container.innerHTML = ''; // Clear previous inputs

            const count = parseInt(this.value);
            if (isNaN(count) || count <= 0) return;

            for (let i = 1; i <= count; i++) {
                const html = `
            <div class="row mb-3">
                <label class="col-sm-2 col-form-label">Material ${i} URL</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" name="material_url[]" placeholder="Enter material URL" required>
                </div>
            </div>
            <div class="row mb-3">
                <label class="col-sm-2 col-form-label">Material ${i} Title</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" name="material_title[]" placeholder="Enter material title" required>
                </div>
            </div>
            <div class="row mb-3">
                <label class="col-sm-2 col-form-label">Material ${i} Description</label>
                <div class="col-sm-10">
                    <textarea class="form-control" name="material_description[]" placeholder="Enter material description" required></textarea>
                </div>
            </div>
            <hr>
        `;
                container.insertAdjacentHTML('beforeend', html);
            }
        });
    </script>

    <?php include 'footer.php'; ?>