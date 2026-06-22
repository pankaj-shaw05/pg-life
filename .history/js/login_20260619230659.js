document.getElementById("login-form").addEventListener("submit", function(e){

    e.preventDefault();

    let formData = new FormData(this);

    fetch("api/login_submit.php", {
        method: "POST",
        body: formData
    })
    .then(response => response.json())
    .then(data => {

        alert(data.message);

        if(data.status === "success"){
            window.location.reload();
        }

    })
    .catch(error => {
        console.log(error);
    });

});