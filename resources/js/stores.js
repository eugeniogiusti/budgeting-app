// Alpine stores registered on alpine:init.
// theme  — persists dark/light preference to localStorage and syncs <html>/<body> classes.
// sidebar — tracks expanded/collapsed/hover state for desktop and open/closed for mobile.
document.addEventListener('alpine:init', () => {
    Alpine.store('theme', {
        init() {
            const savedTheme = localStorage.getItem('theme');
            const systemTheme = window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light';
            this.theme = savedTheme || systemTheme;
            this.updateTheme();
        },
        theme: 'light',
        toggle() {
            this.theme = this.theme === 'light' ? 'dark' : 'light';
            localStorage.setItem('theme', this.theme);
            this.updateTheme();
        },
        updateTheme() {
            const html = document.documentElement;
            const body = document.body;
            if (this.theme === 'dark') {
                html.classList.add('dark');
                body.classList.add('dark', 'bg-gray-900');
            } else {
                html.classList.remove('dark');
                body.classList.remove('dark', 'bg-gray-900');
            }
        }
    });

    Alpine.store('sidebar', {
        isExpanded: window.innerWidth >= 1280,
        isMobileOpen: false,
        isHovered: false,

        init() {
            // Sync sidebar state on viewport resize.
            window.addEventListener('resize', () => {
                if (window.innerWidth < 1280) {
                    this.setMobileOpen(false);
                    this.isExpanded = false;
                } else {
                    this.isMobileOpen = false;
                    this.isExpanded = true;
                }
            });
        },

        toggleExpanded() {
            this.isExpanded = !this.isExpanded;
            this.isMobileOpen = false;
        },

        toggleMobileOpen() {
            this.isMobileOpen = !this.isMobileOpen;
        },

        setMobileOpen(val) {
            this.isMobileOpen = val;
        },

        setHovered(val) {
            if (window.innerWidth >= 1280 && !this.isExpanded) {
                this.isHovered = val;
            }
        }
    });
});
