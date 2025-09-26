<?php
ob_start();
include 'front_header.php';
include 'db.php';

// =============================
// Force login before payment
// =============================
if (!isset($_SESSION['user_id'])) {
    $_SESSION['error'] = "Please login before making a payment.";
    header("Location: index.php");
    exit;
}
$user_id = $_SESSION['user_id'];

// =============================
// Validate course_id
// =============================
if (!isset($_GET['course_id']) || !is_numeric($_GET['course_id'])) {
    echo "<p style='color:red; text-align:center;'>Invalid course ID.</p>";
    include 'front_footer.php';
    exit;
}
$course_id = (int) $_GET['course_id'];

// =============================
// Fetch course details
// =============================
$courseQuery = mysqli_query($con, "SELECT title, price FROM courses WHERE id = $course_id LIMIT 1");
$course = mysqli_fetch_assoc($courseQuery);

if (!$course) {
    echo "<p style='color:red; text-align:center;'>Course not found.</p>";
    include 'front_footer.php';
    exit;
}

// Prices
$usdPrice = number_format($course['price'], 2, '.', '');
$conversionRate = 83; // Example conversion rate
$inrPrice = number_format($usdPrice * $conversionRate, 2, '.', '');

$courseTitle = urlencode($course['title']);
$upiID = "8140047020@upi"; // Your UPI ID

// =============================
// Handle payment form submission
// =============================
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['pay_now'])) {
    $method = $_POST['method']; // 'upi' or 'card'
    $amount = $inrPrice;

    // ✅ First check if user already booked this course
    $check = mysqli_query($con, "SELECT id FROM coursebookings WHERE user_id = $user_id AND course_id = $course_id LIMIT 1");

    if (mysqli_num_rows($check) > 0) {
        // User already booked → Show alert & redirect
        echo "
        <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                Swal.fire({
                    icon: 'warning',
                    title: 'Already Enrolled!',
                    text: 'You have already booked this course.',
                    confirmButtonText: 'Go to Home'
                }).then(() => {
                    window.location.href = 'index.php';
                });
            });
        </script>
        ";
    } else {
        // ✅ Generate unique transaction id
        $transaction_id = 'TXN' . strtoupper(uniqid());
        $status = 'success';

        $insert = mysqli_query($con, "INSERT INTO coursebookings 
            (course_id, user_id, method, amount, status, transaction_id) 
            VALUES ('$course_id', '$user_id', '$method', '$amount', '$status', '$transaction_id')");

        if ($insert) {
            $payment_id = mysqli_insert_id($con);
            echo "
            <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    Swal.fire({
                        icon: 'success',
                        title: 'Course Booking Successful!',
                        html: '<b>Transaction ID:</b> $transaction_id',
                        confirmButtonText: 'Go to Course'
                    }).then(() => {
                        window.location.href = 'course_material.php?course_id=$course_id&payment_id=$payment_id';
                    });
                });
            </script>
            ";
        } else {
            echo "<p style='color:red; text-align:center;'>Payment record could not be saved.</p>";
        }
    }
}
?>

<style>
    .payment-section {
        padding: 40px 0;
        background: #f8f9fa;
        text-align: center;
    }

    .payment-card {
        background: #fff;
        padding: 25px;
        border-radius: 15px;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        max-width: 600px;
        margin: auto;
    }

    .payment-card h2 {
        margin-bottom: 20px;
    }

    .payment-options {
        display: flex;
        justify-content: center;
        gap: 20px;
        flex-wrap: wrap;
    }

    .payment-option {
        background: #f1f1f1;
        border-radius: 10px;
        padding: 15px;
        width: 100px;
        cursor: pointer;
        transition: transform 0.3s, background 0.3s;
        margin-top: 20px;
    }

    .payment-option:hover {
        transform: scale(1.05);
    }

    .payment-option.active {
        background: #d0e6ff;
    }

    .payment-option img {
        height: 40px;
    }

    .hidden {
        display: none;
    }

    .qr-section img {
        width: 200px;
        margin-top: 20px;
    }

    .card-form {
        margin-top: 20px;
        text-align: left;
    }

    .card-form input {
        width: 100%;
        padding: 10px;
        margin-bottom: 12px;
        border: 1px solid #ccc;
        border-radius: 5px;
    }

    .pay-btn {
        margin-top: 20px;
        padding: 12px 25px;
        background: #007bff;
        color: #fff;
        border-radius: 50px;
        text-decoration: none;
        display: inline-block;
        border: none;
        cursor: pointer;
    }

    .pay-btn:hover {
        background: #0056b3;
    }
