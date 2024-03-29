<!-- Header -->
<?php $this->view("admin/header", $data) ?>
      
      <!-- **********************************************************************************************************************************************************
      MAIN SIDEBAR MENU
      *********************************************************************************************************************************************************** -->
    <!-- sidebar -->
    <?php $this->view("admin/sidebar", $data) ?>
      
      <!-- **********************************************************************************************************************************************************
      MAIN CONTENT
      *********************************************************************************************************************************************************** -->
    <style>
        .add-new-category .form-group, .edit-category .from-group{
            padding-bottom: 35px;
        }
        .add-new-category, .edit-category{
            width: 50%;
            height: 300px;
            background-color: #cecccc;
            position: absolute;
            padding: 10px;
            left: 25%;
            top: 0;
            border-radius: 3px;
            box-shadow: 0 2px 1px rgba(0, 0, 0, 0.2)
        }
        .hide {
            display: none;
        }
    </style>
          	<div class="row mt">
          		<div class="col-lg-12">
                    <div class="content-panel">
                        <table class="table table-striped table-advance table-hover">
                            <div style="display: flex; justify-content:space-between; margin-right:10px">
                                <h4><i class="fa fa-angle-right"></i>Product Categories List</h4>
                                <button onclick="showAddNew(event)" class="btn btn-success btn-xs"><i style="margin-right: 10px;"  class="fa fa-plus"></i>Add New Category</button>
                            </div>
                            <!-- Add new category -->
                            <div class="add-new-category hide">
                                <!-- BASIC FORM ELELEMNTS -->
                                <h4 class="mb"><i class="fa fa-angle-right"></i>Add Category</h4>
                                <form class="form-horizontal style-form" method="POST">
                                    <div class="form-group">
                                        <label class="col-sm-4 control-label">Category Name</label>
                                        <div class="col-sm-8">
                                            <input name="category" id="category" type="text" class="form-control">
                                        </div>
                                    </div>
                                    <!-- Sub category -->
                                    <div class="form-group">
                                        <label class="col-sm-4 control-label">Parent Name (Optional)</label>
                                        <div class="col-sm-8">
                                            <select name="parent" id="parent" class="form-control" required>
                                                <option value="">Select a parent category</option>
                                                <?php 
                                                    if (is_array($forSubCategories)) {
                                                    foreach ($forSubCategories as $category) {
                                                ?>
                                                <option value="<?=$category->catId ?>"><?=$category->category ?></option>
                                                <?php } } ?>
                                            </select>
                                        </div>
                                    </div>
                                    <button onclick="collectData(event)" type="button" style="position: absolute;bottom:50px; right:20px" class="btn btn-primary">Save</button>
                                    <button onclick="showAddNew(event)" type="button" style="position: absolute;bottom:50px; left:20px" class="btn btn-danger">Close</button>
                                </form>
                            </div>
                            <!-- Add new category end-->

                            <!-- Edit category -->
                            <div class="edit-category hide">
                                <!-- BASIC FORM ELELEMNTS -->
                                <h4 class="mb"><i class="fa fa-angle-right"></i>Edit Category</h4>
                                <form class="form-horizontal style-form" method="POST">
                                    <div class="form-group">
                                        <label class="col-sm-4 control-label">Category Name</label>
                                        <div class="col-sm-8">
                                            <input name="category" id="category_edit" type="text" class="form-control">
                                        </div>
                                    </div>
                                    <!-- Sub category -->
                                    <div class="form-group">
                                        <label class="col-sm-4 control-label">Parent Name (Optional)</label>
                                        <div class="col-sm-8">
                                            <select name="parent" id="parent_edit" class="form-control" required>
                                                <option value="">Select a category</option>
                                                <?php 
                                                    if (is_array($forSubCategories)) {
                                                    foreach ($forSubCategories as $category) {
                                                ?>
                                                <option value="<?=$category->catId ?>"><?=$category->category ?></option>
                                                <?php } } ?>
                                            </select>
                                        </div>
                                    </div>
                                    <button onclick="collectEditData(event)" type="button" style="position: absolute;bottom:50px; right:20px" class="btn btn-primary">Save</button>
                                    <button onclick="show_edit_category(0,'')" type="button" style="position: absolute;bottom:50px; left:20px" class="btn btn-danger">Close</button>
                                </form>
                            </div>
                            <!-- Edit category end-->
                            
                            <hr>
                            <thead>
                              <tr>
                                  <th><i class="fa fa-bullhorn"></i> Id</th>
                                  <th class="hidden-phone"><i class="fa fa-question-circle"></i> Category Name</th>
                                  <th class="hidden-phone"><i class="fa fa-question-circle"></i> Parent Name</th>
                                  <th><i class=" fa fa-edit"></i> Status</th>
                                  <th><i class="fa fa-bookmark"></i> Action</th>
                                  <th></th>
                              </tr>
                            </thead>
                            <tbody id="table_body">
                                <?php 
                                
                                    echo $table_rows;

                                ?>
                            </tbody>
                        </table>
                        <?php Page::show_links(); ?>
                    </div><!-- /content-panel -->
          		</div>
          	</div>
			
		
        <script>
            
            var  EDIT_ID = 0;

            // add and hide category modal
            function showAddNew(){
                var showCatBox = document.querySelector(".add-new-category");
                var cateInput = document.querySelector("#category");
                if (showCatBox.classList.contains("hide")) {
                    showCatBox.classList.remove("hide"); 
                    cateInput.focus();
                }else{
                    showCatBox.classList.add("hide");
                    cateInput.value = "";
                }
            }

            // Edit and hide category modal
            function show_edit_category(catId,category,parent,e){
                EDIT_ID = catId;
                var showEditCatBox = document.querySelector(".edit-category");

                var cateInput = document.querySelector("#category_edit");
                cateInput.value = category;

                var ParentCateInput = document.querySelector("#parent_edit");
                ParentCateInput.value = parent;

                if (showEditCatBox.classList.contains("hide")) {
                    showEditCatBox.classList.remove("hide"); 
                    cateInput.focus();
                }else{
                    showEditCatBox.classList.add("hide");
                    cateInput.value = "";
                }
            }

            function collectData(e){
               var cateInput = document.querySelector("#category"); 
               if (cateInput.value.trim() == "" || !isNaN(cateInput.value.trim())) {
                alert("Please enter a valid category name");
               }
               var parentInput = document.querySelector("#parent"); 
               if (isNaN(parentInput.value.trim())) {
                alert("Please enter a valid parent category name");
               }

               var category = cateInput.value.trim();
               var parent = parentInput.value.trim();
               sendData({
                    category:category,
                    parent:parent,
                    data_type: "add_category"
                    });


            }

            function collectEditData(e){
               var cateInput = document.querySelector("#category_edit"); 
               if (cateInput.value.trim() == "" || !isNaN(cateInput.value.trim())) {
                alert("Please enter a valid category name");
               }

               var parentInput = document.querySelector("#parent_edit"); 
               if (isNaN(parentInput.value.trim())) {
                alert("Please enter a valid parent category name");
               }

               var category = cateInput.value.trim();
               var parent   = parentInput.value.trim();
               sendData({
                    catId:EDIT_ID,
                    category:category,
                    parent:parent,
                    data_type: "edit_category"
                    });


            }

            function sendData(data = {}){

                var ajax = new XMLHttpRequest();
                // var form = new FormData();

                // form.append('data', data);

                ajax.addEventListener("readystatechange", function(){
                    if (ajax.readyState == 4 && ajax.status == 200) {
                        handleResult(ajax.responseText);
                    }
                });
                ajax.open("POST", "<?=ROOT?>ajax_category", true);
                ajax.send(JSON.stringify(data));
            }

            function handleResult(result){
                if (result != "") {
                    var obj = JSON.parse(result);

                    if (typeof obj.data_type != "undefined") {

                        if (obj.data_type == "add_new") {
                            
                            if (obj.message_type == "info") {
                                alert(obj.message);
                                showAddNew();
                                
                                var table_body = document.querySelector("#table_body");
                                table_body.innerHTML = obj.data;
                            }else{
                                alert(obj.message);
                            }
                        }else 
                            if (obj.data_type == "edit_category") {

                                show_edit_category(0,'',false);
                                
                                var table_body = document.querySelector("#table_body");
                                table_body.innerHTML = obj.data;
                                //alert(obj.message);

                            }else
                            if (obj.data_type == "disable_row") {
                                var table_body = document.querySelector("#table_body");
                                table_body.innerHTML = obj.data;

                            }else
                            if (obj.data_type == "delete_row") {

                                var table_body = document.querySelector("#table_body");
                                table_body.innerHTML = obj.data;

                                alert(obj.message);
                        }
                    }
                }

            }
            // Edit category
            function edit_row(catId){

                sendData({
                    data_type: "",
                });
            }
            // Delete category
            function delete_row(catId){
                if (!confirm("Are your sure you want to delete this category")) {
                    return;
                }
                sendData({
                    data_type: "delete_row",
                    catId:catId
                });
            }
            // Disable category
            function disable_row(catId,state){
                sendData({
                    data_type: "disable_row",
                    catId:catId,
                    current_state:state
                });
            }
        </script>
      <!--main content end-->
 <!-- Footer -->
 <?php $this->view("admin/footer", $data) ?>