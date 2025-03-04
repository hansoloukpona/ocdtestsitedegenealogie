@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Détails de {{ $people->first_name }} {{ $people->last_name }}</h2>

    <ul>
        <li><strong>Nom de naissance :</strong> {{ $people->birth_name ?? 'N/A' }}</li>
        <li><strong>Noms intermédiaires :</strong> {{ $people->middle_names ?? 'N/A' }}</li>
        <li><strong>Date de naissance :</strong> {{ $people->date_of_birth ?? 'N/A' }}</li>
    </ul>

    <h4>Parents :</h4>
    <ul>
        @forelse ($people->parents as $parent)
            <li>{{ $parent->first_name }} {{ $parent->last_name }}</li>
        @empty
            <li>Aucun parent enregistré</li>
        @endforelse
    </ul>

    <h4>Enfants :</h4>
    <ul>
        @forelse ($people->children as $child)
            <li>{{ $child->first_name }} {{ $child->last_name }}</li>
        @empty
            <li>Aucun enfant enregistré</li>
        @endforelse
    </ul>

    <a href="{{ route('people.index') }}" class="btn btn-secondary mt-3">Retour</a>
</div>
@endsection
