document.getElementById('login-form').addEventListener('submit', function(e) {
    e.preventDefault();
    const email = document.getElementById('email').value;
    const password = document.getElementById('password').value;

    // Here you can add your login logic, e.g., sending a request to your server
    console.log(`Email: ${email}, Password: ${password}`);

    // Redirect or show a message based on your login logic
});

document.getElementById('signup-link').addEventListener('click', function(e) {
    e.preventDefault();
    // Redirect to signup page or show signup modal
    alert('Redirecting to signup page...');
});

