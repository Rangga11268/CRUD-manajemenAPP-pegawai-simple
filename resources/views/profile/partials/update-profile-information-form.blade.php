<section>
    <header>
        <h4 class="text-lg font-medium text-gray-900 dark:text-gray-100">
            {{ __('Profile Information') }}
        </h4>

        <p class="mt-1 text-sm text-muted">
            {{ __("Update your account's profile information and email address.") }}
        </p>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" class="mt-6" enctype="multipart/form-data">
        @csrf
        @method('patch')

        <div class="form-group mb-4">
            <label class="form-label font-weight-bold">{{ __('Photo Profile') }}</label>
            <div class="d-flex align-items-center gap-4">
                @php
                    $pegawai = $user->pegawai;
                    $imagePath = $pegawai && $pegawai->image && $pegawai->image !== 'uploads/pegawai/default.png' 
                        ? asset('storage/' . $pegawai->image) 
                        : 'https://ui-avatars.com/api/?name='.urlencode($user->name).'&color=7F9CF5&background=EBF4FF';
                @endphp
                <div class="position-relative">
                    <img src="{{ $imagePath }}" alt="{{ $user->name }}" class="rounded-circle shadow-sm" style="width: 100px; height: 100px; object-fit: cover;" id="profile-preview">
                </div>
                <div class="flex-grow-1">
                    <input type="file" class="form-control" name="image" id="image" accept="image/*" onchange="previewImage(event)">
                    <small class="text-muted">Allowed: jpg, jpeg, png, webp. Max: 2MB</small>
                    @error('image')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
                </div>
            </div>
        </div>

        <div class="form-group">
            <label for="name" class="form-label font-weight-bold">{{ __('Name') }}</label>
            <input type="text" class="form-control" id="name" name="name" value="{{ old('name', $user->name) }}" required autofocus autocomplete="name">
            @error('name')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
        </div>

        <div class="form-group">
            <label for="email" class="form-label font-weight-bold">{{ __('Email') }}</label>
            <input type="email" class="form-control" id="email" name="email" value="{{ old('email', $user->email) }}" required autocomplete="username">
            @error('email')<div class="text-danger small mt-1">{{ $message }}</div>@enderror

            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                <div class="mt-2">
                    <p class="text-sm text-gray-800">
                        {{ __('Your email address is unverified.') }}

                        <button form="send-verification" class="btn btn-link p-0 align-baseline">
                            {{ __('Click here to re-send the verification email.') }}
                        </button>
                    </p>

                    @if (session('status') === 'verification-link-sent')
                        <p class="mt-2 font-medium text-sm text-success">
                            {{ __('A new verification link has been sent to your email address.') }}
                        </p>
                    @endif
                </div>
            @endif
        </div>

        <div class="d-flex align-items-center gap-4 mt-4">
            <button type="submit" class="btn btn-primary px-4">
                <i class="fas fa-save mr-1"></i> {{ __('Save Changes') }}
            </button>

            @if (session('status') === 'profile-updated')
                <div class="alert alert-success py-1 px-3 mb-0" role="alert">
                    <i class="fas fa-check-circle mr-1"></i> {{ __('Saved.') }}
                </div>
            @endif
        </div>
    </form>
    
    <script>
        function previewImage(event) {
            var reader = new FileReader();
            reader.onload = function(){
                var output = document.getElementById('profile-preview');
                output.src = reader.result;
            }
            reader.readAsDataURL(event.target.files[0]);
        }
    </script>
</section>
