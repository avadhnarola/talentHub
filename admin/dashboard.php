<?php
ob_start();
include_once("../db.php");
include("header.php");

if (!isset($_SESSION["admin_id"])) {
  header("location:index.php");
  exit;
}

// =============================
// Fetch students (coursebookings count)
// =============================
$studentsQuery = mysqli_query($con, "SELECT COUNT(*) as total_students FROM coursebookings");
$studentsRow = mysqli_fetch_assoc($studentsQuery);
$total_students = $studentsRow['total_students'] ?? 0;

// =============================
// Fetch total courses
// =============================
$coursesQuery = mysqli_query($con, "SELECT COUNT(*) as total_courses FROM courses");
$coursesRow = mysqli_fetch_assoc($coursesQuery);
$total_courses = $coursesRow['total_courses'] ?? 0;

// =============================
// Fetch total successful transactions amount
// =============================
$revenueQuery = mysqli_query($con, "SELECT SUM(amount) as total_revenue FROM coursebookings WHERE status='success'");
$revenueRow = mysqli_fetch_assoc($revenueQuery);
$total_revenue = $revenueRow['total_revenue'] ?? 0;

// =============================
// Fetch latest transactions with username
// =============================
$transactionsQuery = mysqli_query($con, "
    SELECT p.id, p.amount, p.method, p.status, p.transaction_id, p.created_at, u.username 
    FROM coursebookings p
    JOIN users u ON p.user_id = u.id
    ORDER BY p.created_at DESC
    LIMIT 10
");
?>
<!-- Bootstrap Icons CDN -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">

<!-- Content wrapper -->
<div class="content-wrapper">
  <!-- Content -->
  <div class="container-xxl flex-grow-1 container-p-y">
    <div class="row">
      <div class="col-lg-8 mb-4 order-0">
        <div class="card">
          <div class="d-flex align-items-end row">
            <div class="col-sm-7">
              <div class="card-body">
                <h5 class="card-title text-primary">Welcome back <?php echo $_SESSION['admin_name']; ?>! 🎉</h5>
                <p class="mb-4">
                  You are managing <span class="fw-bold"><?php echo $total_students; ?></span> students and <span
                    class="fw-bold"><?php echo $total_courses; ?></span> courses.
                </p>
                <a href="courses.php" class="btn btn-sm btn-outline-primary">Manage Courses</a>
              </div>
            </div>
            <div class="col-sm-5 text-center text-sm-left">
              <div class="card-body pb-0 px-0 px-md-4">
                <img src="assets/img/illustrations/man-with-laptop-light.png" height="140" alt="Admin"
                  data-app-dark-img="illustrations/man-with-laptop-dark.png"
                  data-app-light-img="illustrations/man-with-laptop-light.png" />
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Students Card -->
      <div class="col-lg-4 col-md-4 order-1">
        <div class="row">
          <div class="col-lg-6 col-md-12 col-6 mb-4">
            <div class="card">
              <div class="card-body">
                <div class="card-title d-flex align-items-start justify-content-between">
                  <div class="avatar flex-shrink-0">
                    <img src="assets/img/icons/unicons/wallet-info.png" alt="Students" class="rounded" />
                  </div>
                </div>
                <span>Students</span>
                <h3 class="card-title text-nowrap mb-1"><?php echo $total_students; ?></h3>
              </div>
            </div>
          </div>

          <!-- Courses Card -->
          <div class="col-lg-6 col-md-12 col-6 mb-4">
            <div class="card">
              <div class="card-body">
                <div class="card-title d-flex align-items-start justify-content-between">
                  <div class="avatar flex-shrink-0">
                    <img src="assets/img/icons/unicons/chart-success.png" alt="Courses" class="rounded" />
                  </div>
                </div>
                <span>Total Courses</span>
                <h3 class="card-title mb-2"><?php echo $total_courses; ?></h3>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Revenue -->
      <div class="col-md-6 col-lg-6 order-2 mb-4">
        <div class="card h-100">
          <div class="card-header d-flex align-items-center justify-content-between">
            <h5 class="card-title m-0 me-2">Total Revenue</h5>
          </div>
          <div class="card-body">
            <h3 class="card-title mb-2">$<?php echo number_format($total_revenue, 2); ?></h3>
          </div>
        </div>
      </div>

      <!-- Transactions History -->
      <div class="col-md-6 col-lg-6 order-2 mb-4">
        <div class="card h-100">
          <div class="card-header d-flex align-items-center justify-content-between">
            <h5 class="card-title m-0 me-2">Recent Transactions</h5>
          </div>
          <div class="card-body">
            <ul class="p-0 m-0">
              <?php while ($row = mysqli_fetch_assoc($transactionsQuery)): ?>
                <li class="d-flex mb-3 pb-1 border-bottom">
                  <div class="avatar flex-shrink-0 me-3">
                    <?php if ($row['status'] == 'success'): ?>
                      <img src="assets/img/icons/unicons/cc-success.png" alt="Success" class="rounded" />
                    <?php elseif ($row['status'] == 'pending'): ?>
                      <img src="assets/img/icons/unicons/cc-warning.png" alt="Pending" class="rounded" />
                    <?php else: ?>
                      <img src="assets/img/icons/unicons/chart.png" alt="Other" class="rounded" />
                    <?php endif; ?>
                  </div>
                  <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                    <div class="me-2">
                      <small class="text-muted d-block mb-1"><?php echo htmlspecialchars($row['username']); ?></small>
                      <h6 class="mb-0"><?php echo ucfirst($row['method']); ?> - <?php echo $row['transaction_id']; ?></h6>
                    </div>
                    <div class="user-progress d-flex align-items-center gap-1">
                      <h6 class="mb-0">$<?php echo number_format($row['amount'], 2); ?></h6>
                      <span class="text-muted d-flex align-items-center gap-1">
                        <?php if ($row['status'] == 'success'): ?>
                          <i class="bi bi-check-circle-fill text-success"></i>
                        <?php elseif ($row['status'] == 'pending'): ?>
                          <i class="bi bi-hourglass-split text-warning"></i>
                        <?php else: ?>
                          <i class="bi bi-x-circle-fill text-danger"></i>
                        <?php endif; ?>
                        
                      </span>

                    </div>
                  </div>
                </li>
              <?php endwhile; ?>
            </ul>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- / Content -->

  <?php include("footer.php"); ?>