const togglePassword = document.getElementById('togglePassword');
const password = document.getElementById('password');

togglePassword.addEventListener('click', function(){

    const type = password.getAttribute('type') === 'password'
        ? 'text'
        : 'password';

    password.setAttribute('type', type);

    this.innerHTML =
        type === 'password'
        ? '<i class="bi bi-eye"></i>'
        : '<i class="bi bi-eye-slash"></i>';

});