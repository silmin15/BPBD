<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Catatan Kejadian
        </h2>
    </x-slot>

    <div class="p-6">
        {{-- Search Bar --}}
        <div class="mb-4">
            <div class="relative">
                <input type="text" class="custom-search-input" placeholder="Pencarian...">
                <div class="absolute inset-y-0 end-0 flex items-center pe-3">
                    <button class="p-2 rounded-full hover:bg-gray-200">
                        <i class="bi bi-search"></i>
                    </button>
                </div>
            </div>
        </div>

        {{-- Tabel Konten --}}
        <div class="custom-card">
            <div class="p-6">
                <table class="w-full custom-table">
                    <thead>
                        <tr>
                            <th>Jenis Bencana</th>
                            <th>Korban</th>
                            <th>Waktu</th>
                            {{-- ... header lainnya ... --}}
                            <th>Titik Koordinat</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($kejadians as $kejadian)
                        <tr>
                            <td>{{ $kejadian->jenisBencana->nama }}</td>
                            <td>-</td>
                            <td>{{ $kejadian->tanggal_kejadian }}</td>
                            {{-- ... data lainnya ... --}}
                            <td>{{ $kejadian->latitude }}, {{ $kejadian->longitude }}</td>
                            <td>
                                <a href="#" class="btn-edit">Edit</a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            {{-- Pagination --}}
            <div class="p-6 border-t">
                {{-- Di sini Anda bisa menempatkan link pagination dari Laravel --}}
                {{-- $kejadians->links() --}}
            </div>
        </div>
    </div>
</x-app-layout>