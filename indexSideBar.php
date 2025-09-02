<!-- Sidebar -->
<aside class="main-sidebar sidebar-dark-primary elevation-4 fixed" style="position: fixed;">
  <a href="index.php" class="brand-link">
    <h1 class="brand-text font-weight-light">MauzoApp</h1>
  </a>
  <div class="sidebar">
    <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
        <li class="nav-item has-treeview menu-open">
            <a href="index.php" class="nav-link active">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>
                Nyumbani             
              </p>
            </a>
          </li>          
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
                <a href="home.php?invoice_number=<?php echo $_GET['invoice_number']?>" class="nav-link">
                  &nbsp;&nbsp;&nbsp;<i class="fas fa-cart-plus"></i>

                  &nbsp;&nbsp;<p>uza Dawa</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="uza_kwa_mkopo.php?invoice_number=<?php echo $_GET['invoice_number']?>" class="nav-link">
                  &nbsp;&nbsp;&nbsp;<i class="fas fa-cart-plus"></i>

                  &nbsp;&nbsp;<p>Uza kwa mkopo</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="pending_sells.php?invoice_number=<?php echo $_GET['invoice_number']?>" class="nav-link">
                &nbsp;&nbsp;&nbsp;<i class="fas fa-cart-plus"></i>
                  &nbsp;&nbsp;<p>Mauzo yasio kamilika</p>
                </a>
              </li>
              <li class="nav-item">
                  <a href="customer_order.php?invoice_number=<?php echo $_GET['invoice_number']?>" class="nav-link">
                      &nbsp;&nbsp;&nbsp;<i class="fas fa-fas fa-cart-plus"></i>
                      &nbsp;&nbsp;<p>Oda za wateja</p>
                  </a>
              </li>
              <li class="nav-item">
                  <a href="return_product.php?invoice_number=<?php echo $_GET['invoice_number']?>" class="nav-link">
                      &nbsp;&nbsp;&nbsp;<i class="fas fa-undo-alt"></i>
                      &nbsp;&nbsp;<p>Rudisha Dawa</p>
                  </a>
              </li> 
              <li class="nav-item">
                   <a href="all_sales.php?invoice_number=<?php echo $_GET['invoice_number']?>" class="nav-link">
                       &nbsp;&nbsp;&nbsp;<i class="fas fa-receipt"></i>
                       &nbsp;&nbsp;<p>Mauzo yote</p>
                   </a>
              </li> 
              <li class="nav-item">
                   <a href="bidhaa_20_zilizoingiza_pesa_nyingi.php?invoice_number=<?php echo $_GET['invoice_number']?>" class="nav-link">
                       &nbsp;&nbsp;&nbsp;<i class="fas fa-trophy"></i>
                       &nbsp;&nbsp;<p>Dawa bora</p>
                   </a>
              </li> 
              <li class="nav-item">
                   <a href="bidhaa_20_zisizoingiza_pesa_nyingi.php?invoice_number=<?php echo $_GET['invoice_number']?>" class="nav-link">
                       &nbsp;&nbsp;&nbsp;<i class="fas fa-times-circle"></i>
                       &nbsp;&nbsp;<p>Dawa dhaifu</p>
                   </a>
              </li> 
              </li> 
              <li class="nav-item">
                <a href="Zilizouzika_kidogo.php?invoice_number=<?php echo $_GET['invoice_number']?>" class="nav-link">
                  &nbsp;&nbsp;&nbsp;<i class="fas fa-exclamation-circle"></i>
                  &nbsp;&nbsp;<p>Zilizo uza kidogo</p>
                </a>
              </li> 
              </li>  
              <li class="nav-item">
                <a href="zilizouzika_sana.php?invoice_number=<?php echo $_GET['invoice_number']?>" class="nav-link">
                  &nbsp;&nbsp;&nbsp;<i class="fas fa-check-circle"></i>
                  &nbsp;&nbsp;<p>Zilizouza sana</p>
                </a>
              </li> 
              <li class="nav-item">
                <a href="never_sold_products.php?invoice_number=<?php echo $_GET['invoice_number']?>" class="nav-link">
                  &nbsp;&nbsp;&nbsp;<i class="fas fa-ban"></i>
                  &nbsp;&nbsp;<p>Hazijawahi kuuzwa</p>
                </a>
              </li>            
            </ul>
          </li>
          <li class="nav-item has-treeview">
            <a href="#" class="nav-link">
                <i class="nav-icon fas fa-wallet"></i>
                <p>Mikopo<i class="fas fa-angle-left right"></i></p>
            </a>
            <ul class="nav nav-treeview">
            <li class="nav-item">
                <a href="tunaowadai.php?invoice_number=<?php echo $_GET['invoice_number']?>" class="nav-link">
                  &nbsp;&nbsp;&nbsp;<i class="fas fa-money-bill"></i>
                  &nbsp;&nbsp;<p>Mikopo</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="madeni_yaliyolipwa.php?invoice_number=<?php echo $_GET['invoice_number']?>" class="nav-link">
                  &nbsp;&nbsp;&nbsp;<i class="fas fa-money-bill"></i>
                  &nbsp;&nbsp;<p>Mikopo iliyolipwa</p>
                </a>
              </li>
            </ul>
          </li>
                    <li class="nav-item has-treeview">
            <a href="#" class="nav-link">
                <i class="nav-icon fas fa-wallet"></i>
                <p>Hamisha Dawa<i class="fas fa-angle-left right"></i></p>
            </a>
            <ul class="nav nav-treeview">
            <li class="nav-item">
                <a href="hamisha_kwa_kuuza.php?invoice_number=<?php echo $_GET['invoice_number']?>" class="nav-link">
                  &nbsp;&nbsp;&nbsp;<i class="fas fa-money-bill"></i>
                  &nbsp;&nbsp;<p>Hamisha kwa kuuza</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="hamisha_kwa_mkopo.php?invoice_number=<?php echo $_GET['invoice_number']?>" class="nav-link">
                  &nbsp;&nbsp;&nbsp;<i class="fas fa-money-bill"></i>
                  &nbsp;&nbsp;<p>Hamisha kwa mkopo</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="hamisha_bure.php?invoice_number=<?php echo $_GET['invoice_number']?>" class="nav-link">
                  &nbsp;&nbsp;&nbsp;<i class="fas fa-money-bill"></i>
                  &nbsp;&nbsp;<p>Hamisha bure</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="receive_transfer.php?invoice_number=<?php echo $_GET['invoice_number']?>" class="nav-link">
                  &nbsp;&nbsp;&nbsp;<i class="fas fa-money-bill"></i>
                  &nbsp;&nbsp;<p>Pokea Dawa</p>
                </a>
              </li>
            </ul>
          </li>
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
                <a href="view.php?invoice_number=<?php echo $_GET['invoice_number']?>" class="nav-link">
                  &nbsp;&nbsp;&nbsp;<i class="fas fa-eye"></i>
                  &nbsp;&nbsp;<p>Orodha ya Dawa</p>
                </a>
             </li>
             <li class="nav-item">
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
              </li>
              <li class="nav-item">
                <a href="expired_products.php?invoice_number=<?php echo $_GET['invoice_number']?>" class="nav-link">
                &nbsp;&nbsp;&nbsp;<i class="fas fa-times"></i>
                  &nbsp;&nbsp;<p>Dawa zilizo expire</p>
                </a>
               </li>
            </ul>
          </li>          
          <li class="nav-item has-treeview">
            <a href="#" class="nav-link">
                <i class="nav-icon fas fa-wallet"></i>
                <p>Matumizi<i class="fas fa-angle-left right"></i></p>
            </a>
            <ul class="nav nav-treeview">
            <li class="nav-item">
                <a href="expenditure.php?invoice_number=<?php echo $_GET['invoice_number']?>" class="nav-link">
                &nbsp;&nbsp;&nbsp;<i class="fas fa-money-bill"></i>
                  &nbsp;&nbsp;<p>Rekodi matumizi</p>
                </a>
              </li>
             </ul>
            </li>
                      <li class="nav-item has-treeview">
            <a href="#" class="nav-link">
                <i class="nav-icon fas fa-wallet"></i>
                <p>Uwakala<i class="fas fa-angle-left right"></i></p>
            </a>
            <ul class="nav nav-treeview">
                            <li class="nav-item">
                <a href="uwakala_management.php?invoice_number=<?php echo $_GET['invoice_number']?>" class="nav-link">
                  &nbsp;&nbsp;&nbsp;<i class="fas fa-cart-plus"></i>

                  &nbsp;&nbsp;<p>Andika taarifa</p>
                </a>
              </li>
                                          <li class="nav-item">
                <a href="report_uwakala_management.php?invoice_number=<?php echo $_GET['invoice_number']?>" class="nav-link">
                  &nbsp;&nbsp;&nbsp;<i class="fas fa-cart-plus"></i>

                  &nbsp;&nbsp;<p>Ripoti uwakala</p>
                </a>
              </li>
             </ul>
            </li>
          <li class="nav-item has-treeview">
            <a href="#" class="nav-link">
                <i class="nav-icon fas fa-wallet"></i>
                <p>Manunuzi<i class="fas fa-angle-left right"></i></p>
            </a>
            <ul class="nav nav-treeview">
            <li class="nav-item">
                <a href="record_purchases.php?invoice_number=<?php echo $_GET['invoice_number']?>" class="nav-link">
                  &nbsp;&nbsp;&nbsp;<i class="fas fa-money-bill"></i>
                  &nbsp;&nbsp;<p>Rekodi manunuzi</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="record_credit_purchases.php?invoice_number=<?php echo $_GET['invoice_number']?>" class="nav-link">
                &nbsp;&nbsp;&nbsp;<i class="fas fa-money-bill"></i>
                  &nbsp;&nbsp;<p>manunuzi ya mkopo </p>
                </a>
              </li>
              <li class="nav-item">
                <a href="reject_purchases.php?invoice_number=<?php echo $_GET['invoice_number']?>" class="nav-link">
                &nbsp;&nbsp;&nbsp;<i class="fas fa-money-bill"></i>
                  &nbsp;&nbsp;<p>Rudisha Dawa</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="credit_purchases_products.php?invoice_number=<?php echo $_GET['invoice_number']?>" class="nav-link">
                &nbsp;&nbsp;&nbsp;<i class="fas fa-money-bill"></i>
                  &nbsp;&nbsp;<p>Dawa za mkopo </p>
                </a>
              </li>
            </ul>
            </li> 
          <li class="nav-item has-treeview">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-chart-bar"></i>
              <p>
                Ripoti
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="stock_report.php?invoice_number=<?php echo $_GET['invoice_number']?>" class="nav-link">
                &nbsp;&nbsp;&nbsp;<i class="fas fa-clipboard-list"></i>
                  &nbsp;&nbsp;<p>Ripoti ya Dawa</p>
                </a>
              </li>
            <li class="nav-item">
                <a href="expenditure_report.php?invoice_number=<?php echo $_GET['invoice_number']?>" class="nav-link">
                &nbsp;&nbsp;&nbsp;<i class="fas fa-file-invoice-dollar"></i>
                  &nbsp;&nbsp;<p>Ripoti ya matumizi</p>
                </a>
              </li>
              <li class="nav-item">
              <a href="sales_report.php?invoice_number=<?php echo $_GET['invoice_number']?>" class="nav-link">
                &nbsp;&nbsp;&nbsp;<i class="fas fa-file-alt"></i>
                  &nbsp;&nbsp;<p>Ripoti ya mauzo</p>
                </a>
              </li>
                                                        <li class="nav-item">
                <a href="report_uwakala_management.php?invoice_number=<?php echo $_GET['invoice_number']?>" class="nav-link">
                  &nbsp;&nbsp;&nbsp;<i class="fas fa-cart-plus"></i>

                  &nbsp;&nbsp;<p>Ripoti uwakala</p>
                </a>
              </li>
              <li class="nav-item">
              <a href="gross_profit_report.php?invoice_number=<?php echo $_GET['invoice_number']?>" class="nav-link">
                &nbsp;&nbsp;&nbsp;<i class="fas fa-file-alt"></i>
                  &nbsp;&nbsp;<p>Gross profit</p>
                </a>
              </li>
              <li class="nav-item">
              <a href="operational_profit_report.php?invoice_number=<?php echo $_GET['invoice_number']?>" class="nav-link">
                &nbsp;&nbsp;&nbsp;<i class="fas fa-file-alt"></i>
                  &nbsp;&nbsp;<p>Operatinal profit</p>
                </a>
              </li>
              <li class="nav-item">
              <a href="ripoti _mauzo_ya_mkopo.php?invoice_number=<?php echo $_GET['invoice_number']?>" class="nav-link">
                &nbsp;&nbsp;&nbsp;<i class="fas fa-file-alt"></i>
                  &nbsp;&nbsp;<p>Ripoti Mauzo mkopo</p>
                </a>
              </li>
              <li class="nav-item">
              <a href="purchases_report.php?invoice_number=<?php echo $_GET['invoice_number']?>" class="nav-link">
                &nbsp;&nbsp;&nbsp;<i class="fas fa-file-alt"></i>
                  &nbsp;&nbsp;<p>Ripoti ya manunuzi</p>
                </a>
              </li>
              <li class="nav-item">
              <a href="credit_purchases_report.php?invoice_number=<?php echo $_GET['invoice_number']?>" class="nav-link">
                &nbsp;&nbsp;&nbsp;<i class="fas fa-file-alt"></i>
                  &nbsp;&nbsp;<p>Nunuliwa kwa mkopo</p>
                </a>
              </li>  
              <li class="nav-item">
              <a href="edited_products_report.php?invoice_number=<?php echo $_GET['invoice_number']?>" class="nav-link">
                &nbsp;&nbsp;&nbsp;<i class="fas fa-file-alt"></i>
                  &nbsp;&nbsp;<p>Dawa zilizohaririwa</p>
                </a>
              </li> 
              <li class="nav-item">
              <a href="deleted_products_report.php?invoice_number=<?php echo $_GET['invoice_number']?>" class="nav-link">
                &nbsp;&nbsp;&nbsp;<i class="fas fa-file-alt"></i>
                  &nbsp;&nbsp;<p>Dawa zilizofutwa</p>
                </a>
              </li>             
              <li class="nav-item">
                <a href="total_sales_graph.php?invoice_number=<?php echo $_GET['invoice_number']?>" class="nav-link">
                &nbsp;&nbsp;&nbsp;<i class="fas fa-chart-line"></i>
                  &nbsp;&nbsp;<p>Grafu idadi zilizouzika</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="sales_graph.php?invoice_number=<?php echo $_GET['invoice_number']?>" class="nav-link">
                &nbsp;&nbsp;&nbsp;<i class="fas fa-chart-area"></i>
                  &nbsp;&nbsp;<p>Grafu kiasi cha pesa</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="profit_graph.php?invoice_number=<?php echo $_GET['invoice_number']?>" class="nav-link">
                &nbsp;&nbsp;&nbsp;<i class="fas fa-chart-pie"></i>
                  &nbsp;&nbsp;<p>Grafu ya faida</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="expenditure_graph.php?invoice_number=<?php echo $_GET['invoice_number']?>" class="nav-link">
                &nbsp;&nbsp;&nbsp;<i class="nav-icon fas fa-chart-bar"></i>
                  &nbsp;&nbsp;<p>Grafu ya matumizi</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="business_analysis.php?invoice_number=<?php echo $_GET['invoice_number']?>" class="nav-link">
                &nbsp;&nbsp;&nbsp;<i class="fas fa-chart-bar"></i>
                  &nbsp;&nbsp;<p>Uchambuzi wa biashara</p>
                </a>
              </li>
            </ul>
          </li> 
          <li class="nav-item has-treeview">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-tools"></i>
              <p>
                Matengenezo
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
            <li class="nav-item">
                <a href="hariri_bidhaa.php?invoice_number=<?php echo $_GET['invoice_number']?>" class="nav-link">
                &nbsp;&nbsp;&nbsp;<i class="icon-edit"></i>
                  &nbsp;&nbsp;<p>Hariri Dawa</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="ongeza_bidhaa.php?invoice_number=<?php echo $_GET['invoice_number']?>" class="nav-link">
                &nbsp;&nbsp;&nbsp;<i class="nav-icon fas fa-plus-circle"></i>
                  &nbsp;&nbsp;<p>Ongeza Dawa</p>
                </a>
              </li>
              <!-- <li class="nav-item">
                <a href="hariri_bidhaa.php?invoice_number=<?php echo $_GET['invoice_number']?>" class="nav-link">
                &nbsp;&nbsp;&nbsp;<i class="nav-icon fas fa-plus-circle"></i>
                  &nbsp;&nbsp;<p>Hariri Dawa</p>
                </a>
              </li> -->
            </ul>
            <ul class="nav nav-treeview">
            <li class="nav-item">
                <a href="user_management.php?invoice_number=<?php echo $_GET['invoice_number']?>" class="nav-link">
                &nbsp;&nbsp;&nbsp;<i class="nav-icon fas fa-users"></i>
                  &nbsp;&nbsp;<p>Watumiaji</p>
                </a>
              </li>
            </ul>
                        <ul class="nav nav-treeview">
            <li class="nav-item">
                <a href="store_management.php?invoice_number=<?php echo $_GET['invoice_number']?>" class="nav-link">
                &nbsp;&nbsp;&nbsp;<i class="nav-icon fas fa-users"></i>
                  &nbsp;&nbsp;<p>Vituo/Matawi</p>
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
      </div>
      </aside>