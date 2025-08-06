<?php
include 'header.php';
include '../db.php';
ob_start();

// Handle deletion
if (isset($_GET['d_id'])) {
  $slider_id = $_GET['d_id'];
  mysqli_query($con, "DELETE FROM slider WHERE slider_id = $slider_id");
  header("location:viewSlider.php");
  exit();
}

// Pagination settings
$limit = 5;
$page_no = isset($_GET['page_no']) ? (int) $_GET['page_no'] : 1;
$start = ($page_no - 1) * $limit;

// Get total number of records
$total_result = mysqli_query($con, "SELECT COUNT(*) as total FROM slider");
$total_row = mysqli_fetch_assoc($total_result);
$total_record = $total_row['total'];
$total_page = ceil($total_record / $limit);

// Fetch limited data
$data = mysqli_query($con, "SELECT * FROM slider LIMIT $start, $limit");
?>

<div class="content-wrapper">
  <div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold py-3 mb-4">
      <span class="text-muted fw-light">Slider /</span> View Sliders
    </h4>

    <!-- Table -->
    <div class="card">
      <h5 class="card-header">View Sliders</h5>
      <div class="table-responsive text-nowrap">
        <table class="table table-hover">
          <thead>
            <tr>
              <th>Id</th>
              <th>Title</th>
              <th>Image</th>
              <th>Status</th>
              <th>Actions</th>
            </tr>
          </thead>
          <tbody class="table-border-bottom-0">
            <?php while ($row = mysqli_fetch_assoc($data)) { ?>
              <tr>
                <td><strong><?php echo $row['slider_id']; ?></strong></td>
                <td><?php echo $row['title']; ?></td>
                <td>
                  <img src="image/<?php echo $row['image']; ?>" width="100px" height="67px">
                </td>
                <td><span class="badge bg-label-primary me-1">Active</span></td>
                <td>
                  <div class="dropdown">
                    <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                      <i class="bx bx-dots-vertical-rounded"></i>
                    </button>
                    <div class="dropdown-menu">
                      <a class="dropdown-item" href="addSlider.php?u_id=<?php echo $row['slider_id']; ?>">
                        <i class="bx bx-edit-alt me-1"></i> Edit</a>
                      <a class="dropdown-item" href="viewSlider.php?d_id=<?php echo $row['slider_id']; ?>"
                        onclick="return confirm('Are you sure you want to delete this slider?');">
                        <i class="bx bx-trash me-1"></i> Delete</a>
                    </div>
                  </div>
                </td>
              </tr>
            <?php } ?>
          </tbody>
        </table>

        <!-- Pagination -->
        <nav aria-label="Page navigation" class="mt-3">
          <ul class="pagination justify-content-center">
            <?php if ($page_no > 1) { ?>
              <li class="page-item">
                <a class="page-link" href="?page_no=<?php echo $page_no - 1; ?>">Previous</a>
              </li>
            <?php } ?>

            <?php for ($i = 1; $i <= $total_page; $i++) { ?>
              <li class="page-item <?php if ($i == $page_no)
                echo 'active'; ?>">
                <a class="page-link" href="?page_no=<?php echo $i; ?>"><?php echo $i; ?></a>
              </li>
            <?php } ?>

            <?php if ($page_no < $total_page) { ?>
              <li class="page-item">
                <a class="page-link" href="?page_no=<?php echo $page_no + 1; ?>">Next</a>
              </li>
            <?php } ?>
          </ul>
        </nav>
        <!-- End Pagination -->

      </div>
    </div>
  </div>

  <?php include 'footer.php'; ?>
</div>

<!-- Layout wrapper close -->
</div>
<div class="layout-overlay layout-menu-toggle"></div>
</div>