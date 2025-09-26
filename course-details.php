<?php
include 'front_header.php';
include 'db.php'; // Database connection

// =============================
// Validate course_id
// =============================
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    echo "<p style='color:red; text-align:center;'>Invalid course ID.</p>";
    include 'front_footer.php';
    exit;
}

$course_id = (int) $_GET['id'];

// =============================
// Fetch course (simple query)
// =============================
$result = mysqli_query($con, "SELECT * FROM courses WHERE id = $course_id LIMIT 1");
$course = mysqli_fetch_assoc($result);

if (!$course) {
    echo "<p style='color:red; text-align:center;'>Course not found.</p>";
    include 'front_footer.php';
    exit;
}
?>

<!-- Page Title -->
<div class="bradcam_area breadcam_bg">
    <div class="container">
        <div class="row">
            <div class="col-xl-12">
                <div class="bradcam_text">
                    <h3><?php echo htmlspecialchars($course['title']); ?></h3>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Course Details Section -->
<div class="course_details_area section__padding">
    <div class="container">
        <div class="row">
            <!-- Course Image -->
            <div class="col-lg-8">
                <div class="course_details_left">
                    <div class="course_thumb">
                        <img class="img-fluid" src="admin/image/<?php echo htmlspecialchars($course['image']); ?>" alt="<?php echo htmlspecialchars($course['title']); ?>">
                    </div>
                    <div class="course_content mt-3">
                        <h3>About this course</h3>
                        <p><?php echo nl2br(htmlspecialchars($course['description'])); ?></p>
                        
                        <h4>Course Duration:</h4>
                        <p><?php echo htmlspecialchars($course['duration']); ?> Weeks</p>
                        
                        <h4>Price:</h4>
                        <p>$<?php echo number_format($course['price'], 2); ?></p>
                    </div>
                </div>
            </div>

            <!-- Sidebar -->
            <div class="col-lg-4">
                <div class="course_sidebar">
                    <div class="apply_btn mb-3">
                        <a href="pricing.php?course_id=<?php echo $course['id']; ?>" class="boxed-btn3 w-100">Apply Now</a>
                    </div>
                    <div class="course_info">
                        <h4>Course Info</h4>
                        <ul>
                            <li><strong>Category:</strong> <?php echo htmlspecialchars($course['category']); ?></li>
                            <li><strong>Start Date:</strong> <?php echo htmlspecialchars($course['start_date']); ?></li>
                            <li><strong>End Date:</strong> <?php echo htmlspecialchars($course['end_date']); ?></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include 'front_footer.php'; ?>
