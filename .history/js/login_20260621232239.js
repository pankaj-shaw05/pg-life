document.addEventListener("DOMContentLoaded", function() {

    document.getElementById('login-form').addEventListener('submit', function(e){

        e.preventDefault();

        let formData = new FormData(this);

        fetch('api/login_submit.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            console.log(data);
            alert(data.message);

            if(data.status === "success"){
                window.location.href(dashboard.php);
            }

        })
        .catch(error => console.log(error));

    });

});