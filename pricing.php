<?php
include 'front_header.php';
include 'db.php';

if (!isset($_GET['course_id']) || !is_numeric($_GET['course_id'])) {
    echo "<p style='color:red; text-align:center;'>Invalid course ID.</p>";
    include 'front_footer.php';
    exit;
}

$course_id = (int) $_GET['course_id'];

$stmt = $con->prepare("SELECT title, price, duration, image, description FROM courses WHERE id = ?");
$stmt->bind_param("i", $course_id);
$stmt->execute();
$result = $stmt->get_result();
$course = $result->fetch_assoc();

if (!$course) {
    echo "<p style='color:red; text-align:center;'>Course not found.</p>";
    include 'front_footer.php';
    exit;
}
?>

<style>
.pricing-section {
    padding: 40px 0;
    background: #f8f9fa;
}
.pricing-card {
    background: #fff;
    border-radius: 15px;
    box-shadow: 0 5px 15px rgba(0,0,0,0.1);
    overflow: hidden;
    max-width: 800px;
    margin: auto;
    transition: transform 0.3s;
}
.pricing-card:hover {
    transform: translateY(-5px);
}
.pricing-image img {
    width: 100%;
    height: auto;
    border-bottom: 4px solid #007bff;
}
.pricing-content {
    padding: 20px;
    text-align: center;
}
.pricing-content h2 {
    font-size: 28px;
    margin-bottom: 15px;
    color: #333;
}
.pricing-content p.description {
    color: #666;
    font-size: 15px;
    margin-bottom: 20px;
}
.price-tag {
    font-size: 30px;
    font-weight: bold;
    color: #007bff;
    margin: 20px 0;
}
.apply-btn {
    display: inline-block;
    padding: 12px 25px;
    background: #007bff;
    color: #fff;
    border-radius: 50px;
    text-decoration: none;
    transition: background 0.3s;
}
.apply-btn:hover {
    background: #0056b3;
}

/* Top alert styling */
.top-alert {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    z-index: 9999;
    border-radius: 0;
    display: none;
}
</style>

<!-- Bootstrap Icons -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

<!-- Top Alert -->
<div id="loginAlert" class="alert alert-warning text-center top-alert" role="alert">
    <i class="bi bi-exclamation-triangle-fill"></i>
    You must be logged in to apply. Redirecting to home...
</div>

<div class="pricing-section">
    <div class="pricing-card">
        <div class="pricing-image">
            <img src="admin/image/<?php echo htmlspecialchars($course['image']); ?>" 
                 alt="<?php echo htmlspecialchars($course['title']); ?>">
        </div>
        <div class="pricing-content">
            <h2><?php echo htmlspecialchars($course['title']); ?></h2>
            <p class="description"><?php echo nl2br(htmlspecialchars($course['description'])); ?></p>
            <p>Course Duration: <?php echo htmlspecialchars($course['duration']); ?> Weeks</p>
            <div class="price-tag">$<?php echo number_format($course['price'], 2); ?></div>

            <?php if (isset($_SESSION['user_id'])): ?>
                <a href="payment.php?course_id=<?php echo $course_id; ?>" class="apply-btn">Proceed to Apply</a>
            <?php else: ?>
                <button id="loginAlertBtn" class="apply-btn">Proceed to Apply</button>
            <?php endif; ?>
        </div>
    </div>
</div>

<script>
document.addEventListener("DOMContentLoaded", function() {
    const loginBtn = document.getElementById("loginAlertBtn");
    const alertBox = document.getElementById("loginAlert");

    if (loginBtn) {
        loginBtn.addEventListener("click", function() {
            // Show top alert
            alertBox.style.display = "block";

            // Redirect after 2.5 seconds
            setTimeout(function() {
                window.location.href = "index.php";
            }, 2500);
        });
    }
});
</script>

<?php include 'front_footer.php'; ?>
