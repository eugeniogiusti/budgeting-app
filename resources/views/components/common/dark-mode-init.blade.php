{{-- Inline IIFE: must run synchronously in <head> to prevent flash of wrong theme.
     Cannot be deferred or bundled — Vite modules are async and would cause FOUC.
     Only touches <html> — document.body is null at this point in the head. --}}
<script>
    (function() {
        const savedTheme = localStorage.getItem('theme');
        const systemTheme = window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light';
        if ((savedTheme || systemTheme) === 'dark') {
            document.documentElement.classList.add('dark');
        } else {
            document.documentElement.classList.remove('dark');
        }
    })();
</script>
