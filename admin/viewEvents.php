<?php
include 'header.php';
include '../db.php';

if (!$_SESSION['admin_id']) {
    header("Location: ./index.php");
    exit();
}

// Delete event
if (isset($_GET['d_id'])) {
    $event_id = $_GET['d_id'];
    mysqli_query($con, "DELETE FROM events WHERE id=$event_id");
    header("Location: ./viewEvents.php");
    exit();
}

// Pagination setup
$limit = 5; // Rows per page
$page = isset($_GET['page']) ? (int) $_GET['page'] : 1;
$offset = ($page - 1) * $limit;

// Get total records for pagination
$total_result = mysqli_query($con, "SELECT COUNT(*) as total FROM events");
$total_row = mysqli_fetch_assoc($total_result);
$total_events = $total_row['total'];
$total_pages = ceil($total_events / $limit);

// Fetch limited rows
$events = mysqli_query($con, "SELECT * FROM events LIMIT $offset, $limit");
?>

<!-- Content wrapper -->
<div class="content-wrapper">
    <!-- Content -->
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Events /</span> View Events</h4>

        <!-- Hoverable Table rows -->
        <div class="card">
            <h5 class="card-header">View Events</h5>
            <div class="table-responsive text-nowrap">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Id</th>
                            <th>Title</th>
                            <th>Time</th>
                            <th>Location</th>
                            <th>Date</th>
                            <th>Description</th>
                            <th>Image</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody class="table-border-bottom-0">
                        <?php while ($Events = mysqli_fetch_assoc($events)) { ?>
                            <tr>
                                <td><?php echo $Events['id']; ?></td>
                                <td><?php echo $Events['title']; ?></td>
                                <td><?php echo $Events['time']; ?></td>
                                <td><?php echo $Events['location']; ?></td>
                                <td><?php echo $Events['date']; ?></td>
                                <td><?php echo $Events['description']; ?></td>
                                <td><img src="image/<?php echo $Events['image']; ?>" alt="Event Image" width="100px" height="67px"></td>

                                <td>
                                    <div class="dropdown">
                                        <button type="button" class="btn p-0 dropdown-toggle hide-arrow"
                                            data-bs-toggle="dropdown">
                                            <i class="bx bx-dots-vertical-rounded"></i>
                                        </button>
                                        <div class="dropdown-menu">
                                            <a class="dropdown-item" href="addEvents.php?u_id=<?php echo $Events['id']; ?>">
                                                <i class="bx bx-edit-alt me-1"></i> Edit</a>
                                            <a class="dropdown-item"
                                                href="deleteEvents.php?d_id=<?php echo $Events['id']; ?>">
                                                <i class="bx bx-trash me-1"></i> Delete</a>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Pagination -->
        <div class="mt-3">
            <nav aria-label="Page navigation">
                <ul class="pagination justify-content-center">
                    <?php if ($page > 1): ?>
                        <li class="page-item">
                            <a class="page-link" href="?page=<?php echo $page - 1; ?>">Previous</a>
                        </li>
                    <?php endif; ?>

                    <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                        <li class="page-item <?php if ($i == $page)
                            echo 'active'; ?>">
                            <a class="page-link" href="?page=<?php echo $i; ?>"><?php echo $i; ?></a>
                        </li>
                    <?php endfor; ?>

                    <?php if ($page < $total_pages): ?>
                        <li class="page-item">
                            <a class="page-link" href="?page=<?php echo $page + 1; ?>">Next</a>
                        </li>
                    <?php endif; ?>
                </ul>
            </nav>
        </div>

        <hr class="my-5" />
    </div>
    <!-- / Content -->
    <?php include 'footer.php'; ?>
</div>
<!-- / Layout page -->

<div class="layout-overlay layout-menu-toggle"></div>
</div>
<!-- / Layout wrapper -->