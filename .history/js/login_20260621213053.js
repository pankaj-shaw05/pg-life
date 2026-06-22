document.getElementById('login-form').addEventListener('submit', function(e) {
    e.preventDefault();
    
    let email = this.email.value;
    let password = this.password.value;
    
    fetch('api/login_submit.php', {
        method: 'POST',
        headers: {'Content-Type': 'application/x-www-form-urlencoded'},
        body: 'email=' + encodeURIComponent(email) + '&password=' + encodeURIComponent(password)
    })
    .then(response => response.json())
    .then(data => {
        alert(data.message);
        if(data.status === 'success') {
            window.location.href = 'dashboard.php';
        } else {
            document.getElementById('login-error').style.display = 'block';
            document.getElementById('login-error').textContent = data.message;
        }
    });
});
