<div>
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
    <div class="g-recaptcha {{ $hasError ? 'is-invalid' : '' }}" data-sitekey = "{{ $site_key }}"></div>

    @error('g-recaptcha-response')
    <span class="invalid-feedback" role="alert">
        <strong>{{$message}}</strong>
    </span>
    @enderror
</div>
