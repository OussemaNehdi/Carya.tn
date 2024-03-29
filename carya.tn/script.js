// ================================== Admin_Dashboard ==================================
// Function to fetch and display user or car information
function displayInfo(type, id) {
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            document.getElementById("info-popup").innerHTML = this.responseText;
        }
    };
    xmlhttp.open("GET", "http://localhost/Mini-PHP-Project/carya.tn/src/controllers/fetch_info.php?type=" + type + "&id=" + id, true);
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

// ================================== End of Admin_Dashboard ==================================
// ----------------------------------------------
// The add car form popup script
document.getElementById("addCarBtn").addEventListener("click", function() {
    // Show the popup and overlay
    document.getElementById("addCarPopup").style.display = "block";
    document.getElementById("overlay").style.display = "block";
});

// Close the popup and overlay when clicking outside the popup
document.getElementById("overlay").addEventListener("click", function() {
    document.getElementById("addCarPopup").style.display = "none";
    document.getElementById("overlay").style.display = "none";
});
// --------------------------------------------------

// ================================== Profile.php ==================================
function redirectToLink(url) {
    window.location.href = url;
}
// ================================== End of Profile.php ==================================