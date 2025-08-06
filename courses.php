<?php
include_once 'front_header.php';
include './db.php';

$courses = mysqli_query($con, "SELECT * FROM courses limit 6");
$category_query = mysqli_query($con, "SELECT DISTINCT category FROM courses");

?>

<!-- bradcam_area_start -->
<div class="bradcam_area breadcam_bg">
    <div class="container">
        <div class="row">
            <div class="col-xl-12">
                <div class="bradcam_text">
                    <h3>Our Courses</h3>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- bradcam_area_end -->

<!-- popular_program_area_start -->
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
                                   data-toggle="tab" href="#<?php echo $id; ?>" role="tab"
                                   aria-controls="<?php echo $id; ?>" aria-selected="<?php echo $aria_selected; ?>">
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
                                                <a href="#" class="boxed-btn5">Apply Now</a>
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

<?php include_once 'front_footer.php'; ?>
