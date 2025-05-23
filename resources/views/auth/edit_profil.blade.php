
@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card o-hidden border-0 shadow-lg my-3 my-md-5" style="border-radius: 20px; background: rgba(255, 255, 255, 0.9); backdrop-filter: blur(10px);">
        <div class="card-body p-0">
            <div class="row">
                <!-- Sidebar Background - Responsive untuk mobile -->
                <div class="col-lg-5 d-none d-lg-flex bg-profile-image justify-content-center align-items-center flex-column text-white" style="
                    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
                    border-radius: 20px 0 0 20px;
                    padding: 2rem;">
                    <i class="fas fa-user-edit fa-4x mb-3" style="opacity: 0.9;"></i>
                    <h3 class="font-weight-bold text-center">Perbarui Profil Anda</h3>
                    <p class="text-center mt-3">"Kesempurnaan dimulai dari detail yang diperhatikan"</p>
                </div>

                <!-- Mobile Header - Hanya tampil di mobile -->
                <div class="col-12 d-lg-none text-center py-4" style="
                    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
                    border-radius: 20px 20px 0 0;
                    color: white;">
                    <i class="fas fa-user-edit fa-3x mb-2" style="opacity: 0.9;"></i>
                    <h3 class="font-weight-bold">Perbarui Profil Anda</h3>
                    <p class="mb-0">"Kesempurnaan dimulai dari detail yang diperhatikan"</p>
                </div>

                <div class="col-lg-7">
                    <div class="p-3 p-sm-4 p-md-5">
                        <div class="text-center mb-4">
                            <h1 class="h4 text-gray-900 font-weight-bold">Edit Profil</h1>
                            <p class="text-muted">Lengkapi data diri Anda dengan informasi terbaru</p>
                        </div>

                        @if(session('error'))
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                {{ session('error') }}
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                        @endif

                        <form class="user" method="POST" action="{{ route('profile.update') }}" id="profileForm" novalidate>
                            @csrf
                            @method('PUT')

                            <div class="form-group floating-label">
                                <input type="text" class="form-control form-control-user @error('username') is-invalid @enderror" 
                                    id="username" name="username" value="{{ old('username', $user->username) }}" 
                                    placeholder=" " required>
                                <label for="username">Username</label>
                                <div class="invalid-feedback" id="username-feedback">
                                    @error('username')
                                        {{ $message }}
                                    @else
                                        Username harus diisi (minimal 3 karakter)
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group floating-label">
                                <input type="text" class="form-control form-control-user @error('nama') is-invalid @enderror" 
                                    id="nama" name="nama" value="{{ old('nama', $user->nama) }}" 
                                    placeholder=" " required minlength="3" maxlength="255">
                                <label for="nama">Nama Lengkap</label>
                                <div class="invalid-feedback" id="nama-feedback">
                                    @error('nama')
                                        {{ $message }}
                                    @else
                                        Nama lengkap harus diisi (minimal 3 karakter)
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group floating-label">
                                <input type="text" class="form-control form-control-user @error('nip') is-invalid @enderror" 
                                    id="nip" name="nip" value="{{ old('nip', $user->nip) }}" 
                                    placeholder=" " required>
                                <label for="nip">Nomor Induk Pegawai (NIP)</label>
                                <div class="invalid-feedback" id="nip-feedback">
                                    @error('nip')
                                        {{ $message }}
                                    @else
                                        NIP harus berupa angka (9-18 digit)
                                    @enderror
                                </div>
                            </div>

                            <div class="text-center mt-4 mb-3">
                                <h5 class="font-weight-bold text-primary">Ubah Password</h5>
                                <small class="text-muted">Kosongkan jika tidak ingin mengubah password</small>
                            </div>

                            <div class="form-group floating-label">
                                <input type="password" class="form-control form-control-user @error('password') is-invalid @enderror" 
                                    id="password" name="password" placeholder=" " minlength="8">
                                <label for="password">Password Baru</label>
                                <div class="invalid-feedback" id="password-feedback">
                                    @error('password')
                                        {{ $message }}
                                    @else
                                        Password minimal 8 karakter
                                    @enderror
                                </div>
                                <small class="text-muted">Minimal 8 karakter</small>
                                <div class="password-strength mt-1" id="password-strength" style="display: none;">
                                    <small class="text-muted">Kekuatan Password: <span id="strength-text">-</span></small>
                                    <div class="progress" style="height: 5px;">
                                        <div id="strength-meter" class="progress-bar" role="progressbar" style="width: 0%"></div>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group floating-label">
                                <input type="password" class="form-control form-control-user" 
                                    id="password-confirm" name="password_confirmation" placeholder=" ">
                                <label for="password-confirm">Konfirmasi Password</label>
                                <div class="invalid-feedback" id="password-confirm-feedback">
                                    Password konfirmasi harus sama dengan password baru
                                </div>
                            </div>

                            <div class="form-group floating-label">
                                <input type="password" class="form-control form-control-user @error('current_password') is-invalid @enderror" 
                                    id="current_password" name="current_password" 
                                    placeholder=" " required>
                                <label for="current_password">Password Saat Ini</label>
                                <div class="invalid-feedback" id="current-password-feedback">
                                    @error('current_password')
                                        {{ $message }}
                                    @else
                                        Password saat ini harus diisi
                                    @enderror
                                </div>
                            </div>

                            <button type="submit" class="btn btn-primary btn-user btn-block py-2 py-md-3 font-weight-bold" 
                                style="border-radius: 50px; background: linear-gradient(90deg, #667eea 0%, #764ba2 100%);
                                       border: none; box-shadow: 0 4px 15px rgba(102, 126, 234, 0.4); transition: all 0.3s;">
                                <i class="fas fa-save mr-2"></i> Simpan Perubahan
                            </button>
                        </form>

                        <hr class="my-4">
                        <div class="text-center">
                            <a class="small text-primary font-weight-bold" href="{{ url('/dashboard') }}">
                                <i class="fas fa-arrow-left mr-1"></i> Kembali ke Dashboard
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    /* Responsive styles */
    @media (max-width: 991.98px) {
        .container {
            padding-left: 10px;
            padding-right: 10px;
        }
    }

    @media (max-width: 575.98px) {
        .form-control-user {
            height: 46px; /* Slightly smaller on mobile */
            font-size: 14px;
        }
        .floating-label label {
            font-size: 14px;
        }
        .btn-user {
            font-size: 14px;
            padding-top: 10px !important;
            padding-bottom: 10px !important;
        }
    }

    /* Fix floating labels on mobile */
    .floating-label {
        position: relative;
        margin-bottom: 1.5rem;
    }
    
    .floating-label label {
        position: absolute;
        top: 12px;
        left: 20px;
        color: #6c757d;
        transition: all 0.3s ease;
        pointer-events: none;
        background: white;
        padding: 0 5px;
        z-index: 1;
    }
    
    .floating-label input:focus ~ label,
    .floating-label input:not(:placeholder-shown) ~ label {
        top: -10px;
        left: 15px;
        font-size: 12px;
        color: #667eea;
    }
    
    .form-control-user {
        height: 50px;
        border-radius: 50px !important;
        padding-left: 20px;
        border: 1px solid #e0e0e0;
    }
    
    .form-control-user:focus {
        box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
        border-color: #667eea;
    }
    
    .btn-user:hover {
        transform: translateY(-2px);
        box-shadow: 0 7px 20px rgba(102, 126, 234, 0.5) !important;
    }
    
    /* Fix touch inputs on mobile */
    input[type="text"], 
    input[type="password"] {
        -webkit-appearance: none;
        -moz-appearance: none;
        appearance: none;
    }
    
    /* Consistent styles across devices */
    input[readonly] {
        background-color: #fff !important; /* samakan dengan input lain */
        color: #495057; /* teks tetap terbaca */
        border: 1px solid #ced4da; /* seperti input normal */
        box-shadow: none !important;
    }
    
    .was-validated .form-control:valid, .form-control.is-valid {
        border-color: #28a745;
        background-image: none;
    }
    
    .was-validated .form-control:invalid, .form-control.is-invalid {
        border-color: #dc3545;
        background-image: none;
    }
    
    .form-control:focus {
        border-color: #667eea;
    }
    
    .password-strength {
        margin-top: 5px;
    }
    
    .password-strength .progress {
        height: 5px;
        margin-top: 5px;
    }
    
    /* Fix for ios input zooming */
    @media screen and (-webkit-min-device-pixel-ratio:0) { 
        select,
        textarea,
        input {
            font-size: 16px !important;
        }
    }
    
    /* Prevent auto-zoom on iOS */
    @media screen and (max-width: 767px) {
        input, select, textarea {
            font-size: 16px !important;
        }
    }
    
    /* Fix for mobile Safari's auto-adjusting font-size */
    @supports (-webkit-overflow-scrolling: touch) {
        input, textarea, select {
            font-size: 16px !important;
        }
    }
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('profileForm');
    const usernameInput = document.getElementById('username');
    const namaInput = document.getElementById('nama');
    const nipInput = document.getElementById('nip');
    const passwordInput = document.getElementById('password');
    const passwordConfirmInput = document.getElementById('password-confirm');
    const currentPasswordInput = document.getElementById('current_password');
    const strengthMeter = document.getElementById('strength-meter');
    const strengthText = document.getElementById('strength-text');
    const strengthDiv = document.getElementById('password-strength');
    
    // Fixing iOS zooming issues by temporarily adjusting viewport
    const metas = document.getElementsByTagName('meta');
    const viewportMeta = Array.from(metas).find(meta => meta.name === 'viewport');
    const originalContent = viewportMeta ? viewportMeta.content : '';
    
    // When input gets focus on mobile devices
    const formInputs = document.querySelectorAll('input');
    formInputs.forEach(input => {
        // Fix iOS zooming when focusing inputs
        input.addEventListener('focus', function() {
            // Check if device is iOS
            if (/iPad|iPhone|iPod/.test(navigator.userAgent) && !window.MSStream) {
                if (viewportMeta) {
                    viewportMeta.content = 'width=device-width, initial-scale=1, maximum-scale=1';
                }
            }
        });
        
        input.addEventListener('blur', function() {
            // Restore original viewport
            if (/iPad|iPhone|iPod/.test(navigator.userAgent) && !window.MSStream) {
                if (viewportMeta) {
                    setTimeout(() => {
                        viewportMeta.content = originalContent;
                    }, 300);
                }
            }
        });
    });
    
    // Validasi saat submit form
    form.addEventListener('submit', function(event) {
        let isValid = true;
        
        // Validasi username
        if (usernameInput.value.length < 3) {
            usernameInput.classList.add('is-invalid');
            isValid = false;
        } else {
            usernameInput.classList.remove('is-invalid');
            usernameInput.classList.add('is-valid');
        }
        
        // Validasi nama
        if (!namaInput.validity.valid) {
            namaInput.classList.add('is-invalid');
            isValid = false;
        } else {
            namaInput.classList.remove('is-invalid');
            namaInput.classList.add('is-valid');
        }
        
        // Validasi NIP
        const nipRegex = /^[0-9]+$/;
        if (!nipRegex.test(nipInput.value) || nipInput.value.length < 9 || nipInput.value.length > 18) {
            nipInput.classList.add('is-invalid');
            document.getElementById('nip-feedback').textContent = 'NIP harus berupa angka (9-18 digit)';
            isValid = false;
        } else {
            nipInput.classList.remove('is-invalid');
            nipInput.classList.add('is-valid');
        }
        
        // Validasi password baru (opsional)
        if (passwordInput.value.length > 0) {
            if (passwordInput.value.length < 8) {
                passwordInput.classList.add('is-invalid');
                document.getElementById('password-feedback').textContent = 'Password minimal 8 karakter';
                isValid = false;
            } else {
                passwordInput.classList.remove('is-invalid');
                passwordInput.classList.add('is-valid');
            }
            
            // Validasi konfirmasi password
            if (passwordConfirmInput.value !== passwordInput.value) {
                passwordConfirmInput.classList.add('is-invalid');
                isValid = false;
            } else {
                passwordConfirmInput.classList.remove('is-invalid');
                passwordConfirmInput.classList.add('is-valid');
            }
        } else {
            passwordInput.classList.remove('is-invalid');
            passwordConfirmInput.classList.remove('is-invalid');
        }
        
        // Validasi password saat ini
        if (currentPasswordInput.value.length === 0) {
            currentPasswordInput.classList.add('is-invalid');
            isValid = false;
        } else {
            currentPasswordInput.classList.remove('is-invalid');
            currentPasswordInput.classList.add('is-valid');
        }
        
        if (!isValid) {
            event.preventDefault();
            
            // Scroll to first invalid input on mobile
            const firstInvalid = form.querySelector('.is-invalid');
            if (firstInvalid && window.innerWidth < 768) {
                setTimeout(() => {
                    window.scrollTo({
                        top: firstInvalid.getBoundingClientRect().top + window.pageYOffset - 100,
                        behavior: 'smooth'
                    });
                }, 100);
            }
        }
    });
    
    // Real-time validasi untuk username
    usernameInput.addEventListener('input', function() {
        if (this.value.length < 3) {
            this.classList.add('is-invalid');
            this.classList.remove('is-valid');
        } else {
            this.classList.remove('is-invalid');
            this.classList.add('is-valid');
        }
    });
    
    // Real-time validasi untuk nama
    namaInput.addEventListener('input', function() {
        if (this.value.length < 3) {
            this.classList.add('is-invalid');
            this.classList.remove('is-valid');
        } else {
            this.classList.remove('is-invalid');
            this.classList.add('is-valid');
        }
    });
    
    // Real-time validasi untuk NIP
    nipInput.addEventListener('input', function() {
        const regex = /^[0-9]+$/;
        if (!regex.test(this.value) || this.value.length < 9 || this.value.length > 18) {
            this.classList.add('is-invalid');
            this.classList.remove('is-valid');
            document.getElementById('nip-feedback').textContent = 'NIP harus berupa angka (9-18 digit)';
        } else {
            this.classList.remove('is-invalid');
            this.classList.add('is-valid');
        }
    });
    
    // Real-time validasi untuk password baru
    passwordInput.addEventListener('input', function() {
        // Show password strength meter when user starts typing
        if (this.value.length > 0) {
            strengthDiv.style.display = 'block';
            
            // Check password strength
            const strength = checkPasswordStrength(this.value);
            updatePasswordStrengthUI(strength);
            
            if (this.value.length < 8) {
                this.classList.add('is-invalid');
                this.classList.remove('is-valid');
            } else {
                this.classList.remove('is-invalid');
                this.classList.add('is-valid');
            }
            
            // Check password confirmation match
            if (passwordConfirmInput.value.length > 0) {
                validatePasswordMatch();
            }
        } else {
            strengthDiv.style.display = 'none';
            this.classList.remove('is-invalid');
            this.classList.remove('is-valid');
            passwordConfirmInput.classList.remove('is-invalid');
            passwordConfirmInput.classList.remove('is-valid');
        }
    });
    
    // Real-time validasi untuk konfirmasi password
    passwordConfirmInput.addEventListener('input', validatePasswordMatch);
    
    // Real-time validasi untuk password saat ini
    currentPasswordInput.addEventListener('input', function() {
        if (this.value.length === 0) {
            this.classList.add('is-invalid');
            this.classList.remove('is-valid');
        } else {
            this.classList.remove('is-invalid');
            this.classList.add('is-valid');
        }
    });
    
    function validatePasswordMatch() {
        if (passwordInput.value.length > 0) {
            if (passwordConfirmInput.value !== passwordInput.value) {
                passwordConfirmInput.classList.add('is-invalid');
                passwordConfirmInput.classList.remove('is-valid');
            } else {
                passwordConfirmInput.classList.remove('is-invalid');
                passwordConfirmInput.classList.add('is-valid');
            }
        }
    }
    
    function checkPasswordStrength(password) {
        let strength = 0;
        
        // Length check
        if (password.length >= 8) strength += 1;
        if (password.length >= 12) strength += 1;
        
        // Complexity checks
        if (/[A-Z]/.test(password)) strength += 1; // Has uppercase
        if (/[a-z]/.test(password)) strength += 1; // Has lowercase
        if (/[0-9]/.test(password)) strength += 1; // Has number
        if (/[^A-Za-z0-9]/.test(password)) strength += 1; // Has special char
        
        return strength;
    }
    
    function updatePasswordStrengthUI(strength) {
        // Update strength meter
        let percentage = (strength / 6) * 100;
        let color = '';
        let text = '';
        
        if (strength <= 2) {
            color = '#dc3545'; // red (danger)
            text = 'Lemah';
        } else if (strength <= 4) {
            color = '#ffc107'; // yellow (warning)
            text = 'Sedang';
        } else {
            color = '#28a745'; // green (success)
            text = 'Kuat';
        }
        
        strengthMeter.style.width = percentage + '%';
        strengthMeter.style.backgroundColor = color;
        strengthText.textContent = text;
        strengthText.style.color = color;
    }
});
</script>
@endsection