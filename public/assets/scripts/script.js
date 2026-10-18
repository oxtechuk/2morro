
// General app script
$(document).ready(function() {
    // Tooltips
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });

    // Logout click handler
    $(document).on('click', '.logout', function(e) {
        e.preventDefault();
        $('#logoutForm').submit();
    });
});
