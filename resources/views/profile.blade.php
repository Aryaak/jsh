@extends('layouts.main', ['title' => "Ubah Profil"])

@section('contents')
    <div class="row">
        <div class="col-md-6 mb-3">
            <x-card header="Ubah Profil">
                <x-form method="put" submit="Simpan" submitIcon="fa-solid fa-save" action="{{ route('user-profile-information.update') }}">
                    <input type="hidden" name="username" value="{{ auth()->user()->username }}">
                    <x-form-input label="Nama" id="name" name="name" value="{{ auth()->user()->name }}" class="mb-3" required />
                    {{-- <x-form-input label="Alamat Email" id="email" name="email" type="email" value="" required /> --}}
                </x-form>
            </x-card>
        </div>
        <div class="col-md-6">
            <x-card header="Ubah Kata Sandi">
                <x-form id="form-update-password" method="put">
                    <x-form-input label="Kata Sandi Sebelumnya" id="current_password" name="current_password" type="password" class="mb-3" required />
                    <x-form-input label="Kata Sandi Baru" id="password" name="password" type="password" class="mb-3" required />
                    <x-form-input label="Konfirmasi Kata Sandi Baru" id="password_confirmation" name="password_confirmation" type="password" required />
                    <div class="text-end">
                        <x-button class="mt-3" icon="fa-solid fa-save" id="btn-update-password">Perbarui</x-button>
                    </div>
                </x-form>
            </x-card>
        </div>
    </div>
@endsection

@push('js')
    <script>
        $(document).on('click', '#btn-update-password', function () {
            loading()
            ajaxPost("{{ route('user-password.update') }}",fetchFormData(new FormData(document.getElementById('form-update-password'))),null,function(){
                clearForm('#form-update-password')
            })
        })
    </script>
@endpush
