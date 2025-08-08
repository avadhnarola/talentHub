<?php
ob_start();
include 'front_header.php';
include 'db.php'; // Your database connection

// Check if success flag is set in URL
$showSuccess = isset($_GET['success']) && $_GET['success'] == 1;

if (isset($_POST['submit'])) {
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $phone = $_POST['phone'];
    $email = $_POST['email'];
    $application = $_POST['application'];

    // Insert into DB (prepared statements recommended for security)
    mysqli_query($con, "INSERT INTO admission (fname, lname, phoneNo, email, application)
                        VALUES ('$first_name', '$last_name', '$phone', '$email', '$application')");

    // Redirect to avoid resubmission and trigger alert
    header("Location: ./Admissions.php?success=1");
    exit();
}
?>

<style>
    /* Top center success alert */
    .success-alert {
        position: fixed;
        top: 20px;
        left: 50%;
        transform: translateX(-50%);
        background: #4CAF50;
        color: white;
        padding: 15px 25px;
        border-radius: 8px;
        font-size: 16px;
        font-weight: bold;
        display: flex;
        align-items: center;
        gap: 10px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.2);
        animation: fadeIn 0.4s ease;
        z-index: 9999;
    }

    /* Right icon */
    .success-alert i {
        font-size: 20px;
        background: white;
        color: #4CAF50;
        border-radius: 50%;
        padding: 3px;
    }

    /* Fade animations */
    @keyframes fadeIn {
        from {
            opacity: 0;
            transform: translate(-50%, -20px);
        }
        to {
            opacity: 1;
            transform: translate(-50%, 0);
        }
    }
    @keyframes fadeOut {
        from {
            opacity: 1;
            transform: translate(-50%, 0);
        }
        to {
            opacity: 0;
            transform: translate(-50%, -20px);
        }
    }
</style>

<?php if ($showSuccess): ?>
    <div class="success-alert" id="successAlert">
        <i>✔</i> Application submitted successfully!
    </div>
    <script>
        // Hide after 4 seconds with fade out
        setTimeout(function () {
            let alertBox = document.getElementById("successAlert");
            alertBox.style.animation = "fadeOut 0.5s ease forwards";
            setTimeout(() => alertBox.remove(), 500);
        }, 4000);
    </script>
<?php endif; ?>

<!-- latest_coures_area_start  -->
<div class="admission_area">
    <div class="admission_inner">
        <div class="container">
            <div class="row justify-content-end">
                <div class="col-lg-7">
                    <div class="admission_form">
                        <h3>Apply for Admission</h3>
                        <form method="POST" enctype="multipart/form-data">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="single_input">
                                        <input type="text" name="first_name" placeholder="First Name" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="single_input">
                                        <input type="text" name="last_name" placeholder="Last Name" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="single_input">
                                        <input type="text" name="phone" placeholder="Phone Number" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="single_input">
                                        <input type="email" name="email" placeholder="Email Address" required>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="single_input">
                                        <textarea name="application" cols="30" placeholder="Write an Application"
                                            rows="10" required></textarea>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="apply_btn">
                                        <button class="boxed-btn3" type="submit" name="submit">Apply Now</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!--/ latest_coures_area_end -->

<?php
include_once 'front_footer.php';
?>
