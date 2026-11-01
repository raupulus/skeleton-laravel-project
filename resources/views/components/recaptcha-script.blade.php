{{--
    Componente invisible de Google reCAPTCHA v3.
    Solo se renderiza si RECAPTCHA_SITE_KEY y RECAPTCHA_SECRET_KEY están definidas.
    El token se solicita justo al enviar el formulario (los tokens v3 caducan a los 2 minutos).
    Uso: <x-recaptcha-script action="contact" /> dentro del <form>.
--}}
@props(['action' => 'submit'])

@if(config('services.recaptcha.site_key') && config('services.recaptcha.secret_key'))
    <input type="hidden" name="g-recaptcha-response" data-recaptcha-action="{{ $action }}">
    @pushOnce('scripts')
        <script src="https://www.google.com/recaptcha/api.js?render={{ config('services.recaptcha.site_key') }}"></script>
        <script>
            document.addEventListener('submit', function (event) {
                var form = event.target;
                var input = form.querySelector('input[data-recaptcha-action]');

                if (!input || form.dataset.recaptchaReady === '1' || typeof grecaptcha === 'undefined') {
                    return;
                }

                event.preventDefault();

                grecaptcha.ready(function () {
                    grecaptcha.execute(@js(config('services.recaptcha.site_key')), { action: input.dataset.recaptchaAction })
                        .then(function (token) {
                            input.value = token;
                            form.dataset.recaptchaReady = '1';
                            form.requestSubmit ? form.requestSubmit() : form.submit();
                        });
                });
            }, true);
        </script>
    @endPushOnce
@endif
