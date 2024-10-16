/**
 * Called in about_us.php, barangay_certificate.php, barangay_clearance.php, barangay_indigency.php, certification.php, contact_us.php, index.php.
 */

document.addEventListener('DOMContentLoaded', function () {
    var dropdown = document.querySelector('.dropdown');
    var dropdownContent = dropdown.querySelector('.dropdown-content');
    var dropbtn = dropdown.querySelector('.dropbtn');

    dropdownContent.style.display = 'none';

    dropbtn.addEventListener('click', function (event) {
        dropdownContent.style.display =
            dropdownContent.style.display === 'block' ? 'none' : 'block';
        event.stopPropagation();
    });

    document.addEventListener('click', function (event) {
        if (!dropdown.contains(event.target)) {
            dropdownContent.style.display = 'none';
        }
    });
});
