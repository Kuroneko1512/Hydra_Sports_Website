// Lấy tất cả các checkbox trong bảng
var checkboxes = document.querySelectorAll('.listCheckbox');

// Tạo một hàm để hiển thị dữ liệu của các dòng có checkbox được chọn
function displaySelectedRows() {
// Lặp qua tất cả các checkbox
checkboxes.forEach(function(checkbox) {
    // Kiểm tra nếu checkbox đã được chọn
    if (checkbox.checked) {
    // Tìm dòng tương ứng với checkbox được chọn
    var row = checkbox.closest('tr');

    // Lấy dữ liệu của dòng
    var renderingEngine = row.cells[1].textContent;
    var browser = row.cells[2].textContent;
    var platform = row.cells[3].textContent;
    var engineVersion = row.cells[4].textContent;

    // Hiển thị dữ liệu trong console
    console.log('Rendering engine: ' + renderingEngine);
    console.log('Browser: ' + browser);
    console.log('Platform: ' + platform);
    console.log('Engine version: ' + engineVersion);
    console.log('---');            
    }
});
}

// Gán sự kiện click cho checkbox chọn tất cả
var mainCheckbox = document.getElementById('mainCheckbox');
mainCheckbox.addEventListener('change', function() {
// Lặp qua tất cả các checkbox và đặt trạng thái tương ứng với checkbox chọn tất cả
checkboxes.forEach(function(checkbox) {
    checkbox.checked = mainCheckbox.checked;
});
// Hiển thị dữ liệu của các dòng được chọn
displaySelectedRows();
console.log('done all');
});

// Gán sự kiện click cho các checkbox riêng lẻ
checkboxes.forEach(function(checkbox) {
    checkbox.addEventListener('change', function() {
        // Hiển thị dữ liệu của các dòng được chọn
        displaySelectedRows();
        console.log('done 1');
    });
});