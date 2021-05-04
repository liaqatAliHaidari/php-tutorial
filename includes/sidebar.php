<?php
if (isset($_SESSION['user_data'])) {
  $name = $_SESSION['user_data']['name'];
  $email = $_SESSION['user_data']['email'];
  $profile = $_SESSION['user_data']['profile'];
}
?>
<div class="sidebar" data-color="rose" data-background-color="black" data-image="/php_tutorial/assets/img/sidebar-1.jpg">
  <div class="logo"><a href="http://www.creative-tim.com" class="simple-text logo-mini">
      CT
    </a>
    <a href="http://www.creative-tim.com" class="simple-text logo-normal">
      Creative Tim
    </a>
  </div>
  <div class="sidebar-wrapper">
    <div class="user">
      <div class="photo">
        <?php if ($profile == '') { ?>
          <img src="/php_tutorial/assets/img/faces/avatar.jpg" alt="...">
        <?php } else { ?>
          <img src="/php_tutorial/assets/images/uploads/<?php echo $profile ?>" alt="...">
        <?php } ?>
      </div>
      <div class="user-info">
        <a data-toggle="collapse" href="#collapseExample" class="username">
          <span>
            <?php echo $name ?>
            <b class="caret"></b>
          </span>
        </a>
        <div class="collapse" id="collapseExample">
          <ul class="nav">
            <li class="nav-item">
              <a class="nav-link" href="/php_tutorial/profile.php">
                <span class="sidebar-mini"> MP </span>
                <span class="sidebar-normal"> My Profile </span>
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="/php_tutorial/change_password.php">
                <span class="sidebar-mini"> EP </span>
                <span class="sidebar-normal"> Edit Profile </span>
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="#">
                <span class="sidebar-mini"> S </span>
                <span class="sidebar-normal"> Settings </span>
              </a>
            </li>
          </ul>
        </div>
      </div>
    </div>
    <ul class="nav">
      <li class="nav-item active ">
        <a class="nav-link" href="../examples/dashboard.html">
          <i class="material-icons">dashboard</i>
          <p> Dashboard </p>
        </a>
      </li>
      <li class="nav-item ">
        <a class="nav-link" data-toggle="collapse" href="#pagesExamples">
          <i class="material-icons">image</i>
          <p> Pages
            <b class="caret"></b>
          </p>
        </a>
        <div class="collapse" id="pagesExamples">
          <ul class="nav">
            <li class="nav-item ">
              <a class="nav-link" href="../examples/pages/pricing.html">
                <span class="sidebar-mini"> P </span>
                <span class="sidebar-normal"> Pricing </span>
              </a>
            </li>
            <li class="nav-item ">
              <a class="nav-link" href="../examples/pages/rtl.html">
                <span class="sidebar-mini"> RS </span>
                <span class="sidebar-normal"> RTL Support </span>
              </a>
            </li>
            <li class="nav-item ">
              <a class="nav-link" href="../examples/pages/timeline.html">
                <span class="sidebar-mini"> T </span>
                <span class="sidebar-normal"> Timeline </span>
              </a>
            </li>
            <li class="nav-item ">
              <a class="nav-link" href="../examples/pages/login.html">
                <span class="sidebar-mini"> LP </span>
                <span class="sidebar-normal"> Login Page </span>
              </a>
            </li>
            <li class="nav-item ">
              <a class="nav-link" href="../examples/pages/register.html">
                <span class="sidebar-mini"> RP </span>
                <span class="sidebar-normal"> Register Page </span>
              </a>
            </li>
            <li class="nav-item ">
              <a class="nav-link" href="../examples/pages/lock.html">
                <span class="sidebar-mini"> LSP </span>
                <span class="sidebar-normal"> Lock Screen Page </span>
              </a>
            </li>
            <li class="nav-item ">
              <a class="nav-link" href="../examples/pages/user.html">
                <span class="sidebar-mini"> UP </span>
                <span class="sidebar-normal"> User Profile </span>
              </a>
            </li>
            <li class="nav-item ">
              <a class="nav-link" href="../examples/pages/error.html">
                <span class="sidebar-mini"> E </span>
                <span class="sidebar-normal"> Error Page </span>
              </a>
            </li>
          </ul>
        </div>
      </li>
    </ul>
  </div>
  <div class="sidebar-background"></div>
</div>