// (function ($) {
//     "use strict";
    
//     // Dropdown on mouse hover
//     $(document).ready(function () {
//         function toggleNavbarMethod() {
//             if ($(window).width() > 992) {
//                 $('.navbar .dropdown').on('mouseover', function () {
//                     $('.dropdown-toggle', this).trigger('click');
//                 }).on('mouseout', function () {
//                     $('.dropdown-toggle', this).trigger('click').blur();
//                 });
//             } else {
//                 $('.navbar .dropdown').off('mouseover').off('mouseout');
//             }
//         }
//         toggleNavbarMethod();
//         $(window).resize(toggleNavbarMethod);
//     });
    
    
//     // Back to top button
//     $(window).scroll(function () {
//         if ($(this).scrollTop() > 100) {
//             $('.back-to-top').fadeIn('slow');
//         } else {
//             $('.back-to-top').fadeOut('slow');
//         }
//     });
//     $('.back-to-top').click(function () {
//         $('html, body').animate({scrollTop: 0}, 1500, 'easeInOutExpo');
//         return false;
//     });


//     // Vendor carousel
//     $('.vendor-carousel').owlCarousel({
//         loop: true,
//         margin: 29,
//         nav: false,
//         autoplay: true,
//         smartSpeed: 1000,
//         responsive: {
//             0:{
//                 items:2
//             },
//             576:{
//                 items:3
//             },
//             768:{
//                 items:4
//             },
//             992:{
//                 items:5
//             },
//             1200:{
//                 items:6
//             }
//         }
//     });


//     // Related carousel
//     $('.related-carousel').owlCarousel({
//         loop: true,
//         margin: 29,
//         nav: false,
//         autoplay: true,
//         smartSpeed: 1000,
//         responsive: {
//             0:{
//                 items:1
//             },
//             576:{
//                 items:2
//             },
//             768:{
//                 items:3
//             },
//             992:{
//                 items:4
//             }
//         }
//     });


//     // Product Quantity
//     $('.quantity button').on('click', function () {
//         var button = $(this);
//         var oldValue = button.parent().parent().find('input').val();
//         if (button.hasClass('btn-plus')) {
//             var newVal = parseFloat(oldValue) + 1;
//         } else {
//             if (oldValue > 0) {
//                 var newVal = parseFloat(oldValue) - 1;
//             } else {
//                 newVal = 0;
//             }
//         }
//         button.parent().parent().find('input').val(newVal);
//     });
    
// })(jQuery);

