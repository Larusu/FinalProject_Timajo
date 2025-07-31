function togglePassword(button) {
  const input = button.previousElementSibling;
  const icon = button.querySelector('img');

  if (input.type === 'password') {
    input.type = 'text';
    icon.src = '..assets/images/eye-open.svg'; 
    icon.alt = 'Hide password';
  } else {
    input.type = 'password';
    icon.src = '..assets/images/eye-closed.svg';
    icon.alt = 'Show password';
  }
}

function validatePasswords() {
  const password = document.getElementById('password').value;
  const confirm = document.getElementById('confirm_password').value;
  const errorText = document.getElementById('password-error');

  if (password !== confirm) {
    errorText.classList.add('visible');
    return false;
  }

  errorText.classList.remove('visible');
  return true;
}

