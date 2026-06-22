document.getElementById('login-form').addEventListener('submit', function(e) {
    e.preventDefault();

    let formData = new FormData(this);

    fetch('api/login_submit.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {

        alert("Login successful");

        if(data.status === "success"){
            window.location.href = "dashboard.php";
        } else {
            document.getElementById('login-error').innerText = data.message;
            document.getElementById('login-error').style.display = "block";
        }

    });
});