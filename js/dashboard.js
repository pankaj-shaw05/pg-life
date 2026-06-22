document.querySelectorAll('.interested-container i').forEach(function(icon) {
    let count = 0;
    icon.addEventListener('click', function() {
        this.classList.toggle('active');
        let countDiv = this.nextElementSibling;
        if (this.classList.contains('active')) {
            count++;  
        } else {
            count--;
        }
        countDiv.textContent = count;
    });
});

