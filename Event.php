<?php
include_once 'front_header.php';
include_once './db.php';
$events = mysqli_query($con, "SELECT * FROM events ORDER BY date ASC LIMIT 3");
if (!$events) {
    die("Query failed: " . mysqli_error($con));
}
?>

<!-- bradcam_area_start  -->
<div class="bradcam_area breadcam_bg">
    <div class="container">
        <div class="row">
            <div class="col-xl-12">
                <div class="bradcam_text">
                    <h3>Recent Events</h3>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- bradcam_area_end  -->

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
<?php
include_once 'front_footer.php'; ?>