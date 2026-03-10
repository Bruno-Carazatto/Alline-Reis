document.addEventListener('DOMContentLoaded', () => {
    const form = document.getElementById('formContato');
    const telefoneInput = document.getElementById('telefone');

    if (telefoneInput) {
        telefoneInput.addEventListener('input', (e) => {
            let value = e.target.value.replace(/\D/g, '');

            if (value.length > 11) {
                value = value.slice(0, 11);
            }

            if (value.length <= 10) {
                value = value.replace(/^(\d{0,2})(\d{0,4})(\d{0,4}).*/, function (_, a, b, c) {
                    let result = '';
                    if (a) result += `(${a}`;
                    if (a.length === 2) result += ') ';
                    if (b) result += b;
                    if (c) result += `-${c}`;
                    return result;
                });
            } else {
                value = value.replace(/^(\d{0,2})(\d{0,5})(\d{0,4}).*/, function (_, a, b, c) {
                    let result = '';
                    if (a) result += `(${a}`;
                    if (a.length === 2) result += ') ';
                    if (b) result += b;
                    if (c) result += `-${c}`;
                    return result;
                });
            }

            e.target.value = value;
        });
    }

    if (form) {
        form.addEventListener('submit', (event) => {
            if (!form.checkValidity()) {
                event.preventDefault();
                event.stopPropagation();
            }

            form.classList.add('was-validated');
        });
    }

    const navLinks = document.querySelectorAll('.navbar .nav-link');
    const navbarCollapse = document.getElementById('menuPrincipal');

    navLinks.forEach(link => {
        link.addEventListener('click', () => {
            if (navbarCollapse && navbarCollapse.classList.contains('show')) {
                const bsCollapse = bootstrap.Collapse.getInstance(navbarCollapse) || new bootstrap.Collapse(navbarCollapse, {
                    toggle: false
                });
                bsCollapse.hide();
            }
        });
    });
});