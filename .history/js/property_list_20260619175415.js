<script>
let selectedGender = '';
let selectedRent = '';

document.querySelectorAll('.gender-btn').forEach(function(btn) {
    btn.addEventListener('click', function() {
        document.querySelectorAll('.gender-btn').forEach(b => b.classList.remove('btn-dark'));
        this.classList.add('btn-dark');
        selectedGender = this.getAttribute('data-value');
    })
});

document.querySelectorAll('.rent-btn').forEach(function(btn) {
    btn.addEventListener('click', function() {
        document.querySelectorAll('.rent-btn').forEach(b => b.classList.remove('btn-dark'));
        this.classList.add('btn-dark');
        selectedRent = this.getAttribute('data-value');
    })
});

document.getElementById('apply-filter').addEventListener('click', function() {
    let city = document.getElementById('city-name').value;
    let url = 'property_list.php?city=' + city;
    if(selectedGender) url += '&gender=' + selectedGender;
    if(selectedRent) url += '&filter=' + selectedRent;
    window.location.href = url;
});

document.querySelectorAll('.is-interested-image').forEach(function(icon) {
    icon.addEventListener('click', function() {
        let property_id = this.getAttribute('property_id');
        let iconElement = this;
        
        fetch('includes/update_interested.php', {
            method: 'POST',
            headers: {'Content-Type': 'application/x-www-form-urlencoded'},
            body: 'property_id=' + property_id
        })
        .then(response => response.text())
        .then(data => {
            let countDiv = iconElement.nextElementSibling;
            let count = parseInt(countDiv.textContent);
            
            if(data == 'liked') {
                iconElement.classList.remove('far');
                iconElement.classList.add('fas');
                iconElement.style.color = '#EA322E';
                countDiv.textContent = (count + 1) + ' interested';
            } else {
                iconElement.classList.remove('fas');
                iconElement.classList.add('far');
                iconElement.style.color = '#aaa';
                countDiv.textContent = (count - 1) + ' interested';
            }
        });
    })
});
</script>