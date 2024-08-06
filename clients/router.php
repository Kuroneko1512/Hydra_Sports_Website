<?php
// index phục vụ request của người dùng

// kiểm tra act và điều hướng tới các controller phù hợp
match ($route->getAct()) {
    '/' => (new HomeController())->index(),
    'product' => (new CategoryController())->product_list(),
    'product_detail' => (new ProductController())->detail(),

    'contact' => (new ContactController())->contact(),
    'shoppingcart_cart' => (new ShoppingCartController())->cart(),
    'checkout' => (new CheckoutController())->checkout(),

    'cart' => (new CartController())->cart(),

};
