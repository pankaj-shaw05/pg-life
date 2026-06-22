document.getElementById('edit-profile-form').addEventListener('submit', function(e) {

e.preventDefault();

let formData = new FormData(this);

fetch('api/edit_profile.php', {
    method: 'POST',
    body: formData
})

.then(response => response.json())

.then(data => {

    alert(data.message);

    if(data.status === "success") {

        location.reload();

    }

})

.catch(error => {
    console.log(error);
});

});