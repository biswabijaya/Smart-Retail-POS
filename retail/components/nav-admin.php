<nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top" id="mainNav">
  <a class="navbar-brand" href="index.php"> <img src="logo.png" width="150px" alt="Shanti Fresh"></a>
  <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" id="navbarResponsive">
    <ul class="navbar-nav navbar-sidenav" id="nav-sidebar" style="padding-top:7px;">
      <?php if ($_SESSION['usertype']=='admin'): ?>
        <li class="nav-item <?php if($active=='overview.php') echo " active "; ?>" data-toggle="tooltip" data-placement="right" title="Overview">
          <a class="nav-link" href="overview.php">
            <i class="fa fa-fw fa-shopping-bag"></i>
            <span class="nav-link-text">Optimize</span>
          </a>
        </li>
      <?php endif; ?>
      <li class="nav-item <?php if($active=='sales.php') echo " active "; ?>" data-toggle="tooltip" data-placement="right" title="Sales">
        <a class="nav-link" href="sales.php">
          <i class="fa fa-fw fa-shopping-bag"></i>
          <span class="nav-link-text">Sales</span>
        </a>
      </li>
      <li class="nav-item <?php if($active=='purchases.php') echo " active "; ?>" data-toggle="tooltip" data-placement="right" title="Purchase">
        <a class="nav-link" href="purchases.php">
          <i class="fa fa-fw fa-bitbucket"></i>
          <span class="nav-link-text">Purchase</span>
        </a>
      </li>
      <li class="nav-item <?php if($active=='expenses.php') echo " active "; ?>" data-toggle="tooltip" data-placement="right" title="Expenses">
        <a class="nav-link" href="expenses.php">
          <i class="fa fa-fw fa-file-text"></i>
          <span class="nav-link-text">Expenses</span>
        </a>
      </li>
      <li class="nav-item <?php if($active=='products.php') echo " active "; ?>" data-toggle="tooltip" data-placement="right" title="Stock">
        <a class="nav-link" href="products.php">
          <i class="fa fa-fw fa-cubes"></i>
          <span class="nav-link-text">Stock</span>
        </a>
      </li>
      <li class="nav-item <?php if($active=='stores.php') echo " active "; ?>" data-toggle="tooltip" data-placement="right" title="Stores">
        <a class="nav-link" href="stores.php">
          <i class="fa fa-fw fa-archive"></i>
          <span class="nav-link-text">Stores</span>
        </a>
      </li>
      <li class="nav-item <?php if($active=='hsn.php') echo " active "; ?>" data-toggle="tooltip" data-placement="right" title="HSN Search">
        <a class="nav-link" href="hsn.php">
          <i class="fa fa-fw fa-search"></i>
          <span class="nav-link-text">HSN</span>
        </a>
      </li>
      <li class="nav-item <?php if($active=='reports.php') echo " active "; ?>" data-toggle="tooltip" data-placement="right" title="Reports">
        <a class="nav-link" href="reports.php">
          <i class="fa fa-fw fa-pie-chart"></i>
          <span class="nav-link-text">Reports</span>
        </a>
      </li>
      <li class="nav-item <?php if($active=='staffs.php') echo " active "; ?>" data-toggle="tooltip" data-placement="right" title="Staffs">
        <a class="nav-link" href="staffs.php">
          <i class="fa fa-fw fa-address-card"></i>
          <span class="nav-link-text">Staffs</span>
        </a>
      </li>
      <li class="nav-item <?php if($active=='customers.php') echo " active "; ?>" data-toggle="tooltip" data-placement="right" title="Customers">
        <a class="nav-link" href="customers.php">
          <i class="fa fa-fw fa-users"></i>
          <span class="nav-link-text">Customers</span>
        </a>
      </li>
      <li class="nav-item <?php if($active=='suppliers.php') echo " active "; ?>" data-toggle="tooltip" data-placement="right" title="Suppliers">
        <a class="nav-link" href="suppliers.php">
          <i class="fa fa-fw fa-exchange"></i>
          <span class="nav-link-text">Suppliers</span>
        </a>
      </li>
      <li class="nav-item <?php if($active=='settings.php') echo " active "; ?>" data-toggle="tooltip" data-placement="right" title="Company Settings">
        <a class="nav-link" href="settings.php">
          <i class="fa fa-fw fa-cog"></i>
          <span class="nav-link-text">Settings</span>
        </a>
      </li>
    </ul>
    <ul class="navbar-nav sidenav-toggler">
      <li class="nav-item">
        <a class="nav-link text-center" id="sidenavToggler">
          <i class="fa fa-fw fa-angle-left"></i>
        </a>
      </li>
    </ul>
    <ul class="navbar-nav ml-auto">
      <li class="nav-item <?php if($active=='') echo " active "; ?> dropdown">
        <a class="nav-link dropdown-toggle mr-lg-2" id="messagesDropdown" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          <i class="fa fa-fw fa-envelope"></i>
          <span class="d-lg-none">Messages
            <span class="badge badge-pill badge-primary">12 New</span>
          </span>
          <span class="indicator text-primary d-none d-lg-block">
            <i class="fa fa-fw fa-circle"></i>
          </span>
        </a>
        <div class="dropdown-menu" aria-labelledby="messagesDropdown">
          <h6 class="dropdown-header">New Messages:</h6>
          <div class="dropdown-divider"></div>
          <a class="dropdown-item" href="#">
            <strong>David Miller</strong>
            <span class="small float-right text-muted">11:21 AM</span>
            <div class="dropdown-message small">Hey there! This new version of SB Admin is pretty awesome! These messages clip off when they reach the end of the box so they don't overflow over to the sides!</div>
          </a>
          <div class="dropdown-divider"></div>
          <a class="dropdown-item" href="#">
            <strong>Jane Smith</strong>
            <span class="small float-right text-muted">11:21 AM</span>
            <div class="dropdown-message small">I was wondering if you could meet for an appointment at 3:00 instead of 4:00. Thanks!</div>
          </a>
          <div class="dropdown-divider"></div>
          <a class="dropdown-item" href="#">
            <strong>John Doe</strong>
            <span class="small float-right text-muted">11:21 AM</span>
            <div class="dropdown-message small">I've sent the final files over to you for review. When you're able to sign off of them let me know and we can discuss distribution.</div>
          </a>
          <div class="dropdown-divider"></div>
          <a class="dropdown-item small" href="#">View all messages</a>
        </div>
      </li>
      <li class="nav-item <?php if($active=='') echo " active "; ?> dropdown">
        <a class="nav-link dropdown-toggle mr-lg-2" id="alertsDropdown" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          <i class="fa fa-fw fa-bell"></i>
          <span class="d-lg-none">Alerts
            <span class="badge badge-pill badge-warning">6 New</span>
          </span>
          <span class="indicator text-warning d-none d-lg-block">
            <i class="fa fa-fw fa-circle"></i>
          </span>
        </a>
        <div class="dropdown-menu" aria-labelledby="alertsDropdown">
          <h6 class="dropdown-header">New Alerts:</h6>
          <div class="dropdown-divider"></div>
          <a class="dropdown-item" href="#">
            <span class="text-success">
              <strong>
                <i class="fa fa-long-arrow-up fa-fw"></i>Status Update</strong>
            </span>
            <span class="small float-right text-muted">11:21 AM</span>
            <div class="dropdown-message small">This is an automated server response message. All systems are online.</div>
          </a>
          <div class="dropdown-divider"></div>
          <a class="dropdown-item" href="#">
            <span class="text-danger">
              <strong>
                <i class="fa fa-long-arrow-down fa-fw"></i>Status Update</strong>
            </span>
            <span class="small float-right text-muted">11:21 AM</span>
            <div class="dropdown-message small">This is an automated server response message. All systems are online.</div>
          </a>
          <div class="dropdown-divider"></div>
          <a class="dropdown-item" href="#">
            <span class="text-success">
              <strong>
                <i class="fa fa-long-arrow-up fa-fw"></i>Status Update</strong>
            </span>
            <span class="small float-right text-muted">11:21 AM</span>
            <div class="dropdown-message small">This is an automated server response message. All systems are online.</div>
          </a>
          <div class="dropdown-divider"></div>
          <a class="dropdown-item small" href="#">View all alerts</a>
        </div>
      </li>
      <li class="nav-item <?php if($active=='') echo " active "; ?>">
        <form class="form-inline my-2 my-lg-0 mr-lg-2" method="GET" action="product.php">
          <div class="input-group">
            <input class="form-control" name="sku" type="number" placeholder="Search Order / Product">
            <input name="action" type="hidden" value="view">
            <span class="input-group-append">
              <button class="btn btn-primary" type="button">
                <i class="fa fa-search"></i>
              </button>
            </span>
          </div>
        </form>
      </li>
      <li class="nav-item <?php if($active=='') echo " active "; ?>">
        <a class="nav-link" data-toggle="modal" data-target="#logoutmodal">
          <i class="fa fa-fw fa-sign-out"></i>Logout</a>
      </li>
    </ul>
  </div>
</nav>
