<?php 
include_once 'front_header.php';
include_once './db.php';

// Check if ID is given and valid
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id = intval($_GET['id']);
    $result = mysqli_query($con, "SELECT * FROM events WHERE id = $id LIMIT 1");
    $event = mysqli_fetch_assoc($result);
}

// If no valid ID or no event found, load first event
if (empty($event)) {
    $result = mysqli_query($con, "SELECT * FROM events ORDER BY date ASC LIMIT 1");
    $event = mysqli_fetch_assoc($result);
}

// If still no event, show error
if (!$event) {
    die("No events found in database.");
}
?>

<!-- bradcam_area_start -->
<div class="bradcam_area breadcam_bg">
    <div class="container">
        <div class="row">
            <div class="col-xl-12">
                <div class="bradcam_text">
                    <h3>Event Details</h3>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- bradcam_area_end -->

<div class="event_details_area section__padding">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="single_event d-flex align-items-center">
                    <div class="thumb">
                        <img src="admin/image/<?php echo !empty($event['image']) ? $event['image'] : 'img/event/default.png'; ?>" alt="">
                        <div class="date text-center">
                            <h4><?php echo date('d', strtotime($event['date'])); ?></h4>
                            <span><?php echo date('M, Y', strtotime($event['date'])); ?></span>
                        </div>
                    </div>
                    <div class="event_details_info">
                        <div class="event_info">
                            <a href="#">
                                <h4><?php echo $event['title']; ?></h4>
                            </a>
                            <p>
                                <span> <i class="flaticon-clock"></i> <?php echo date("g:i A", strtotime($event['time'])); ?></span> 
                                <span> <i class="flaticon-calendar"></i> <?php echo date('d M Y', strtotime($event['date'])); ?></span> 
                                <span> <i class="flaticon-placeholder"></i> <?php echo $event['location']; ?></span>
                            </p>
                        </div>
                        <p class="event_info_text">
                            <?php echo nl2br($event['description']); ?>
                        </p>
                        <a href="#" class="boxed-btn3">Book a seat</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php 
include_once 'front_footer.php';
?>
