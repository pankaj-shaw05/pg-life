document.getElementById('signup-form').addEventListener('submit', function(e) {

e.preventDefault();

let formData = new FormData(this);

fetch('api/signup_submit.php', {
    method: 'POST',
    body: formData
})

.then(response => response.json())

.then(data => {

    alert(data.message);

    if(data.status === "success") {

        document.getElementById('signup-form').reset();

        $('#signup-modal').modal('hide');

        $('#login-modal').modal('show');
    }

})

.catch(error => {
    console.log(error);
});

});