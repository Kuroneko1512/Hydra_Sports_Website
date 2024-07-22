<?php
// index phục vụ request của người dùng

// kiểm tra act và điều hướng tới các controller phù hợp
match ($route->getAct()) {
    '/' => (new HomeController())->index(),
    'product_detail' => (new ProductController())->detail(),
    'category' => (new CategoryController())->category(),
    'contact' => (new ContactController())->contact(),
    'shoppingcart_cart' => (new ShoppingCartController())->cart(),
    'checkout' => (new CheckoutController())->checkout(),

    'cart' => (new CartController())->cart(),
    

};