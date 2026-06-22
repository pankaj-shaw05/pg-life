document.querySelectorAll('.is-interested-image').forEach(function(icon) {

icon.addEventListener('click', function() {

    let property_id = this.getAttribute('property_id');
    let iconElement = this;

    fetch('api/toggle_interested.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded'
        },
        body: 'property_id=' + property_id
    })

    .then(response => response.json())

    .then(data => {

        if(data.status === "error") {
            alert(data.message);
            return;
        }

        let countDiv = iconElement.nextElementSibling;
        let count = parseInt(countDiv.textContent);

        if(data.action === "liked") {

            iconElement.classList.remove('far');
            iconElement.classList.add('fas');
            iconElement.style.color = '#EA322E';

            countDiv.textContent = (count + 1) + " interested";
        }

        else if(data.action === "unliked") {

            iconElement.classList.remove('fas');
            iconElement.classList.add('far');
            iconElement.style.color = '#aaa';

            countDiv.textContent = (count - 1) + " interested";
        }

    })

    .catch(error => {
        console.log(error);
    });

});

});
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
        if(data.status == 'success') {
            window.location.href = 'dashboard.php';
        } else {
            document.getElementById('login-error').style.display = 'block';
            document.getElementById('login-error').textContent = data.message;
        }
    });
});