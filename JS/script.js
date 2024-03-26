function toggleCarImage(carId) {
    var image = document.getElementById('car-image-' + carId);
    if (image.style.display === 'none') {
        image.style.display = 'block';
    } else {
        image.style.display = 'none';
    }
}