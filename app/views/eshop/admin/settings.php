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
    .add-new-slider {
        padding: 50px 50px;
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
                            if ($type == "socials") {
                                
                                if (isset($settings) && is_array($settings)) {
        
                        ?>
                        <div class="order-table">
                            <h4><i class="fa fa-angle-right"></i>Social links List</h4>  
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
                                            <td><?=ucwords(str_replace("-", " ",$setting->setting)) ?></td>
                                            <?php
                                                if ($setting->type == "" || $setting->type == "text") { ?>
                                                <td><input placeholder="<?=ucwords(str_replace("-", " ",$setting->setting)) ?>" type="text" class="form-control" name="<?=$setting->setting?>" value="<?=$setting->value ?>"></td>
                                                <?php }elseif($setting->type == "textarea"){ ?>

                                                    <td><textarea placeholder="<?=ucwords(str_replace("-", " ",$setting->setting)) ?>" type="text" class="form-control" name="<?=$setting->setting?>"><?=$setting->value ?></textarea></td>
                                                <?php } ?>
                                            <td></td>
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
                            <?php } }elseif ($type == "slider_images") { 
                                if ($action == "show") {

                                ?>
                                <table class="table table-striped table-advance table-hover">
                                    <div style="display: flex; justify-content:space-between; margin-right:10px">
                                        <h4><i class="fa fa-angle-right"></i>Slider Table</h4>
                                        <a href="<?=ROOT?>admin/settings/slider_images?action=add" style="display: flex; align-items:center;"  class="btn btn-success btn-xs">
                                            <i style="margin-right: 10px;"  class="fa fa-plus"></i>
                                            Add New Slider
                                        </a>
                            
                                    </div>

                                    
                                    <hr>
                                    <thead>
                                    <tr>
                                        <th><i class="fa fa-bullhorn"></i> Id</th>
                                        <th class="hidden-phone"><i class="fa fa-question-circle"></i>Slider Title</th>
                                        <th><i class=" fa fa-edit"></i> Slider Subtitle</th>
                                        <th><i class=" fa fa-edit"></i> Slider Text</th>
                                        <th><i class=" fa fa-edit"></i> Slider Button Text</th>
                                        <th><i class=" fa fa-edit"></i> Slider Image</th>
                                        <th><i class=" fa fa-edit"></i> Image</th>
                                        <th><i class=" fa fa-edit"></i> Status</th>
                                        <th><i class="fa fa-bookmark"></i> Action</th>
                                    </tr>
                                    </thead>
                                    <tbody id="table_body">
                                        <?php
                                            if (isset($slider_row)) {
                                                $i = 0;
                                                foreach ($slider_row as $slider) {
                                                $i++;
                                        ?>
                                       <tr>
                                        <td><?=$i?></td>
                                        <td><?=$slider->header1_text?></td>
                                        <td><?=$slider->header2_text?></td>
                                        <td><?=$slider->text?></td>
                                        <td><?=$slider->link_text?></td>
                                        <td><img height="50" width="50" src="<?=ROOT . $slider->image?>" alt=""></td>
                                        <td><?php if (!empty($slider->image2)) { ?>
                                                <img height="50" width="50" src="<?=ROOT . $slider->image2?>" alt="">
                                            <?php } ?>
                                        </td>
                                        <td><?=$slider->disabled ? "Enable" : "Disabled" ?></td>
                                        <td>...</td>
                                       </tr>
                                       <?php } } ?>
                                    </tbody>
                                </table>
                            <?php }elseif ($action == "add") { ?>
                                      
                                <!-- Add new product -->
                                <div class="add-new-slider">
                                    <!-- BASIC FORM ELELEMNTS -->
                                    <h4 class="mb"><i class="fa fa-angle-right"></i>Add New Slider</h4>
                                    <form class="form-horizontal style-form" method="POST" enctype="multipart/form-data">
                                        <div class="form-group">
                                            <label class="col-sm-4 control-label" for="header1_text">Slider Title</label>
                                            <div class="col-sm-8">
                                                <input value="<?=isset($POST["header1_text"]) ? $POST["header1_text"] : "" ?>" autofocus name="header1_text" id="header1_text" type="text" class="form-control" placeholder="Write a slider title">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-sm-4 control-label" for="header2_text">Slider Subtitle</label>
                                            <div class="col-sm-8">
                                                <input name="header2_text" id="header2_text" value="<?=isset($POST["header2_text"]) ? $POST["header2_text"] : "" ?>" type="text" class="form-control" placeholder="Write a slider sub-title">
                                            </div>
                                        </div>
                                        
                                        <div class="form-group">
                                            <label class="col-sm-4 control-label">Slider Main Message</label>
                                            <div class="col-sm-8">
                                                <textarea placeholder="Write a slider description" name="text" id="text" class="form-control"><?=isset($POST["text"]) ? $POST["text"] : "" ?></textarea>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-sm-4 control-label" for="link_text">Slider Button Link</label>
                                            <div class="col-sm-8">
                                                <input name="link_text" id="link_text" type="text" value="<?=isset($POST["link_text"]) ? $POST["link_text"] : "" ?>" class="form-control" placeholder="e.g http://your website.com/your_content_title">
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="col-sm-4 control-label">Slider Image (Required)</label>
                                            <div class="col-sm-8">
                                                <input name="image" id="image" type="file" class="form-control">
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="col-sm-4 control-label">Product Image 2 (optional)</label>
                                            <div class="col-sm-8">
                                                <input name="image2" id="image2" type="file" class="form-control">
                                            </div>
                                        </div>
                                        
                                        <div class="js-product-images-add edit-product-images">
                                            <img src="" alt="">
                                            <img src="" alt="">
                                        </div>
                                        <div style="display: flex; justify-content: space-between">
                                            <input type="reset" value="Close" class="btn btn-danger">
                                            <input type="submit" value="Save" class="btn btn-primary">
                                            
                                        </div>
                                    </form>
                                </div>
                                <!-- Add new product end-->
                            <?php  } } ?>
                        
                    </div><!-- /content-panel -->
          		</div>
          	</div>
			
      <!--main content end-->
 <!-- Footer -->
 <?php $this->view("admin/footer", $data) ?>