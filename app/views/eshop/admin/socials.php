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
                    if (isset($settings) && is_array($settings)) {
   
                ?>
                <div class="order-table">
                    <h4><i class="fa fa-angle-right"></i>Product List</h4>  
                    <hr>
                    <form action="" method="POST">
                        <table class="table table-striped table-advance table-hover table-class">
                            <thead>
                                <tr>
                                    <th>Serial</th>
                                    <th>Setting Name</th>
                                    <th>Setting Value</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody">
                                <?php 
                                    $i = 0;
                                    foreach ($settings as $setting) {
                                    $i++;
                                ?>
                                <tr>
                                    <td><?=$i ?></td>
                                    <td><a href="<?=ROOT?>profile"><?=ucwords(str_replace("-", " ",$setting->setting)) ?></a></td>
                                    <td><input type="text" class="form-control" name="<?=$setting->setting?>" value="<?=$setting->value ?>"></td>
                                    <td><span onclick="disable_row('.$args.')" class="label label-'.$status_color.' label-mini" style="cursor:pointer">'.$catRow->disabled.'</span></td>
                                    <td style="font-size: 10px;">view</td>
                                </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                        <input type="submit" value="Save" class="btn btn-primary pull-right">
                    </form>
                </div>
                <?php }else{ ?>
                    <div style="padding: 10px;">No social link found</div>
                    <?php } ?>
                        
                    </div><!-- /content-panel -->
          		</div>
          	</div>
			
      <!--main content end-->
 <!-- Footer -->
 <?php $this->view("admin/footer", $data) ?>