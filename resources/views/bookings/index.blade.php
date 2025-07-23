<!-- resources/views/admin/bookings/index.blade.php -->
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Daftar Booking
        </h2>
    </x-slot>

    <div class="py-10">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Filter Buttons -->
            <div class="mb-4 flex space-x-2">
                <a href="{{ route('admin.bookings.index') }}"
                    class="px-4 py-2 rounded-md @if(!request('status')) bg-indigo-600 text-white @else bg-gray-200 text-gray-800 hover:bg-gray-300 @endif">
                    Semua
                </a>
                <a href="{{ route('admin.bookings.index', ['status' => 'pending']) }}"
                    class="px-4 py-2 rounded-md @if(request('status') == 'pending') bg-indigo-600 text-white @else bg-gray-200 text-gray-800 hover:bg-gray-300 @endif">
                    Pending
                </a>
                <a href="{{ route('admin.bookings.index', ['status' => 'confirmed']) }}"
                    class="px-4 py-2 rounded-md @if(request('status') == 'confirmed') bg-indigo-600 text-white @else bg-gray-200 text-gray-800 hover:bg-gray-300 @endif">
                    Confirmed
                </a>
                <a href="{{ route('admin.bookings.index', ['status' => 'completed']) }}"
                    class="px-4 py-2 rounded-md @if(request('status') == 'completed') bg-indigo-600 text-white @else bg-gray-200 text-gray-800 hover:bg-gray-300 @endif">
                    Completed
                </a>
                <a href="{{ route('admin.bookings.index', ['status' => 'cancelled']) }}"
                    class="px-4 py-2 rounded-md @if(request('status') == 'cancelled') bg-indigo-600 text-white @else bg-gray-200 text-gray-800 hover:bg-gray-300 @endif">
                    Cancelled
                </a>
            </div>

            <!-- Bookings Table -->
            <div class="bg-white p-6 rounded-xl shadow-md">
                @if ($bookings->isEmpty())
                    <p class="text-gray-600">Tidak ada booking yang ditemukan.</p>
                @else
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama Pelanggan</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal & Jam</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Barberman</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach ($bookings as $booking)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $booking->id }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $booking->customer_name }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                            {{ \Carbon\Carbon::parse($booking->booking_date)->format('d M Y') }} -
                                            {{ \Carbon\Carbon::parse($booking->booking_time)->format('H:i') }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $booking->barber->name }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full
                                                @if($booking->status == 'pending') bg-yellow-100 text-yellow-800
                                                @elseif($booking->status == 'confirmed') bg-blue-100 text-blue-800
                                                @elseif($booking->status == 'completed') bg-green-100 text-green-800
                                                @else bg-red-100 text-red-800 @endif">
                                                {{ ucfirst($booking->status) }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                            <a href="{{ route('admin.bookings.show', $booking->id) }}" class="text-indigo-600 hover:text-indigo-900 mr-3">Lihat</a>
                                            <form action="{{ route('admin.bookings.destroy', $booking->id) }}" method="POST" class="inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus booking ini?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-600 hover:text-red-900">Hapus</button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="mt-4">
                        {{ $bookings->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
