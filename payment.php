<?php
include 'front_header.php';
include 'db.php';

if (!isset($_GET['course_id']) || !is_numeric($_GET['course_id'])) {
    echo "<p style='color:red; text-align:center;'>Invalid course ID.</p>";
    include 'front_footer.php';
    exit;
}

$course_id = (int) $_GET['course_id'];

$stmt = $con->prepare("SELECT title, price FROM courses WHERE id = ?");
$stmt->bind_param("i", $course_id);
$stmt->execute();
$result = $stmt->get_result();
$course = $result->fetch_assoc();

if (!$course) {
    echo "<p style='color:red; text-align:center;'>Course not found.</p>";
    include 'front_footer.php';
    exit;
}

$usdPrice = number_format($course['price'], 2, '.', ''); // Price in USD
$conversionRate = 83; // 1 USD = ₹83 (you can update this rate)
$inrPrice = number_format($usdPrice * $conversionRate, 2, '.', ''); // Converted INR value

$courseTitle = urlencode($course['title']);
$upiID = "9601833510@upi"; // Your UPI ID
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
            $<?php echo $usdPrice; ?> 
            OR ₹<?php echo $inrPrice; ?>
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

        <!-- QR Scanner Section -->
        <div id="qr-section" class="qr-section hidden">
            <p>Scan the QR code to complete the payment</p>
            <img id="qr-image" src="" alt="QR Code">
            <br>
            <a href="course_material.php?course_id=<?php echo $course_id; ?>" class="pay-btn">I Have Paid</a>
        </div>

        <!-- Debit Card Form -->
        <div id="card-form" class="card-form hidden">
            <label>Cardholder Name</label>
            <input type="text" placeholder="John Doe">
            <label>Card Number</label>
            <input type="text" placeholder="1234 5678 9012 3456">
            <label>Expiry Date</label>
            <input type="text" placeholder="MM/YY">
            <label>CVV</label>
            <input type="password" placeholder="123">
            <a href="Admissions.php?course_id=<?php echo $course_id; ?>" class="pay-btn">Pay Now</a>
        </div>
    </div>
</div>

<script>
    const coursePrice = "<?php echo $inrPrice; ?>"; // INR value for payment
    const courseTitle = "<?php echo $courseTitle; ?>";
    const upiID = "<?php echo $upiID; ?>";

    document.querySelectorAll('.payment-option').forEach(option => {
        option.addEventListener('click', () => {
            document.querySelectorAll('.payment-option').forEach(opt => opt.classList.remove('active'));
            option.classList.add('active');

            const method = option.dataset.method;
            const qrSection = document.getElementById('qr-section');
            const qrImage = document.getElementById('qr-image');
            const cardForm = document.getElementById('card-form');

            qrSection.classList.add('hidden');
            cardForm.classList.add('hidden');

            if (method === 'upi') {
                let upiLink = `upi://pay?pa=${encodeURIComponent(upiID)}&pn=Your%20Institute&am=${coursePrice}&cu=INR&tn=${courseTitle}`;
                let qrUrl = `https://api.qrserver.com/v1/create-qr-code/?size=300x300&data=${encodeURIComponent(upiLink)}`;
                qrImage.src = qrUrl;
                qrSection.classList.remove('hidden');
            } else if (method === 'card') {
                cardForm.classList.remove('hidden');
            }
        });
    });
</script>

<?php include 'front_footer.php'; ?>
