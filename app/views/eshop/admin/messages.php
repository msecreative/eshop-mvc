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
                    if (isset($messages) && is_array($messages)) {
   
                ?>
                <div class="order-table">
                    <h4><i class="fa fa-angle-right"></i>Message List</h4>  
                    <hr>
                    <table class="table table-striped table-advance table-hover table-class">
                        <thead>
                            <tr>
                                <th>Serial</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Subject</th>
                                <th>Message</th>
                                <th>Messaging Date</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody">
                            <?php 
                                $i = 0;
                                foreach ($messages as $message) {
                                $i++;
                            ?>
                            <tr>
                                <td><?=$i ?></td>
                                <td><a href="<?=ROOT?>profile"><?=$message->name ?></a></td>
                                <td><?=$message->email ?></td>
                                <td><?=$message->subject ?></td>
                                <td><?=$message->message ?></td>
                                <td><?=date("d-M-Y H:i:a", strtotime($message->date)) ?></td>
                                <td style="font-size: 10px;"><button class="btn btn-danger"><i class="fa fa-trash-o"></i></button></td>
                            </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
                <?php }else{ ?>
                    <div style="padding: 10px;">No message found</div>
                    <?php } ?>
                        
                    </div><!-- /content-panel -->
          		</div>
          	</div>
			
      <!--main content end-->
 <!-- Footer -->
 <?php $this->view("admin/footer", $data) ?>