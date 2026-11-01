@if(config('services.recaptcha.site_key') && config('services.recaptcha.secret_key'))
    <div
        wire:ignore
        x-data="{
            siteKey: @js(config('services.recaptcha.site_key')),
            init() {
                if (!window.grecaptcha) {
                    const script = document.createElement('script');
                    script.src = 'https://www.google.com/recaptcha/api.js?render=' + encodeURIComponent(this.siteKey);
                    script.async = true;
                    script.onload = () => this.refreshToken();
                    document.head.appendChild(script);
                } else {
                    this.refreshToken();
                }

                const form = this.$el.closest('form');
                if (form) {
                    form.addEventListener('submit', () => this.refreshToken());
                }
            },
            refreshToken() {
                if (!window.grecaptcha) return;
                window.grecaptcha.ready(() => {
                    window.grecaptcha.execute(this.siteKey, { action: 'login' }).then((token) => {
                        $wire.set('data.g-recaptcha-response', token, false);
                    });
                });
            }
        }"
        class="hidden"
        aria-hidden="true"
    ></div>
@endif
