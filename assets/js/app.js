document.addEventListener('DOMContentLoaded', () => {
  const toggle = document.querySelector('.menu-toggle');
  const nav = document.querySelector('.nav-links');
  if (toggle && nav) toggle.addEventListener('click', () => nav.classList.toggle('open'));

  document.querySelectorAll('form[data-validate]').forEach(form => {
    form.addEventListener('submit', event => {
      if (!form.checkValidity()) {
        event.preventDefault();
        form.reportValidity();
      }
      const password = form.querySelector('[name="password"]');
      const confirm = form.querySelector('[name="confirm_password"]');
      if (password && confirm && password.value !== confirm.value) {
        event.preventDefault();
        confirm.setCustomValidity('Passwords do not match.');
        confirm.reportValidity();
        confirm.addEventListener('input', () => confirm.setCustomValidity(''), { once: true });
      }
    });
  });
});
