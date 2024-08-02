<?php 
    class HomeController extends BaseController
    {
        public function loadModels(){}

        public function index() {
        $categoryModel =  new Category();
        $categories = $categoryModel->getCategories(8);
        $data['categories'] = $categories;

        $productModel= new Product();
        $productVariantModel= new ProductVariant();
        $productImageModel= new ProductImage();

        $products= $productModel->getProducts(null, 8);
        // $products= $productModel->allTable();
        $productsRecent= $productModel->getProductRecent(8);
        // pp($productsRecent);
        foreach ($products as $key => $value) {
            
            $productVariants=$productVariantModel->all_VR_Table($value['id']);
            $productImages = $productImageModel->all_Image_Table($value['id']);

            $products[$key]['price'] = isset($productVariants[0]['price']) ? $productVariants[0]['price'] : 0;
            $products[$key]['image_url'] = isset($productImages[0]['image_url']) ? $productImages[0]['image_url'] : '';
        }
        foreach ($productsRecent as $key => $value) {
            
            $productVariants=$productVariantModel->all_VR_Table($value['id']);
            $productImages = $productImageModel->all_Image_Table($value['id']);

            $productsRecent[$key]['price'] = isset($productVariants[0]['price']) ? $productVariants[0]['price'] : 0;
            $productsRecent[$key]['image_url'] = isset($productImages[0]['image_url']) ? $productImages[0]['image_url'] : '';
        }

        $data['products']=$products;
        $data['productsRecent'] = $productsRecent;
        
        $this->viewApp->requestView('index', $data);
    }
        
    }

?>