</style>

<div class="payment-section">
    <div class="payment-card">
        <h2>Pay for: <?php echo htmlspecialchars($course['title']); ?></h2>
        <p>
            <strong>Amount:</strong>
            $<?php echo $usdPrice; ?> OR ₹<?php echo $inrPrice; ?>
        </p>
        <h3>Select Payment Method</h3>

        <div class="payment-options">
            <div class="payment-option" data-method="upi" data-app="Google Pay">
                <img src="admin/image/g-pay.png" alt="Google Pay">
            </div>
            <div class="payment-option" data-method="upi" data-app="PhonePe">
                <img src="admin/image/phone-pe.png" alt="PhonePe">
            </div>
            <div class="payment-option" data-method="upi" data-app="BHIM">
                <img src="admin/image/bhim.png" alt="BHIM UPI">
            </div>
            <div class="payment-option" data-method="card">
                <img src="admin/image/credit-card.png" alt="Credit Card">
            </div>
        </div>

        <!-- QR Payment -->
        <form method="POST" id="upi-form" class="hidden">
            <input type="hidden" name="method" value="upi">
            <p>Scan the QR code to complete the payment</p>
            <img id="qr-image" src="" alt="QR Code">
            <br>
            <input type="submit" name="pay_now" class="pay-btn" value="I Have Paid">
        </form>

        <!-- Card Payment -->
        <form method="POST" id="card-form" class="card-form hidden">
            <label>Cardholder Name</label>
            <input type="text" name="card_name" placeholder="John Doe" required>
            <label>Card Number</label>
            <input type="text" name="card_number" placeholder="1234 5678 9012 3456" required>
            <label>Expiry Date</label>
            <input type="text" name="expiry" placeholder="MM/YY" required>
            <label>CVV</label>
            <input type="password" name="cvv" placeholder="123" required>
            <input type="hidden" name="method" value="card">
            <button type="submit" name="pay_now" class="pay-btn">Pay Now</button>
        </form>
    </div>
</div>

<script>
    const coursePrice = "<?php echo $inrPrice; ?>";
    const courseTitle = "<?php echo $courseTitle; ?>";
    const upiID = "<?php echo $upiID; ?>";

    document.querySelectorAll('.payment-option').forEach(option => {
        option.addEventListener('click', () => {
            document.querySelectorAll('.payment-option').forEach(opt => opt.classList.remove('active'));
            option.classList.add('active');

            const method = option.dataset.method;
            const qrForm = document.getElementById('upi-form');
            const qrImage = document.getElementById('qr-image');
            const cardForm = document.getElementById('card-form');

            qrForm.classList.add('hidden');
            cardForm.classList.add('hidden');

            if (method === 'upi') {
                let upiLink = `upi://pay?pa=${encodeURIComponent(upiID)}&pn=Your%20Institute&am=${coursePrice}&cu=INR&tn=${courseTitle}`;
                let qrUrl = `https://api.qrserver.com/v1/create-qr-code/?size=300x300&data=${encodeURIComponent(upiLink)}`;
                qrImage.src = qrUrl;
                qrForm.classList.remove('hidden');
            } else if (method === 'card') {
                cardForm.classList.remove('hidden');
            }
        });
    });
</script>

<?php include 'front_footer.php'; ?>