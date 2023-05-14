      <!--sidebar start-->
      <aside>
          <div id="sidebar"  class="nav-collapse ">
              <!-- sidebar menu start-->
              <ul class="sidebar-menu" id="nav-accordion">
              
              	  <p class="centered"><a href="profile.html"><img src="<?=ASSETS . THEME ?>admin/img/ui-sam.jpg" class="img-circle" width="60"></a></p>
              	  <h5 class="centered"><?=ucwords($data["user_data"]->name) ?></h5>
              	  	
                  <li class="mt">
                      <a href="index.html">
                          <i class="fa fa-dashboard"></i>
                          <span>Dashboard</span>
                      </a>
                  </li>
                  <li class="">
                      <a target="_blank" href="<?=ROOT?>index">
                          <i class="fa fa-shopping-cart"></i>
                          <span>Shop Website</span>
                      </a>
                  </li>

                  <li class="sub-menu">
                      <a href="javascript:;" >
                          <i class="fa fa-desktop"></i>
                          <span>Products</span>
                      </a>
                      <ul class="sub">
                          <li><a  href="<?=ROOT ?>admin/products">View Products</a></li>
                      </ul>
                  </li>
                  <li class="sub-menu">
                      <a href="<?=ROOT ?>admin/categories/list" >
                          <i class="fa fa-list-alt"></i>
                          <span>Categories</span>
                      </a>
                      <ul class="sub">
                          <li><a  href="<?=ROOT ?>admin/categories">View Category</a></li>
                      </ul>
                  </li>

                  <li class="sub-menu">
                      <a href="<?=ROOT ?>admin/orders" >
                          <i class="fa fa-reorder"></i>
                          <span>Orders</span>
                      </a>
                  </li>
                  <li class="sub-menu">
                      <a href="<?=ROOT ?>admin/settings" >
                          <i class="fa fa-cogs"></i>
                          <span>Settings</span>
                      </a>
                      <ul class="sub">
                          <li><a  href="<?=ROOT ?>admin/settings/slider-image">Home Image</a></li>
                      </ul>
                  </li>
                  <li class="sub-menu">
                      <a href="<?=ROOT ?>admin/users" >
                          <i class="fa fa-users"></i>
                          <span>Users</span>
                      </a>
                      <ul class="sub">
                          <li><a  href="<?=ROOT ?>admin/users/customers">Customer</a></li>
                          <li><a  href="<?=ROOT ?>admin/users/admins">Admins</a></li>
                      </ul>
                  </li>
                  <li class="sub-menu">
                      <a href="<?=ROOT ?>admin/backub" >
                          <i class="fa fa-hdd-o"></i>
                          <span>Website Backup</span>
                      </a>
                  </li>
              </ul>
              <!-- sidebar menu end-->
          </div>
      </aside>
      <!--sidebar end-->
            <!--main content start-->
        <section id="main-content">
          <section class="wrapper site-min-height">
          	<h3><i class="fa fa-angle-right"></i> <?= ucwords($data["page_title"]) ?></h3>