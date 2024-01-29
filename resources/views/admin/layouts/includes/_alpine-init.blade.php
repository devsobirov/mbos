<script>
    function getThemeFromLocalStorage() {
        // if user already changed the theme, use it
        if (window.localStorage.getItem('dark')) {
            return JSON.parse(window.localStorage.getItem('dark'))
        }

        // else return their preferences
        return (
            !!window.matchMedia &&
            window.matchMedia('(prefers-color-scheme: dark)').matches
        )
    }

    function setThemeToLocalStorage(value) {
        window.localStorage.setItem('dark', value)
    }

    document.addEventListener('alpine:init', () => {

        Alpine.store('messages', {
            errors: [],
            success: [],
            // Handling errors from response
            handleErrors(res) {
                let data = res ? res.data : {};
                if (data.message) this.errors.push(data.message);

                if (data.errors) {
                    for (const [key, msgs] of Object.entries(data.errors)) {
                        if (msgs && msgs.length) msgs.forEach(m => { this.errors.push(m); console.log(m); })
                    }
                }
            }
        });

        Alpine.data('alpineApp', () => ({
            dark: getThemeFromLocalStorage(),
            toggleTheme() {
                this.dark = !this.dark
                setThemeToLocalStorage(this.dark)
            }
        }));
    })
</script>
