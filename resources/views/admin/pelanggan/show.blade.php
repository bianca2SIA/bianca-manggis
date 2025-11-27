@extends('layouts.admin.app')

@section('content')
<div class="py-4">
    <h3>Detail Pelanggan</h3>
    <div class="card p-4 mb-4">
        <h5>Informasi Pelanggan</h5>
        <p><b>Nama:</b> {{ $pelanggan->first_name }} {{ $pelanggan->last_name }}</p>
        <p><b>Email:</b> {{ $pelanggan->email }}</p>
        <p><b>No Hp:</b> {{ $pelanggan->phone }}</p>
        <p><b>Tanggal Lahir:</b> {{ $pelanggan->birthday }}</p>
        <p><b>Gender:</b> {{ $pelanggan->gender }}</p>
    </div>
    <div class="card p-4">
        <h5>Upload File Pendukung</h5>
        <form action="{{ route('pelanggan.files', $pelanggan->pelanggan_id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="ref_table" value="pelanggan">
            <input type="hidden" name="ref_id" value="{{ $pelanggan->pelanggan_id }}">
            <input type="file" name="files[]" class="form-control mb-3" multiple>
            <button class="btn btn-primary btn-sm">Upload</button>
        </form>
        <hr>
        <h6>Daftar File</h6>
        @foreach ($files as $file)
            <div class="d-flex justify-content-between mb-2">
              <a href="{{ asset('storage/' . $file->filename) }}" target="_blank">
    {{ basename($file->filename) }}
</a>
                <form action="{{ route('pelanggan.files.delete', $file->id) }}"
                      method="POST"
                      onsubmit="return confirm('Hapus file ini?')">
                    @csrf
                    @method('DELETE')
                    <button class="btn btn-danger btn-sm">Hapus</button>
                </form>
            </div>
        @endforeach
    </div>
</div>
@endsection
