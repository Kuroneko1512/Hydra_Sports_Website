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
                                        <th>Màu</th>
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
                                                        <td>${variant.color}</td>
                                                        <td>${variant.size}</td>
                                                        <td>${variant.quantity}</td>
                                                        <td>${variant.price}</td>
                                                        <td>${variant.sku}</td>
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

    if (subTableRow && subTableRow.classList.contains("sub-table")) {
        // Nếu bảng phụ đã tồn tại, ẩn hoặc hiển thị nó
        subTableRow.style.display =
            subTableRow.style.display === "none" ? "table-row" : "none";
    } else {
        // Nếu bảng phụ chưa tồn tại, lấy dữ liệu từ máy chủ và tạo bảng phụ
        //   fetch(`get_product_variants.php?product_id=${productId}`)
        //     .then(response => response.json())
        //     .then(variantData => {
        //       const subTableHtml = createSubTable(variantData);
        //       productRow.insertAdjacentHTML('afterend', subTableHtml);
        //     });
        const variantData = [
            {
                color: "Đỏ",
                size: "XL",
                quantity: 100,
                price: "$50",
                sku: "AT001-RED-XL",
            },
            {
                color: "Xanh",
                size: "L",
                quantity: 75,
                price: "$45",
                sku: "AT001-BLUE-L",
            },
        ];
        const subTableHtml = createSubTable(variantData);
        productRow.insertAdjacentHTML("afterend", subTableHtml);
        console.log(subTableHtml);
    }
}

// Gắn sự kiện click cho các tên sản phẩm
document
    .querySelectorAll("#TableProduct .product-name")
    .forEach((productName) => {
        productName.addEventListener("click", handleProductNameClick);
        console.log("done 2");
    });
// const a = document.querySelectorAll("#TableProduct .product-name");
// console.log(handleProductNameClick);
