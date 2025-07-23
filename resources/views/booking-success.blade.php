
<!-- resources/views/booking-success.blade.php -->
@extends('layouts.app-menu')

@section('title', 'Booking Berhasil!')

@section('content')
<div class="flex flex-col items-center justify-center min-h-screen -mt-20">
    <div class="bg-white p-8 rounded-xl shadow-lg w-full max-w-md text-center">
        <svg class="mx-auto h-20 w-20 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
        </svg>
        <h2 class="text-3xl font-extrabold text-gray-900 mt-6 mb-4">Booking Berhasil!</h2>
        <p class="text-gray-600 text-lg mb-6">Terima kasih atas booking Anda. Kami akan segera menghubungi Anda via WhatsApp untuk konfirmasi detail booking.</p>
        <a href="{{ url('/') }}" class="inline-flex items-center px-6 py-3 border border-transparent text-base font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
            Kembali ke Halaman Utama
        </a>
    </div>
</div>
@endsection
