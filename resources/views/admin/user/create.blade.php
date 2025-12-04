@extends('layouts.admin.app')

@section('content')
        <div class="py-4">
            <nav aria-label="breadcrumb" class="d-none d-md-inline-block">
                <ol class="breadcrumb breadcrumb-dark breadcrumb-transparent">
                    <li class="breadcrumb-item">
                        <a href="#">
                            <svg class="icon icon-xxs" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6">
                                </path>
                            </svg>
                        </a>
                    </li>
                    <li class="breadcrumb-item"><a href="#">User</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Tambah User</li>
                </ol>
            </nav>
            <div class="d-flex justify-content-between w-100 flex-wrap">
                <div class="mb-3 mb-lg-0">
                    <h1 class="h4">Tambah User</h1>
                    <p class="mb-0">Form untuk menambahkan data user baru.</p>
                </div>
                <div>
                    <a href="{{ route('pelanggan.index') }}" class="btn btn-primary">
                        <i class="far fa-question-circle me-1"></i> Kembali
                    </a>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-12 mb-4">
                <div class="card border-0 shadow components-section">
                    <div class="card-body">

                        {{-- FORM TAMBAH USER + FOTO PROFIL --}}
                        <form action="{{ route('user.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf

                            <div class="row mb-4">
                                <div class="col-lg-4 col-sm-6">
                                    {{-- Nama Lengkap --}}
                                    <div class="mb-3">
                                        <label for="name" class="form-label">Nama Lengkap</label>
                                        <input type="text"
                                               name="name"
                                               id="name"
                                               class="form-control @error('name') is-invalid @enderror"
                                               value="{{ old('name') }}"
                                               required>
                                        @error('name')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    {{-- Email --}}
                                    <div class="mb-3">
                                        <label for="email" class="form-label">Email</label>
                                        <input type="email"
                                               name="email"
                                               id="email"
                                               class="form-control @error('email') is-invalid @enderror"
                                               value="{{ old('email') }}"
                                               required>
                                        @error('email')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-lg-4 col-sm-12">
                                    {{-- Password --}}
                                    <div class="mb-3">
                                        <label for="password" class="form-label">Password</label>
                                        <input type="password"
                                               name="password"
                                               id="password"
                                               class="form-control @error('password') is-invalid @enderror"
                                               required>
                                        @error('password')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    {{-- Password Confirmation --}}
                                    <div class="mb-3">
                                        <label for="password_confirmation" class="form-label">Password Confirmation</label>
                                        <input type="password"
                                               name="password_confirmation"
                                               id="password_confirmation"
                                               class="form-control">
                                    </div>
                                    {{-- Role User --}}
<div class="mb-3">
    <label for="role" class="form-label">Role</label>
    <select name="role" id="role"
            class="form-control @error('role') is-invalid @enderror" required>
        <option value="">-- Pilih Role --</option>
        <option value="Super Admin">Super Admin</option>
      
        <option value="Pelanggan">Pelanggan</option>
        <option value="Mitra">Mitra</option>
    </select>
    @error('role')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>


                                    {{-- FOTO PROFIL --}}
                                    <div class="mb-3">
                                        <label for="profile_picture" class="form-label">Foto Profil</label>
                                        <input type="file"
                                               name="profile_picture"
                                               id="profile_picture"
                                               class="form-control @error('profile_picture') is-invalid @enderror">
                                        @error('profile_picture')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    {{-- Buttons --}}
                                    <div class="">
                                        <button type="submit" class="btn btn-primary">Simpan</button>
                                        <a href="{{ route('pelanggan.index') }}"
                                           class="btn btn-outline-secondary ms-2">Batal</a>
                                    </div>
                                </div>
                            </div>
                        </form>
                        {{-- END FORM --}}
                    </div>


                </div>
            </div>
        </div>
@endsection
