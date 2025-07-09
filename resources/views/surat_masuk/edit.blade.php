@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
            <h6 class="m-0 font-weight-bold text-primary">Edit Surat Masuk</h6>
            <div class="dropdown no-arrow">
                <a href="{{ route('surat-masuk.index') }}" class="btn btn-secondary btn-sm">
                    <i class="fas fa-arrow-left fa-sm"></i> Kembali
                </a>
            </div>
        </div>

        <div class="card-body">
            @if ($errors->any())
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif

            <form action="{{ route('surat-masuk.update', $surat->id_surat) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="row mb-3">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="no_agenda">Nomor Agenda <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('no_agenda') is-invalid @enderror" 
                                id="no_agenda" name="no_agenda" value="{{ old('no_agenda', $surat->no_agenda) }}" required>
                        </div>
                        
                        <div class="form-group">
                            <label for="no_surat">Nomor Surat <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('no_surat') is-invalid @enderror" 
                                id="no_surat" name="no_surat" value="{{ old('no_surat', $surat->no_surat) }}" required>
                        </div>

                         {{-- Klasifikasi Surat --}}
                        <div class="form-group">
                            <label for="klasifikasi_surat">Klasifikasi Surat <span class="text-danger">*</span></label>
                            <select name="klasifikasi_surat" id="klasifikasi_surat"
                                class="form-control @error('klasifikasi_surat') is-invalid @enderror" required>
                                <option value="">-- Pilih Klasifikasi --</option>
                                <option value="Surat Umum" {{ old('klasifikasi_surat', $surat->klasifikasi_surat) == 'Surat Umum' ? 'selected' : '' }}>Surat Umum</option>
                                <option value="Surat Dinas" {{ old('klasifikasi_surat', $surat->klasifikasi_surat) == 'Surat Dinas' ? 'selected' : '' }}>Surat Dinas</option>
                                <option value="Surat Niaga" {{ old('klasifikasi_surat', $surat->klasifikasi_surat) == 'Surat Niaga' ? 'selected' : '' }}>Surat Niaga</option>
                                <option value="Surat Pribadi" {{ old('klasifikasi_surat', $surat->klasifikasi_surat) == 'Surat Pribadi' ? 'selected' : '' }}>Surat Pribadi</option>
                                <option value="Surat Keputusan (SK)" {{ old('klasifikasi_surat', $surat->klasifikasi_surat) == 'Surat Keputusan (SK)' ? 'selected' : '' }}>Surat Keputusan (SK)</option>
                                <option value="Surat Resmi Lainnya" {{ old('klasifikasi_surat', $surat->klasifikasi_surat) == 'Surat Resmi Lainnya' ? 'selected' : '' }}>Surat Resmi Lainnya</option>
                            </select>
                            @error('klasifikasi_surat')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        
                        <div class="form-group">
                            <label for="pengirim">Pengirim <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('pengirim') is-invalid @enderror" 
                                id="pengirim" name="pengirim" value="{{ old('pengirim', $surat->pengirim) }}" required>
                        </div>
                        
                        <div class="form-group">
                            <label for="asal_surat">Asal Surat <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('asal_surat') is-invalid @enderror" 
                                id="asal_surat" name="asal_surat" value="{{ old('asal_surat', $surat->asal_surat) }}" required>
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="penerima">Penerima <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('penerima') is-invalid @enderror" 
                                id="penerima" name="penerima" value="{{ old('penerima', $surat->penerima) }}" required>
                        </div>
                        
                        <div class="form-group">
                            <label for="jumlah">Jumlah <span class="text-danger">*</span></label>
                            <input type="number" class="form-control @error('jumlah') is-invalid @enderror" 
                                id="jumlah" name="jumlah" value="{{ old('jumlah', $surat->jumlah) }}" required>
                        </div>
                        
                        <div class="form-group">
                            <label for="tgl_surat">Tanggal Surat <span class="text-danger">*</span></label>
                            <input type="date" class="form-control @error('tgl_surat') is-invalid @enderror" 
                                id="tgl_surat" name="tgl_surat" value="{{ old('tgl_surat', $surat->tgl_surat) }}" required>
                        </div>
                        
                        <div class="form-group">
                            <label for="tgl_agenda">Tanggal Agenda <span class="text-danger">*</span></label>
                            <input type="date" class="form-control @error('tgl_agenda') is-invalid @enderror" 
                                id="tgl_agenda" name="tgl_agenda" value="{{ old('tgl_agenda', $surat->tgl_agenda) }}" required>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label for="isi">Isi Surat <span class="text-danger">*</span></label>
                    <textarea class="form-control @error('isi') is-invalid @enderror" 
                        id="isi" name="isi" rows="4" required>{{ old('isi', $surat->isi) }}</textarea>
                </div>

                <div class="form-group">
                <label for="file">File Surat <span class="text-danger">*</span></label>
                <div class="input-group">
                    <input type="file" class="form-control @error('file') is-invalid @enderror" id="file" name="file" {{ $surat->file ? '' : 'required' }}>
                    @error('file')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <small class="form-text text-muted">Format file: PDF, JPG, JPEG, PNG (Maks. 10MB)</small>
                
                @if($surat->file)
                    <div class="mt-2">
                        <p class="mb-1">File saat ini:</p>
                        <div class="d-flex align-items-center">
                            <span class="mr-2">{{ $surat->file }}</span>
                            <a href="{{ route('surat-masuk.view-file', $surat->id_surat) }}" class="btn btn-sm btn-info mr-2" target="_blank">
                                <i class="fas fa-eye"></i> Lihat
                            </a>
                        </div>
                        <small class="text-muted">Unggah file baru untuk mengganti file yang ada. Jika tidak mengunggah file baru, file yang ada akan tetap digunakan.</small>
                    </div>
                @else
                    <small class="text-danger">Belum ada file surat. Harap unggah file surat.</small>
                @endif
            </div>

                <div class="form-group text-right">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const form = document.querySelector('form');
        form.addEventListener('submit', function(event) {
            let isValid = true;
            
            // Check all required fields
            const requiredInputs = form.querySelectorAll('input[required], textarea[required]');
            requiredInputs.forEach(function(input) {
                if (!input.value.trim()) {
                    setInvalid(input, input.placeholder + ' tidak boleh kosong');
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
            
            // Validate file if selected
            const fileInput = document.getElementById('file');
            const fileRequired = fileInput.hasAttribute('required');
            const hasExistingFile = document.querySelector('.d-flex.align-items-center') !== null;
            
            if (fileRequired && !hasExistingFile && (!fileInput.files || fileInput.files.length === 0)) {
                setInvalid(fileInput, 'File surat harus diunggah');
                isValid = false;
            } else if (fileInput.files && fileInput.files.length > 0) {
                const file = fileInput.files[0];
                const fileSize = file.size / 1024 / 1024; // size in MB
                const allowedExtensions = ['pdf', 'jpg', 'jpeg', 'png'];
                const fileExtension = file.name.split('.').pop().toLowerCase();
                
                if (!allowedExtensions.includes(fileExtension)) {
                    setInvalid(fileInput, 'Format file harus PDF, JPG, JPEG, atau PNG');
                    isValid = false;
                } else if (fileSize > 10) {
                    setInvalid(fileInput, 'Ukuran file maksimal 10MB');
                    isValid = false;
                }
            }
            
            if (!isValid) {
                event.preventDefault();
                // Show alert for validation errors
                showAlert('Mohon lengkapi semua kolom yang wajib diisi dengan benar', 'danger');
            }
        });
        
        function setInvalid(element, message) {
            element.classList.add('is-invalid');
            let feedbackElement = element.nextElementSibling;
            
            // If next element is not a feedback div, create one
            if (!feedbackElement || !feedbackElement.classList.contains('invalid-feedback')) {
                feedbackElement = document.createElement('div');
                feedbackElement.classList.add('invalid-feedback');
                element.parentNode.insertBefore(feedbackElement, element.nextSibling);
            }
            
            feedbackElement.textContent = message;
            
            // Scroll to first invalid element
            if (!window.invalidElementFound) {
                window.invalidElementFound = true;
                element.scrollIntoView({ behavior: 'smooth', block: 'center' });
                element.focus();
            }
        }
        
        function showAlert(message, type) {
            const alertDiv = document.createElement('div');
            alertDiv.className = `alert alert-${type} alert-dismissible fade show`;
            alertDiv.innerHTML = `
                ${message}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            `;
            
            const cardBody = document.querySelector('.card-body');
            const firstChild = cardBody.firstChild;
            cardBody.insertBefore(alertDiv, firstChild);
            
            // Auto dismiss after 5 seconds
            setTimeout(() => {
                alertDiv.classList.remove('show');
                setTimeout(() => alertDiv.remove(), 150);
            }, 5000);
        }
    });
</script>
@endpush
