<!-- Sidebar -->
<aside class="main-sidebar sidebar-dark-primary elevation-4 fixed" style="position: fixed;">
  <a href="index.php" class="brand-link">
    <h1 class="brand-text font-weight-light">MauzoApp</h1>
  </a>
  <div class="sidebar">
    <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">

          
             <li class="nav-item has-treeview">
                <a href="#" class="nav-link">
                 <i class="nav-icon fas fa-shopping-cart"></i>
              <p>
                Mauzo
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
            <li class="nav-item">
                <a href="cashierPOS.php?invoice_number=<?php echo $_GET['invoice_number']?>" class="nav-link">
                &nbsp;&nbsp;&nbsp;<i class="fas fa-cart-plus"></i>
                  &nbsp;&nbsp;<p>Uza Dawa</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="cashier_uza_kwa_mkopo.php?invoice_number=<?php echo $_GET['invoice_number']?>" class="nav-link">
                &nbsp;&nbsp;&nbsp;<i class="fas fa-cart-plus"></i>
                  &nbsp;&nbsp;<p>Uza kwa mkopo</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="cashier_pending_sells.php?invoice_number=<?php echo $_GET['invoice_number']?>" class="nav-link">
                &nbsp;&nbsp;&nbsp;<i class="fas fa-cart-plus"></i>
                  &nbsp;&nbsp;<p>Mauzo yasio kamilika</p>
                </a>
              </li>
              <!-- <li class="nav-item">
                  <a href="cashier_customer_order.php?invoice_number=<?php echo $_GET['invoice_number']?>" class="nav-link">
                      &nbsp;&nbsp;&nbsp;<i class="fas fa-fas fa-cart-plus"></i>
                      &nbsp;&nbsp;<p>Oda za wateja</p>
                  </a>
              </li> -->
              <!-- <li class="nav-item">
                  <a href="return_product.php?invoice_number=<?php echo $_GET['invoice_number']?>" class="nav-link">
                      &nbsp;&nbsp;&nbsp;<i class="fas fa-undo-alt"></i>
                      &nbsp;&nbsp;<p>Rudisha Dawa</p>
                  </a>
              </li>  -->
            </ul>
            <li class="nav-item has-treeview">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-boxes"></i>
              <p>
              Dawa
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
            <li class="nav-item">
                <a href="cashier_view_products.php?invoice_number=<?php echo $_GET['invoice_number']?>" class="nav-link">
                  &nbsp;&nbsp;&nbsp;<i class="fas fa-eye"></i>
                  &nbsp;&nbsp;<p>Orodha ya Dawa</p>
                </a>
             </li>
             <!-- <li class="nav-item">
                  <a href="bidhaa_zilizoharibika.php?invoice_number=<?php echo $_GET['invoice_number']?>" class="nav-link">
                      &nbsp;&nbsp;&nbsp;<i class="fas fa-trash-alt"></i>
                      &nbsp;&nbsp;<p>Dawa zilizo haribika</p>
                  </a>
              </li> 
             <li class="nav-item">
                <a href="qty_alert.php?invoice_number=<?php echo $_GET['invoice_number']?>" class="nav-link">
                &nbsp;&nbsp;&nbsp;<i class="fas fa-exclamation-triangle"></i>
                  &nbsp;&nbsp;<p>Dawa karibia kuisha</p> 
                </a>
              </li>
              <li class="nav-item">
                <a href="out_of_stock.php?invoice_number=<?php echo $_GET['invoice_number']?>" class="nav-link">
                &nbsp;&nbsp;&nbsp;<i class="fas fa-box-open"></i>
                  &nbsp;&nbsp;<p>Dawa zilizoisha</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="ex_alert.php?invoice_number=<?php echo $_GET['invoice_number']?>" class="nav-link">
                &nbsp;&nbsp;&nbsp;<i class="fas fa-exclamation"></i>
                  &nbsp;&nbsp;<p>Zinazokaribia ku expire</p>
                </a>
              </li> -->
              <!-- <li class="nav-item">
                <a href="expired_products.php?invoice_number=<?php echo $_GET['invoice_number']?>" class="nav-link">
                &nbsp;&nbsp;&nbsp;<i class="fas fa-times"></i>
                  &nbsp;&nbsp;<p>Dawa zilizo expire</p>
                </a>
               </li> -->
            </ul>
          </li>  
          <li class="nav-item has-treeview">
                <a href="#" class="nav-link">
                 <i class="nav-icon fas fa-wallet"></i>
              <p>
                Matumizi
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
            <li class="nav-item">
                <a href="cashier_expenditure.php?invoice_number=<?php echo $_GET['invoice_number']?>" class="nav-link">
                &nbsp;&nbsp;&nbsp;<i class="fas fa-money-bill"></i>
                  &nbsp;&nbsp;<p>Rekodi matumizi</p>
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