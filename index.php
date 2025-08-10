<?php
ob_start();
include 'front_header.php';
include './db.php';
$events = mysqli_query($con, "SELECT * FROM events ORDER BY date ASC LIMIT 3");
if (!$events) {
    die("Query failed: " . mysqli_error($con));
}

$slider_data = mysqli_query($con, "select * from slider limit 0,3");
$category_query = mysqli_query($con, "SELECT DISTINCT category FROM courses");
$courses = mysqli_query($con, "SELECT * FROM courses");
$latestCOurses = mysqli_query($con, "SELECT * FROM courses ORDER BY id DESC LIMIT 2");

$showSuccess = false;

if (isset($_POST['submit'])) {
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $phone = $_POST['phone'];
    $email = $_POST['email'];
    $application = $_POST['application'];

    mysqli_query($con, "INSERT INTO admission (fname, lname, phoneNo, email, application)
                        VALUES ('$first_name', '$last_name', '$phone', '$email', '$application')");

    $showSuccess = true; // Show the success popup

    header("Location: ./index.php"); // Redirect to the index page
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
        border-radius: 80%;
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


<!-- slider_area_start -->
<div class="slider_area">
    <div class="slider_active owl-carousel">
        <!-- Loop Through Slider Items -->
        <?php while ($row = mysqli_fetch_assoc($slider_data)) { ?>
            <div class="single_slider d-flex align-items-center"
                style="background-image: url('./admin/image/<?php echo $row['image']; ?>');">
                <div class="container">
                    <div class="row">
                        <div class="col-xl-12">
                            <div class="slider_text">
                                <h3 class="slider-title"><?php echo $row['title']; ?></h3>
                                <div class="row">
                                    <a href="#" class="boxed-btn3">Get Start</a>
                                    <a href="#" class="boxed-btn4 ml-2">Take a tour</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php } ?>
    </div>
</div>

<!-- slider_area_end -->

<!-- service_area_start  -->
<div class="service_area gray_bg">
    <div class="container">
        <div class="row justify-content-center ">
            <div class="col-lg-4 col-md-6">
                <div class="single_service d-flex align-items-center ">
                    <div class="icon">
                        <i class="flaticon-school"></i>
                    </div>
                    <div class="service_info">
                        <h4>Scholarship</h4>
                        <p>Available</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6">
                <div class="single_service d-flex align-items-center ">
                    <div class="icon">
                        <i class="flaticon-error"></i>
                    </div>
                    <div class="service_info">
                        <h4>Scholarship</h4>
                        <p>Available</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6">
                <div class="single_service d-flex align-items-center ">
                    <div class="icon">
                        <i class="flaticon-book"></i>
                    </div>
                    <div class="service_info">
                        <h4>Scholarship</h4>
                        <p>Available</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!--/ service_area_start  -->

<!-- popular_program_area_start  -->
<div class="popular_program_area section__padding program__page">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="section_title text-center">
                    <h3>Popular Program</h3>
                </div>
            </div>
        </div>

        <!-- Tabs -->
        <div class="row">
            <div class="col-lg-12">
                <nav class="custom_tabs text-center">
                    <div class="nav" id="nav-tab" role="tablist">
                        <?php
                        mysqli_data_seek($category_query, 0); // reset pointer
                        $first = true;
                        while ($cat = mysqli_fetch_assoc($category_query)) {
                            $category = $cat['category'];
                            $id = 'nav-' . strtolower(str_replace(' ', '-', $category));
                            $active = $first ? 'active' : '';
                            $aria_selected = $first ? 'true' : 'false';
                            ?>
                            <a class="nav-item nav-link <?php echo $active; ?>" id="<?php echo $id; ?>-tab"
                                data-toggle="tab" href="#<?php echo $id; ?>" role="tab" aria-controls="<?php echo $id; ?>"
                                aria-selected="<?php echo $aria_selected; ?>">
                                <?php echo htmlspecialchars($category); ?>
                            </a>
                            <?php $first = false;
                        } ?>
                    </div>
                </nav>
            </div>
        </div>

        <!-- Tab Content -->
        <div class="tab-content" id="nav-tabContent">
            <?php
            mysqli_data_seek($category_query, 0); // reset pointer
            $first = true;
            while ($cat = mysqli_fetch_assoc($category_query)) {
                $category = $cat['category'];
                $id = 'nav-' . strtolower(str_replace(' ', '-', $category));
                $active = $first ? 'show active' : '';
                ?>
                <div class="tab-pane fade <?php echo $active; ?>" id="<?php echo $id; ?>" role="tabpanel"
                    aria-labelledby="<?php echo $id; ?>-tab">
                    <div class="row">
                        <?php
                        $course_query = mysqli_query($con, "SELECT * FROM courses WHERE category='" . mysqli_real_escape_string($con, $category) . "'");
                        while ($row = mysqli_fetch_assoc($course_query)) {
                            ?>
                            <div class="col-lg-4 col-md-6">
                                <div class="single__program">
                                    <div class="program_thumb">
                                        <img src="./admin/image/<?php echo $row['image']; ?>" alt=""
                                            style="height: 250px; width: 100%; object-fit: cover;">
                                    </div>
                                    <div class="program__content">
                                        <span><?php echo htmlspecialchars($row['category']); ?></span>
                                        <h4><?php echo htmlspecialchars($row['title']); ?></h4>
                                        <p><?php echo htmlspecialchars($row['description']); ?></p>
                                        <a href="course-details.php?id=<?php echo $row['id']; ?>" class="boxed-btn5">Apply
                                            Now</a>
                                    </div>
                                </div>
                            </div>
                        <?php } ?>
                    </div>
                </div>
                <?php $first = false;
            } ?>
        </div>
    </div>
</div>
<!-- popular_program_area_end -->

<!-- latest_coures_area_start  -->
<div class="latest_coures_area">
    <div class="latest_coures_inner">
        <div class="container">
            <div class="row">
                <div class="col-lg-8">
                    <div class="coures_info">
                        <div class="section_title white_text">
                            <h3>Latest Courses</h3>
                            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod <br> tempor
                                incididunt ut labore et dolore magna aliqua. Ut enim ad minim <br> veniam, quis nostrud
                                exercitation.</p>
                        </div>
                        <div class="coures_wrap d-flex">
                            <?php while ($row = mysqli_fetch_assoc($latestCOurses)) { ?>
                                <div class="single_wrap">
                                    <div class="icon">
                                        <i class="flaticon-lab"></i>
                                    </div>
                                    <h4><?php echo $row['title']; ?></h4>
                                    <p><?php echo $row['description']; ?></p>
                                    <a href="#" class="boxed-btn5">Apply NOw</a>
                                </div>
                            <?php } ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!--/ latest_coures_area_end -->

<!-- recent_event_area_strat  -->
<div class="recent_event_area section__padding">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8 col-md-10">
                <div class="section_title text-center mb-70">
                    <h3 class="mb-45">Recent Event</h3>
                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut
                        labore et dolore magna aliqua.</p>
                </div>
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <?php while ($event = mysqli_fetch_assoc($events)) { ?>
                    <div class="single_event d-flex align-items-center">
                        <div class="date text-center">
                            <span><?php echo date('d', strtotime($event['date'])); ?></span>
                            <p style="width:100px;"><?php echo date('M, Y', strtotime($event['date'])); ?></p>
                        </div>
                        <div class="event_info">
                            <a href="event_details.php?id=<?php echo $event['id']; ?>">
                                <h4><?php echo $event['title']; ?></h4>
                            </a>
                            <p>
                                <span> <i class="flaticon-clock"></i>
                                    <?php echo date("g:i A", strtotime($event['time'])); ?>
                                </span>

                                <span> <i class="flaticon-calendar"></i>
                                    <?php echo date('d M Y', strtotime($event['date'])); ?> </span>
                                <span> <i class="flaticon-placeholder"></i> <?php echo $event['location']; ?> </span>
                            </p>
                        </div>
                    </div>
                <?php } ?>

            </div>
        </div>
    </div>
</div>
<!-- recent_event_area_end  -->

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


<!-- recent_news_area_start  -->
<div class="recent_news_area section__padding">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8 col-md-10">
                <div class="section_title text-center mb-70">
                    <h3 class="mb-45">Recent News</h3>
                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut
                        labore et dolore magna aliqua.</p>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="single__news">
                    <div class="thumb">
                        <a href="single-blog.php">
                            <img src="img/news/1.png" alt="">
                        </a>
                        <span class="badge">Group Study</span>
                    </div>
                    <div class="news_info">
                        <a href="single-blog.php">
                            <h4>Those Other College Expenses You
                                Aren’t Thinking About</h4>
                        </a>
                        <p class="d-flex align-items-center"> <span><i class="flaticon-calendar-1"></i> May 10,
                                2020</span>

                            <span> <i class="flaticon-comment"></i> 01 comments</span>
                        </p>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="single__news">
                    <div class="thumb">
                        <a href="single-blog.html">
                            <img src="img/news/2.png" alt="">
                        </a>
                        <span class="badge bandge_2">Hall Life</span>
                    </div>
                    <div class="news_info">
                        <a href="single-blog.html">
                            <h4>Those Other College Expenses You
                                Aren’t Thinking About</h4>
                        </a>
                        <p class="d-flex align-items-center"> <span><i class="flaticon-calendar-1"></i> May 10,
                                2020</span>

                            <span> <i class="flaticon-comment"></i> 01 comments</span>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- recent_news_area_end  -->

<?php include 'front_footer.php'; ?>

<script>
    $(document).ready(function () {
        $(".slider_active").owlCarousel({
            items: 1,              // Show 1 slide at a time
            loop: true,            // Infinite loop
            autoplay: true,        // Enable auto-scrolling
            autoplayTimeout: 4000, // Time between slides (4 seconds)
            autoplayHoverPause: true, // Pause on hover
            smartSpeed: 800,       // Smooth transition speed
            nav: false,            // Hide next/prev arrows (optional)
            dots: true             // Show navigation dots
        });
    });
</script>