
document.addEventListener('DOMContentLoaded', function() {
    // Mobile sidebar toggle
    var mobileToggle = document.querySelector('.mobile-toggle-nav');
    if (mobileToggle) {
        mobileToggle.addEventListener('click', function() {
            var app = document.querySelector('.app-container');
            if (app) app.classList.toggle('sidebar-mobile-open');
        });
    }

    // Desktop sidebar toggle
    var closeSidebarBtns = document.querySelectorAll('.close-sidebar-btn');
    closeSidebarBtns.forEach(function(btn) {
        btn.addEventListener('click', function() {
            var app = document.querySelector('.app-container');
            if (app) {
                var toggleClass = btn.getAttribute('data-class') || 'closed-sidebar';
                app.classList.toggle(toggleClass);
                btn.classList.toggle('is-active');
            }
        });
    });

    // Mobile header nav toggle
    var headerToggle = document.querySelector('.mobile-toggle-header-nav');
    if (headerToggle) {
        headerToggle.addEventListener('click', function() {
            var headerContent = document.querySelector('.app-header-content');
            if (headerContent) headerContent.classList.toggle('header-mobile-open');
        });
    }
});
