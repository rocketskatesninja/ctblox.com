/**
 * Theme Switcher for CTBlox
 * Handles switching between light and dark modes
 */

// Check for saved theme preference or use device preference
const getPreferredTheme = () => {
    const savedDarkMode = localStorage.getItem('darkMode');
    if (savedDarkMode === 'enabled') {
        return 'dark';
    } else if (savedDarkMode === 'disabled') {
        return 'light';
    }
    return window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light';
};

// Apply theme to document
const applyTheme = (theme) => {
    const html = document.documentElement;
    const body = document.body;
    
    if (theme === 'dark') {
        html.classList.add('dark');
        html.classList.remove('light');
        body.classList.add('dark-mode');
        localStorage.setItem('darkMode', 'enabled');
        
        // Update UI elements if they exist
        const darkModeToggle = document.getElementById('dark-mode-toggle');
        if (darkModeToggle) darkModeToggle.checked = true;
        
        const darkModeLight = document.querySelector('.dark-mode-light');
        const darkModeDark = document.querySelector('.dark-mode-dark');
        if (darkModeLight) darkModeLight.classList.add('hidden');
        if (darkModeDark) darkModeDark.classList.remove('hidden');
    } else {
        html.classList.remove('dark');
        html.classList.add('light');
        body.classList.remove('dark-mode');
        localStorage.setItem('darkMode', 'disabled');
        
        // Update UI elements if they exist
        const darkModeToggle = document.getElementById('dark-mode-toggle');
        if (darkModeToggle) darkModeToggle.checked = false;
        
        const darkModeLight = document.querySelector('.dark-mode-light');
        const darkModeDark = document.querySelector('.dark-mode-dark');
        if (darkModeLight) darkModeLight.classList.remove('hidden');
        if (darkModeDark) darkModeDark.classList.add('hidden');
        
        // Force remove dark mode classes from elements
        document.querySelectorAll('[class*="dark:"]').forEach(element => {
            // Force reflow to ensure styles are applied correctly
            element.style.display = element.style.display;
        });
    }
};

// Initialize theme
const initTheme = () => {
    // Apply the preferred theme
    applyTheme(getPreferredTheme());
    
    // Set up listeners for theme toggle
    document.addEventListener('DOMContentLoaded', () => {
        const toggleDarkMode = document.getElementById('toggle-dark-mode');
        const darkModeToggle = document.getElementById('dark-mode-toggle');
        
        if (toggleDarkMode) {
            toggleDarkMode.addEventListener('click', () => {
                const currentTheme = document.documentElement.classList.contains('dark') ? 'dark' : 'light';
                const newTheme = currentTheme === 'dark' ? 'light' : 'dark';
                applyTheme(newTheme);
            });
        }
        
        if (darkModeToggle) {
            darkModeToggle.addEventListener('change', () => {
                const newTheme = darkModeToggle.checked ? 'dark' : 'light';
                applyTheme(newTheme);
            });
        }
        
        // Listen for OS theme changes
        window.matchMedia('(prefers-color-scheme: dark)').addEventListener('change', e => {
            if (localStorage.getItem('darkMode') === null) {
                applyTheme(e.matches ? 'dark' : 'light');
            }
        });
    });
};

// Run initialization
initTheme();
