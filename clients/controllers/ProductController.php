<?php 

class ProductController extends BaseController
{
    public function loadModels() {}

    public function detail() {
        
        $id=$_GET['id'];
        $productVariantModel= new ProductVariant(); // khởi tạo project mới
        $productImageModel= new ProductImage();
        $productModel= new Product();
        $colorModel= new Color();
        $sizeModel= new Size();

        $colors = $colorModel->allTable();
        $sizes = $sizeModel->allTable();

        $product=$productModel->findIdTable($id);
        $productVariantsDetail=$productVariantModel->all_VR_Table($product['id']);
        $productImagesDetail = $productImageModel->all_Image_Table($product['id']);

        $product['price'] = isset($productVariantsDetail[0]['price']) ? $productVariantsDetail[0]['price'] : 0;
        $product['image_url'] = isset($productImagesDetail[0]['image_url']) ? $productImagesDetail[0]['image_url'] : '';
        $data['product'] = $product;

        // pp($productImagesDetail);

        foreach ($productVariantsDetail as $key => $variant) {
            foreach ($sizes as $value) {
                if ($variant['size_id'] == $value['id']) {
                    $productVariantsDetail[$key]['size_name'] = $value['size_name'];
                    break;
                }
            }

            foreach ($colors as $value) {
                if ($variant['color_id'] == $value['id']) {
                    $productVariantsDetail[$key]['color_name'] = $value['color_name'];
                    break;
                }
            }
        }

        $data['productVariantsDetail'] = $productVariantsDetail;
        $data['productImagesDetail'] = $productImagesDetail;

        $data['colors'] = $colors;
        $data['sizes'] = $sizes;

        $page = isset($_GET['page']) ? $_GET['page'] : 1; // phân trang
        $limit = 8;
        $products = $productModel->getProducts(null, $limit, ($page - 1) * $limit);
        foreach ($products as $key => $value) {
            
            $productVariants=$productVariantModel->all_VR_Table($value['id']);
            $productImages = $productImageModel->all_Image_Table($value['id']);

            $products[$key]['price'] = isset($productVariants[0]['price']) ? $productVariants[0]['price'] : 0;
            $products[$key]['image_url'] = isset($productImages[0]['image_url']) ? $productImages[0]['image_url'] : '';
        }
        $data['products'] = $products;
        
        $this->viewApp->requestView('product.detail', $data);
    }


}