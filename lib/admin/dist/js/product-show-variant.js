// Hàm để tạo bảng phụ
function createSubTable(variantData) {
    const subTableHtml = `
                    <tr class="sub-table">
                        <td colspan="13">
                            <table class="table table-striped table-bordered  table-hover table-sm">
                                <thead class="thead-light">
                                    <tr>
                                        <th></th>
                                        <th>
                                            <label class="customcheckbox m-b-20">
                                                <input type="checkbox" class="mainCheckbox1" />
                                                <span class="checkmark"></span>
                                            </label>
                                        </th>
                                        <th>Image</th>
                                        <th>Color</th>
                                        <th>Size</th>
                                        <th>Số lượng</th>
                                        <th>Giá</th>
                                        <th>SKU</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    ${variantData
                                        .map(
                                            (variant) =>
                                                `
                                                    <tr>
                                                        <td></td>
                                                        <td>
                                                            <label class="customcheckbox">
                                                                <input type="checkbox" class="listCheckbox1" />
                                                                <span class="checkmark"></span>
                                                            </label>
                                                        </td>
                                                        <td>
                                                            ${variant.images.map(image => `
                                                                <img src="${image.image_url}" alt="Image" style="width: 50px; height: 50px;" class="${image.is_primary ? 'primary-image' : ''}">
                                                            `).join('')}
                                                        </td>
                                                        <td>${variant.color_name}</td>
                                                        <td>${variant.size_name}</td>
                                                        <td>${variant.stock}</td>
                                                        <td>${variant.price}</td>
                                                        <td></td>
                                                        <td>
                                                            <a href="">
                                                                <button type="button" class="btn btn-cyan btn-sm">Edit</button>
                                                            </a>
                                                            <a href="">
                                                                <button type="button" class="btn btn-danger btn-sm">Delete</button>
                                                            </a>
                                                        </td>
                                                    </tr>
                                                `
                                        )
                                        .join("")}
                                </tbody>
                            </table>
                        </td>
                    </tr>
                    `;
    return subTableHtml;
}

// Hàm xử lý sự kiện click cho tên sản phẩm
function handleProductNameClick(event) {
    event.preventDefault();
    const productId = this.dataset.productId;
    const productRow = this.closest("tr");
    const subTableRow = productRow.nextElementSibling;

    let subTableHtml ;
    // var getProductVariantUrl = '<?= $route->getLocateAdmin("get-product-variant", ["product_id" => "${productId}"]) ?>';
    var getProductVariantUrl = `<?= $route->getLocateAdmin("get-product-variant", ["product_id" => "${productId}"]) ?>`;

    if (subTableRow && subTableRow.classList.contains("sub-table")) {
        // Nếu bảng phụ đã tồn tại, ẩn hoặc hiển thị nó
        subTableRow.style.display =
            subTableRow.style.display === "none" ? "table-row" : "none";
    } else {
        // Nếu bảng phụ chưa tồn tại, lấy dữ liệu từ máy chủ và tạo bảng phụ
        // fetch(`<?= $route->getLocateAdmin('get-product-variant') ?>&product_id=${productId}`, {
            const getProductVariantUrl = getProductVariantUrlBase + '&product_id=' + productId;

        fetch(getProductVariantUrl, {
            method: 'GET',
            headers: { 'Content-Type': 'application/json' },
        })
            .then(response => response.json())
            .then(variantData => {
                subTableHtml = createSubTable(variantData);
                productRow.insertAdjacentHTML('afterend', subTableHtml);
                console.log(subTableHtml);
            })
            .catch(error => console.error('Error fetching product variants:', error));;
        // const variantData = [
        //     {
        //         color: "Đỏ",
        //         size: "XL",
        //         quantity: 100,
        //         price: "$50",
        //         sku: "AT001-RED-XL",
        //     },
        //     {
        //         color: "Xanh",
        //         size: "L",
        //         quantity: 75,
        //         price: "$45",
        //         sku: "AT001-BLUE-L",
        //     },
        // ];
        // const subTableHtml = createSubTable(variantData);
        // productRow.insertAdjacentHTML("afterend", subTableHtml);
        // console.log(subTableHtml);
    }
}
// Gắn sự kiện click cho các tên sản phẩm
function attachProductNameClickEvent() {
    var productNames = document.querySelectorAll("#TableProduct .product-name");

    productNames.forEach(function(productName) {
        productName.addEventListener("click", handleProductNameClick);
    });
}

// Gắn sự kiện click lần đầu tiên
attachProductNameClickEvent();

// Gắn lại sự kiện click khi dữ liệu được tải lại
var dataTable = $('#zero_config3').DataTable();
dataTable.on('draw', function() {
    // Xóa tất cả sự kiện click cũ trên tên sản phẩm
    var productNames = document.querySelectorAll("#TableProduct .product-name");
    productNames.forEach(function(productName) {
        productName.removeEventListener("click", handleProductNameClick);
    });

    // Gắn lại sự kiện click mới
    attachProductNameClickEvent();
});

// Xử lý sự kiện tìm kiếm
dataTable.on('search.dt', function() {
    // Xóa tất cả sự kiện click cũ trên tên sản phẩm
    var productNames = document.querySelectorAll("#TableProduct .product-name");
    productNames.forEach(function(productName) {
        productName.removeEventListener("click", handleProductNameClick);
    });

    // Gắn lại sự kiện click mới
    attachProductNameClickEvent();
});

// Gắn sự kiện click cho các tên sản phẩm
// document.querySelectorAll("#TableProduct .product-name")
//     .forEach((productName) => {
//         productName.addEventListener("click", handleProductNameClick);
//         console.log("done 2");
//     });
// const a = document.querySelectorAll("#TableProduct .product-name");
// console.log(handleProductNameClick);

// <td>
//     ${(() => {
//         const primaryImage = variant.images.find(image => image.is_primary);
//         const otherImagesCount = variant.images.length - 1;
//         console.log(primaryImage);
//         console.log(primaryImage.image_url);
//         return `
//             <div class="image-container">
//                 <img src="${primaryImage.image_url}" alt="Image" style="width: 50px; height: 50px;">
//                 ${otherImagesCount > 0 ? `<span class="image-count">+${otherImagesCount}</span>` : ''}
//             </div>
//         `;
//     })()}
// </td>