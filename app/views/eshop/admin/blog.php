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

    .add-new-post {
        margin: 30px;
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
                    <?php if($mode == "add_new"){ ?>
                        <a style="margin-left: 10px;" href="<?=ROOT?>admin/blogs" class="btn btn-info pull-left"><i class="fa fa-arrow-left"></i> Back to post list</a>
                   <?php } ?>
                    <a style="margin-right: 10px;" href="<?=ROOT?>admin/blogs?add_new=true" class="btn btn-info pull-right">Add New Post <i class="fa fa-plus"></i></a>
                    <br>
                    <br>
                    <hr>
                           
                <?php 
                    if ($mode == "read") {
                        if (isset($blogs) && is_array($blogs)) {
   
                ?>
                <!-- read table -->
                <div class="order-table">
                    <h4><i class="fa fa-angle-right"></i>Blog List</h4>  
                    <hr>
                    <table class="table table-striped table-advance table-hover table-class">
                        <thead>
                            <tr>
                                <th>Serial</th>
                                <th>Title</th>
                                <th>User</th>
                                <th>Post</th>
                                <th>Date</th>
                                <th>Image</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody">
                            <?php 
                                $i = 0;
                                foreach ($blogs as $blog) {
                                $i++;
                            ?>
                            <tr>
                                <td><?=$i ?></td>
                                <td><a href="<?=ROOT?>profile"><?=$blog->title ?></a></td>
                                <td><?=$blog->user_url ?></td>
                                <td><?=$blog->post ?></td>
                                <td><?=$blog->image ?></td>
                                <td><?=date("d-M-Y H:i:a", strtotime($blog->date)) ?></td>
                                <td style="font-size: 10px;">
                                    <a href="<?=ROOT?>admin/blogs?edit=<?=$blog->blogId?>" class="btn btn-danger"><i class="fa fa-pencil"></i></a>
                                    <a href="<?=ROOT?>admin/blogs?delete=<?=$blog->blogId?>" class="btn btn-danger"><i class="fa fa-trash-o"></i></a>
                                </td>
                            </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
                 <!-- read table end -->
                <?php }else{ ?>
                    <div style="padding: 10px;">No blog post found!</div>
                <?php } }elseif ($mode == "add_new") {  ?>
                    <?php 
                        if (isset($errors)) { ?>
                            <p style="margin: 0 10px;" class="status alert alert-danger"><?=$errors ?></p>
                    <?php } ?>

                    <!-- Add new Post -->
                    <div class="add-new-post">
                        <!-- BASIC FORM ELELEMNTS -->
                        <h3 class="mb">Add New Post</h3>
                        <form class="form-horizontal style-form" method="POST" enctype="multipart/form-data">
                            <div class="form-group">
                                <label class="col-sm-4 control-label" for="header1_text">Post Title</label>
                                <div class="col-sm-8">
                                    <input value="<?=isset($POST["title"]) ? $POST["title"] : "" ?>" name="title" id="title" type="text" class="form-control" placeholder="Write a Post title">
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <label class="col-sm-4 control-label">Post Details</label>
                                <div class="col-sm-8">
                                    <textarea placeholder="Write a Post details" name="post" id="post" class="form-control"><?=isset($POST["post"]) ? $POST["post"] : "" ?></textarea>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-4 control-label">Post Image (optional)</label>
                                <div class="col-sm-8">
                                    <input name="image" id="image" type="file" class="form-control">
                                </div>
                            </div>
                            
                            <div class="js-Post-images-add edit-Post-images">
                                <img src="" alt="">
                                <img src="" alt="">
                            </div>
                            <div style="display: flex; justify-content: space-between">
                                <input type="reset" value="Close" class="btn btn-danger">
                                <input type="submit" value="Post" class="btn btn-primary">
                                
                            </div>
                        </form>
                    </div>
                    <!-- Add new Post end-->
                <?php } ?>

                        
                    </div><!-- /content-panel -->
          		</div>
          	</div>
			
      <!--main content end-->
 <!-- Footer -->
 <?php $this->view("admin/footer", $data) ?>