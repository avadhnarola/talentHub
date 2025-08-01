<?php
include 'header.php';
include '../db.php';
ob_start();

if (!isset($_SESSION["admin_id"])) {
    header("location:index.php");
}


if (isset($_GET['u_id'])) {

    $slider_id = $_GET['u_id'];
    $u_data = mysqli_query($con, "select * from slider where slider_id=$slider_id");
    $u_data = mysqli_fetch_assoc($u_data);

}

if (isset($_POST['submit'])) {
    $title = $_POST['title'];
    $subtitle = $_POST['subtitle'];
    $image = $_FILES['image']['name'];


    move_uploaded_file($_FILES['image']['tmp_name'], "image/$image");


    if($slider_id){
      mysqli_query($con, "update slider set title='$title', subtitle='$subtitle', image='$image' where slider_id=$slider_id");
      header("location:v_slider.php");

    }else{

      mysqli_query($con, "insert into slider(title,subtitle,image) values('$title','$subtitle','$image')");
      header("location:./v_slider.php");
    }
   

}
?>


<div class="content-wrapper">
  <div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Slider /</span> Add Slider</h4>
    <div class="row">
      <!-- Basic Layout -->
      <div class="col-xxl">
        <div class="card mb-4">
          <div class="card-header d-flex align-items-center justify-content-between">
            <h5 class="mb-0">Add Slider</h5>
            
          </div>
          <div class="card-body">
            <form method="POST" enctype="multipart/form-data">

              <div class="row mb-3">
                <label class="col-sm-2 col-form-label" for="basic-default-name">Title</label>
                <div class="col-sm-10">
                  <input type="text" name="title" class="form-control" id="basic-default-name" placeholder="Enter Title" required value="<?php echo @$u_data['title']; ?>" />
                </div>
              </div>

              <div class="row mb-3">
                <label class="col-sm-2 col-form-label" for="basic-default-company">Subtitle</label>
                <div class="col-sm-10">
                  <input type="text" name="subtitle" class="form-control" id="basic-default-company" required placeholder="Enter Subtitle" value="<?php echo @$u_data['subtitle']; ?>"/>
                </div>
              </div>

                <div class="row mb-3">
                    <label class="col-sm-2 col-form-label" for="basic-default-email">Image</label>
                    <div class="col-sm-10">
                    <input type="file" name="image" class="form-control" id="basic-default-email" required/>
                    </div>
                </div>
              <div class="row justify-content-end">
                <div class="col-sm-10">
                  <input type="submit" class="btn btn-primary" value="Send" name="submit">
                </div>
              </div>
            </form>
          </div>
        </div>
        
      </div>
    </div>
  </div>
</div>
<?php include 'footer.php'; ?> 
</div>

  <!-- / Content -->

 