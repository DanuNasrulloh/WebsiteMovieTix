document.addEventListener('DOMContentLoaded', function() {
    const logoutButton = document.getElementById('logoutButton');
    
    logoutButton.addEventListener('click', function(e) {
        e.preventDefault();
        
        // Show confirmation dialog
        const confirmLogout = confirm('Apakah Anda yakin ingin keluar?');
        
        if (confirmLogout) {
            // Clear any session/local storage
            localStorage.clear();
            sessionStorage.clear();
            // Redirect to login page
            window.location.href = '../HTML/index.html';
        }
    });
});