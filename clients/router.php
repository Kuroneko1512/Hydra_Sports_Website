<?php
// index phục vụ request của người dùng

// kiểm tra act và điều hướng tới các controller phù hợp
match ($route->getAct()) {
    '/' => (new HomeController())->index()
};