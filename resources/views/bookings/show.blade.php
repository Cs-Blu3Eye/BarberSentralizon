<!-- resources/views/admin/bookings/show.blade.php -->
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Detail Booking #{{ $booking->id }}
        </h2>
    </x-slot>

    <div class="py-10">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white p-6 rounded-xl shadow-md mb-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <p class="text-sm font-medium text-gray-500">Nama Pelanggan:</p>
                        <p class="text-lg text-gray-900 font-semibold">{{ $booking->customer_name }}</p>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-500">Nomor WhatsApp:</p>
                        <p class="text-lg text-gray-900 font-semibold">{{ $booking->customer_whatsapp }}</p>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-500">Tanggal Booking:</p>
                        <p class="text-lg text-gray-900 font-semibold">{{ \Carbon\Carbon::parse($booking->booking_date)->format('d F Y') }}</p>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-500">Jam Booking:</p>
                        <p class="text-lg text-gray-900 font-semibold">{{ \Carbon\Carbon::parse($booking->booking_time)->format('H:i') }}</p>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-500">Barberman:</p>
                        <p class="text-lg text-gray-900 font-semibold">{{ $booking->barber->name }}</p>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-500">Status:</p>
                        <p class="text-lg text-gray-900 font-semibold">
                            <span class="px-3 py-1 inline-flex text-sm leading-5 font-semibold rounded-full
                                @if($booking->status == 'pending') bg-yellow-100 text-yellow-800
                                @elseif($booking->status == 'confirmed') bg-blue-100 text-blue-800
                                @elseif($booking->status == 'completed') bg-green-100 text-green-800
                                @else bg-red-100 text-red-800 @endif">
                                {{ ucfirst($booking->status) }}
                            </span>
                        </p>
                    </div>
                </div>

                <div class="mt-6">
                    <p class="text-sm font-medium text-gray-500 mb-2">Layanan yang Dipilih:</p>
                    <ul class="list-disc list-inside ml-4 text-gray-900">
                        @foreach($services as $service)
                            <li>{{ $service->name }} (Rp {{ number_format($service->price, 0, ',', '.') }})</li>
                        @endforeach
                    </ul>
                </div>

                @if ($booking->notes)
                    <div class="mt-6">
                        <p class="text-sm font-medium text-gray-500">Catatan Tambahan:</p>
                        <p class="text-gray-900 italic">{{ $booking->notes }}</p>
                    </div>
                @endif

                @if ($booking->photo_path)
                    <div class="mt-6">
                        <p class="text-sm font-medium text-gray-500 mb-2">Foto Referensi:</p>
                        <img src="{{ Storage::url($booking->photo_path) }}" alt="Foto Referensi Booking" class="max-w-xs h-auto rounded-lg shadow-md border border-gray-200">
                    </div>
                @endif

                <div class="mt-8 flex items-center space-x-4">
                    <form action="{{ route('bookings.updateStatus', $booking->id) }}" method="POST" class="flex items-center space-x-2">
                        @csrf
                        @method('PUT')
                        <label for="status" class="text-sm font-medium text-gray-700">Ubah Status:</label>
                        <select name="status" id="status" class="px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                            <option value="pending" {{ $booking->status == 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="confirmed" {{ $booking->status == 'confirmed' ? 'selected' : '' }}>Confirmed</option>
                            <option value="completed" {{ $booking->status == 'completed' ? 'selected' : '' }}>Completed</option>
                            <option value="cancelled" {{ $booking->status == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                        </select>
                        <button type="submit" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            Update Status
                        </button>
                    </form>

                    <form action="{{ route('bookings.destroy', $booking->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus booking ini?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                            Hapus Booking
                        </button>
                    </form>
                </div>
            </div>

            <div class="mt-6">
                <a href="{{ route('bookings.index') }}" class="text-indigo-600 hover:text-indigo-900 text-sm font-medium">&larr; Kembali ke Daftar Booking</a>
            </div>
        </div>
    </div>
</x-app-layout>
