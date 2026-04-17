@extends('layouts.admin')

@section('title', 'Admin Profile - ZADA.CO')

@section('content')

<style>
    :root {
        --zada-gold: #c5a059;
        --zada-dark: #1a1a1a;
        --border-color: #eceef0;
        --bg-body: #f8f9fa;
    }

    body { 
        background-color: var(--bg-body); 
        color: #333; 
        font-family: 'Inter', sans-serif; 
    }

    /* Typography Match Dashboard */
    .profile-header-title { 
        font-family: 'Playfair Display', serif; 
        font-weight: 700; 
        color: var(--zada-dark); 
    }

    .card-pro {
        background: white; 
        border: 1px solid var(--border-color);
        border-radius: 12px; 
        overflow: hidden;
        box-shadow: 0 2px 4px rgba(0,0,0,0.02);
    }

    /* Avatar Styling */
    .avatar-container {
        position: relative;
        display: inline-block;
        padding: 5px;
        border: 1px solid var(--border-color);
        border-radius: 50%;
        background: white;
    }

    .avatar-main {
        width: 110px;
        height: 110px;
        border-radius: 50%;
        object-fit: cover;
    }

    .avatar-placeholder-pro {
        width: 110px;
        height: 110px;
        border-radius: 50%;
        background: var(--zada-dark);
        color: var(--zada-gold);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 2.5rem;
        font-weight: 700;
        font-family: 'Playfair Display', serif;
    }

    /* Form Styling Match */
    .label-xs { 
        font-size: 11px; 
        text-transform: uppercase; 
        letter-spacing: 0.8px; 
        font-weight: 700; 
        color: #888; 
        margin-bottom: 8px;
        display: block;
    }

    .form-control-pro {
        background-color: #fbfbfc;
        border: 1px solid var(--border-color);
        border-radius: 8px;
        padding: 12px 15px;
        font-size: 13.5px;
        color: var(--zada-dark);
        transition: all 0.2s;
    }

    .form-control-pro:focus {
        background-color: #fff;
        border-color: var(--zada-gold);
        box-shadow: 0 0 0 3px rgba(197, 160, 89, 0.1);
        outline: none;
    }

    /* Button Match Quick Actions */
    .btn-save-pro {
        background: var(--zada-dark);
        color: white;
        border: none;
        border-radius: 8px;
        padding: 12px;
        font-size: 12px;
        font-weight: 700;
        letter-spacing: 1px;
        text-transform: uppercase;
        width: 100%;
        transition: all 0.3s;
    }

    .btn-save-pro:hover {
        background: var(--zada-gold);
        transform: translateY(-1px);
    }

    .status-pill-alert {
        padding: 12px 20px;
        border-radius: 8px;
        font-size: 13px;
        font-weight: 600;
        background: #f0fdf4;
        color: #166534;
        border: 1px solid #bbf7d0;
    }
</style>

<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-lg-5 col-md-8">
            
            {{-- HEADER SEPERTI DASHBOARD --}}
            <div class="mb-4">
                <h3 class="profile-header-title m-0">Pengaturan Profil</h3>
                <p class="text-muted small">Kelola identitas akses administrator Anda</p>
            </div>

            <div class="card card-pro">
                <div class="card-body p-4 p-md-5">
                    <form action="{{ route('admin.profile.update') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="text-center mb-5">
                            <div class="avatar-container">
                                @if(Auth::user()->photo)
                                    <img src="/admin_photo/{{ Auth::user()->photo }}" class="avatar-main" id="preview">
                                @else
                                    <div class="avatar-placeholder-pro" id="preview-placeholder">
                                        {{ substr(Auth::user()->name, 0, 1) }}
                                    </div>
                                @endif
                            </div>
                            <div class="mt-3">
                                <h6 class="fw-bold m-0">{{ Auth::user()->name }}</h6>
                                <p class="text-muted small">Administrator Sistem</p>
                            </div>
                        </div>

                        <div class="row g-4">
                            <div class="col-12">
                                <label class="label-xs">Nama Lengkap</label>
                                <input type="text" name="name" class="form-control-pro w-100" value="{{ Auth::user()->name }}" placeholder="Masukkan nama lengkap">
                            </div>

                            <div class="col-12">
                                <label class="label-xs">Alamat Email</label>
                                <input type="email" name="email" class="form-control-pro w-100" value="{{ Auth::user()->email }}" placeholder="nama@zada.co">
                            </div>

                            <div class="col-12">
                                <label class="label-xs">Unggah Foto Profil</label>
                                <input type="file" name="photo" class="form-control-pro w-100" id="photoInput" style="padding: 8px;">
                                <small class="text-muted mt-2 d-block" style="font-size: 10px;">Rekomendasi: Persegi (1:1), Maks 2MB</small>
                            </div>

                            <div class="col-12 mt-5">
                                <button type="submit" class="btn-save-pro">
                                    Simpan Perubahan
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <div class="text-center mt-4">
                <a href="#" class="text-muted small text-decoration-none" style="font-size: 11px; font-weight: 600; letter-spacing: 0.5px;">
                    <i class="bi bi-shield-lock me-1"></i> KEAMANAN & ENKRIPSI DATA
                </a>
            </div>

        </div>
    </div>
</div>

<script>
    document.getElementById('photoInput').onchange = evt => {
        const [file] = document.getElementById('photoInput').files
        if (file) {
            const preview = document.getElementById('preview');
            const placeholder = document.getElementById('preview-placeholder');
            
            if(preview) {
                preview.src = URL.createObjectURL(file);
            } else if(placeholder) {
                // Jika sebelumnya placeholder, ganti jadi tag img
                const newImg = document.createElement('img');
                newImg.src = URL.createObjectURL(file);
                newImg.className = 'avatar-main';
                newImg.id = 'preview';
                placeholder.parentNode.replaceChild(newImg, placeholder);
            }
        }
    }
</script>

@endsection