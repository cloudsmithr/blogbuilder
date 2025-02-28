document.addEventListener("DOMContentLoaded", function () {
    const themeToggle = document.getElementById("theme-toggle");
    const toggleIcon = themeToggle.querySelector(".toggle-icon");

    function setTheme(theme) {
        if (theme === "dark") {
            document.documentElement.setAttribute("data-theme", "dark");
            toggleIcon.textContent = "🌙";
        } else {
            document.documentElement.removeAttribute("data-theme");
            toggleIcon.textContent = "🌞";
        }
    }

    // Load saved theme preference
    const savedTheme = localStorage.getItem("theme") || "light";
    setTheme(savedTheme);

    themeToggle.addEventListener("click", function () {
        const currentTheme = document.documentElement.getAttribute("data-theme") === "dark" ? "light" : "dark";
        console.log("changing theme to " + currentTheme);
        setTheme(currentTheme);
        localStorage.setItem("theme", currentTheme);
    });
});

window.addEventListener('beforeunload', () => {
    if (localStorage.getItem('theme') === 'dark') {
        document.documentElement.setAttribute('data-theme', 'dark');
    }
});

window.addEventListener('load', () => {
    if (localStorage.getItem('theme') === 'dark') {
        document.documentElement.setAttribute('data-theme', 'dark');
    }
});