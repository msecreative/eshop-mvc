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
                    if ($mode == "read") {
                        if (isset($messages) && is_array($messages)) {
   
                ?>
                <!-- read table -->
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
                                <td style="font-size: 10px;">
                                    <a href="<?=ROOT?>admin/messages?delete=<?=$message->contactId?>" class="btn btn-danger"><i class="fa fa-trash-o"></i></a>
                                </td>
                            </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
                 <!-- read table end -->
                <?php }else{ ?>
                    <div style="padding: 10px;">No message found</div>
                <?php } ?>
                <?php Page::show_links(); ?>
                    <?php }elseif($mode == "delete_confirm"){ ?>
                        <div style="padding: 10px;">
                            <p class="status alert alert-danger">The message deleted successfully</p>
                            <a href="<?=ROOT?>admin/messages" class="btn btn-success"> Back to inbox</a>
                        </div>

                    <?php }elseif($mode == "delete" && is_object($messages)){ ?>
                        <p style="margin: 0 10px;" class="status alert alert-danger">Are you confirmed to delete this message?</p>
                        <div class="order-table">
                            <div style="display: flex; justify-content:space-between; align-items:center; padding:10px">
                                <h4><i class="fa fa-angle-right"></i>Message List</h4>
                                <a href="<?=ROOT?>admin/messages" class="btn btn-success"> Back to inbox</a>
                            </div>  
                            <hr>
                            <table class="table table-striped table-advance table-hover table-class">
                                <thead>
                                    <tr>
                                        <th>Serial</th>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Subject</th>
                                        <th>Messagef</th>
                                        <th>Messaging Datef</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody">
                                    <tr>
                                        <td><?=$messages->contactId ?></td>
                                        <td><a href="<?=ROOT?>profile"><?=$messages->name ?></a></td>
                                        <td><?=$messages->email ?></td>
                                        <td><?=$messages->subject ?></td>
                                        <td><?=$messages->message ?></td>
                                        <td><?=date("d-M-Y H:i:a", strtotime($messages->date)) ?></td>
                                        <td style="font-size: 10px;">
                                            <a href="<?=ROOT?>admin/messages?delete_confirm=<?=$messages->contactId?>" class="btn btn-danger"><i class="fa fa-trash-o"></i> Delete</a>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                    <?php } ?>
                        
                    </div><!-- /content-panel -->
          		</div>
          	</div>
			
      <!--main content end-->
 <!-- Footer -->
 <?php $this->view("admin/footer", $data) ?>