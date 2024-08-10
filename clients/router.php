<?php
// index phục vụ request của người dùng

// kiểm tra act và điều hướng tới các controller phù hợp
match ($route->getAct()) {
    '/' => (new HomeController())->index(),
    'login' => (new SessionController())->login(),
    'signup' => (new SignupController())->signup(),
    'logout' => (new SessionController())->logout(),
    'product' => (new CategoryController())->product_list(),
    'product_detail' => (new ProductController())->detail(),

    'contact' => (new ContactController())->contact(),
    'checkout' => (new CheckoutController())->checkout(),
    'success' => (new CheckoutController())->success(),

    'cart' => (new CartController())->cart(),

};
