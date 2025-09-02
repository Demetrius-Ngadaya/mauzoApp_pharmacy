	
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="#" class="brand-link">   
      <H1><span class="brand-text font-weight-light"> MauzoApp</span></H1>
    </a>
    <!-- Sidebar -->  
    <div class="sidebar"> 
      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
          <li class="nav-item has-treeview menu-open">
            <a href="index.php" class="nav-link active">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>
                Nyumbani               
              </p>
            </a>
          </li>
          
          <li class="nav-item has-treeview">
            <a href="dashboard.php" class="nav-link">
              <i class="nav-icon fas fa-inbox"></i>
              <p>
            Mauzo
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="home.php?invoice_number=<?php echo $_GET['invoice_number']?>" class="nav-link">
                  &nbsp;&nbsp;&nbsp;<i class="fa fa-table"></i>

                  &nbsp;&nbsp;<p>Fanya mauzo</p>
                </a>
              </li>
              <li class="nav-item">
                  <a href="return_product.php?invoice_number=CA-2390900" class="nav-link">
                      &nbsp;&nbsp;&nbsp;<i class="fa fa-users"></i>
                      &nbsp;&nbsp;<p>Rudisha Dawa</p>
                  </a>
              </li> 
              <li class="nav-item">
                  <a href="bidhaa_zilizoharibika.php?invoice_number=CA-2390900" class="nav-link">
                      &nbsp;&nbsp;&nbsp;<i class="fa fa-users"></i>
                      &nbsp;&nbsp;<p>Zilizo haribika</p>
                  </a>
              </li>     
              <li class="nav-item">
                   <a href="all_sales.php?invoice_number=CA-2390900" class="nav-link">
                       &nbsp;&nbsp;&nbsp;<i class="fa fa-users"></i>
                       &nbsp;&nbsp;<p>Mauzo yote</p>
                   </a>
              </li> 
              <li class="nav-item">
                   <a href="bidhaa_20_zilizoingiza_pesa_nyingi.php?invoice_number=CA-2390900" class="nav-link">
                       &nbsp;&nbsp;&nbsp;<i class="fa fa-users"></i>
                       &nbsp;&nbsp;<p>20 bora</p>
                   </a>
              </li> 
              <li class="nav-item">
                   <a href="bidhaa_20_zisizoingiza_pesa_nyingi.php?invoice_number=CA-2390900" class="nav-link">
                       &nbsp;&nbsp;&nbsp;<i class="fa fa-users"></i>
                       &nbsp;&nbsp;<p>20 sio bora</p>
                   </a>
              </li>  
              </li>  
              <li class="nav-item">
                <a href="Zilizouzika_kidogo.php?invoice_number" class="nav-link">
                &nbsp;&nbsp;&nbsp;<i class="fa fa-inbox"></i>
                  &nbsp;&nbsp;<p>zilizouzika kidogo</p>
                </a>
              </li> 
              </li>  
              <li class="nav-item">
                <a href="zilizouzika_sana.php?invoice_number" class="nav-link">
                &nbsp;&nbsp;&nbsp;<i class="fa fa-inbox"></i>
                  &nbsp;&nbsp;<p>zilizouzika sana</p>
                </a>
              </li> 
              <li class="nav-item">
                <a href="never_sold_products.php?invoice_number" class="nav-link">
                &nbsp;&nbsp;&nbsp;<i class="fa fa-inbox"></i>
                  &nbsp;&nbsp;<p>Hazijawahi kuuzwa</p>
                </a>
              </li>         
              <li class="nav-item">
                <a href="view.php?invoice_number" class="nav-link">
                &nbsp;&nbsp;&nbsp;<i class="fa fa-inbox"></i>
                  &nbsp;&nbsp;<p>Ziangalie Dawa</p>
                </a>
              </li>           
            </ul>
          </li>
          <li class="nav-item has-treeview">
            <a href="#" class="nav-link">
              <i class="nav-icon fa fa-table"></i>
              <p>
              Dawa
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
            <li class="nav-item">
                <a href="view.php?invoice_number" class="nav-link">
                &nbsp;&nbsp;&nbsp;<i class="fa fa-inbox"></i>
                  &nbsp;&nbsp;<p>Ziangalie Dawa</p>
                </a>
              </li>  
            <li class="nav-item"> 
                <a href="new_product.php?invoice_number" class="nav-link">
                &nbsp;&nbsp;&nbsp;<i class="fa fa-inbox"></i>
                  &nbsp;&nbsp;<p>Ongeza Dawa</p>
                </a>
              </li>  
            <li class="nav-item">
                <a href="qty_alert.php" class="nav-link">
                &nbsp;&nbsp;&nbsp;<i class="fa fa-table"></i>
                  &nbsp;&nbsp;<p>Zinazokaribia kuisha</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="out_of_stock.php" class="nav-link">
                &nbsp;&nbsp;&nbsp;<i class="fa fa-table"></i>
                  &nbsp;&nbsp;<p>Zilizoisha</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="ex_alert.php" class="nav-link">
                &nbsp;&nbsp;&nbsp;<i class="fa fa-table"></i>
                  &nbsp;&nbsp;<p>Zinazokaribia ku expire</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="diplomaTestSchedule.php" class="nav-link">
                &nbsp;&nbsp;&nbsp;<i class="fa fa-table"></i>
                  &nbsp;&nbsp;<p>zilizo expire</p>
                </a>
              </li>
            </ul>
          </li>
          
          <li class="nav-item has-treeview">
            <a href="#" class="nav-link">
              <i class="nav-icon fa fa-table"></i>
              <p>
                Matumizi
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
            <li class="nav-item">
                <a href="expenditure.php" class="nav-link">
                &nbsp;&nbsp;&nbsp;<i class="fa fa-table"></i>
                  &nbsp;&nbsp;<p>Rekodi matumizi</p>
                </a>
              </li>
            </ul>
          </li>
          
          <li class="nav-item has-treeview">
            <a href="#" class="nav-link">
              <i class="nav-icon fa fa-table"></i>
              <p>
                Ripoti
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
            <li class="nav-item">
                <a href="expenditure.php" class="nav-link">
                &nbsp;&nbsp;&nbsp;<i class="fa fa-table"></i>
                  &nbsp;&nbsp;<p>Ripoti ya Matumizi</p>
                </a>
              </li>
              <li class="nav-item">
              <a href="sales_report.php?invoice_number=CA-2390900" class="nav-link">
                &nbsp;&nbsp;&nbsp;<i class="fa fa-table"></i>
                  &nbsp;&nbsp;<p>Ripoti ya Mauzo</p>
                </a>
              </li>
              </li>
              <li class="nav-item">
                <a href="profit_graph.php" class="nav-link">
                &nbsp;&nbsp;&nbsp;<i class="fa fa-table"></i>
                  &nbsp;&nbsp;<p>Graph ya faida</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="expenditure_graph.php" class="nav-link">
                &nbsp;&nbsp;&nbsp;<i class="fa fa-table"></i>
                  &nbsp;&nbsp;<p>Graph ya matumizi</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="total_sales_graph.php" class="nav-link">
                &nbsp;&nbsp;&nbsp;<i class="fa fa-table"></i>
                  &nbsp;&nbsp;<p>Graph ya mauzo</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="business_analysis.php" class="nav-link">
                &nbsp;&nbsp;&nbsp;<i class="fa fa-table"></i>
                  &nbsp;&nbsp;<p>Uchambuzi biashara</p>
                </a>
              </li>
            </ul>
          </li>
          <li class="nav-item has-treeview">
            <a href="#" class="nav-link">
              <i class="nav-icon fa fa-table"></i>
              <p>
                Settings
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
            <li class="nav-item">
                <a href="user_management.php" class="nav-link">
                &nbsp;&nbsp;&nbsp;<i class="fa fa-table"></i>
                  &nbsp;&nbsp;<p>Watumiaji</p>
                </a>
              </li>
            </ul>
          </li>
          <li class="nav-item has-treeview">
          <a href="logout.php" class="nav-link">
                &nbsp;&nbsp;&nbsp;<i class="fa fa-power-off"></i>
                  &nbsp;&nbsp;&nbsp;<p>Ondoka</p>
                </a>
              </li>
            </ul>
          </li>
        </ul>
      </nav>

      