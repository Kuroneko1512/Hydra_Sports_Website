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
    if (!form) return;

    const submitButton = form.querySelector('button[type="submit"]');
    function attachEventListeners(element) {
        element.querySelectorAll('input, select').forEach(input => {
            if (input.type === 'file') {
                input.addEventListener('change', validateForm);
            } else {
                input.addEventListener('input', validateForm);
            }
        });
    }
    function getFormData(form) {
    const formData = new FormData(form);
    const data = {};
    console.log('FormData entries:', Array.from(formData.entries()));
    attachEventListeners(form);
    // Duyệt qua tất cả các trường trong form
    for (let [key, value] of formData.entries()) {
        if (key.startsWith('variant[')) {
            // Xử lý các trường của variant
            const matches = key.match(/variant\[(\d+)\]\[(\w+)\]/);
            if (matches) {
                console.log(`Processing variant field: ${key} = ${value}`);
                const [, index, field] = matches;
                if (!data.variant) data.variant = [];
                if (!data.variant[index]) data.variant[index] = {};

                if (field === 'images[]') {
                    if (!data.variant[index].images) data.variant[index].images = [];
                    if (value instanceof File && value.name) {
                        data.variant[index].images.push(value.name);
                    }
                }
                else {
                    // Xử lý các trường khác của variant
                    data.variant[index][field] = value;
                }
            }
        } else if (key === 'image'|| key === 'avatar') {
            // Xử lý trường ảnh chính của sản phẩm
            if (value instanceof File && value.name) {
                data[key] = value.name;
            } else {
                data[key] = '';
            }
        } else {
            // Xử lý các trường thông thường
            data[key] = value;
        }
    }

    console.log('Processed data before final adjustments:', JSON.stringify(data, null, 2));

    // Xử lý cuối cùng cho các trường của variant
    if (data.variant) {
        const variantRows = form.querySelectorAll('#variants-body tr');
        data.variant.forEach((variant, index) => {
            ['color', 'size', 'stock', 'price'].forEach(field => {
                if (!variant.hasOwnProperty(field) || variant[field] === '') {
                    const input = variantRows[index].querySelector(`[name^="variant[${index}][${field}]"]`);
                    variant[field] = input ? input.value : '';
                }
            });
            if (!Array.isArray(variant.images) || variant.images.length === 0) {
                const imageInputs = variantRows[index].querySelectorAll('input[type="file"]');
                variant.images = Array.from(imageInputs).filter(input => input.files.length > 0).map(input => input.files[0].name);
            }
        });
    }

    console.log('Final data:', JSON.stringify(data, null, 2));
    window.attachEventListeners = attachEventListeners;
    return data;
}


    // Hàm xử lý hiển thị lỗi
    function displayErrors(errors) {
        console.log('Received errors:', errors);
        // Xóa tất cả thông báo lỗi cũ
        form.querySelectorAll('.error-message').forEach(el => el.textContent = '');
        
        let hasErrors = false;
        for (const [field, message] of Object.entries(errors)) {
            let errorElement;
            if (field.includes('.')) {
                // Xử lý lỗi cho các trường phức tạp (như variant)
                const fieldParts = field.split('.');
                const errorId = fieldParts.join('-') + '-error';
                errorElement = form.querySelector(`#${errorId}`);
            } else {
                // Xử lý lỗi cho các trường thông thường
                errorElement = form.querySelector(`#${field}-error`);
            }
            if (errorElement) {
                errorElement.textContent = message;
                hasErrors = true;
            }
        }
        
        // Cập nhật trạng thái nút submit
        submitButton.disabled = hasErrors;
    }

    // Hàm xác thực form với debounce
    const validateForm = debounce(function() {
        const data = getFormData(form);
        console.log("Sending data to server:", JSON.stringify(data, null, 2));

        // Gửi request xác thực đến server
        fetch(validateEndpoint, {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify(data)
        })
        .then(response => response.json())
        .then(errors => {
            console.log('Server response:', errors);
            displayErrors(errors);
        })
        .catch(error => console.error('Error:', error));
    }, 300);

    // Thêm sự kiện change cho các trường select
    form.querySelectorAll('select').forEach(select => {
        select.addEventListener('change', validateForm);
    });
    // Thêm sự kiện input cho các trường nhập liệu
    form.querySelectorAll('input').forEach(input => {
        if (input.type === 'file') {
            input.addEventListener('change', validateForm);
        } else {
            input.addEventListener('input', validateForm);
        }
    });


    // Thêm sự kiện submit cho form
    form.addEventListener('submit', function(event) {
        const formData = new FormData(form);
        let hasEmptyFields = false;

        // Kiểm tra các trường rỗng
        for (let [key, value] of formData.entries()) {
            // Bỏ qua kiểm tra cho các trường file
            if (key === 'image' || key.endsWith('[images][]')) continue;
            
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
        'editSizeForm':validateEditSizeUrl,
        'createProductForm': validateProductDataUrl,
        'editProductForm': validateEditProductDataUrl,
    };

    for (const [formId, endpoint] of Object.entries(forms)) {
        if (document.getElementById(formId)) {
            createValidator(formId, endpoint);
        }
    }
});
// Hàm tạo validator cho form
// function createValidator(formId, validateEndpoint) {
//     const form = document.getElementById(formId);
//     console.log(form);
//     if (!form) return;

//     const inputs = form.querySelectorAll('input[name]');
//     const submitButton = form.querySelector('button[type="submit"]');

//     // Hàm xác thực form với debounce
//     const validateForm = debounce(function() {
//         const formData = new FormData(form);
//         const data = Object.fromEntries(formData);

