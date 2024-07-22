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
    }

?>