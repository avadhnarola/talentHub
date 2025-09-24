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

// Fetch course details
$stmt = $con->prepare("SELECT title, description FROM courses WHERE id = ? LIMIT 1");
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
?>

<!-- Font Awesome CDN -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">

<style>
    .course-container {
        max-width: 1100px;
        margin: 40px auto;
        padding: 25px;
        background: #fff;
        border-radius: 15px;
        box-shadow: 0 5px 20px rgba(0, 0, 0, 0.1);
    }

    .course-container h1 {
        font-size: 34px;
        color: #007bff;
        margin-bottom: 15px;
        text-align: center;
    }

    .course-container p {
        font-size: 17px;
        color: #555;
        line-height: 1.6;
        text-align: center;
    }

    /* Video Section */
    .video-section {
        margin-top: 40px;
    }

    .video-section h2 {
        text-align: center;
        margin-bottom: 35px;
        font-size: 26px;
        color: #333;
        font-weight: 600;
    }

    .video-block {
        display: flex;
        align-items: center;
        margin-bottom: 50px;
        gap: 20px;
        flex-wrap: wrap;
    }

    .video-block:nth-child(even) {
        flex-direction: row-reverse;
    }

    .video-block iframe {
        flex: 1 1 60%;
        min-width: 300px;
        height: 360px;
        border: none;
        border-radius: 15px;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.15);
        transition: transform 0.3s ease;
    }

    .video-block iframe:hover {
        transform: scale(1.02);
    }

    .video-info {
        flex: 1 1 35%;
        padding: 20px;
        text-align: left;
    }

    .video-info h3 {
        font-size: 22px;
        color: #222;
        margin-bottom: 12px;
    }

    .video-info p {
        font-size: 15px;
        color: #666;
        line-height: 1.6;
    }

    .video-icon {
        font-size: 45px;
        color: #007bff;
        margin-bottom: 15px;
    }

    .back-btn {
        display: inline-block;
        margin-top: 30px;
        padding: 12px 25px;
        background: #007bff;
        color: #fff;
        border-radius: 50px;
        text-decoration: none;
        font-size: 16px;
    }

    .back-btn:hover {
        background: #0056b3;
    }
</style>

<div class="course-container">
    <h1><?php echo htmlspecialchars($course['title']); ?></h1>
    <p><?php echo nl2br(htmlspecialchars($course['description'])); ?></p>

    <div class="video-section">
        <h2><i class="fas fa-chalkboard-teacher"></i> Course Learning Videos</h2>

        <!-- Video 1 -->
        <div class="video-block">
            <div class="video-info">
                <div class="video-icon"><i class="fas fa-play-circle"></i></div>
                <h3>Welcome & Introduction</h3>
                <p>Start your journey with an overview of the course. Understand learning goals and how each section
                    builds your knowledge.</p>
            </div>
            <iframe src="https://www.youtube.com/embed/tgbNymZ7vqY" allowfullscreen></iframe>
        </div>

        <!-- Video 2 -->
        <div class="video-block">
            <div class="video-info">
                <div class="video-icon"><i class="fas fa-graduation-cap"></i></div>
                <h3>Core Concepts Explained</h3>
                <p>Dive deep into the fundamentals with clear explanations and examples that help you master the subject
                    step by step.</p>
            </div>
            <iframe src="https://www.youtube.com/embed/kpUSX9fZf8g" allowfullscreen></iframe>
        </div>

        <!-- Video 3 -->
        <div class="video-block">
            <div class="video-info">
                <div class="video-icon"><i class="fas fa-lightbulb"></i></div>
                <h3>Advanced Applications</h3>
                <p>Apply your learning to real-world problems. This advanced module shows practical use-cases and expert
                    tips to excel.</p>
            </div>
            <iframe src="https://www.youtube.com/embed/aqz-KE-bpKQ" allowfullscreen></iframe>
        </div>

        <!-- Video 4 -->
        <div class="video-block">
            <div class="video-info">
                <div class="video-icon"><i class="fas fa-laptop-code"></i></div>
                <h3>Learn Coding Basics</h3>
                <p>An introduction to computer programming for beginners. Understand the logic and structure behind
                    coding.</p>
            </div>
            <iframe src="https://www.youtube.com/embed/rfscVS0vtbw" allowfullscreen></iframe>
        </div>

        <!-- Video 5 -->
        <div class="video-block">
            <div class="video-info">
                <div class="video-icon"><i class="fas fa-users"></i></div>
                <h3>Effective Communication Skills</h3>
                <p>Learn how to communicate better in personal and professional life to succeed in any career.</p>
            </div>
            <iframe src="https://www.youtube.com/embed/HAnw168huqA" allowfullscreen></iframe>
        </div>

        <!-- Video 6 -->
        <div class="video-block">
            <div class="video-info">
                <div class="video-icon"><i class="fas fa-brain"></i></div>
                <h3>Productivity & Learning Strategies</h3>
                <p>Boost your productivity and learning efficiency with scientifically proven techniques and habits.</p>
            </div>
            <iframe src="https://www.youtube.com/embed/lHfjvYzr-3g" allowfullscreen></iframe>
        </div>
    </div>

    <div style="text-align:center;">
        <a href="courses.php" class="back-btn"><i class="fas fa-arrow-left"></i> Back to Courses</a>
    </div>
</div>

<?php include 'front_footer.php'; ?>