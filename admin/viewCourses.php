<?php
include 'header.php';
include '../db.php';

if (!$_SESSION['admin_id']) {
  header("Location: ./index.php");
  exit();
}
?>

<!-- Content wrapper -->
<div class="content-wrapper">
  <!-- Content -->
  <div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Course /</span> View Courses</h4>

    <!-- Search Bar -->
    <div class="card p-3 mb-3">
      <input type="text" id="search" class="form-control" placeholder="Search courses by title, category, or description...">
    </div>

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
              <th>Material URL</th>
              <th>Start Date</th>
              <th>End Date</th>
              <th>Image</th>
              <th>Actions</th>
            </tr>
          </thead>
          <tbody id="course_table">
            <!-- Data will be loaded here via AJAX -->
          </tbody>
        </table>
      </div>
    </div>

    <div id="pagination" class="mt-3"></div>

    <hr class="my-5" />
  </div>
  <!-- / Content -->
  <?php include 'footer.php'; ?>
</div>

<!-- / Layout page -->
<div class="layout-overlay layout-menu-toggle"></div>
</div>

<!-- jQuery for AJAX -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function () {
  function loadCourses(query = '', page = 1) {
    $.ajax({
      url: "fetch_courses.php",
      method: "POST",
      data: { query: query, page: page },
      success: function (data) {
        let response = JSON.parse(data);
        $("#course_table").html(response.table);
        $("#pagination").html(response.pagination);
      }
    });
  }

  // Load initial data
  loadCourses();

  // Live search
  $("#search").keyup(function () {
    let query = $(this).val();
    loadCourses(query, 1);
  });

  // Pagination click
  $(document).on("click", ".page-link", function (e) {
    e.preventDefault();
    let page = $(this).data("page");
    let query = $("#search").val();
    loadCourses(query, page);
  });
});
</script>
