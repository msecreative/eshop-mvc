<!-- Header -->
<?php $this->view("admin/header", $data) ?>
<style>
     .order-table>table tbody>tr>td {
        font-size: 10px;
    }
    .order-details {
        background-color: #eee;
        box-shadow: 0px 0px 10px #aaa;
        width: 97%;
        min-height: 100px;
        position:absolute;
        right: 0;
        margin: 20px;
        padding: 20px;
        z-index: 2;
    }

    .hide {
        display: none;
    }
</style>
      
      <!-- **********************************************************************************************************************************************************
      MAIN SIDEBAR MENU
      *********************************************************************************************************************************************************** -->
    <!-- sidebar -->
    <?php $this->view("admin/sidebar", $data) ?>
      
      <!-- **********************************************************************************************************************************************************
      MAIN CONTENT
      *********************************************************************************************************************************************************** -->

          	<div class="row mt">
          		<div class="col-lg-12">
                    <div class="content-panel">
                           
                <?php 
                    if (is_array($users)) {
   
                ?>
                <div class="order-table">
                    <h4><i class="fa fa-angle-right"></i>Product List</h4>  
                    <hr>
                    <table class="table table-striped table-advance table-hover table-class">
                        <thead>
                            <tr>
                                <th>Serial</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>rank</th>
                                <th>Date</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody">
                            <?php 
                                $i = 0;
                                foreach ($users as $user) {
                                $i++;
                            ?>
                            <tr>
                                <td><?=$i ?></td>
                                <td><a href="<?=ROOT?>order_details"><?=$user->orderId ?></a></td>
                                <td><a href="<?=ROOT?>profile/<?=$user->user_name->url_address?>"><?=$user->user_name->name ?></a></td>
                                <td style="font-size: 10px;"><?=$user->delevery_address ?></td>
                                <td>$<?=$user->total ?></td>
                                <td style="font-size: 10px;"><?=date("d-M-Y H:i:a", strtotime($user->date)) ?></td>
                            </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
                <?php }else{ ?>
                    <div>No user found</div>
                    <?php } ?>
                        
                    </div><!-- /content-panel -->
          		</div>
          	</div>
			
      <!--main content end-->
 <!-- Footer -->
 <?php $this->view("admin/footer", $data) ?>