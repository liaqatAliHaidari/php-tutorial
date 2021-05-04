<?php
// include 'connection.php';

// $sql = "Select * from users where id = 1";
// $result = $conn->query($sql);
// $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
// echo json_encode($row);
// die();
if (isset($_POST['action']) == 'register') {
  include 'connection.php';
  $name = $_POST['name'];
  $email = $_POST['email'];
  $password = $_POST['password'];
  $cPassword = $_POST['cPassword'];


  // validation
  $error = array(
    'error_status' => 0
  );
  if (empty($name)) {
    $error['error_status'] = 1;
    $error['name'] = 'Name is required!';
  }
  if (empty($email)) {
    $error['error_status'] = 1;
    $error['email'] = 'Email is required!';
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

  // validation successfully
  $hashed_password = md5($password);
  $qry = "INSERT INTO users (name,email,password) VALUES('" . $name . "','" . $email . "','" . $hashed_password . "')";
  $result = $conn->query($qry);

  if ($result) {
    $response = array(
      'status' => 1,
      'msg' => 'Registration completed successfully!'
    );
  } else {
    $response = array(
      'status' => 0,
      'msg' => 'Registration Failed!'
    );
  }
  echo json_encode($response);
  exit();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <link rel="apple-touch-icon" sizes="76x76" href="assets/img/apple-icon.png">
  <link rel="icon" type="image/png" href="assets/img/favicon.png">
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
  <title>
    Register
  </title>
  <meta content='width=device-width, initial-scale=1.0, shrink-to-fit=no' name='viewport' />
  <!--     Fonts and icons     -->
  <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700|Roboto+Slab:400,700|Material+Icons" />
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css">
  <!-- CSS Files -->
  <link href="assets/css/material-dashboard.css?v=2.2.2" rel="stylesheet" />
  <!-- CSS Just for demo purpose, don't include it in your project -->
  <link href="assets/demo/demo.css" rel="stylesheet" />
  <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.1.4/toastr.min.css" />
</head>

<body class="off-canvas-sidebar">
  <!-- Navbar -->
  <nav class="navbar navbar-expand-lg navbar-transparent navbar-absolute fixed-top text-white">
    <div class="container">
      <div class="navbar-wrapper">
        <a class="navbar-brand" href="javascript:;">Login Page</a>
      </div>
      <button class="navbar-toggler" type="button" data-toggle="collapse" aria-controls="navigation-index" aria-expanded="false" aria-label="Toggle navigation">
        <span class="sr-only">Toggle navigation</span>
        <span class="navbar-toggler-icon icon-bar"></span>
        <span class="navbar-toggler-icon icon-bar"></span>
        <span class="navbar-toggler-icon icon-bar"></span>
      </button>
      <div class="collapse navbar-collapse justify-content-end">
        <ul class="navbar-nav">
          <li class="nav-item active">
            <a href="/php_tutorial/register.php" class="nav-link">
              <i class="material-icons">person_add</i>
              Register
            </a>
          </li>
          <li class="nav-item">
            <a href="/php_tutorial/login.php" class="nav-link">
              <i class="material-icons">fingerprint</i>
              Login
            </a>
          </li>
        </ul>
      </div>
    </div>
  </nav>
  <!-- End Navbar -->
  <div class="wrapper wrapper-full-page">
    <div class="page-header login-page header-filter" filter-color="black" style="background-image: url('assets/img/login.jpg'); background-size: cover; background-position: top center;">
      <div class="container">
        <div class="row">
          <div class="col-lg-4 col-md-6 col-sm-8 ml-auto mr-auto">
            <form class="form" method="" action="" id="registrationForm">
              <div class="card card-login card-hidden">
                <div class="card-header card-header-rose text-center">
                  <h4 class="card-title">Registration</h4>
                  <div class="social-line">
                    <a href="#pablo" class="btn btn-just-icon btn-link btn-white">
                      <i class="fa fa-facebook-square"></i>
                    </a>
                    <a href="#pablo" class="btn btn-just-icon btn-link btn-white">
                      <i class="fa fa-twitter"></i>
                    </a>
                    <a href="#pablo" class="btn btn-just-icon btn-link btn-white">
                      <i class="fa fa-google-plus"></i>
                    </a>
                  </div>
                </div>
                <div class="card-body ">
                  <p class="card-description text-center">Or Be Classical</p>
                  <span class="bmd-form-group">
                    <div class="input-group">
                      <div class="input-group-prepend">
                        <span class="input-group-text">
                          <i class="material-icons">face</i>
                        </span>
                      </div>
                      <input type="text" name="name" class="form-control" placeholder="First Name...">
                    </div>
                    <small class="text-danger ml-5" id="nameError"></small>
                  </span>
                  <span class="bmd-form-group">
                    <div class="input-group">
                      <div class="input-group-prepend">
                        <span class="input-group-text">
                          <i class="material-icons">email</i>
                        </span>
                      </div>
                      <input type="email" name="email" class="form-control" placeholder="Email...">
                    </div>
                    <small class="text-danger ml-5" id="emailError"></small>
                  </span>
                  <span class="bmd-form-group">
                    <div class="input-group">
                      <div class="input-group-prepend">
                        <span class="input-group-text">
                          <i class="material-icons">lock_outline</i>
                        </span>
                      </div>
                      <input type="password" name="password" class="form-control" placeholder="Password...">
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
                      <input type="password" name="cPassword" class="form-control" placeholder="Confirm Password...">
                    </div>
                    <small class="text-danger ml-5" id="cPasswordError"></small>
                  </span>
                </div>
                <div class="card-footer justify-content-center">
                  <button type="submit" href="#pablo" class="btn btn-success btn-block">Register</button>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
      <footer class="footer">
        <div class="container">
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
  <script src="assets/js/core/jquery.min.js"></script>
  <script src="assets/js/core/popper.min.js"></script>
  <script src="assets/js/core/bootstrap-material-design.min.js"></script>
  <script src="assets/js/plugins/perfect-scrollbar.min.js"></script>
  <!--  Notifications Plugin    -->
  <script src="assets/js/plugins/bootstrap-notify.js"></script>
  <!-- Control Center for Material Dashboard: parallax effects, scripts for the example pages etc -->
  <script src="assets/js/material-dashboard.js?v=2.2.2" type="text/javascript"></script>
  <!-- Material Dashboard DEMO methods, don't include it in your project! -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.1.4/toastr.min.js"></script>

  <script>
    $(document).ready(function() {
      md.checkFullPageBackgroundImage();
      setTimeout(function() {
        // after 1000 ms we add the class animated to the login/register card
        $('.card').removeClass('card-hidden');
      }, 700);
    });
  </script>
  <script>
    $('#registrationForm').on('submit', function(e) {
      e.preventDefault();
      var data = new FormData($(this)[0]);
      data.append('action', 'register');
      var form = $(this);
      form.find(':submit').attr('disabled', true);
      var url = "/php_tutorial/register.php";
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
          form.find(':submit').attr('disabled', false);
          if (response.error_status = 1) {
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
            toastr.success(response.msg);
            setTimeout(function() {
              window.location.href = '/php_tutorial/login.php'
            })
          } else if (response.status == 0) {
            // Handling failure response
            toastr.error(response.msg);
          }
        }
      });
    });
  </script>
</body>

</html>