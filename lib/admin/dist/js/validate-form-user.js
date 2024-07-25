function debounce(func, wait) {
    let timeout;
    return function executedFunction(...args) {
        const later = () => {
            clearTimeout(timeout);
            func(...args);
        };
        clearTimeout(timeout);
        timeout = setTimeout(later, wait);
    };
}

function createValidator(formId, validateEndpoint) {
    const form = document.getElementById(formId);
    if (!form) return;

    const inputs = form.querySelectorAll('input[name]');

    const validateForm = debounce(function() {
        const formData = {};
        inputs.forEach(input => {
            formData[input.name] = input.value;
        });

        if (formId === 'editUserForm') {
            formData.id = form.querySelector('input[name="id"]').value;
        }

        fetch(validateEndpoint, {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify(formData)
        })
        .then(response => response.json())
        .then(errors => {
            form.querySelectorAll('.error-message').forEach(el => el.textContent = '');
            for (const field in errors) {
                const errorElement = form.querySelector(`#${field}-error`);
                if (errorElement) {
                    errorElement.textContent = errors[field];
                }
            }
        })
        .catch(error => console.error('Error:', error));
    }, 300);

    inputs.forEach(input => {
        input.addEventListener('input', validateForm);
    });
}

document.addEventListener('DOMContentLoaded', function() {
    if (document.getElementById('createUserForm')) {
        createValidator('createUserForm', validateUserDataUrl);
    }
    if (document.getElementById('editUserForm')) {
        createValidator('editUserForm', validateEditUserDataUrl);
    }

});
