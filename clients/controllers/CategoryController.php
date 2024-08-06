<?php 

class CategoryController extends BaseController
{
    public function loadModels() {}

    public function product_list() {
        
        $productVariantModel= new ProductVariant();
        $productImageModel= new ProductImage();
        $productModel= new Product();
        $page = isset($_GET['page']) ? $_GET['page'] : 1; // phân trang
        $cat = isset($_GET['cat']) ? $_GET['cat'] : '';
        $limit = 8;

        $countProduct = $productModel->countProducts(null);
        $data['num_of_products'] = $countProduct;
        $products = $productModel->getProducts($cat, $limit, ($page - 1) * $limit);

        foreach ($products as $key => $value) {
            
            $productVariants=$productVariantModel->all_VR_Table($value['id']);
            $productImages = $productImageModel->all_Image_Table($value['id']);

            $products[$key]['price'] = isset($productVariants[0]['price']) ? $productVariants[0]['price'] : 0;
            $products[$key]['image_url'] = isset($productImages[0]['image_url']) ? $productImages[0]['image_url'] : '';
        }
        $data['products'] = $products;
        $this->viewApp->requestView('productList.list', $data);
    }


}