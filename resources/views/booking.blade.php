<!-- resources/views/booking.blade.php -->
@extends('layouts.app-menu')

@section('title', 'Booking Barber Shop')

@section('content')
<div class="flex flex-col items-center justify-center min-h-screen -mt-20">
    <div class="bg-white p-8 rounded-xl shadow-lg w-full max-w-2xl">
        <h2 class="text-4xl font-extrabold text-center text-gray-900 mb-8">Booking Sekarang!</h2>
        <p class="text-center text-gray-600 mb-8">Isi formulir di bawah ini untuk memesan layanan di Barber Shop XYZ.</p>

        @if ($errors->any())
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-6" role="alert">
                <strong class="font-bold">Oops!</strong>
                <span class="block sm:inline">Ada beberapa masalah dengan input Anda:</span>
                <ul class="mt-2 list-disc list-inside">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('booking.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf

            <div>
                <label for="customer_name" class="block text-sm font-medium text-gray-700 mb-1">Nama Lengkap</label>
                <input type="text" id="customer_name" name="customer_name" value="{{ old('customer_name') }}"
                       class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                       placeholder="Masukkan nama lengkap Anda" required>
            </div>

            <div>
                <label for="customer_whatsapp" class="block text-sm font-medium text-gray-700 mb-1">Nomor WhatsApp</label>
                <input type="text" id="customer_whatsapp" name="customer_whatsapp" value="{{ old('customer_whatsapp') }}"
                       class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                       placeholder="Contoh: 081234567890" required>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="booking_date" class="block text-sm font-medium text-gray-700 mb-1">Tanggal Booking</label>
                    <input type="date" id="booking_date" name="booking_date" value="{{ old('booking_date', date('Y-m-d')) }}"
                           class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                           min="{{ date('Y-m-d') }}" required>
                </div>
                <div>
                    <label for="booking_time" class="block text-sm font-medium text-gray-700 mb-1">Jam Booking</label>
                    <select id="booking_time" name="booking_time"
                            class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                            required>
                        <option value="">Pilih Jam</option>
                        @foreach($times as $time)
                            <option value="{{ $time }}" {{ old('booking_time') == $time ? 'selected' : '' }}>{{ $time }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Pilih Layanan</label>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                    @foreach($services as $service)
                        <div class="flex items-center bg-gray-50 p-3 rounded-md border border-gray-200">
                            <input type="checkbox" id="service_{{ $service->id }}" name="service_ids[]" value="{{ $service->id }}"
                                   class="h-4 w-4 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500"
                                   {{ is_array(old('service_ids')) && in_array($service->id, old('service_ids')) ? 'checked' : '' }}>
                            <label for="service_{{ $service->id }}" class="ml-3 text-sm font-medium text-gray-900">
                                {{ $service->name }} (Rp {{ number_format($service->price, 0, ',', '.') }})
                            </label>
                        </div>
                    @endforeach
                </div>
            </div>

            <div>
                <label for="barber_id" class="block text-sm font-medium text-gray-700 mb-1">Pilih Barberman</label>
                <select id="barber_id" name="barber_id"
                        class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                        required>
                    <option value="">Pilih Barberman</option>
                    @foreach($barbers as $barber)
                        <option value="{{ $barber->id }}" {{ old('barber_id') == $barber->id ? 'selected' : '' }}>{{ $barber->name }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label for="photo" class="block text-sm font-medium text-gray-700 mb-1">Upload Foto (Opsional)</label>
                <input type="file" id="photo" name="photo" accept=".jpg,.jpeg,.png"
                       class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100">
                <p class="mt-1 text-xs text-gray-500">Hanya .jpg/.jpeg/.png, maksimal 2MB.</p>
            </div>

            <div>
                <label for="notes" class="block text-sm font-medium text-gray-700 mb-1">Catatan Tambahan (Opsional)</label>
                <textarea id="notes" name="notes" rows="3"
                          class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                          placeholder="Contoh: Potongan rambut undercut, atau ada alergi tertentu.">{{ old('notes') }}</textarea>
            </div>

            <button type="submit"
                    class="w-full flex justify-center py-3 px-4 border border-transparent rounded-md shadow-sm text-lg font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition duration-150 ease-in-out">
                Kirim Booking
            </button>
        </form>
    </div>
</div>
@endsection

