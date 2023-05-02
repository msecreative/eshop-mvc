<?php $this->view("header", $data) ?>
<style>
        /*White Panel */
    .white-panel {
        text-align: center;
        background: #f4f4f4;
        color: #11151b;
        margin-bottom: 40px;
    }

    .white-panel p {
        margin-top: 5px;
        font-weight: 700;
        margin-left: 15px;
    }
    .white-panel .white-header {
        background: #fdb45e;
        padding: 3px;
        margin-bottom: 15px;
        color: #11151b;
    }
    .white-panel .small {
        font-size: 10px;
        color: #11151b;
    }

    .white-panel i {
        color: #68dff0;
        padding-right: 4px;
        font-size: 14px;
    }
    .pn:hover {
        box-shadow: 2px 3px 2px rgba(0, 0, 0, 0.3);
    }
</style>
<section class="user-profile">
    <div class="container">
        <div class="row">
            <div class="col-md-4">
                <!-- WHITE PANEL - TOP USER -->
                <div class="white-panel pn">
                    <div class="white-header">
                        <h5><?=$data["user_data"]->rank ?></h5>
                    </div>
                    <p><img src="<?=ASSETS . THEME ?>admin/img/ui-zac.jpg" class="img-circle" width="80"></p>
                    <p><b><?=$data["user_data"]->name ?></b></p>
                    <div class="row">
                        <div class="col-md-6">
                            <p class="small mt">MEMBER SINCE</p>
                            <p>2012</p>
                        </div>
                        <div class="col-md-6">
                            <p class="small mt">TOTAL SPEND</p>
                            <p>$ 47,60</p>
                        </div>
                    </div>
                </div>
            </div><!-- /col-md-4 -->
        </div>
    </div>
</section>

<?php $this->view("footer", $data) ?>