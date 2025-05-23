@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ isset($surat) ? 'Edit Surat Masuk' : 'Tambah Surat Masuk' }}</div>

                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif

                    <form method="POST" action="{{ isset($surat) ? route('surat-masuk.update', $surat->id_surat) : route('surat-masuk.store') }}" enctype="multipart/form-data">
                        @csrf
                        @if(isset($surat))
                            @method('PUT')
                        @endif

                        <div class="form-group row mb-3">
                            <label for="no_agenda" class="col-md-4 col-form-label text-md-right">No. Agenda</label>
                            <div class="col-md-6">
                                <input id="no_agenda" type="text" class="form-control @error('no_agenda') is-invalid @enderror" name="no_agenda" value="{{ isset($surat) ? $surat->no_agenda : old('no_agenda') }}" required autofocus>
                                @error('no_agenda')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row mb-3">
                            <label for="no_surat" class="col-md-4 col-form-label text-md-right">No. Surat</label>
                            <div class="col-md-6">
                                <input id="no_surat" type="text" class="form-control @error('no_surat') is-invalid @enderror" name="no_surat" value="{{ isset($surat) ? $surat->no_surat : old('no_surat') }}" required>
                                @error('no_surat')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row mb-3">
                            <label for="pengirim" class="col-md-4 col-form-label text-md-right">Pengirim</label>
                            <div class="col-md-6">
                                <input id="pengirim" type="text" class="form-control @error('pengirim') is-invalid @enderror" name="pengirim" value="{{ isset($surat) ? $surat->pengirim : old('pengirim') }}" required>
                                @error('pengirim')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row mb-3">
                            <label for="asal_surat" class="col-md-4 col-form-label text-md-right">Asal Surat</label>
                            <div class="col-md-6">
                                <input id="asal_surat" type="text" class="form-control @error('asal_surat') is-invalid @enderror" name="asal_surat" value="{{ isset($surat) ? $surat->asal_surat : old('asal_surat') }}" required>
                                @error('asal_surat')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row mb-3">
                            <label for="penerima" class="col-md-4 col-form-label text-md-right">Penerima</label>
                            <div class="col-md-6">
                                <input id="penerima" type="text" class="form-control @error('penerima') is-invalid @enderror" name="penerima" value="{{ isset($surat) ? $surat->penerima : old('penerima') }}" required>
                                @error('penerima')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row mb-3">
                            <label for="isi" class="col-md-4 col-form-label text-md-right">Isi Surat</label>
                            <div class="col-md-6">
                                <textarea id="isi" class="form-control @error('isi') is-invalid @enderror" name="isi" required>{{ isset($surat) ? $surat->isi : old('isi') }}</textarea>
                                @error('isi')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row mb-3">
                            <label for="jumlah" class="col-md-4 col-form-label text-md-right">Jumlah</label>
                            <div class="col-md-6">
                                <input id="jumlah" type="number" class="form-control @error('jumlah') is-invalid @enderror" name="jumlah" value="{{ isset($surat) ? $surat->jumlah : old('jumlah') }}" required>
                                @error('jumlah')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row mb-3">
                            <label for="tgl_surat" class="col-md-4 col-form-label text-md-right">Tanggal Surat</label>
                            <div class="col-md-6">
                                <input id="tgl_surat" type="date" class="form-control @error('tgl_surat') is-invalid @enderror" name="tgl_surat" value="{{ isset($surat) ? $surat->tgl_surat : old('tgl_surat') }}" required>
                                @error('tgl_surat')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row mb-3">
                            <label for="tgl_agenda" class="col-md-4 col-form-label text-md-right">Tanggal Agenda</label>
                            <div class="col-md-6">
                                <input id="tgl_agenda" type="date" class="form-control @error('tgl_agenda') is-invalid @enderror" name="tgl_agenda" value="{{ isset($surat) ? $surat->tgl_agenda : old('tgl_agenda') }}" required>
                                @error('tgl_agenda')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row mb-3">
                            <label for="file" class="col-md-4 col-form-label text-md-right">File Surat</label>
                            <div class="col-md-6">
                                <input id="file" type="file" class="form-control @error('file') is-invalid @enderror" name="file">
                                @if(isset($surat) && $surat->file)
                                    <small class="form-text text-muted">File saat ini: {{ $surat->file }}</small>
                                @endif
                                @error('file')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ isset($surat) ? 'Update' : 'Simpan' }}
                                </button>
                                <a href="{{ route('surat-masuk.index') }}" class="btn btn-secondary">Kembali</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection