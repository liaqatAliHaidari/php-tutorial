<?php

session_start();
if (isset($_SESSION['user_data'])) {
  if (isset($_POST['action']) == 'changePassword') {
    include 'connection.php';

    $oldPassword = $_POST['oldPassword'];
    $password = $_POST['password'];
    $cPassword = $_POST['cPassword'];

    // validation
    $error = array(
      'error_status' => 0
    );
    if (empty($oldPassword)) {
      $error['error_status'] = 1;
      $error['oldPassword'] = 'Old Password is required!';
    }
    if (empty($password)) {
      $error['error_status'] = 1;
      $error['password'] = 'Password is required!';
    }
    if (!empty($password)) {
      if (strlen($password) < 5) {
        $error['error_status'] = 1;
        $error['password'] = 'Password must be at least 5 characters!';
      }
    }
    if (!empty($password)) {
      if (empty($cPassword)) {
        $error['error_status'] = 1;
        $error['cPassword'] = 'Confirm Password is required!';
      }
    }
    if (!empty($password) && !empty($cPassword)) {
      if ($password != $cPassword) {
        $error['error_status'] = 1;
        $error['cPassword'] = 'Password and Confirm Password are not the same';
      }
    }
    if ($error['error_status'] > 0) {
      echo json_encode($error);
      exit();
    }

    // if validation is successful
    $email = $_SESSION['user_data']['email'];

    $hashed_password = md5($oldPassword);
    $new_hashed_password = md5($password);
    $qry = "Select * from users where email = '" . $email . "' and password = '" . $hashed_password . "'";
    $result = $conn->query($qry);
    $row = mysqli_fetch_array($result, MYSQLI_ASSOC);

    $count = mysqli_num_rows($result);
    if ($count == 1) {
      // user exists we will update the password
      $qry = "Update users set password = '" . $new_hashed_password . "' Where email = '" . $email . "'";
      $result = $conn->query($qry);
      if ($result) {
        // destroy the user session
        session_destroy();
        $response = array(
          'status' => 1,
          'msg' => 'password changed successfully successful'
        );
      } else {
        $response = array(
          'status' => 0,
          'msg' => 'Changing password failed!'
        );
      }
    } else {
      $error['error_status'] = 1;
      $error['oldPassword'] = 'Invalid Old Password';
      if ($error['error_status'] > 0) {
        echo json_encode($error);
        exit();
      }
    }
    echo json_encode($response);
    exit();
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
    change password
  </title>
  <meta content='width=device-width, initial-scale=1.0, shrink-to-fit=no' name='viewport' />
  <!--     Fonts and icons     -->
  <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700|Roboto+Slab:400,700|Material+Icons" />
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css">
  <!-- CSS Files -->
  <link href="/php_tutorial/assets/css/material-dashboard.css?v=2.2.2" rel="stylesheet" />
  <!-- CSS Just for demo purpose, don't include it in your project -->
  <link href="/php_tutorial/assets/demo/demo.css" rel="stylesheet" />
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
            <div class="row">
              <div class="col-lg-4 col-md-6 col-sm-8 ml-auto mr-auto">
                <form class="form" method="" action="" id="changePasswordForm">
                  <div class="card card-login card-hidden">
                    <div class="card-header card-header-rose text-center">
                      <h4 class="card-title">Change Password</h4>
                    </div>
                    <div class="card-body ">
                      <span class="bmd-form-group">
                        <div class="input-group">
                          <div class="input-group-prepend">
                            <span class="input-group-text">
                              <i class="material-icons">lock_outline</i>
                            </span>
                          </div>
                          <input type="password" name="oldPassword" class="form-control" placeholder="Old Password...">
                        </div>
                        <small class="text-danger ml-5" id="oldPasswordError"></small>
                      </span>
                      <span class="bmd-form-group">
                        <div class="input-group">
                          <div class="input-group-prepend">
                            <span class="input-group-text">
                              <i class="material-icons">lock_outline</i>
                            </span>
                          </div>
                          <input type="password" name="password" class="form-control" placeholder="New Password...">
                        </div>
                        <small class="text-danger ml-5" id="passwordError"></small>
                      </span>
                      <span class="bmd-form-group">
                        <div class="input-group">
                          <div class="input-group-prepend">
                            <span class="input-group-text">
                              <i class="material-icons">lock_outline</i>
                            </span>
                          </div>
                          <input type="password" name="cPassword" class="form-control" placeholder="Confirm New Password...">
                        </div>
                        <small class="text-danger ml-5" id="cPasswordError"></small>
                      </span>
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
  <script>
    $('#changePasswordForm').on('submit', function(e) {
      e.preventDefault();
      var data = new FormData($(this)[0]);
      data.append('action', 'changePassword');
      var form = $(this);
      form.find(':submit').attr('disabled', true);
      var url = "/php_tutorial/change_password.php";
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
            form.trigger('reset');
            form.find('small').text('');
            // handling success respone
            window.location.href = '/php_tutorial/login.php';
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