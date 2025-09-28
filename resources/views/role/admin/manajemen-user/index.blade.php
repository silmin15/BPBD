@extends('layouts.app_admin')

{{-- Judul batang di atas konten --}}
@section('page_title', 'Manajemen User')
@section('page_icon') <i class="bi bi-people-fill"></i> @endsection

{{-- Tombol kanan judul (ikuti gaya SOP: btn-success) --}}
@section('page_actions')
    <button type="button" class="btn btn-success d-inline-flex align-items-center gap-2" data-bs-toggle="modal"
        data-bs-target="#createUserModal" aria-label="Buat user baru">
        <i class="bi bi-plus-lg"></i><span>Buat User</span>
    </button>
@endsection

@section('content')
    {{-- Flash --}}
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show mb-3" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif
    @if (session('error'))
        <div class="alert alert-danger alert-dismissible fade show mb-3" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    {{-- ===== Card utama (gaya SOP) ===== --}}
    <div class="card shadow-sm">

        {{-- (opsional) Toolbar kecil di atas tabel: cukup kosongkan jika belum perlu filter/search --}}
        {{-- <div class="card-body pb-2">
            <form class="row g-2">
                ...
            </form>
        </div> --}}

        {{-- Tabel --}}
        <div class="table-responsive">
            <table class="table table-hover table-striped align-middle mb-0">
                <thead class="table-light sticky-top">
                    <tr>
                        <th style="width:72px" class="text-center">#</th>
                        <th>Nama</th>
                        <th>Email</th>
                        <th style="width:220px">Role</th>
                        <th style="width:220px" class="text-end">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($users as $i => $u)
                        <tr>
                            <td class="text-center">{{ $users->firstItem() + $i }}</td>
                            <td class="fw-semibold">{{ $u->name }}</td>
                            <td>{{ $u->email }}</td>
                            <td>
                                @php $rolesText = $u->getRoleNames()->join(', '); @endphp
                                <span class="badge text-bg-primary-subtle text-primary">{{ $rolesText ?: '—' }}</span>
                            </td>
                            <td class="text-end">
                                <a href="{{ route('admin.manajemen-user.edit', $u) }}"
                                    class="btn btn-sm btn-outline-primary">
                                    <i class="bi bi-pencil"></i> Edit
                                </a>

                                <form action="{{ route('admin.manajemen-user.destroy', $u) }}" method="POST"
                                    class="d-inline" onsubmit="return confirm('Hapus user ini?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center text-muted py-4">Belum ada user.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Footer info + pagination (persis seperti SOP) --}}
        <div class="card-footer bg-white d-flex flex-column flex-md-row justify-content-between align-items-center">
            @php $total = method_exists($users, 'total') ? $users->total() : $users->count(); @endphp
            <small class="text-muted mb-2 mb-md-0">
                Menampilkan {{ $users->count() ? $users->firstItem() . '–' . $users->lastItem() : 0 }} dari {{ $total }}
                data
            </small>
            {{ $users->withQueryString()->onEachSide(1)->links() }}
        </div>
    </div>

    {{-- ===== Modal Buat User (tidak diubah fungsinya) ===== --}}
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
                                    <option value="" disabled {{ old('role') ? '' : 'selected' }}>Pilih role
                                    </option>
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

    {{-- Auto open modal ketika validasi gagal --}}
    @if ($errors->createUser->any())
        <script>
            document.addEventListener('DOMContentLoaded', () => {
                const el = document.getElementById('createUserModal');
                if (!el) return;
                const modal = new bootstrap.Modal(el);
                modal.show();
                setTimeout(() => {
                    const firstInvalid = el.querySelector('.is-invalid');
                    if (firstInvalid) firstInvalid.focus();
                }, 300);
            });
        </script>
    @endif
@endsection
