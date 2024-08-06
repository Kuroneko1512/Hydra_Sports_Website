<?php
    class ReviewController extends BaseController{
        public $reviewModel;
        public function loadModels(){
            $this->reviewModel = new Review();
        }

        public function list(){
            $reviews = $this->reviewModel->allTable();
            $this->viewApp->requestView('review.list', ['reviews' => $reviews]);
        }

        public function index(){    
            //     $reviews = $this->reviewModel->allTable();
            //     $this->viewApp->requestView('review.list', ['reviews' => $reviews]);
            // 
                $productModel= new Product();
                $data['products'] = $productModel->allTable();
                $userModel= new User();
                $data['users'] = $userModel->allTable();
                $reviewModel = new Review();
                $reviews = $reviewModel->allTable();
                $data['reviews'] = $reviews;
    
                $this->viewApp->requestView('review.index', $data);
            }
    
            public function add(){
                $productModel= new Product();
                $userModel= new User();
                $data= [];
                $data['products'] = $productModel->allTable();
                $data['users'] = $userModel->allTable();
    
                $reviewModel = new Review();//Khởi tạo một object mới
    
                if(isset($_POST['btn_add'])){
                    // var_dump($_POST);
                    // die();
                    $user_id = $_POST['user_id'];
                    $product_id=$_POST['product_id'];
                    $order_id=$_POST['order_id'];
                    $rating=$_POST['rating'];
                    $content=$_POST['content'];
    
                    $dataComment['user_id'] = $user_id;
                    $dataComment['product_id'] = $product_id;
                    $dataComment['order_id'] = (int)$order_id;
                    $dataComment['content'] = $content;
                    $dataComment['rating'] = $rating;
                    $reviewModel->insertTable($dataComment);
                    $this->route->redirectAdmin('review_list');
                }
                $this->viewApp->requestView('review.add', $data);
            }
    }

?>