//         // Gửi request xác thực đến server
//         fetch(validateEndpoint, {
//             method: 'POST',
//             headers: { 'Content-Type': 'application/json' },
//             body: JSON.stringify(data)
//         })
//         .then(response => response.json())
//         .then(errors => {
//             // Xóa tất cả thông báo lỗi cũ
//             form.querySelectorAll('.error-message').forEach(el => el.textContent = '');
            
//             // Hiển thị các lỗi mới (nếu có)
//             let hasErrors = false;
//             for (const [field, message] of Object.entries(errors)) {
//                 const errorElement = form.querySelector(`#${field}-error`);
//                 if (errorElement) {
//                     errorElement.textContent = message;
//                     hasErrors = true;
//                 }
//             }
//             console.log('show new error');
//             // Cập nhật trạng thái nút submit
//             submitButton.disabled = hasErrors;
//         })
//         .catch(error => console.error('Error:', error));
//     }, 300);

//     // Thêm sự kiện input cho mỗi trường nhập liệu
//     inputs.forEach(input => input.addEventListener('input', validateForm));
//     console.log('show input error');
//     // Thêm sự kiện submit cho form
//     form.addEventListener('submit', function(event) {
//         const formData = new FormData(form);
//         let hasEmptyFields = false;

//         // Kiểm tra các trường rỗng
//         for (let [key, value] of formData.entries()) {
//             if (value.trim() === '') {
//                 hasEmptyFields = true;
//                 break;
//             }
//         }

//         // Ngăn chặn submit nếu có trường rỗng hoặc còn lỗi
//         if (hasEmptyFields || submitButton.disabled) {
//             event.preventDefault();
//             alert('Vui lòng điền đầy đủ thông tin và sửa các lỗi trước khi gửi.');
//         }
//     });
// }

// Hàm xử lý dữ liệu form bao gồm cả variant (nếu có)
    // function getFormData(form) {
    //     const formData = new FormData(form);
    //     const data = {};
        
    //     for (let [key, value] of formData.entries()) {
    //         if (key.startsWith('variant[')) {
    //             // Xử lý các trường variant
    //             const matches = key.match(/variant\[(\d+)\]\[(\w+)\]/);
    //             if (matches) {
    //                 const [, index, field] = matches;
    //                 if (!data.variant) data.variant = [];
    //                 if (!data.variant[index]) data.variant[index] = {};
    //                 data.variant[index][field] = value;
    //             }
    //         } else if (key === 'image' || key.endsWith('[images][]')) {
    //             // Xử lý file upload
    //             const fileInput = form.querySelector(`input[name="${key}"]`);
    //             if (fileInput && fileInput.files.length > 0) {
    //                 data[key] = fileInput.files[0].name;
    //             } else {
    //                 data[key] = '';
    //             }
    //         } else {
    //             // Xử lý các trường thông thường
    //             data[key] = value;
    //         }
    //     }
        
    //     // Đảm bảo tất cả các trường variant tồn tại
    //     if (data.variant) {
    //         const variantRows = form.querySelectorAll('#variants-body tr');
    //         data.variant.forEach((variant, index) => {
    //             ['color', 'size', 'stock', 'price'].forEach(field => {
    //                 if (!variant.hasOwnProperty(field)) {
    //                     const input = variantRows[index].querySelector(`[name^="variant[${index}][${field}]"]`);
    //                     variant[field] = input ? input.value : '';
    //                 }
    //             });
    //         });
    //     }
        
    //     console.log('Data received:',data);
    //     return data;
    // }
    // function getFormData(form) {
    //     const formData = new FormData(form);
    //     const data = {};
    //     console.log('FormData entries:', Array.from(formData.entries()));
        
    //     for (let [key, value] of formData.entries()) {
    //         if (key.startsWith('variant[')) {
    //             const matches = key.match(/variant\[(\d+)\]\[(\w+)\]/);
    //             if (matches) {
    //                 console.log(`Processing variant field: ${key} = ${value}`);

    //                 const [, index, field] = matches;
    //                 if (!data.variant) data.variant = [];
    //                 if (!data.variant[index]) data.variant[index] = {};
    //                 if (field === 'images[]') {
    //                     if (!data.variant[index].images) data.variant[index].images = [];
    //                     data.variant[index].images.push(value.name);
    //                 } else {
    //                     data.variant[index][field] = value;
    //                 }
    //             }
    //         } else if (key === 'image') {
    //             const fileInput = form.querySelector(`input[name="${key}"]`);
    //             data[key] = fileInput && fileInput.files.length > 0 ? fileInput.files[0].name : '';
    //         } else {
    //             data[key] = value;
    //         }
    //     }
    //     console.log('Processed data before final adjustments:', JSON.stringify(data, null, 2));
    
    //     if (data.variant) {
    //         const variantRows = form.querySelectorAll('#variants-body tr');
    //         data.variant.forEach((variant, index) => {
    //             ['color', 'size', 'stock', 'price'].forEach(field => {
    //                 if (!variant.hasOwnProperty(field)) {
    //                     const input = variantRows[index].querySelector(`[name^="variant[${index}][${field}]"]`);
    //                     variant[field] = input ? input.value : '';
    //                 }
    //             });
    //             if (!variant.hasOwnProperty('images')) {
    //                 variant.images = [];
    //             }
    //         });
    //     }
    
    //     // console.log('Data received:', data);
    //     console.log('Final data:', JSON.stringify(data, null, 2));

    //     return data;
    // }