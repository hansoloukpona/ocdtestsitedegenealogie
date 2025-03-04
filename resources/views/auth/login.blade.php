@extends('layouts.app')

@section('style')
    <title>Connexion</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
@endsection

@section('content')
    <div class="flex items-center justify-center min-h-screen bg-gray-100">
        <div class="bg-white p-6 rounded shadow-md w-96">
            <h2 class="text-2xl mb-4 text-center">Connexion</h2>

            @if (session('success'))
                <div class="bg-green-100 text-green-800 p-2 mb-4 rounded">
                    {{ session('success') }}
                </div>
            @endif

            @if ($errors->any())
                <div class="bg-red-100 text-red-800 p-2 mb-4 rounded">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('login') }}" method="POST">
                @csrf
                <div class="mb-4">
                    <label for="email" class="block text-sm">Email :</label>
                    <input type="email" id="email" name="email" value="{{ old('email') }}" required
                        class="w-full border border-gray-300 rounded p-2">
                </div>
                <div class="mb-4">
                    <label for="password" class="block text-sm">Mot de passe :</label>
                    <input type="password" id="password" name="password" required
                        class="w-full border border-gray-300 rounded p-2">
                </div>
                <button type="submit" class="w-full bg-blue-500 text-white p-2 rounded hover:bg-blue-600 transition">
                    Se connecter
                </button>
            </form>
        </div>
    </div>
@endsection
