// User Menu Functionality
document.addEventListener('DOMContentLoaded', function() {
    const userMenuButton = document.getElementById('user-menu-button');
    const userDropdownMenu = document.getElementById('user-dropdown-menu');
    
    if (userMenuButton && userDropdownMenu) {
        // Toggle menu when button is clicked
        userMenuButton.addEventListener('click', function(e) {
            e.preventDefault();
            e.stopPropagation();
            userDropdownMenu.classList.toggle('hidden');
            console.log('Menu toggled via dedicated script');
        });
        
        // Close menu when clicking outside
        document.addEventListener('click', function(e) {
            if (userDropdownMenu && !userDropdownMenu.contains(e.target) && 
                userMenuButton && !userMenuButton.contains(e.target)) {
                userDropdownMenu.classList.add('hidden');
            }
        });
        
        // Dark mode toggle functionality
        const darkModeToggle = document.getElementById('dark-mode-toggle');
        const toggleDarkMode = document.getElementById('toggle-dark-mode');
        
        if (toggleDarkMode) {
            toggleDarkMode.addEventListener('click', function(e) {
                e.preventDefault();
                e.stopPropagation();
                
                const html = document.documentElement;
                if (html.classList.contains('dark')) {
                    disableDarkMode();
                } else {
                    enableDarkMode();
                }
            });
        }
        
        // Check for saved dark mode preference or use system preference
        const savedDarkMode = localStorage.getItem('darkMode');
        const prefersDarkMode = window.matchMedia('(prefers-color-scheme: dark)').matches;
        
        // Initialize dark mode based on saved preference or system preference
        if (savedDarkMode === 'enabled' || (savedDarkMode === null && prefersDarkMode)) {
            enableDarkMode();
        } else {
            disableDarkMode();
        }
    }
});

// Function to enable dark mode
function enableDarkMode() {
    const html = document.documentElement;
    const darkModeToggle = document.getElementById('dark-mode-toggle');
    const darkModeLight = document.querySelector('.dark-mode-light');
    const darkModeDark = document.querySelector('.dark-mode-dark');
    
    html.classList.add('dark');
    if (darkModeToggle) darkModeToggle.checked = true;
    if (darkModeLight) darkModeLight.classList.add('hidden');
    if (darkModeDark) darkModeDark.classList.remove('hidden');
    localStorage.setItem('darkMode', 'enabled');
    
    // Add dark mode styles
    document.body.classList.add('dark-mode');
    document.querySelectorAll('.bg-white').forEach(el => {
        el.classList.add('dark-bg');
        el.classList.remove('bg-white');
    });
    document.querySelectorAll('.text-gray-700').forEach(el => {
        el.classList.add('text-gray-300');
        el.classList.remove('text-gray-700');
    });
}

// Function to disable dark mode
function disableDarkMode() {
    const html = document.documentElement;
    const darkModeToggle = document.getElementById('dark-mode-toggle');
    const darkModeLight = document.querySelector('.dark-mode-light');
    const darkModeDark = document.querySelector('.dark-mode-dark');
    
    html.classList.remove('dark');
    if (darkModeToggle) darkModeToggle.checked = false;
    if (darkModeLight) darkModeLight.classList.remove('hidden');
    if (darkModeDark) darkModeDark.classList.add('hidden');
    localStorage.setItem('darkMode', 'disabled');
    
    // Remove dark mode styles
    document.body.classList.remove('dark-mode');
    document.querySelectorAll('.dark-bg').forEach(el => {
        el.classList.add('bg-white');
        el.classList.remove('dark-bg');
    });
    document.querySelectorAll('.text-gray-300').forEach(el => {
        el.classList.add('text-gray-700');
        el.classList.remove('text-gray-300');
    });
}
