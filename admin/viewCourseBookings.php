<?php
include 'header.php';
include '../db.php';

if (!$_SESSION['admin_id']) {
    header("Location: ./index.php");
    exit();
}

// Delete booking
if (isset($_GET['d_id'])) {
    $booking_id = (int) $_GET['d_id'];
    mysqli_query($con, "DELETE FROM coursebookings WHERE id=$booking_id");
    header("Location: ./viewCourseBookings.php");
    exit();
}

// Pagination setup
$limit = 5; // Rows per page
$page = isset($_GET['page']) ? (int) $_GET['page'] : 1;
$offset = ($page - 1) * $limit;

// Get total records for pagination
$total_result = mysqli_query($con, "SELECT COUNT(*) as total FROM coursebookings");
$total_row = mysqli_fetch_assoc($total_result);
$total_bookings = $total_row['total'];
$total_pages = ceil($total_bookings / $limit);

// Fetch limited rows (joining with users and courses for better display)
$bookings = mysqli_query($con, "
    SELECT cb.*, u.username, u.email, c.title AS course_title 
    FROM coursebookings cb
    JOIN users u ON cb.user_id = u.id
    JOIN courses c ON cb.course_id = c.id
    ORDER BY cb.created_at DESC
    LIMIT $offset, $limit
");
?>

<!-- Content wrapper -->
<div class="content-wrapper">
    <!-- Content -->
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="fw-bold py-3 mb-4">
            <span class="text-muted fw-light">Course Bookings /</span> View Course Bookings
        </h4>

        <!-- Hoverable Table rows -->
        <div class="card">
            <h5 class="card-header">View Course Bookings</h5>
            <div class="table-responsive text-nowrap">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Booking ID</th>
                            <th>Transaction ID</th>
                            <th>User</th>
                            <th>Email</th>
                            <th>Course</th>
                            <th>Method</th>
                            <th>Amount</th>
                            <th>Status</th>
                            <th>Date</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody class="table-border-bottom-0">
                        <?php while ($booking = mysqli_fetch_assoc($bookings)) { ?>
                            <tr>
                                <td><?php echo $booking['id']; ?></td>
                                <td><?php echo $booking['transaction_id'] ?: '<span style="color:red;">NULL</span>'; ?></td>
                                <td><?php echo htmlspecialchars($booking['username']); ?></td>
                                <td><?php echo htmlspecialchars($booking['email']); ?></td>
                                <td><?php echo htmlspecialchars($booking['course_title']); ?></td>
                                <td><?php echo strtoupper($booking['method']); ?></td>
                                <td>₹<?php echo number_format($booking['amount'], 2); ?></td>
                                <td>
                                    <?php if ($booking['status'] == 'success') { ?>
                                        <span class="badge bg-success">Success</span>
                                    <?php } else { ?>
                                        <span class="badge bg-warning">Pending</span>
                                    <?php } ?>
                                </td>
                                <td><?php echo $booking['created_at']; ?></td>
                                <td>
                                    <div class="dropdown">
                                        <button type="button" class="btn p-0 dropdown-toggle hide-arrow"
                                            data-bs-toggle="dropdown">
                                            <i class="bx bx-dots-vertical-rounded"></i>
                                        </button>
                                        <div class="dropdown-menu">
                                            <a class="dropdown-item"
                                                href="viewCourseBookings.php?d_id=<?php echo $booking['id']; ?>"
                                                onclick="return confirm('Are you sure you want to delete this booking?');">
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