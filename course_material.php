<?php
include 'front_header.php';
include 'db.php';

// Validate course_id
if (!isset($_GET['course_id']) || !is_numeric($_GET['course_id'])) {
    echo "<p style='color:red; text-align:center;'>Invalid course ID.</p>";
    include 'front_footer.php';
    exit;
}

$course_id = (int) $_GET['course_id'];

// Fetch course details and material filename
$stmt = $con->prepare("SELECT title, description, material_url FROM courses WHERE id = ? LIMIT 1");
$stmt->bind_param("i", $course_id);
$stmt->execute();
$result = $stmt->get_result();
$course = $result->fetch_assoc();
$stmt->close();

if (!$course) {
    echo "<p style='color:red; text-align:center;'>Course not found.</p>";
    include 'front_footer.php';
    exit;
}

$filename = trim($course['material_url'] ?? '');

// Build a public URL to the file (or fall back to the streaming endpoint)
$pdfUrl = null;
if ($filename !== '') {
    // Candidate directories where the admin upload might have put the file.
    // Adjust / add directories to match how your admin file upload stores files.
    $candidates = [
        __DIR__ . '/admin/assets/materials/' . $filename,
        __DIR__ . '/admin/materials/' . $filename,
        __DIR__ . '/assets/materials/' . $filename,
        __DIR__ . '/materials/' . $filename,
        __DIR__ . '/../admin/assets/materials/' . $filename,
        __DIR__ . '/../admin/materials/' . $filename,
        $_SERVER['DOCUMENT_ROOT'] . '/admin/assets/materials/' . $filename,
        $_SERVER['DOCUMENT_ROOT'] . '/materials/' . $filename,
    ];

    foreach ($candidates as $candidatePath) {
        if (file_exists($candidatePath) && is_file($candidatePath) && is_readable($candidatePath)) {
            $realPath = realpath($candidatePath);
            $docRoot = realpath($_SERVER['DOCUMENT_ROOT']);

            if ($docRoot !== false && strpos($realPath, $docRoot) === 0) {
                // File is inside document root -> build a web-accessible URL
                $urlPath = '/' . ltrim(str_replace('\\', '/', substr($realPath, strlen($docRoot))), '/');
                // Ensure spaces and special chars are encoded
                $urlPath = implode('/', array_map('rawurlencode', explode('/', $urlPath)));
                $pdfUrl = $urlPath;
            } else {
                // File exists but outside document root -> stream it securely
                $pdfUrl = 'serve_material.php?course_id=' . $course_id;
            }
            break;
        }
    }
}
?>

<style>
/* (same styles you had — feel free to keep yours) */
.course-container { max-width: 900px; margin: 40px auto; padding: 25px; background: #fff; border-radius: 15px; box-shadow: 0 5px 15px rgba(0,0,0,0.1); }
.course-container h1 { font-size: 28px; color: #007bff; margin-bottom: 15px; }
.course-container p { font-size: 16px; color: #555; line-height: 1.6; }
.material-section { margin-top: 30px; }
.material-section h2 { font-size: 22px; color: #333; margin-bottom: 15px; }
.material-section iframe { width: 100%; height: 600px; border: none; border-radius: 10px; }
.back-btn { display: inline-block; margin-top: 20px; padding: 10px 20px; background: #007bff; color: #fff; border-radius: 50px; text-decoration: none; }
.back-btn:hover { background: #0056b3; }
</style>

<div class="course-container">
    <h1><?php echo htmlspecialchars($course['title']); ?></h1>
    <p><?php echo nl2br(htmlspecialchars($course['description'])); ?></p>

    <div class="material-section">
        <h2>Course Material</h2>

        <?php if ($pdfUrl): ?>
            <!-- Display PDF inside iframe -->
            <iframe src="<?php echo htmlspecialchars($pdfUrl); ?>"></iframe>

            <!-- optional download link -->
            <p style="margin-top:10px;">
                <a href="<?php echo htmlspecialchars($pdfUrl); ?>" target="_blank" class="back-btn">Open / Download Material</a>
            </p>
        <?php else: ?>
            <p style="color:red;">Course material is not yet available.</p>
        <?php endif; ?>
    </div>

    <a href="courses.php" class="back-btn">← Back to Courses</a>
</div>

<?php include 'front_footer.php'; ?>
