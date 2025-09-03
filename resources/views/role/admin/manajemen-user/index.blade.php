@extends('layouts.app_admin')

{{-- Judul batang di atas konten --}}
@section('page_title', 'Manajemen User')
@section('page_icon')
    <i class="bi bi-people-fill"></i>
@endsection

{{-- Tombol di kanan judul --}}
@section('page_actions')
    <button type="button" class="btn-orange inline-flex items-center gap-2" data-bs-toggle="modal"
        data-bs-target="#createUserModal" aria-label="Buat user baru">
        <i class="bi bi-plus-lg"></i>
        <span>Buat User</span>
    </button>
@endsection

@section('content')

    {{-- Alert flash --}}
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show mb-4" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif
    @if (session('error'))
        <div class="alert alert-danger alert-dismissible fade show mb-4" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    {{-- Modal Buat User --}}
    <div class="modal fade" id="createUserModal" tabindex="-1" aria-labelledby="createUserModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="createUserModalLabel">Buat User</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                </div>

                <form method="POST" action="{{ route('admin.manajemen-user.store') }}" novalidate>
                    @csrf
                    <div class="modal-body">
                        @if ($errors->createUser->any())
                            <div class="alert alert-danger">Periksa kembali isian Anda.</div>
                        @endif

                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label">Nama</label>
                                <input name="name" class="form-control @error('name', 'createUser') is-invalid @enderror"
                                    value="{{ old('name') }}" required>
                                @error('name', 'createUser')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Email</label>
                                <input name="email" type="email"
                                    class="form-control @error('email', 'createUser') is-invalid @enderror"
                                    value="{{ old('email') }}" required>
                                @error('email', 'createUser')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Username (opsional)</label>
                                <input name="username"
                                    class="form-control @error('username', 'createUser') is-invalid @enderror"
                                    value="{{ old('username') }}">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">No. HP (opsional)</label>
                                <input name="phone"
                                    class="form-control @error('phone', 'createUser') is-invalid @enderror"
                                    value="{{ old('phone') }}">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Password</label>
                                <input name="password" type="password"
                                    class="form-control @error('password', 'createUser') is-invalid @enderror" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Konfirmasi Password</label>
                                <input name="password_confirmation" type="password" class="form-control" required>
                            </div>
                            <div class="col-md-12">
                                <label class="form-label">Role</label>
                                <select name="role" class="form-select @error('role', 'createUser') is-invalid @enderror"
                                    required>
                                    <option value="" disabled {{ old('role') ? '' : 'selected' }}>Pilih role</option>
                                    @foreach ($roles as $id => $name)
                                        @if (in_array($name, ['PK', 'KL', 'RR', 'Staf BPBD']))
                                            <option value="{{ $name }}" @selected(old('role') === $name)>
                                                {{ $name }}</option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- Auto open modal kalau validasi gagal --}}
    @if ($errors->createUser->any())
        <script>
            document.addEventListener('DOMContentLoaded', () => {
                const el = document.getElementById('createUserModal');
                if (el) {
                    const modal = new bootstrap.Modal(el);
                    modal.show();
                    setTimeout(() => {
                        const firstInvalid = el.querySelector('.is-invalid');
                        if (firstInvalid) firstInvalid.focus();
                    }, 300);
                }
            });
        </script>
    @endif

    <div class="table-card overflow-x-auto mt-4">
        <table class="bpbd-table min-w-full">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Nama</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th class="col-aksi">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($users as $u)
                    <tr>
                        <td>{{ $users->firstItem() + $loop->index }}</td>
                        <td class="font-semibold">{{ $u->name }}</td>
                        <td>{{ $u->email }}</td>
                        <td>{{ $u->getRoleNames()->join(', ') }}</td>
                        <td class="col-aksi">
                            <a href="{{ route('admin.manajemen-user.edit', $u) }}" class="btn-edit">Edit</a>
                            <form action="{{ route('admin.manajemen-user.destroy', $u) }}" method="POST" class="d-inline"
                                onsubmit="return confirm('Hapus user?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn-delete">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center text-slate-500 py-6">Belum ada user</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>


    <div class="mt-4">
        {{ $users->withQueryString()->links() }}
    </div>

@endsection
