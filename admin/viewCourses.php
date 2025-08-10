<?php
include 'header.php';
include '../db.php';

if (!$_SESSION['admin_id']) {
  header("Location: ./index.php");
  exit();
}

// Delete course
if (isset($_GET['d_id'])) {
  $course_id = (int)$_GET['d_id'];
  mysqli_query($con, "DELETE FROM courses WHERE id=$course_id");
  header("Location: ./viewCourses.php");
  exit();
}

// Pagination setup
$limit = 5; // Rows per page
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $limit;

// Get total records for pagination
$total_result = mysqli_query($con, "SELECT COUNT(*) as total FROM courses");
$total_row = mysqli_fetch_assoc($total_result);
$total_courses = $total_row['total'];
$total_pages = ceil($total_courses / $limit);

// Fetch limited rows
$courses = mysqli_query($con, "SELECT * FROM courses ORDER BY id DESC LIMIT $offset, $limit");
?>

<!-- Content wrapper -->
<div class="content-wrapper">
  <!-- Content -->
  <div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Course /</span> View Courses</h4>

    <!-- Hoverable Table rows -->
    <div class="card">
      <h5 class="card-header">View Courses</h5>
      <div class="table-responsive text-nowrap">
        <table class="table table-hover">
          <thead>
            <tr>
              <th>Id</th>
              <th>Category</th>
              <th>Title</th>
              <th>Description</th>
              <th>Duration (Week)</th>
              <th>Price ($)</th>
              <th>Start Date</th>
              <th>End Date</th>
              <th>Image</th>
              <th>Actions</th>
            </tr>
          </thead>
          <tbody class="table-border-bottom-0">
            <?php if (mysqli_num_rows($courses) > 0): ?>
              <?php while ($course = mysqli_fetch_assoc($courses)) { ?>
                <tr>
                  <td><?php echo $course['id']; ?></td>
                  <td><?php echo htmlspecialchars($course['category']); ?></td>
                  <td><?php echo htmlspecialchars($course['title']); ?></td>
                  <td><?php echo nl2br(htmlspecialchars($course['description'])); ?></td>
                  <td><?php echo htmlspecialchars($course['duration']); ?></td>
                  <td><?php echo number_format($course['price'], 2); ?></td>
                  <td>
                    <?php 
                      echo !empty($course['start_date']) 
                        ? date("d-M-Y", strtotime($course['start_date'])) 
                        : '—'; 
                    ?>
                  </td>
                  <td>
                    <?php 
                      echo !empty($course['end_date']) 
                        ? date("d-M-Y", strtotime($course['end_date'])) 
                        : '—'; 
                    ?>
                  </td>
                  <td>
                    <?php if (!empty($course['image'])): ?>
                      <img src="image/<?php echo htmlspecialchars($course['image']); ?>" alt="Course Image" width="100" height="100">
                    <?php else: ?>
                      <span>No Image</span>
                    <?php endif; ?>
                  </td>
                  <td>
                    <div class="dropdown">
                      <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                        <i class="bx bx-dots-vertical-rounded"></i>
                      </button>
                      <div class="dropdown-menu">
                        <a class="dropdown-item" href="addCourses.php?u_id=<?php echo $course['id']; ?>">
                          <i class="bx bx-edit-alt me-1"></i> Edit</a>
                        <a class="dropdown-item" href="viewCourses.php?d_id=<?php echo $course['id']; ?>" onclick="return confirm('Are you sure you want to delete this course?');">
                          <i class="bx bx-trash me-1"></i> Delete</a>
                      </div>
                    </div>
                  </td>
                </tr>
              <?php } ?>
            <?php else: ?>
              <tr>
                <td colspan="10" class="text-center">No courses found</td>
              </tr>
            <?php endif; ?>
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
            <li class="page-item <?php if ($i == $page) echo 'active'; ?>">
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
