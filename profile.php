<?php

session_start();
if (isset($_SESSION['user_data'])) {
  include 'connection.php';
  if (isset($_POST['action']) == 'changeProfile') {
    $error = array(
      'error_status' => 0
    );
    if ($_FILES['image']['size'] == 0) {
      $error['error_status'] = 1;
      $error['image'] = 'Profile Image is required';
      echo json_encode($error);
      exit();
    }
    $errors = array();
    $file_name = $_FILES['image']['name'];
    $file_size = $_FILES['image']['size'];
    $file_tmp = $_FILES['image']['tmp_name'];
    $file_type = $_FILES['image']['type'];
    $file_extension_arr = explode('.', $_FILES['image']['name']);

    $file_extension = strtolower(end($file_extension_arr));
    $extensions = array("jpeg", "jpg", "png");

    if (in_array($file_extension, $extensions) === false) {
      $error['error_status'] = 1;
      $error['image'] = 'extension not allowed, please choose a JPEG or PNG file.';
    }

    if ($file_size > 2097152) {
      $error['error_status'] = 1;
      $error['image'] = 'File size must be less than 2 MB.';
    }
    if ($error['error_status'] > 0) {
      echo json_encode($error);
      exit();
    } else {
      $res = move_uploaded_file($file_tmp, "assets/images/uploads/" . $file_name);
      if ($res) {
        // update the user profile field in database
        $email = $_SESSION['user_data']['email'];
        $qry = "Update users set profile = '" . $file_name . "' Where email = '" . $email . "'";
        $result = $conn->query($qry);
        $_SESSION['user_data']['profile'] = $file_name;
        $response = array(
          'status' => 1,
          'msg' => 'Profile Image uploaded successfully'
        );
      } else {
        $response = array(
          'status' => 0,
          'msg' => 'Uploading Profile Image failed.'
        );
      }
      echo json_encode($response);
      exit();
    }
  }
} else {
  header('Location: /php_tutorial/login.php');
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <link rel="apple-touch-icon" sizes="76x76" href="/php_tutorial/assets/img/apple-icon.png">
  <link rel="icon" type="image/png" href="/php_tutorial/assets/img/favicon.png">
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
  <title>
    profile
  </title>
  <meta content='width=device-width, initial-scale=1.0, shrink-to-fit=no' name='viewport' />
  <!--     Fonts and icons     -->
  <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700|Roboto+Slab:400,700|Material+Icons" />
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css">
  <!-- CSS Files -->
  <link href="/php_tutorial/assets/css/material-dashboard.css?v=2.2.2" rel="stylesheet" />
  <!-- CSS Just for demo purpose, don't include it in your project -->
  <link href="/php_tutorial/assets/demo/demo.css" rel="stylesheet" />
  <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.1.4/toastr.min.css" />

</head>

<body class="">
  <div class="wrapper ">
    <?php include './includes/sidebar.php' ?>
    <div class="main-panel">
      <!-- Navbar -->
      <?php include './includes/navbar.php' ?>
      <!-- End Navbar -->
      <div class="content">
        <div class="content">
          <div class="container-fluid">
            <div class="row text-center">
              <div class="col-lg-4 col-md-6 col-sm-12 ml-auto mr-auto">
                <form class="form" method="" action="" id="changeProfileForm">
                  <div class="card card-login card-hidden">
                    <div class="card-header card-header-rose text-center">
                      <h4 class="card-title">Change Profile</h4>
                    </div>
                    <div class="card-body ">
                      <h4 class="title">Regular Image</h4>
                      <div class="fileinput fileinput-new text-center" data-provides="fileinput">
                        <div class="fileinput-new thumbnail">
                          <?php if ($profile == '') { ?>
                            <img src="/php_tutorial/assets/img/image_placeholder.jpg" alt="...">
                          <?php } else { ?>
                            <img src="/php_tutorial/assets/images/uploads/<?php echo $profile ?>" alt="...">
                          <?php } ?>
                        </div>
                        <div class="fileinput-preview fileinput-exists thumbnail"></div>
                        <div>
                          <span class="btn btn-rose btn-round btn-file">
                            <span class="fileinput-new">Select image</span>
                            <span class="fileinput-exists">Change</span>
                            <input type="file" name="image">
                          </span><br />
                          <small class="text-danger" id="imageError"></small>
                        </div>
                      </div>
                    </div>
                    <div class="card-footer justify-content-center">
                      <button type="submit" href="#pablo" class="btn btn-success btn-block">Submit</button>
                    </div>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
      <footer class="footer">
        <div class="container-fluid">
          <nav class="float-left">
            <ul>
              <li>
                <a href="https://www.creative-tim.com">
                  Creative Tim
                </a>
              </li>
              <li>
                <a href="https://creative-tim.com/presentation">
                  About Us
                </a>
              </li>
              <li>
                <a href="http://blog.creative-tim.com">
                  Blog
                </a>
              </li>
              <li>
                <a href="https://www.creative-tim.com/license">
                  Licenses
                </a>
              </li>
            </ul>
          </nav>
          <div class="copyright float-right">
            &copy;
            <script>
              document.write(new Date().getFullYear())
            </script>, made with <i class="material-icons">favorite</i> by
            <a href="https://www.creative-tim.com" target="_blank">Creative Tim</a> for a better web.
          </div>
        </div>
      </footer>
    </div>
  </div>
  <!--   Core JS Files   -->
  <script src="/php_tutorial/assets/js/core/jquery.min.js"></script>
  <script src="/php_tutorial/assets/js/core/popper.min.js"></script>
  <script src="/php_tutorial/assets/js/core/bootstrap-material-design.min.js"></script>
  <script src="/php_tutorial/assets/js/plugins/perfect-scrollbar.min.js"></script>
  <!-- Plugin for the momentJs  -->
  <script src="/php_tutorial/assets/js/plugins/moment.min.js"></script>
  <!--  Plugin for Sweet Alert -->
  <script src="/php_tutorial/assets/js/plugins/sweetalert2.js"></script>
  <!-- Forms Validations Plugin -->
  <script src="/php_tutorial/assets/js/plugins/jquery.validate.min.js"></script>
  <!-- Plugin for the Wizard, full documentation here: https://github.com/VinceG/twitter-bootstrap-wizard -->
  <script src="/php_tutorial/assets/js/plugins/jquery.bootstrap-wizard.js"></script>
  <!--	Plugin for Select, full documentation here: http://silviomoreto.github.io/bootstrap-select -->
  <script src="/php_tutorial/assets/js/plugins/bootstrap-selectpicker.js"></script>
  <!--  Plugin for the DateTimePicker, full documentation here: https://eonasdan.github.io/bootstrap-datetimepicker/ -->
  <script src="/php_tutorial/assets/js/plugins/bootstrap-datetimepicker.min.js"></script>
  <!--  DataTables.net Plugin, full documentation here: https://datatables.net/  -->
  <script src="/php_tutorial/assets/js/plugins/jquery.dataTables.min.js"></script>
  <!--	Plugin for Tags, full documentation here: https://github.com/bootstrap-tagsinput/bootstrap-tagsinputs  -->
  <script src="/php_tutorial/assets/js/plugins/bootstrap-tagsinput.js"></script>
  <!-- Plugin for Fileupload, full documentation here: http://www.jasny.net/bootstrap/javascript/#fileinput -->
  <script src="/php_tutorial/assets/js/plugins/jasny-bootstrap.min.js"></script>
  <!--  Full Calendar Plugin, full documentation here: https://github.com/fullcalendar/fullcalendar    -->
  <script src="/php_tutorial/assets/js/plugins/fullcalendar.min.js"></script>
  <!-- Vector Map plugin, full documentation here: http://jvectormap.com/documentation/ -->
  <script src="/php_tutorial/assets/js/plugins/jquery-jvectormap.js"></script>
  <!--  Plugin for the Sliders, full documentation here: http://refreshless.com/nouislider/ -->
  <script src="/php_tutorial/assets/js/plugins/nouislider.min.js"></script>
  <!-- Include a polyfill for ES6 Promises (optional) for IE11, UC Browser and Android browser support SweetAlert -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/core-js/2.4.1/core.js"></script>
  <!-- Library for adding dinamically elements -->
  <script src="/php_tutorial/assets/js/plugins/arrive.min.js"></script>
  <!--  Google Maps Plugin    -->
  <script src="https://maps.googleapis.com/maps/api/js?key=YOUR_KEY_HERE"></script>
  <!-- Chartist JS -->
  <script src="/php_tutorial/assets/js/plugins/chartist.min.js"></script>
  <!--  Notifications Plugin    -->
  <script src="/php_tutorial/assets/js/plugins/bootstrap-notify.js"></script>
  <!-- Control Center for Material Dashboard: parallax effects, scripts for the example pages etc -->
  <script src="/php_tutorial/assets/js/material-dashboard.js?v=2.2.2" type="text/javascript"></script>
  <!-- Material Dashboard DEMO methods, don't include it in your project! -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.1.4/toastr.min.js"></script>

  <script>
    $('#changeProfileForm').on('submit', function(e) {
      e.preventDefault();
      var data = new FormData($(this)[0]);
      data.append('action', 'changeProfile');
      var form = $(this);
      form.find(':submit').attr('disabled', true);
      var url = "/php_tutorial/profile.php";
      $.ajax({
        type: 'POST',
        url: url,
        data: data,
        dataType: 'JSON',
        processData: false,
        contentType: false,
        error: function(xhr, textStatus, errorThrown) {
          console.log(xhr.responseText);
        },
        success: function(response) {
          console.log(response);
          form.find(':submit').attr('disabled', false);
          if (response.error_status == 1) {
            form.find('small').text('');
            // If validation error exists
            for (var key in response) {
              var errorContainer = form.find(`#${key}Error`);
              if (errorContainer.length !== 0) {
                errorContainer.html(response[key]);
              }
            }
          }
          if (response.status == 1) {
            toastr.success(response.msg);
            // handling success respone
            setTimeout(function() {
              window.location.href = '/php_tutorial/dashboard.php';
            }, 2000)
          } else if (response.status == 0) {
            // Handling failure response
            console.login(response.msg);
          }
        }
      });
    });
  </script>
</body>

</html>