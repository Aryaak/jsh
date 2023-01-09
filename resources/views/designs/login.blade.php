@extends('layouts.auth', ['title' => 'Masuk'])

@push('css')
    <link rel="stylesheet" href="{{ asset('public/theme/css/pages/page-auth.css') }}" />
@endpush

@section('contents')
    <div class="text-center mt-4 mb-5">
        <h4 class="mb-2">Masuk</h4>
        <p class="mb-4">Silakan masukkan kredensial Anda.</p>
    </div>

    <x-form action="" method="post" submit="Masuk" submitIcon="bx bxs-key" submitWide>
        <x-form-input id="username" name="username" label="Username" class="mb-3" required />
        <x-form-input id="password" name="password" type="password" label="Kata Sandi" required />
    </x-form>
@endsection
