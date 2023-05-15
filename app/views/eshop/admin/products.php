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
        .add-new-product .form-group, 
        .edit-product .form-group{
            padding-bottom: 35px;
        }
        .add-new-product, .edit-product{
            width: 50%;
            height: 550px;
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
                                <h4><i class="fa fa-angle-right"></i>Product List</h4>
                                <button onclick="showAddNew(event)" class="btn btn-success btn-xs"><i style="margin-right: 10px;"  class="fa fa-plus"></i>Add New Product</button>
                            </div>
                            <!-- Add new product -->
                            <div class="add-new-product hide">
                                <!-- BASIC FORM ELELEMNTS -->
                                <h4 class="mb"><i class="fa fa-angle-right"></i>Add Product</h4>
                                <form class="form-horizontal style-form" method="POST">
                                    <div class="form-group">
                                        <label class="col-sm-4 control-label">Product Name</label>
                                        <div class="col-sm-8">
                                            <input name="description" id="description" type="text" class="form-control" required>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-4 control-label">Product Category</label>
                                        <div class="col-sm-8">
                                            <select name="category" id="category" class="form-control" required>
                                                <option value="">Select a category</option>
                                                <?php 
                                                    if (is_array($allcategories)) {
                                                    foreach ($allcategories as $category) {
                                                ?>
                                                <option value="<?=$category->catId ?>"><?=$category->category ?></option>
                                                <?php } } ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-4 control-label">Product Quantity</label>
                                        <div class="col-sm-8">
                                            <input name="quantity" id="quantity" type="number" value="1" class="form-control" required>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-sm-4 control-label">Product Price</label>
                                        <div class="col-sm-8">
                                            <input name="price" id="price" type="number" value="0.00" step="0.01" class="form-control" required>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-4 control-label">Product Image (Required)</label>
                                        <div class="col-sm-8">
                                            <input name="image" id="image" type="file" class="form-control" required>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-sm-4 control-label">Product Image 2 (optional)</label>
                                        <div class="col-sm-8">
                                            <input name="image2" id="image2" type="file" class="form-control">
                                        </div>
                                    </div>
                                    
                                    <div class="form-group">
                                        <label class="col-sm-4 control-label">Product Image 3 (optional)</label>
                                        <div class="col-sm-8">
                                            <input name="image3" id="image3" type="file" class="form-control">
                                        </div>
                                    </div>
                                
                                    <div class="form-group">
                                        <label class="col-sm-4 control-label">Product Image 4 (optional)</label>
                                        <div class="col-sm-8">
                                            <input name="image4" id="image4" type="file" class="form-control">
                                        </div>
                                    </div>
                                    <button onclick="collectData(event)" type="button" style="position: absolute;bottom:50px; right:20px" class="btn btn-primary">Save</button>
                                    <button onclick="showAddNew(event)" type="button" style="position: absolute;bottom:50px; left:20px" class="btn btn-danger">Close</button>
                                </form>
                            </div>
                            <!-- Add new product end-->

                            <!-- Edit product -->
                            <div class="edit-product hide">
                                <!-- BASIC FORM ELELEMNTS -->
                                <h4 class="mb"><i class="fa fa-angle-right"></i>Edit Product</h4>
                                <form class="form-horizontal style-form" method="POST">
                                    <div class="form-group">
                                        <label class="col-sm-4 control-label">Product Name</label>
                                        <div class="col-sm-8">
                                            <input name="description" id="product_edit" type="text" class="form-control">
                                        </div>
                                    </div>
                                    <button onclick="collectEditData(event)" type="button" style="position: absolute;bottom:50px; right:20px" class="btn btn-primary">Save</button>
                                    <button onclick="show_edit_product(0,'')" type="button" style="position: absolute;bottom:50px; left:20px" class="btn btn-danger">Close</button>
                                </form>
                            </div>
                            <!-- Edit product end-->
                            
                            <hr>
                            <thead>
                              <tr>
                                  <th><i class="fa fa-bullhorn"></i> Id</th>
                                  <th class="hidden-phone"><i class="fa fa-question-circle"></i>Name</th>
                                  <th><i class=" fa fa-edit"></i> Category</th>
                                  <th><i class=" fa fa-edit"></i> Qty</th>
                                  <th><i class=" fa fa-edit"></i> Price</th>
                                  <th><i class=" fa fa-edit"></i> Date</th>
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
                    </div><!-- /content-panel -->
          		</div>
          	</div>
			
		
        <script>
            
            var  EDIT_ID = 0;

            // add and hide product modal
            function showAddNew(){
                var showCatBox = document.querySelector(".add-new-product");
                var productInput = document.querySelector("#description");
                if (showCatBox.classList.contains("hide")) {
                    showCatBox.classList.remove("hide"); 
                    productInput.focus();
                }else{
                    showCatBox.classList.add("hide");
                    productInput.value = "";
                }
            }

            // Edit and hide product modal
            function show_edit_product(pId,description,e){
                EDIT_ID = pId;
                var showEditCatBox = document.querySelector(".edit-product");
                var cateInput = document.querySelector("#product_edit");

                cateInput.value = description;
                if (showEditCatBox.classList.contains("hide")) {
                    showEditCatBox.classList.remove("hide"); 
                    cateInput.focus();
                }else{
                    showEditCatBox.classList.add("hide");
                    cateInput.value = "";
                }
            }

            function collectData(e){
               var productInput = document.querySelector("#description"); 
               if (productInput.value.trim() == "" || !isNaN(productInput.value.trim())) {
                alert("Please enter a valid product name");
                return;
               }
               var categoryInput = document.querySelector("#category"); 
               if (categoryInput.value.trim() == "" || isNaN(categoryInput.value.trim())) {
                alert("Please enter a valid category name");
                return;
               }
               var quantityInput = document.querySelector("#quantity"); 
               if (quantityInput.value.trim() == "" || isNaN(quantityInput.value.trim())) {
                alert("Please enter a valid quantity name");
                return;
               }
               var priceInput = document.querySelector("#price"); 
               if (priceInput.value.trim() == "" || isNaN(priceInput.value.trim())) {
                alert("Please enter a valid price name");
                return;
               }
               var imageInput = document.querySelector("#image"); 
               if (imageInput.files.length == 0 ) {
                alert("Please enter a valid image");
                return;
               }

               var data = new FormData();
              
               var image2Input = document.querySelector("#image2"); 
               if (image2Input.files.length > 0 ) {
                data.append("image2", image2Input.files[0]);
               }

             
               var image3Input = document.querySelector("#image3"); 
               if (image3Input.files.length > 0 ) {
                data.append("image3", image3Input.files[0]);
               }
              
               var image4Input = document.querySelector("#image4"); 
               if (image4Input.files.length > 0 ) {
                data.append("image4", image4Input.files[0]);
               }
               
               data.append("description", productInput.value.trim());
               data.append("category", categoryInput.value.trim());
               data.append("quantity", quantityInput.value.trim());
               data.append("price", priceInput.value.trim());
               data.append("image", imageInput.files[0]);
               data.append("data_type", "add_product");
               
               sendDataFile(data);


            }

            function collectEditData(e){
               var cateInput = document.querySelector("#product_edit"); 
               if (cateInput.value.trim() == "" || !isNaN(cateInput.value.trim())) {
                alert("Please enter a valid product name");
               }

               var data = cateInput.value.trim()
               sendData({
                    pId:EDIT_ID,
                    product:data,
                    data_type: "edit_product"
                    });


            }
            // Send only post data
            function sendData(data = {}){

                var ajax = new XMLHttpRequest();
                // var form = new FormData();

                // form.append('data', data);

                ajax.addEventListener("readystatechange", function(){
                    if (ajax.readyState == 4 && ajax.status == 200) {
                        handleResult(ajax.responseText);
                    }
                });
                ajax.open("POST", "<?=ROOT?>ajax_product", true);
                ajax.send(JSON.stringify(data));
            }
            // Send only form data like files, images
            function sendDataFile(formData){

                var ajax = new XMLHttpRequest();
                // var form = new FormData();

                // form.append('data', data);

                ajax.addEventListener("readystatechange", function(){
                    if (ajax.readyState == 4 && ajax.status == 200) {
                        handleResult(ajax.responseText);
                    }
                });
                ajax.open("POST", "<?=ROOT?>ajax_product", true);
                ajax.send(formData);
            }

            function handleResult(result){
                console.log(result);
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
                            if (obj.data_type == "edit_product") {

                                show_edit_product(0,'',false);
                                
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
            // Edit product
            function edit_row(pId){

                sendData({
                    data_type: "",
                });
            }
            // Delete product
            function delete_row(pId){
                if (!confirm("Are your sure you want to delete this product")) {
                    return;
                }
                sendData({
                    data_type: "delete_row",
                    pId:pId
                });
            }
            // Disable product
            function disable_row(pId,state){
                sendData({
                    data_type: "disable_row",
                    pId:pId,
                    current_state:state
                });
            }
        </script>
      <!--main content end-->
 <!-- Footer -->
 <?php $this->view("admin/footer", $data) ?>