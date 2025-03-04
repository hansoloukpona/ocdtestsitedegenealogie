@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="mb-4">Liste des personnes</h2>
    <a href="{{ route('people.create') }}" class="btn btn-primary mb-3">Ajouter une personne</a>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>#</th>
                <th>Prénom</th>
                <th>Nom</th>
                <th>Créé par</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($people as $person)
                <tr>
                    <td>{{ $person->id }}</td>
                    <td>{{ $person->first_name }}</td>
                    <td>{{ $person->last_name }}</td>
                    <td>{{ $person->creator->name ?? 'N/A' }}</td>
                    <td>
                        <a href="{{ route('people.show', $person->id) }}" class="btn btn-info btn-sm">Voir</a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <!-- Lien de pagination -->
    <div class="d-flex justify-content-center">
        {{ $people->links() }}
    </div>
</div>
@endsection
