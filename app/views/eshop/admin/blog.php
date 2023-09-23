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
                    <?php if($mode != "read"){ ?>
                        <a style="margin-left: 10px;" href="<?=ROOT?>admin/blogs" class="btn btn-info pull-left"><i class="fa fa-arrow-left"></i> Back to post list</a>
                   <?php } ?>
                    <a style="margin-right: 10px;" href="<?=ROOT?>admin/blogs?add_new=true" class="btn btn-info pull-right">Add New Post <i class="fa fa-plus"></i></a>
                    <br>
                    <br>
                    <hr>
                           
                <?php 
                    if ($mode == "read") {
                ?>
                <!-- read table -->
                <div class="order-table p-4">
                    <h4><i class="fa fa-angle-right"></i>Blog List</h4>  
                    <hr>
                    <?php if (isset($blogs) && is_array($blogs)) { ?>
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
                                <td><a href="<?=ROOT?>post/"><?=$blog->title ?></a></td>
                                <td><a href="<?=ROOT?>profile/<?=$blog->user_url ?>"><?=$blog->user_data->name ?></a></td>
                                <td style="width:40%"><?=nl2br(htmlspecialchars(substr($blog->post, 0, 350)))?> ...</td>
                                <td><?=date("d-M-Y H:i:a", strtotime($blog->date)) ?></td>
                                <td><?=!empty($blog->image) ? "<img src='".ROOT."$blog->image' height='70px' width='70px' alt=''>" : "" ?></td>
                                <td style="font-size: 10px;">
                                    <a href="<?=ROOT?>admin/blogs?edit=<?=$blog->blogId?>" class="btn btn-info"><i class="fa fa-pencil"></i></a>
                                    <a href="<?=ROOT?>admin/blogs?delete=<?=$blog->blogId?>" class="btn btn-danger"><i class="fa fa-trash-o"></i></a>
                                </td>
                            </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                    <?php }else{ ?>
                    <div style="padding: 10px;">No blog post found!</div>
                    <?php } ?>
                    <?php Page::show_links(); ?>
                </div>
                 <!-- read table end -->
                <?php  }elseif ($mode == "add_new") {  ?>
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
                                <a class="btn btn-danger" href="<?=ROOT?>admin/blogs">Close</a>
                                <input type="submit" value="Post" class="btn btn-primary">
                                
                            </div>
                        </form>
                    </div>
                    <!-- Add new Post end-->
                <?php }elseif ($mode == "edit") {  ?>
                    <?php 
                        if (isset($errors)) { ?>
                            <p style="margin: 0 10px;" class="status alert alert-danger"><?=$errors ?></p>
                    <?php } ?>
                    <!-- Edit Post -->
                    <div class="add-new-post">
                        <!-- BASIC FORM ELELEMNTS -->
                        <h3 class="mb">Edit Post</h3>
                        <form class="form-horizontal style-form" method="POST" enctype="multipart/form-data">
                            <input value="<?=isset($POST->blogId) ? $POST->blogId : "" ?>" name="blogId" id="title" type="hidden">
                            <div class="form-group">
                                <label class="col-sm-4 control-label" for="header1_text">Post Title</label>
                                <div class="col-sm-8">
                                    <input value="<?=isset($POST->title) ? $POST->title : "" ?>" name="title" id="title" type="text" class="form-control" placeholder="Write a Post title">
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <label class="col-sm-4 control-label">Post Details</label>
                                <div class="col-sm-8">
                                    <textarea placeholder="Write a Post details" name="post" id="post" class="form-control"><?=isset($POST->post) ? $POST->post : "" ?></textarea>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-4 control-label">Post Image (optional)</label>
                                <div class="col-sm-8">
                                    <input name="image" id="image" type="file" class="form-control">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-4 control-label"></label>
                                <div class="col-sm-8">
                                    <?=!empty($POST->image) ? "<img height='100px' width='150px' src='".ROOT."$POST->image' alt=''>" : "" ?>
                                </div>
                            </div>
                            
                            <div class="js-Post-images-add edit-Post-images">
                            
                                
                            </div>
                            <div style="display: flex; justify-content: space-between">
                                <a class="btn btn-danger" href="<?=ROOT?>admin/blogs">Close</a>
                                <input type="submit" value="Save" class="btn btn-primary">
                                
                            </div>
                        </form>
                    </div>
                    <!-- Edit Post end-->
                <?php }elseif ($mode == "delete" && is_object($blogs)) { ?>
                    <p style="margin: 0 10px;" class="status alert alert-danger">Are you confirmed to delete this post?</p>
                        <div class="order-table">
                            <h4><i class="fa fa-angle-right"></i>Message List</h4> 
                            <hr>
                            <table class="table table-striped table-advance table-hover table-class">
                                <thead>
                                    <tr>
                                        <th>Serial</th>
                                        <th>User</th>
                                        <th>Title</th>
                                        <th>Post</th>
                                        <th>Date</th>
                                        <th>Image</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody">
                                    <tr>
                                        <td><?=$blogs->blogId ?></td>
                                        <td><a href="<?=ROOT?>profile/<?=$blogs->user_url ?>"><?=$blogs->user_data->name ?></a></td>
                                        <td><a href="<?=ROOT?>profile"><?=$blogs->title ?></a></td>
                                        <td><?=$blogs->post ?></td>
                                        <td><?=date("d-M-Y H:i:a", strtotime($blogs->date)) ?></td>
                                        <td><?=!empty($blogs->image) ? "<img src='".ROOT."$blogs->image' height='70px' width='70px' alt=''>" : "" ?></td>
                                        <td style="font-size: 10px;">
                                            <a href="<?=ROOT?>admin/blogs?delete_confirm=<?=$blogs->blogId?>" class="btn btn-danger"><i class="fa fa-trash-o"></i> Delete</a>
                                        </td>
                                    </tr>
                                </tbody>
                                
                            </table>
                        </div>
                <?php }elseif($mode == "delete_confirm"){ ?>
                    <div style="padding: 10px;">
                        <p class="status alert alert-danger">The post deleted successfully</p>
                        <a href="<?=ROOT?>admin/blogs" class="btn btn-success"> Back to post list</a>
                    </div>
                <?php } ?>

                        
                    </div><!-- /content-panel -->
          		</div>
          	</div>
			
      <!--main content end-->
 <!-- Footer -->
 <?php $this->view("admin/footer", $data) ?>