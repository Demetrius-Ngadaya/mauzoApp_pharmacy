
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="adminDashboard.php" class="brand-link">
      <!-- <img src="dist/img/avatar.png" alt="sfuchas Logo" class="brand-image img-circle elevation-3"
           style="opacity: .8"> -->
      <span class="brand-text font-weight-light">
      <?php  if (isset($_SESSION['username'])) : ?> 
                <strong>
                    <?php echo $_SESSION['username']; ?>
                </strong>
        <?php endif ?>
      </span>
    </a>
    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <!-- <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img src="dist/img/sfuchaslogo.jpeg" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
          <a href="#" class="d-block">Alexander Pierce</a>
        </div>
      </div> -->

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
          <li class="nav-item has-treeview menu-open">
            <a href="#" class="nav-link active">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>
                Dashboard                
              </p>
            </a>
          </li>
          
          <li class="nav-item has-treeview">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-book"></i>
              <p>
                Sells
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="home.php?invoice_number=<?php echo $_GET['invoice_number']?>" class="nav-link">
                  &nbsp;&nbsp;&nbsp;<i class="fa fa-user"></i>
                  &nbsp;&nbsp;<p>Sell product</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="#" class="nav-link">
                &nbsp;&nbsp;&nbsp;<i class="icon-bar-chart"></i>
                  &nbsp;&nbsp;<p>Sales report</p>
                </a>
              </li>
                           
            </ul>
          </li>
          <li class="nav-item has-treeview">
            <a href="#" class="nav-link">
              <i class="nav-icon fa fa-table"></i>
              <p>
              Medicines
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
            <li class="nav-item">
                <a href="#" class="nav-link">
                &nbsp;&nbsp;&nbsp;<i class="fa fa-table"></i>
                  &nbsp;&nbsp;<p>List of medicines</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="#" class="nav-link">
                &nbsp;&nbsp;&nbsp;<i class="fa fa-table"></i>
                  &nbsp;&nbsp;<p>6 months to expire</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="#" class="nav-link">
                &nbsp;&nbsp;&nbsp;<i class="fa fa-table"></i>
                  &nbsp;&nbsp;<p>Expired medicines</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="" class="nav-link">
                &nbsp;&nbsp;&nbsp;<i class="fa fa-table"></i>
                  &nbsp;&nbsp;<p>Stock alert</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="#" class="nav-link">
                &nbsp;&nbsp;&nbsp;<i class="fa fa-table"></i>
                  &nbsp;&nbsp;<p>Zero quantity</p>
                </a>
              </li>
            </ul>
          </li>
          <li class="nav-item has-treeview">
            <a href="#" class="nav-link">
              <i class="nav-icon fa fa-box"></i>
              <p>
                Settings
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
            <li class="nav-item">
                <a href="#" class="nav-link">
                &nbsp;&nbsp;&nbsp;<i class="fa fa-users"></i>
                  &nbsp;&nbsp;<p>Users</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="logout.php" class="nav-link">
                &nbsp;&nbsp;&nbsp;<i class="fa fa-power-off"></i>
                  &nbsp;&nbsp;<p>log out</p>
                </a>
              </li>
            </ul>
          </li>
        </ul>
      </nav>

      