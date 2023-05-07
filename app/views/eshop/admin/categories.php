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
        .add-new-category{
            width: 50%;
            height: 300px;
            background-color: #cecccc;
            position: absolute;
            padding: 10px;
            left: 25%;
            top: 40%;
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
                                    <button onclick="collectData(event)" type="button" style="position: absolute;bottom:50px; right:20px" class="btn btn-primary">Save</button>
                                    <button onclick="showAddNew(event)" type="button" style="position: absolute;bottom:50px; left:20px" class="btn btn-danger">Close</button>
                                </form>
                            </div>
                            
                            <hr>
                            <thead>
                              <tr>
                                  <th><i class="fa fa-bullhorn"></i> Id</th>
                                  <th class="hidden-phone"><i class="fa fa-question-circle"></i> Category Name</th>
                                  <th><i class=" fa fa-edit"></i> Status</th>
                                  <th><i class="fa fa-bookmark"></i> Action</th>
                                  <th></th>
                              </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td><a href="basic_table.html#">Company Ltd</a></td>
                                    <td class="hidden-phone">Lorem Ipsum dolor</td>
                                    <td>12000.00$ </td>
                                    <td><span class="label label-info label-mini">Due</span></td>
                                    <td>
                                        <button class="btn btn-success btn-xs"><i class="fa fa-check"></i></button>
                                        <button class="btn btn-primary btn-xs"><i class="fa fa-pencil"></i></button>
                                        <button class="btn btn-danger btn-xs"><i class="fa fa-trash-o "></i></button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div><!-- /content-panel -->
          		</div>
          	</div>
			
		
        <script>
            // add and hide modal
            function showAddNew(e){
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

            function collectData(){
               var cateInput = document.querySelector("#category"); 
               if (cateInput.value.trim() == "" || !isNaN(cateInput.value.trim())) {
                alert("Please enter a valid category name");
               }
               sendData(cateInput.value.trim());


            }
            function sendData(data){

                var ajax = new XMLHttpRequest();
                var form = new FormData();

                form.append('data', 'data');

                ajax.addEventListener("readystatechange", function(){
                    if (ajax.readyState == 4 && ajax.status == 200) {
                        handleResult(ajax.responseText);
                    }
                });
                ajax.open("POST", "<?=ROOT?>ajax", true);
                ajax.send(form);
            }

            function handleResult(result){
                showAddNew();

            }
        </script>
      <!--main content end-->
 <!-- Footer -->
 <?php $this->view("admin/footer", $data) ?>