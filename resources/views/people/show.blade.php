@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Détails de {{ $people->first_name }} {{ $people->last_name }}</h2>
    <ul>
        <li><strong>Prénom :</strong> {{ $people->first_name }}</li>
        <li><strong>Nom :</strong> {{ $people->last_name }}</li>
        <li><strong>Email :</strong> {{ $people->email }}</li>
    </ul>

    <hr>

    <h4>Rechercher le degré de parenté</h4>
    <form action="{{ route('show.degree.form') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="target_id" class="form-label">ID de l'autre personne :</label>
            <input type="number" name="id2" id="target_id" class="form-control" placeholder="Entrez l'ID">
        </div>
        <button type="submit" class="btn btn-primary">Voir le degré de parenté</button>
    </form>

    @isset($degree)
        <div class="alert alert-success mt-3">
            Le degré de parenté entre {{ $people->first_name }} et la personne cible est : {{ $degree }}.
        </div>
    @endisset

    @isset($error)
        <div class="alert alert-danger mt-3">
            {{ $error }}
        </div>
    @endisset

    <a href="{{ route('people.index') }}" class="btn btn-secondary mt-3">Retour à la liste des personnes</a>
</div>
@endsection
