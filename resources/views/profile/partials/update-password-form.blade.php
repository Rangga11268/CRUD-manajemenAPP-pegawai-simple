<section>
    <header class="mb-4">
        <h5 class="text-dark font-weight-bold">
            {{ __('Update Password') }}
        </h5>

        <p class="text-muted small">
            {{ __('Ensure your account is using a long, random password to stay secure.') }}
        </p>
    </header>

    <form method="post" action="{{ route('password.update') }}">
        @csrf
        @method('put')

        <div class="form-group">
            <label for="update_password_current_password" class="font-weight-bold">{{ __('Current Password') }}</label>
            <input type="password" class="form-control" id="update_password_current_password" name="current_password" autocomplete="current-password">
            @error('current_password', 'updatePassword')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
        </div>

        <div class="form-group">
            <label for="update_password_password" class="font-weight-bold">{{ __('New Password') }}</label>
            <input type="password" class="form-control" id="update_password_password" name="password" autocomplete="new-password">
            @error('password', 'updatePassword')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
        </div>

        <div class="form-group">
            <label for="update_password_password_confirmation" class="font-weight-bold">{{ __('Confirm Password') }}</label>
            <input type="password" class="form-control" id="update_password_password_confirmation" name="password_confirmation" autocomplete="new-password">
            @error('password_confirmation', 'updatePassword')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
        </div>

        <div class="d-flex align-items-center mt-3">
            <button type="submit" class="btn btn-primary rounded-pill px-4 shadow-sm">{{ __('Save') }}</button>

            @if (session('status') === 'password-updated')
                <p class="text-success small mb-0 ml-3 font-weight-bold">{{ __('Saved.') }}</p>
            @endif
        </div>
    </form>
</section>
