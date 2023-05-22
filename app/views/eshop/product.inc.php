<div class="col-sm-4">
    <div class="product-image-wrapper">
        <div class="single-products">
            <div class="productinfo text-center">
                <div style="overflow: hidden;">
                <img class="product-overley" src="<?=ROOT.$data->image?>" alt="" />
                </div>
                <h2>$<?=$data->price?></h2>
                <p><a href="productDetails/<?=$data->slag?>"><?=$data->description?></a></p>
                <a href="" class="btn btn-default add-to-cart"><i class="fa fa-shopping-cart"></i>Add to cart</a>
            </div>
        </div>
        <div class="choose">
            <ul class="nav nav-pills nav-justified">
                <li><a href="#"><i class="fa fa-plus-square"></i>Add to wishlist</a></li>
                <li><a href="#"><i class="fa fa-plus-square"></i>Add to compare</a></li>
            </ul>
        </div>
    </div>
</div>