function toggleCarImage(carId) {
    var image = document.getElementById('car-image-' + carId);
    if (image.style.display === 'none') {
        image.style.display = 'block';
    } else {
        image.style.display = 'none';
    }
}

// console.log('script.js loaded');

// Function to fetch and display user or car information
function displayInfo(type, id) {
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            document.getElementById("info-popup").innerHTML = this.responseText;
        }
    };
    xmlhttp.open("GET", "http://localhost/Mini-PHP-Project/PHP/admin_dashboard/requests/fetch_info.php?type=" + type + "&id=" + id, true);
    xmlhttp.send();
}

// Event listener for hovering over user ID or car ID
document.querySelectorAll('.user-info, .car-info, .car-image').forEach(item => {
    item.addEventListener('mouseover', event => {
        const type = event.target.classList.contains('user-info') ? 'user' : event.target.classList.contains('car-image') ? 'image' : 'car';
        const id = event.target.getAttribute('data-id');
        displayInfo(type, id);
        document.getElementById('info-popup').style.display = 'block';
        document.getElementById('info-popup').style.left = event.pageX + 'px';
        document.getElementById('info-popup').style.top = (event.pageY + 20) + 'px';
    });
    item.addEventListener('mouseout', () => {
        document.getElementById('info-popup').style.display = 'none';
    });
});