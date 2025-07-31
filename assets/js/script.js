function togglePassword(button) {
  const input = document.getElementById('password');
  const icon = button.querySelector('img');

  if (input.type === 'password') {
    input.type = 'text';
    icon.src = 'assets/images/eye-open.svg'; // Ensure this file exists
    icon.alt = 'Hide password';
  } else {
    input.type = 'password';
    icon.src = 'assets/images/eye-closed.svg'; // Ensure this file exists
    icon.alt = 'Show password';
  }
}
