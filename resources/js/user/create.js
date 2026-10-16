document.addEventListener('DOMContentLoaded', () => {

    /*
    |--------------------------------------------------------------------------
    | MOSTRAR / OCULTAR CONTRASEÑA
    |--------------------------------------------------------------------------
    */

    document.querySelectorAll('.password-toggle').forEach(button => {

        button.addEventListener('click', () => {

            const targetId = button.dataset.target;
            const input = document.getElementById(targetId);
            const icon = button.querySelector('i');

            if (input.type === 'password') {

                input.type = 'text';

                icon.classList.remove('fa-eye');
                icon.classList.add('fa-eye-slash');

                button.setAttribute(
                    'aria-label',
                    'Ocultar contraseña'
                );

            } else {

                input.type = 'password';

                icon.classList.remove('fa-eye-slash');
                icon.classList.add('fa-eye');

                button.setAttribute(
                    'aria-label',
                    'Mostrar contraseña'
                );
            }
        });

    });


    /*
    |--------------------------------------------------------------------------
    | SEGURIDAD DE CONTRASEÑA
    |--------------------------------------------------------------------------
    */

    const password = document.getElementById('password');
    const strengthBar = document.getElementById('strengthBar');
    const strengthText = document.getElementById('strengthText');

    if (password) {

        password.addEventListener('input', () => {

            const value = password.value;

            let strength = 0;

            if (value.length >= 8) {
                strength++;
            }

            if (/[A-Z]/.test(value)) {
                strength++;
            }

            if (/[a-z]/.test(value)) {
                strength++;
            }

            if (/[0-9]/.test(value)) {
                strength++;
            }

            if (/[^A-Za-z0-9]/.test(value)) {
                strength++;
            }


            if (value.length === 0) {

                strengthBar.style.width = '0%';
                strengthText.textContent = 'Seguridad de contraseña';

            } else if (strength <= 2) {

                strengthBar.style.width = '35%';
                strengthText.textContent = 'Contraseña débil';

            } else if (strength <= 4) {

                strengthBar.style.width = '70%';
                strengthText.textContent = 'Contraseña media';

            } else {

                strengthBar.style.width = '100%';
                strengthText.textContent = 'Contraseña segura';

            }

        });
    }


    /*
    |--------------------------------------------------------------------------
    | CONFIRMAR CONTRASEÑA
    |--------------------------------------------------------------------------
    */

    const passwordConfirm = document.getElementById('password_confirm');
    const passwordMatch = document.getElementById('passwordMatch');

    function checkPasswordMatch() {

        if (!passwordConfirm || !passwordMatch) {
            return;
        }

        if (passwordConfirm.value === '') {

            passwordMatch.textContent =
                'Vuelva a escribir la contraseña para confirmarla.';

            passwordMatch.style.color = '#6b7280';

            return;
        }

        if (password.value === passwordConfirm.value) {

            passwordMatch.textContent =
                'Las contraseñas coinciden.';

            passwordMatch.style.color = '#16a34a';

        } else {

            passwordMatch.textContent =
                'Las contraseñas no coinciden.';

            passwordMatch.style.color = '#dc2626';
        }
    }

    if (passwordConfirm) {
        passwordConfirm.addEventListener('input', checkPasswordMatch);
    }

    if (password) {
        password.addEventListener('input', checkPasswordMatch);
    }


    /*
    |--------------------------------------------------------------------------
    | PREVENIR DOBLE ENVÍO
    |--------------------------------------------------------------------------
    */

    const form = document.getElementById('userCreateForm');
    const saveButton = document.getElementById('saveUserBtn');

    if (form && saveButton) {

        form.addEventListener('submit', () => {

            saveButton.disabled = true;

            saveButton.innerHTML = `
                <i class="fas fa-spinner fa-spin"></i>
                Guardando...
            `;

        });
    }

});