@extends('layouts.admin')

@section('title', 'Admin Profile - ZADA.CO')

@section('content')

<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&family=Playfair+Display:wght@700&display=swap" rel="stylesheet">

<style>
    :root {
        --zada-gold: #c2a35d;
        --zada-dark: #1a1a1a;
        --zada-border: #f0f0f0;
    }

    body {
        font-family: 'Plus Jakarta Sans', sans-serif;
        background-color: #fcfcfc;
    }

    /* Transition halus untuk semua elemen */
    * { transition: all 0.3s ease; }

    .profile-header {
        font-family: 'Playfair Display', serif;
        font-weight: 700;
        font-size: 2rem;
        color: var(--zada-dark);
        margin-bottom: 2rem;
    }

    .card-luxury {
        background: #ffffff;
        border: 1px solid var(--zada-border);
        border-radius: 20px;
        box-shadow: 0 4px 20px rgba(0,0,0,0.01);
    }

    /* Avatar: Hanya scale sangat halus saat hover */
    .avatar-wrapper {
        position: relative;
        width: 120px;
        height: 120px;
        margin: 0 auto 2rem;
    }

    .avatar-wrapper:hover {
        transform: scale(1.03);
    }

    .avatar-preview, .avatar-placeholder {
        width: 120px;
        height: 120px;
        border-radius: 50%;
        object-fit: cover;
        border: 4px solid #fff;
        box-shadow: 0 5px 15px rgba(0,0,0,0.08);
    }

    .avatar-placeholder {
        background: var(--zada-dark);
        color: var(--zada-gold);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 2.5rem;
        font-weight: 700;
    }

    .form-label {
        font-size: 0.75rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 1px;
        color: #999;
        margin-bottom: 8px;
    }

    .form-control-zada {
        background-color: #f9f9f9;
        border: 1px solid #eee;
        border-radius: 12px;
        padding: 12px 18px;
        font-size: 0.95rem;
    }

    /* Focus: Hanya perubahan warna border & sedikit bayangan */
    .form-control-zada:focus {
        background-color: #fff;
        border-color: var(--zada-gold);
        box-shadow: 0 5px 15px rgba(194, 163, 93, 0.08);
        outline: none;
    }

    .btn-update {
        background: var(--zada-dark);
        color: white;
        border: none;
        border-radius: 12px;
        padding: 14px 30px;
        font-weight: 600;
        width: 100%;
    }

    /* Hover: Perubahan warna solid & angkat sedikit */
    .btn-update:hover {
        background: var(--zada-gold);
        transform: translateY(-2px);
    }

    .alert-zada {
        background: #f0fdf4;
        color: #166534;
        border-radius: 15px;
        border: none;
        padding: 15px 20px;
        font-weight: 600;
        margin-bottom: 2rem;
    }
</style>

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-6 col-md-8">
            
            <h1 class="profile-header">Settings</h1>

            @if(session('success'))
                <div class="alert alert-zada d-flex align-items-center">
                    <i class="bi bi-check-circle-fill me-3"></i>
                    {{ session('success') }}
                </div>
            @endif

            <div class="card card-luxury">
                <div class="card-body p-4 p-md-5">
                    <form action="{{ route('admin.profile.update') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="text-center">
                            <div class="avatar-wrapper">
                                @if(Auth::user()->photo)
                                    <img src="/admin_photo/{{ Auth::user()->photo }}" class="avatar-preview" id="preview">
                                @else
                                    <div class="avatar-placeholder">
                                        {{ substr(Auth::user()->name, 0, 1) }}
                                    </div>
                                @endif
                            </div>
                        </div>

                        <div class="row g-4">
                            <div class="col-12">
                                <label class="form-label">Full Name</label>
                                <input type="text" name="name" class="form-control-zada w-100" value="{{ Auth::user()->name }}">
                            </div>

                            <div class="col-12">
                                <label class="form-label">Email Address</label>
                                <input type="email" name="email" class="form-control-zada w-100" value="{{ Auth::user()->email }}">
                            </div>

                            <div class="col-12">
                                <label class="form-label">Update Photo</label>
                                <input type="file" name="photo" class="form-control-zada w-100" id="photoInput">
                            </div>

                            <div class="col-12 mt-5">
                                <button type="submit" class="btn-update">
                                    Save Changes
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <div class="text-center mt-4">
                <a href="#" class="text-muted small text-decoration-none hover-gold">Privacy & Security Settings</a>
            </div>

        </div>
    </div>
</div>

<script>
    document.getElementById('photoInput').onchange = evt => {
        const [file] = document.getElementById('photoInput').files
        if (file) {
            const preview = document.getElementById('preview');
            if(preview) preview.src = URL.createObjectURL(file);
        }
    }
</script>

@endsection