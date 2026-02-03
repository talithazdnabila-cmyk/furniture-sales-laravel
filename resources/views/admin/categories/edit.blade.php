@extends('layouts.admin')

@section('title', 'Edit Kategori - ZADA.CO')

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

    .header-section {
        margin-bottom: 2.5rem;
    }

    .header-title {
        font-family: 'Playfair Display', serif;
        font-weight: 700;
        font-size: 2.2rem;
        color: var(--zada-dark);
    }

    .card-luxury {
        background: #ffffff;
        border: 1px solid var(--zada-border);
        border-radius: 20px;
        box-shadow: 0 10px 30px rgba(0,0,0,0.02);
        width: 100%;
    }

    .form-label {
        font-size: 0.7rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 1.2px;
        color: #aaa;
        margin-bottom: 10px;
    }

    .form-control-zada {
        background-color: #f9f9f9;
        border: 1px solid #eee;
        border-radius: 12px;
        padding: 15px 20px;
        font-size: 0.95rem;
        transition: 0.3s ease;
    }

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
        padding: 16px 40px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 1px;
        transition: 0.3s;
    }

    .btn-update:hover {
        background: var(--zada-gold);
        transform: translateY(-2px);
        box-shadow: 0 10px 20px rgba(194, 163, 93, 0.3);
    }

    .btn-cancel {
        color: #999;
        text-decoration: none;
        font-weight: 600;
        padding: 16px 30px;
        border-radius: 12px;
        transition: 0.3s;
    }

    .btn-cancel:hover {
        background: #f5f5f5;
        color: var(--zada-dark);
    }
</style>

<div class="container-fluid py-4">
    
    <div class="header-section">
        <h1 class="header-title">Edit Category</h1>
        <p class="text-muted small fw-bold" style="letter-spacing: 1px;">Refine your collection categories</p>
    </div>

    <div class="card card-luxury">
        <div class="card-body p-4 p-md-5">
            <form action="{{ route('admin.categories.update', $category->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="row g-4">
                    <div class="col-12">
                        <label class="form-label">Category Name</label>
                        <input type="text" 
                               name="name" 
                               class="form-control-zada w-100" 
                               value="{{ $category->name }}" 
                               placeholder="e.g. Exclusive Collection"
                               required>
                        <small class="text-muted mt-2 d-block" style="font-size: 11px;">
                            This name will be displayed across the store and used for product filtering.
                        </small>
                    </div>

                    {{-- Footer Action --}}
                    <div class="col-12 mt-5 border-top pt-4">
                        <div class="d-flex justify-content-end align-items-center gap-2">
                            <a href="{{ route('admin.categories.index') }}" class="btn-cancel">
                                Discard
                            </a>
                            <button type="submit" class="btn-update shadow-sm">
                                Update Category
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

</div>

@endsection