(function ($) {
    "use strict";
    
    // Dropdown on mouse hover
    $(document).ready(function () {
        function toggleNavbarMethod() {
            if ($(window).width() > 992) {
                $('.navbar .dropdown').on('mouseover', function () {
                    $('.dropdown-toggle', this).trigger('click');
                }).on('mouseout', function () {
                    $('.dropdown-toggle', this).trigger('click').blur();
                });
            } else {
                $('.navbar .dropdown').off('mouseover').off('mouseout');
            }
        }
        toggleNavbarMethod();
        $(window).resize(toggleNavbarMethod);
    });
    
    
    // Back to top button
    $(window).scroll(function () {
        if ($(this).scrollTop() > 100) {
            $('.back-to-top').fadeIn('slow');
        } else {
            $('.back-to-top').fadeOut('slow');
        }
    });
    $('.back-to-top').click(function () {
        $('html, body').animate({scrollTop: 0}, 1500, 'easeInOutExpo');
        return false;
    });


    // Vendor carousel
    $('.vendor-carousel').owlCarousel({
        loop: true,
        margin: 29,
        nav: false,
        autoplay: true,
        smartSpeed: 1000,
        responsive: {
            0:{
                items:2
            },
            576:{
                items:3
            },
            768:{
                items:4
            },
            992:{
                items:5
            },
            1200:{
                items:6
            }
        }
    });


    // Related carousel
    $('.related-carousel').owlCarousel({
        loop: true,
        margin: 29,
        nav: false,
        autoplay: true,
        smartSpeed: 1000,
        responsive: {
            0:{
                items:1
            },
            576:{
                items:2
            },
            768:{
                items:3
            },
            992:{
                items:4
            }
        }
    });


    // Product Quantity in detail product
    $('.quantity button.in-detail').on('click', function (e) {
        console.log('detail');
        e.preventDefault();
        var button = $(this);// chính là button
        var oldValue = button.parent().parent().find('input').val();
        if (button.hasClass('btn-plus')) {
            var newVal = parseFloat(oldValue) + 1;
        } else {
            if (oldValue > 0) {
                var newVal = parseFloat(oldValue) - 1;
            } else {
                newVal = 0;
            }
        }
        button.parent().parent().find('input').val(newVal);
    });
    
    // Product Quantity in cart
    $('.quantity button.in-cart').on('click', function (e) {
        console.log('cart');
        e.preventDefault();
        var button = $(this);
        var oldValue = button.parent().parent().find('input').val();
        var itemID = button.parent().parent().find('input').attr('data-id');
        var price = button.parent().parent().find('input').attr('data-price');
        if (button.hasClass('btn-plus')) {
            var newVal = parseFloat(oldValue) + 1;
        } else {
            if (oldValue > 0) {
                var newVal = parseFloat(oldValue) - 1;
            } else {
                newVal = 0;
            }
        }

        if (newVal <= 0) {
            return 0;
        }
        console.log('newVal', newVal);

        $.ajax({ // để call API
            url: baseURL + "?act=update-cart",
            type: "post",
            data: {id: itemID, quantity: newVal} ,
            success: function (response) {
                button.parent().parent().find('input').val(newVal);// xét giá trị để nó tăng lên
                //window.location.replace(baseURL + "?act=cart");// refresh lại page
                button.parent().parent().parent().parent().find('.total-item-price').text('$' + (newVal * price));

                var totalPrice = 0;
                $('.item-in-cart').each(function() {
                    totalPrice += $(this).attr('data-price') * $(this).val();
                });
                $('#total-price-in-cart').text('$' + totalPrice);
                $('#subtotal-in-cart').text('$' + totalPrice);
            },
            error: function(jqXHR, textStatus, errorThrown) {
               console.log(textStatus, errorThrown);
            }
        });
        
    });
    // Xóa sản phẩm trong giỏ hàng
    $('.delete-item-in-cart').on('click', function (e) {
        e.preventDefault();
        var button = $(this);
        var itemID = button.parent().parent().find('input').attr('data-id');//?

        $.ajax({
            url: baseURL + "?act=delete-item-in-cart",
            type: "post",
            data: {id: itemID} ,
            success: function (response) {
                button.parent().parent().remove();

                var totalPrice = 0;
                $('.item-in-cart').each(function() {
                    totalPrice += $(this).attr('data-price') * $(this).val();
                });
                $('#total-price-in-cart').text('$' + totalPrice);
                $('#subtotal-in-cart').text('$' + totalPrice);
            },
            error: function(jqXHR, textStatus, errorThrown) {
               console.log(textStatus, errorThrown);
            }
        });
        
    });
    
})(jQuery);
// Bắt sự kiện màu và color để lấy ra id của sản phẩm 
function changeImageProduct() {
    var size = document.querySelector('input[name="size"]:checked').value; // how-to-get-the-value-of-a-selected-radio-button
    var color = document.querySelector('input[name="color"]:checked').value; // how-to-get-the-value-of-a-selected-radio-button
    
    var varientID = null;
    var price = 0;


    for (var i = 0; i < variants.length; i++) {

        // console.log('variants[i].color_id', variants[i].color_id);
        // console.log('variants[i].size_id', variants[i].size_id);
        // console.log('color', color);
        // console.log('size', size);

        if (variants[i].color_id == color && variants[i].size_id == size) {
            varientID = variants[i].id;
            price = variants[i].price;
        }
    }

    if (varientID != null) {

        document.getElementById("product_price").innerHTML= '$' + price;
        document.getElementById("variant_id").value= varientID;

        var imageUrl = null;

        for (var i = 0; i < images.length; i++) {
            if (images[i].product_variant_id == varientID) {
                imageUrl = images[i].image_url;
                break;
            }
        }

        if (imageUrl != null) {
            document.getElementById("product_image").src= baseURL + 'uploads/products/' + imageUrl;
        }

    }


}
