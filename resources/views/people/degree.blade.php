@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Calcul du Degré de Parenté</h2>
    <form action="{{ route('degree.between', ['id1' => $person1->id, 'id2' => $person2->id]) }}" method="GET">
        <button type="submit" class="btn btn-primary">Voir le degré de parenté</button>
    </form>

    @isset($degree)
        <div class="alert alert-success mt-3">
            Le degré de parenté entre {{ $person1->first_name }} et {{ $person2->first_name }} est : {{ $degree }}.
        </div>
    @endisset

    @isset($error)
        <div class="alert alert-danger mt-3">
            {{ $error }}
        </div>
    @endisset
</div>
@endsection