@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Ajouter une nouvelle personne</h2>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('people.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="first_name" class="form-label">Prénom</label>
            <input type="text" class="form-control" id="first_name" name="first_name" value="{{ old('first_name') }}" required>
        </div>
        <div class="mb-3">
            <label for="last_name" class="form-label">Nom</label>
            <input type="text" class="form-control" id="last_name" name="last_name" value="{{ old('last_name') }}" required>
        </div>
        <div class="mb-3">
            <label for="birth_name" class="form-label">Nom de naissance (optionnel)</label>
            <input type="text" class="form-control" id="birth_name" name="birth_name" value="{{ old('birth_name') }}">
        </div>
        <div class="mb-3">
            <label for="middle_names" class="form-label">Noms intermédiaires (optionnel)</label>
            <input type="text" class="form-control" id="middle_names" name="middle_names" value="{{ old('middle_names') }}">
        </div>
        <div class="mb-3">
            <label for="date_of_birth" class="form-label">Date de naissance (optionnel)</label>
            <input type="date" class="form-control" id="date_of_birth" name="date_of_birth" value="{{ old('date_of_birth') }}">
        </div>
        <button type="submit" class="btn btn-success">Enregistrer</button>
        <a href="{{ route('people.index') }}" class="btn btn-secondary">Annuler</a>
    </form>
</div>
@endsection
