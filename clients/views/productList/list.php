<!-- Breadcrumb Start -->
<div class="container-fluid">
    <div class="row px-xl-5">
        <div class="col-9">
            <nav class="breadcrumb bg-light mb-30">
                <a class="breadcrumb-item text-dark" href="#">Home</a>
                <span class="breadcrumb-item active">Product List</span>
            </nav>
        </div>

        
    </div>
</div>
<!-- Breadcrumb End -->


<!-- Shop Start -->
<div class="container-fluid">
    <div class="row px-xl-5">


        <!-- Shop Product Start -->
        <div class="col-lg-12 col-md-8">
            <div class="row pb-3">
                <?php foreach($products as $product){ ?>
                    <div class="col-lg-3 col-md-6 col-sm-6 pb-1">
                    <div class="product-item bg-light mb-4">
                        <div class="product-img position-relative overflow-hidden">
                        <img  class="img-fluid w-100" src="<?=BASE_URL?>uploads/products/<?= $product['image_url'] ?>" alt="">
                            <div class="product-action">
                                <a class="btn btn-outline-dark btn-square" href=""><i class="fa fa-shopping-cart"></i></a>
                                <a class="btn btn-outline-dark btn-square" href=""><i class="far fa-heart"></i></a>
                                <a class="btn btn-outline-dark btn-square" href=""><i class="fa fa-sync-alt"></i></a>
                                <a class="btn btn-outline-dark btn-square" href=""><i class="fa fa-search"></i></a>
                            </div>
                        </div>
                        <div class="text-center py-4">
                            <a class="h6 text-decoration-none text-truncate" href="<?= $route->getLocateClient('product_detail') ?>&id=<?= $product['id'] ?>"><?= $product['product_name'] ?></a>
                            <div class="d-flex align-items-center justify-content-center mt-2">
                                <h5><?= $product['price'] ?></h5>
                                <h6 class="text-muted ml-2"><del>$0</del></h6>
                            </div>
                            <div class="d-flex align-items-center justify-content-center mb-1">
                                <small class="fa fa-star text-primary mr-1"></small>
                                <small class="fa fa-star text-primary mr-1"></small>
                                <small class="fa fa-star text-primary mr-1"></small>
                                <small class="fa fa-star text-primary mr-1"></small>
                                <small class="fa fa-star text-primary mr-1"></small>
                            </div>
                        </div>
                    </div>
                </div>
                <?php } ?>
               
                <div class="col-12">
                    <nav>
                        <!-- <ul class="pagination justify-content-center">
                            <li class="page-item disabled"><a class="page-link" href="#">Previous</span></a></li>
                            <li class="page-item active"><a class="page-link" href="#">1</a></li>
                            <li class="page-item"><a class="page-link" href="#">2</a></li>
                            <li class="page-item"><a class="page-link" href="#">3</a></li>
                            <li class="page-item"><a class="page-link" href="#">Next</a></li>
                        </ul> -->

                        <ul class="pagination justify-content-center">
                            <!-- <li class="page-item disabled"><a class="page-link" href="#">Previous</span></a></li> --> 
                            
                            <?php for ($i = 0; $i < ceil($num_of_products / 8); $i++) {?>
                            <li class="page-item"><a class="page-link" href="<?= $route->getLocateClient('product') ?>&page=<?= $i + 1;?>"><?= $i + 1;?></a></li>
                            <?php }?>

                            <!-- <li class="page-item"><a class="page-link" href="#">Next</a></li> -->
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
        <!-- Shop Product End -->
    </div>
</div>
<!-- Shop End -->