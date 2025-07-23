<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            {{-- Booking Hari Ini --}}
            <div class="bg-white p-6 rounded-xl shadow-md flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-500">Booking Hari Ini</p>
                    <p class="text-2xl font-extrabold text-indigo-600">{{ $todayBookingsCount }}</p>
                </div>
                <i class="text-4xl fas fa-calendar text-indigo-400 opacity-50"></i>
            </div>

            {{-- Booking Minggu Ini --}}
            <div class="bg-white p-6 rounded-xl shadow-md flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-500">Booking Minggu Ini</p>
                    <p class="text-2xl font-extrabold text-green-600">{{ $thisWeekBookingsCount }}</p>
                </div>
                <i class="text-4xl fas fa-clipboard-list text-green-400 opacity-50"></i>
            </div>

            {{-- Total Penghasilan Minggu Ini --}}
            <div class="bg-white p-6 rounded-xl shadow-md flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-500">Penghasilan Minggu Ini</p>
                    <p class="text-2xl font-extrabold text-amber-600">Rp
                        {{ number_format($thisWeekRevenue, 0, ',', '.') }}</p>
                </div>
                <i class="text-4xl fas fa-wallet text-amber-400 opacity-50"></i>
            </div>

            {{-- Jumlah Layanan --}}
            <div class="bg-white p-6 rounded-xl shadow-md flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-500">Total Layanan</p>
                    <p class="text-2xl font-extrabold text-blue-600">{{ $servicesCount }}</p>
                </div>
                <i class="text-4xl fas fa-concierge-bell text-blue-400 opacity-50"></i>
            </div>
        </div>


        <div class="bg-white p-6 rounded-xl shadow-md">
            <h3 class="text-2xl font-bold text-gray-900 mb-4">Daftar Antrian Hari Ini</h3>
            @if ($todayBookings->isEmpty())
                <p class="text-gray-600">Tidak ada booking untuk hari ini.</p>
            @else
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th scope="col"
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Jam</th>
                                <th scope="col"
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Nama Pelanggan</th>
                                <th scope="col"
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Barberman</th>
                                <th scope="col"
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Status</th>
                                <th scope="col"
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach ($todayBookings as $booking)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        {{ \Carbon\Carbon::parse($booking->booking_time)->format('H:i') }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        {{ $booking->customer_name }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        {{ $booking->barber->name }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span
                                            class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full
                                        @if ($booking->status == 'pending') bg-yellow-100 text-yellow-800
                                        @elseif($booking->status == 'confirmed') bg-blue-100 text-blue-800
                                        @elseif($booking->status == 'completed') bg-green-100 text-green-800
                                        @else bg-red-100 text-red-800 @endif">
                                            {{ ucfirst($booking->status) }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                        <a href="{{ route('bookings.show', $booking->id) }}"
                                            class="text-indigo-600 hover:text-indigo-900">Lihat Detail</a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
