@extends('layouts.main', ['title' => "Ubah Profil"])

@section('contents')
    <div class="row">
        <div class="col-md-6 mb-3">
            <x-card header="Ubah Profil">
                <x-form method="put" submit="Simpan" submitIcon="fa-solid fa-save">
                    <x-form-input label="Nama" id="name" name="name" value="" class="mb-3" required />
                    <x-form-input label="Alamat Email" id="email" name="email" type="email" value="" required />
                </x-form>
            </x-card>
        </div>
        <div class="col-md-6">
            <x-card header="Ubah Kata Sandi">
                <x-form method="put" submit="Perbarui" submitIcon="fa-solid fa-save">
                    <x-form-input label="Kata Sandi Sebelumnya" id="current_password" name="current_password" type="password" class="mb-3" required />
                    <x-form-input label="Kata Sandi Baru" id="password" name="password" type="password" class="mb-3" required />
                    <x-form-input label="Konfirmasi Kata Sandi Baru" id="password_confirmation" name="password_confirmation" type="password" required />
                </x-form>
            </x-card>
        </div>
    </div>
@endsection
