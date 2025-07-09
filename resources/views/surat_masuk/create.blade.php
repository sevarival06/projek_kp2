@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card border-0 shadow-lg rounded-4 overflow-hidden">
                <!-- Header dengan gradient -->
                <div class="card-header border-0 bg-gradient-primary p-3">
                    <div class="d-flex align-items-center">
                        <div class="avatar-circle bg-white me-3">
                            <i class="fas fa-envelope fa-fw text-primary"></i>
                        </div>
                        <h5 class="m-0 fw-bold text-white">📨 Tambah Surat Masuk</h5>
                    </div>
                </div>

                <div class="card-body p-4">
                    <!-- Alert container -->
                    <div id="alert-container">
                        @if(session('success'))
                            <div class="alert alert-success alert-dismissible fade show rounded-3" role="alert">
                                <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        @endif
                        
                        @if($errors->any())
                            <div class="alert alert-danger alert-dismissible fade show rounded-3" role="alert">
                                <i class="fas fa-exclamation-circle me-2"></i><strong>Oops!</strong> Ada beberapa masalah:
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                <ul class="list-unstyled mt-2 mb-0">
                                    @foreach($errors->all() as $error)
                                        <li><i class="fas fa-times-circle me-1"></i>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                    </div>

                    <!-- Progress indicator -->
                    <div class="progress rounded-pill mb-4" style="height: 6px;">
                        <div id="form-progress" class="progress-bar progress-bar-striped progress-bar-animated bg-primary" role="progressbar" style="width: 0%"></div>
                    </div>

                    <form method="POST" action="{{ route('surat-masuk.store') }}" enctype="multipart/form-data" id="surat-form" class="needs-validation" novalidate>
                        @csrf
                        
                        <div class="row g-3">
                            <!-- No. Agenda & No. Surat - Row 1 -->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="no_agenda" class="form-label mb-1">
                                        <i class="fas fa-hashtag text-primary me-1"></i>No. Agenda<span class="text-danger">*</span>
                                    </label>
                                    <input id="no_agenda" type="text" class="form-control @error('no_agenda') is-invalid @enderror" 
                                           name="no_agenda" value="{{ old('no_agenda') }}" required autofocus 
                                           maxlength="50" placeholder="123" pattern="[0-9]+" 
                                           title="Hanya angka yang diperbolehkan">
                                    @error('no_agenda')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <div class="form-text small"><i class="fas fa-info-circle fa-xs"></i> Hanya angka, maksimal 50 karakter</div>
                                </div>
                            </div>

                            
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="no_surat" class="form-label mb-1">
                                        <i class="fas fa-file-alt text-primary me-1"></i>No. Surat<span class="text-danger">*</span>
                                    </label>
                                    <input id="no_surat" type="text" class="form-control @error('no_surat') is-invalid @enderror" 
                                           name="no_surat" value="{{ old('no_surat') }}" required 
                                           maxlength="50" placeholder="ABC/123/2025">
                                    @error('no_surat')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <div class="form-text small"><i class="fas fa-info-circle fa-xs"></i> Maksimal 50 karakter</div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="klasifikasi_surat" class="form-label mb-1">
                                        <i class="fas fa-tag text-primary me-1"></i>Klasifikasi Surat<span class="text-danger">*</span>
                                    </label>
                                    <select name="klasifikasi_surat" id="klasifikasi_surat" 
                                            class="form-control @error('klasifikasi_surat') is-invalid @enderror" required>
                                        <option value="">-- Pilih Klasifikasi --</option>
                                        <option value="Surat Umum" {{ old('klasifikasi_surat', $surat->klasifikasi_surat ?? '') == 'Surat Umum' ? 'selected' : '' }}>Surat Umum</option>
                                        <option value="Surat Dinas" {{ old('klasifikasi_surat', $surat->klasifikasi_surat ?? '') == 'Surat Dinas' ? 'selected' : '' }}>Surat Dinas</option>
                                        <option value="Surat Niaga" {{ old('klasifikasi_surat', $surat->klasifikasi_surat ?? '') == 'Surat Niaga' ? 'selected' : '' }}>Surat Niaga</option>
                                        <option value="Surat Pribadi" {{ old('klasifikasi_surat', $surat->klasifikasi_surat ?? '') == 'Surat Pribadi' ? 'selected' : '' }}>Surat Pribadi</option>
                                        <option value="Surat Keputusan (SK)" {{ old('klasifikasi_surat', $surat->klasifikasi_surat ?? '') == 'Surat Keputusan (SK)' ? 'selected' : '' }}>Surat Keputusan (SK)</option>
                                        <option value="Surat Resmi Lainnya" {{ old('klasifikasi_surat', $surat->klasifikasi_surat ?? '') == 'Surat Resmi Lainnya' ? 'selected' : '' }}>Surat Resmi Lainnya</option>
                                    </select>
                                    @error('klasifikasi_surat')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <div class="form-text small"><i class="fas fa-info-circle fa-xs"></i> Wajib pilih klasifikasi</div>
                                </div>
                            </div>

                            
                            <!-- Pengirim & Asal Surat - Row 2 -->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="pengirim" class="form-label mb-1">
                                        <i class="fas fa-user text-primary me-1"></i>Pengirim<span class="text-danger">*</span>
                                    </label>
                                    <input id="pengirim" type="text" class="form-control @error('pengirim') is-invalid @enderror" 
                                           name="pengirim" value="{{ old('pengirim') }}" required 
                                           maxlength="250" placeholder="Nama Pengirim">
                                    @error('pengirim')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <div class="form-text small"><i class="fas fa-info-circle fa-xs"></i> Maksimal 250 karakter</div>
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="asal_surat" class="form-label mb-1">
                                        <i class="fas fa-building text-primary me-1"></i>Asal Surat<span class="text-danger">*</span>
                                    </label>
                                    <input id="asal_surat" type="text" class="form-control @error('asal_surat') is-invalid @enderror" 
                                           name="asal_surat" value="{{ old('asal_surat') }}" required 
                                           maxlength="500" placeholder="Asal Surat">
                                    @error('asal_surat')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <div class="form-text small"><i class="fas fa-info-circle fa-xs"></i> Maksimal 500 karakter</div>
                                </div>
                            </div>
                            
                            <!-- Penerima - Row 3 -->
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="penerima" class="form-label mb-1">
                                        <i class="fas fa-user-check text-primary me-1"></i>Penerima<span class="text-danger">*</span>
                                    </label>
                                    <input id="penerima" type="text" class="form-control @error('penerima') is-invalid @enderror" 
                                           name="penerima" value="{{ old('penerima') }}" required 
                                           maxlength="250" placeholder="Nama Penerima">
                                    @error('penerima')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <div class="form-text small"><i class="fas fa-info-circle fa-xs"></i> Maksimal 250 karakter</div>
                                </div>
                            </div>
                            
                            <!-- Perihal Surat - Row 4 -->
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="isi" class="form-label mb-1">
                                        <i class="fas fa-align-left text-primary me-1"></i>Perihal Surat<span class="text-danger">*</span>
                                    </label>
                                    <textarea id="isi" class="form-control @error('isi') is-invalid @enderror" 
                                              name="isi" required rows="3" 
                                              placeholder="Perihal Surat">{{ old('isi') }}</textarea>
                                    @error('isi')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            
                            <!-- Jumlah & Tanggal - Row 5 -->
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="jumlah" class="form-label mb-1">
                                        <i class="fas fa-layer-group text-primary me-1"></i>Jumlah<span class="text-danger">*</span>
                                    </label>
                                    <input id="jumlah" type="number" class="form-control @error('jumlah') is-invalid @enderror" 
                                           name="jumlah" value="{{ old('jumlah', 1) }}" required 
                                           min="1" max="1000" placeholder="1">
                                    @error('jumlah')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <div class="form-text small"><i class="fas fa-info-circle fa-xs"></i> Min 1, maks 1000</div>
                                </div>
                            </div>
                            
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="tgl_surat" class="form-label mb-1">
                                        <i class="fas fa-calendar-alt text-primary me-1"></i>Tanggal Surat<span class="text-danger">*</span>
                                    </label>
                                    <input id="tgl_surat" type="date" class="form-control date-picker @error('tgl_surat') is-invalid @enderror" 
                                           name="tgl_surat" value="{{ old('tgl_surat') }}" required>
                                    @error('tgl_surat')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="tgl_agenda" class="form-label mb-1">
                                        <i class="fas fa-calendar-check text-primary me-1"></i>Tanggal Agenda<span class="text-danger">*</span>
                                    </label>
                                    <input id="tgl_agenda" type="date" class="form-control date-picker @error('tgl_agenda') is-invalid @enderror" 
                                           name="tgl_agenda" value="{{ old('tgl_agenda') }}" required>
                                    @error('tgl_agenda')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            
                            <!-- File Upload - Row 6 -->
                            <div class="col-md-12 mt-2">
                                <div class="upload-container border border-2 border-dashed rounded-3 p-3 text-center">
                                    <div class="upload-icon mb-2">
                                        <i class="fas fa-cloud-upload-alt fa-2x text-primary"></i>
                                    </div>
                                    <h6 class="mb-1">Upload File Surat<span class="text-danger">*</span></h6>
                                    <p class="text-muted small mb-2">Format: PDF, JPG, JPEG, PNG. Maks: 10MB</p>
                                    
                                    <input id="file" type="file" class="form-control d-none @error('file') is-invalid @enderror" 
                                           name="file" accept=".pdf,.jpg,.jpeg,.png" required>
                                           
                                    <button type="button" class="btn btn-outline-primary btn-sm px-3" id="browse-btn">
                                        <i class="fas fa-folder-open me-1"></i>Pilih File
                                    </button>
                                    
                                    <div id="file-preview" class="mt-2 d-none">
                                        <div class="d-flex align-items-center justify-content-center bg-light p-2 rounded-3">
                                            <i class="fas fa-file-alt text-primary me-2"></i>
                                            <span id="file-name" class="text-truncate">filename.pdf</span>
                                            <span class="ms-1 text-muted small" id="file-size">(0 KB)</span>
                                            <button type="button" class="btn btn-link text-danger p-0 ms-2" id="remove-file">
                                                <i class="fas fa-times-circle"></i>
                                            </button>
                                        </div>
                                    </div>
                                    
                                    @error('file')
                                        <div class="invalid-feedback d-block mt-2">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            
                            <!-- Buttons - Row 7 -->
                            <div class="col-12 mt-3 d-flex justify-content-end gap-2">
                                <a href="{{ route('surat-masuk.index') }}" class="btn btn-light">
                                    <i class="fas fa-arrow-left me-1"></i>Kembali
                                </a>
                                <button type="submit" class="btn btn-primary px-4">
                                    <i class="fas fa-save me-1"></i>Simpan
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@push('styles')
<style>
    /* Card styling */
    .card {
        border-radius: 12px;
    }
    
    .card-header {
        border-bottom: none;
    }
    
    /* Gradient Background */
    .bg-gradient-primary {
        background: linear-gradient(to right, #4e73df, #6f42c1);
    }
    
    /* Avatar circle */
    .avatar-circle {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 32px;
        height: 32px;
        border-radius: 50%;
    }
    
    /* Form controls */
    .form-control {
        border-radius: 8px;
        border: 1px solid #dee2e6;
        padding: 8px 12px;
        font-size: 14px;
        transition: all 0.2s ease;
    }
    
    .form-control:focus {
        border-color: #4e73df;
        box-shadow: 0 0 0 0.2rem rgba(78, 115, 223, 0.25);
    }
    
    .form-label {
        font-size: 14px;
        font-weight: 500;
        color: #495057;
    }
    
    /* Upload area */
    .upload-container {
        background-color: #f8f9fa;
        border-color: #dee2e6 !important;
        transition: all 0.2s ease;
    }
    
    .upload-container:hover {
        border-color: #4e73df !important;
        background-color: rgba(78, 115, 223, 0.05);
    }
    
    /* Button styling */
    .btn-primary {
        background-color: #4e73df;
        border-color: #4e73df;
    }
    
    .btn-primary:hover {
        background-color: #3d5ebd;
        border-color: #3d5ebd;
    }
    
    .btn-light {
        background-color: #f8f9fa;
        border-color: #dee2e6;
    }
    
    /* Progress bar */
    .progress {
        height: 6px;
        background-color: #f2f2f2;
    }
    
    /* Small helper text */
    .form-text {
        font-size: 11px;
        color: #6c757d;
    }
    
    /* Make everything more compact */
    .form-group {
        margin-bottom: 8px;
    }
</style>
@endpush

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Reset validation flag when starting validation
        window.addEventListener('submit', function() {
            window.invalidElementFound = false;
        });
        
        // File upload handling
        const fileInput = document.getElementById('file');
        const browseBtn = document.getElementById('browse-btn');
        const filePreview = document.getElementById('file-preview');
        const fileName = document.getElementById('file-name');
        const fileSize = document.getElementById('file-size');
        const removeFileBtn = document.getElementById('remove-file');
        
        // Browse button click handler
        browseBtn.addEventListener('click', function() {
            fileInput.click();
        });
        
        // File input change handler
        fileInput.addEventListener('change', function() {
            handleFiles(this.files);
        });
        
        // Handle the selected files
        function handleFiles(files) {
            if (files.length === 0) return;
            
            const file = files[0];
            
            // Display file info
            fileName.textContent = file.name;
            fileSize.textContent = '(' + formatBytes(file.size) + ')';
            
            filePreview.classList.remove('d-none');
            
            // Validate file type and size
            validateFile(file);
        }
        
        // Remove file handler
        removeFileBtn.addEventListener('click', function() {
            fileInput.value = '';
            filePreview.classList.add('d-none');
            fileInput.classList.remove('is-invalid');
        });
        
        // Format bytes to human-readable format
        function formatBytes(bytes, decimals = 1) {
            if (bytes === 0) return '0 Bytes';
            
            const k = 1024;
            const dm = decimals < 0 ? 0 : decimals;
            const sizes = ['Bytes', 'KB', 'MB', 'GB'];
            
            const i = Math.floor(Math.log(bytes) / Math.log(k));
            
            return parseFloat((bytes / Math.pow(k, i)).toFixed(dm)) + ' ' + sizes[i];
        }
        
        // Validate file
        function validateFile(file) {
            const allowedTypes = ['application/pdf', 'image/jpeg', 'image/jpg', 'image/png'];
            const maxSize = 10 * 1024 * 1024; // 10MB
            
            if (!allowedTypes.includes(file.type)) {
                setInvalid(fileInput, 'Format file harus PDF, JPG, JPEG, atau PNG');
                return false;
            } else if (file.size > maxSize) {
                setInvalid(fileInput, 'Ukuran file maksimal 10MB');
                return false;
            }
            
            return true;
        }
        
        // Trigger calendar to show automatically when clicking on date inputs
        const dateInputs = document.querySelectorAll('.date-picker');
        dateInputs.forEach(function(input) {
            input.addEventListener('click', function() {
                this.showPicker();
            });
            input.addEventListener('focus', function() {
                this.showPicker();
            });
        });

        // Set default dates if empty
        if (!document.getElementById('tgl_surat').value) {
            document.getElementById('tgl_surat').value = new Date().toISOString().split('T')[0];
        }
        if (!document.getElementById('tgl_agenda').value) {
            document.getElementById('tgl_agenda').value = new Date().toISOString().split('T')[0];
        }
        
        // Form progress indicator
        const formInputs = document.querySelectorAll('#surat-form input[required], #surat-form textarea[required]');
        const progressBar = document.getElementById('form-progress');
        
        // Update progress when inputs change
        function updateProgress() {
            let filledCount = 0;
            
            formInputs.forEach(input => {
                if (input.value.trim() !== '') {
                    filledCount++;
                }
            });
            
            const progressPercent = (filledCount / formInputs.length) * 100;
            progressBar.style.width = progressPercent + '%';
        }
        
        // Check initial progress
        updateProgress();
        
        // Listen for input changes
        formInputs.forEach(input => {
            input.addEventListener('input', updateProgress);
        });
        
        // Client-side validation
        const form = document.querySelector('form');
        form.addEventListener('submit', function(event) {
            let isValid = true;
            
            // Check all required fields
            const requiredInputs = form.querySelectorAll('input[required], textarea[required]');
            requiredInputs.forEach(function(input) {
                if (!input.value.trim()) {
                    setInvalid(input, 'Bidang ini harus diisi');
                    isValid = false;
                }
            });
            
            // Validate no_agenda (must be numeric)
            const noAgenda = document.getElementById('no_agenda');
            if (noAgenda.value.trim() && !/^\d+$/.test(noAgenda.value)) {
                setInvalid(noAgenda, 'Nomor agenda hanya boleh diisi dengan angka');
                isValid = false;
            } else if (noAgenda.value.length > 50) {
                setInvalid(noAgenda, 'Nomor agenda maksimal 50 karakter');
                isValid = false;
            }
            
            // Validate no_surat
            const noSurat = document.getElementById('no_surat');
            if (noSurat.value.length > 50) {
                setInvalid(noSurat, 'Nomor surat maksimal 50 karakter');
                isValid = false;
            }
            
            // Validate file if present
            if (!fileInput.files || fileInput.files.length === 0) {
                setInvalid(fileInput, 'File surat harus diunggah');
                isValid = false;
            } else {
                const file = fileInput.files[0];
                isValid = validateFile(file) && isValid;
            }
            
            if (!isValid) {
                event.preventDefault();
                showAlert('Mohon lengkapi semua bidang yang diperlukan', 'danger');
            }
        });
        
        function setInvalid(element, message) {
            element.classList.add('is-invalid');
            
            // Special handling for file input which has a custom UI
            if (element.id === 'file') {
                // Find existing feedback or create new one
                let feedbackElement = document.querySelector('.upload-container .invalid-feedback');
                if (!feedbackElement) {
                    feedbackElement = document.createElement('div');
                    feedbackElement.classList.add('invalid-feedback', 'd-block', 'mt-2');
                    document.querySelector('.upload-container').appendChild(feedbackElement);
                }
                feedbackElement.textContent = message;
            } else {
                // For other inputs
                let feedbackElement = element.nextElementSibling;
                if (feedbackElement && feedbackElement.classList.contains('invalid-feedback')) {
                    feedbackElement.textContent = message;
                } else {
                    feedbackElement = document.createElement('div');
                    feedbackElement.classList.add('invalid-feedback');
                    feedbackElement.textContent = message;
                    element.parentNode.insertBefore(feedbackElement, element.nextSibling);
                }
            }
            
            // Scroll to first invalid element
            if (!window.invalidElementFound) {
                window.invalidElementFound = true;
                element.scrollIntoView({ behavior: 'smooth', block: 'center' });
                setTimeout(() => element.focus(), 500);
            }
        }
        
        function showAlert(message, type) {
            const alertDiv = document.createElement('div');
            alertDiv.className = `alert alert-${type} alert-dismissible fade show rounded-3`;
            alertDiv.innerHTML = `
                <i class="fas fa-${type === 'danger' ? 'exclamation-circle' : 'check-circle'} me-2"></i>
                ${message}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            `;
            
            const alertContainer = document.getElementById('alert-container');
            alertContainer.innerHTML = ''; // Clear previous alerts
            alertContainer.appendChild(alertDiv);
            
            // Auto dismiss after 5 seconds
            setTimeout(() => {
                alertDiv.classList.remove('show');
                setTimeout(() => alertDiv.remove(), 150);
            }, 5000);
        }
    });
</script>
@endpush
