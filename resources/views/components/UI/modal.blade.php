{{-- Modal Login --}}
<div class="modal fade" id="loginModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content login-glass rounded-lg shadow-soft">
            <div class="modal-body p-4 p-lg-5 text-black">

                {{-- Logo + Judul --}}
                <div class="text-center mb-4">
                    <img src="{{ asset('images/logo-bpbd.png') }}" alt="Logo BPBD" style="width:90px;height:auto;"
                        class="mx-auto mb-2">
                    <h4 class="fw-bold mb-1">BPBD Banjarnegara</h4>
                    <p class="text-muted small">Melayani masyarakat dalam penanggulangan bencana dengan sistem informasi
                        terintegrasi.</p>
                </div>

                {{-- FORM --}}
                <form id="loginFormModal" method="POST" action="{{ route('login') }}" novalidate>
                    @csrf
                    
                    {{-- Email --}}
                    <x-form.group for="emailModal" label="Username / E-mail">
                        <x-form.input id="emailModal" name="email" type="email"
                            placeholder="user123 atau user@mail.com" required autofocus />
                        @error('email')
                            <x-ui.alert type="danger" class="mt-1 small">{{ $message }}</x-ui.alert>
                        @enderror
                    </x-form.group>

                    {{-- Password --}}
                    <x-form.group for="passwordModal" label="Password" class="mt-3">
                        <x-form.input id="passwordModal" name="password" type="password" placeholder="••••••••"
                            required />
                        @error('password')
                            <x-ui.alert type="danger" class="mt-1 small">{{ $message }}</x-ui.alert>
                        @enderror
                    </x-form.group>

                    {{-- Ingat saya + Lupa sandi --}}
                    <div class="d-flex justify-content-between align-items-center mt-3">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="remember" id="remember_me">
                            <label class="form-check-label" for="remember_me">Ingat saya</label>
                        </div>
                        <a href="{{ route('password.request') }}" class="login-forgot">Lupa kata sandi?</a>
                    </div>

                    {{-- Tombol Login --}}
                    <x-form.actions class="mt-4">
                        <x-ui.button type="submit" variant="footer" class="w-100">
                            Login
                        </x-ui.button>
                    </x-form.actions>
                </form>

            </div>
        </div>
    </div>
</div>
