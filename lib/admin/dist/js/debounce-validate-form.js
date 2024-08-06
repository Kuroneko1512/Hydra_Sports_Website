// Hàm debounce để giới hạn tần suất gọi hàm
function debounce(func, wait) {
    let timeout;
    return function(...args) {
        clearTimeout(timeout);
        timeout = setTimeout(() => func.apply(this, args), wait);
    };
}

// Hàm tạo validator cho form
function createValidator(formId, validateEndpoint) {
    const form = document.getElementById(formId);
    console.log(form);
    if (!form) return;

    const inputs = form.querySelectorAll('input[name]');
    const submitButton = form.querySelector('button[type="submit"]');

    // Hàm xác thực form với debounce
    const validateForm = debounce(function() {
        const formData = new FormData(form);
        const data = Object.fromEntries(formData);

        // Gửi request xác thực đến server
        fetch(validateEndpoint, {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify(data)
        })
        .then(response => response.json())
        .then(errors => {
            // Xóa tất cả thông báo lỗi cũ
            form.querySelectorAll('.error-message').forEach(el => el.textContent = '');
            
            // Hiển thị các lỗi mới (nếu có)
            let hasErrors = false;
            for (const [field, message] of Object.entries(errors)) {
                const errorElement = form.querySelector(`#${field}-error`);
                if (errorElement) {
                    errorElement.textContent = message;
                    hasErrors = true;
                }
            }
            console.log('show new error');
            // Cập nhật trạng thái nút submit
            submitButton.disabled = hasErrors;
        })
        .catch(error => console.error('Error:', error));
    }, 300);

    // Thêm sự kiện input cho mỗi trường nhập liệu
    inputs.forEach(input => input.addEventListener('input', validateForm));
    console.log('show input error');
    // Thêm sự kiện submit cho form
    form.addEventListener('submit', function(event) {
        const formData = new FormData(form);
        let hasEmptyFields = false;

        // Kiểm tra các trường rỗng
        for (let [key, value] of formData.entries()) {
            if (value.trim() === '') {
                hasEmptyFields = true;
                break;
            }
        }

        // Ngăn chặn submit nếu có trường rỗng hoặc còn lỗi
        if (hasEmptyFields || submitButton.disabled) {
            event.preventDefault();
            alert('Vui lòng điền đầy đủ thông tin và sửa các lỗi trước khi gửi.');
        }
    });
}

// Khởi tạo validator khi DOM đã sẵn sàng
document.addEventListener('DOMContentLoaded', function() {
    const forms = {
        'createUserForm': validateUserDataUrl,
        'editUserForm': validateEditUserDataUrl,
        'createCategoryForm':validateCategoryUrl,
        'editCategoryForm':validateEditCategoryUrl,
        'createColorForm':validateColorUrl,
        'editColorForm':validateEditColorUrl,
        'createSizeForm':validateSizeUrl,
        'editSizeForm':validateEditSizeUrl
    };

    for (const [formId, endpoint] of Object.entries(forms)) {
        if (document.getElementById(formId)) {
            createValidator(formId, endpoint);
        }
    }
});
