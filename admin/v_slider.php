<?php
include 'header.php';
include '../db.php';
ob_start();

if (isset($_GET['d_id'])) {
  $slider_id = $_GET['d_id'];
  mysqli_query($con, "delete from slider where slider_id=$slider_id");
  header("location:v_slider.php");
}

$data = mysqli_query($con, query: "select * from slider");

//pagination

$limit = 5;

if (isset($_GET["src"])) {
  $src = $_GET['src'];
} else {
  $src = '';
}

$all_data = mysqli_query($con, "select*from slider limit 0,100");

$total_record = mysqli_num_rows($all_data);

$total_page = ceil($total_record / $limit);

if (isset($_GET['page_no'])) {
  $page_no = $_GET['page_no'];
} else {
  $page_no = 1;
}

$start = ($page_no - 1) * $limit;   //0*10 = 0 1*10=10 2*10=20

$data = mysqli_query($con, "select*from slider limit $start,$limit");

?>


<div class="content-wrapper">
  <!-- Content -->

  <div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Course /</span> View Course</h4>

    <!-- Hoverable Table rows -->
    <div class="card">
      <h5 class="card-header">View Courses</h5>
      <div class="table-responsive text-nowrap">
        <table class="table table-hover">
          <thead>
            <tr>
              <th>Id</th>
              <th>Title</th>
              <th>Sub-Title</th>
              <th>Image</th>
              <th>Actions</th>
            </tr>
          </thead>
          <tbody class="table-border-bottom-0">
            <?php while ($row = mysqli_fetch_assoc($data)) { ?>
              <tr>
                <td><i class="fab fa-angular fa-lg text-danger me-3"></i>
                  <strong><?php echo $row['slider_id']; ?></strong></td>
                <td><?php echo $row['title']; ?></td>
                <td><?php echo $row['subtitle']; ?></td>
                <td><img src="image/<?php echo $row['image']; ?>" width="150px" height="100px"></td>
                <td><span class="badge bg-label-primary me-1">Active</span></td>
                <td>
                  <div class="dropdown">
                    <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                      <i class="bx bx-dots-vertical-rounded"></i>
                    </button>
                    <div class="dropdown-menu">
                      <a class="dropdown-item" href="add_slider.php?u_id=<?php echo $row['slider_id']; ?>"><i
                          class="bx bx-edit-alt me-1"></i> Edit</a>

                      <a class="dropdown-item" href="v_slider.php?d_id=<?php echo $row['slider_id']; ?>"><i
                          class="bx bx-trash me-1"></i> Delete</a>
                    </div>
                  </div>
                </td>
              </tr>
            <?php } ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
  <?php include 'footer.php'; ?>
</div>
</div>
<div class="layout-overlay layout-menu-toggle"></div>
</div>