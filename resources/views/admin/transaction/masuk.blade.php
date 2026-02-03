@extends('layouts.admin')

@section('title', 'Transaksi Masuk')

@section('content')
<h3>Transaksi Masuk</h3>

<table border="1" cellpadding="10">
    <tr>
        <th>Kode</th>
        <th>User</th>
        <th>Total</th>
        <th>Status</th>
        <th>Aksi</th>
    </tr>

    @foreach($transaksis as $t)
    <tr>
        <td>{{ $t->kode_transaksi }}</td>
        <td>{{ $t->user->name ?? '-' }}</td>
        <td>Rp {{ number_format($t->total_harga) }}</td>
        <td>{{ $t->status }}</td>
        <td>
            <form action="{{ route('admin.transaksi.create', $t->id) }}" method="POST" style="display:inline">
                @csrf
                <button type="submit">Konfirmasi</button>
            </form>

            <form action="{{ route('admin.transaksi.tolak', $t->id) }}" method="POST" style="display:inline">
                @csrf
                <button type="submit">Tolak</button>
            </form>
        </td>
    </tr>
    @endforeach
</table>
