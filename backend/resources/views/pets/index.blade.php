@extends('layouts.main')

@section('content')
    @if(session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    @if(session('message'))
        <div class="alert alert-warning">
            {{ session('message') }}
        </div>
    @endif

    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2>Lista zwierzaków</h2>
        <form method="GET" action="{{ route('pets.index') }}" class="mb-3">
            <label for="status">Filtruj według statusu:</label>
            <select name="status" id="status" class="form-select" onchange="this.form.submit()">
                <option value="available" {{ $status == 'available' ? 'selected' : '' }}>Dostępne</option>
                <option value="pending" {{ $status == 'pending' ? 'selected' : '' }}>Oczekujące</option>
                <option value="sold" {{ $status == 'sold' ? 'selected' : '' }}>Sprzedane</option>
            </select>
        </form>

        <a href="{{ route('pets.create') }}" class="btn btn-success">➕ Dodaj zwierzaka</a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered">
        <thead>
        <tr>
            <th>ID</th>
            <th>Imię</th>
            <th>Kategoria</th>
            <th>Tagi</th>
            <th>Status</th>
            <th>Akcje</th>
        </tr>
        </thead>
        <tbody>
        @foreach($pets as $pet)
            <tr>
                <td>{{ $pet['id'] }}</td>
                @if(isset($pet['name'])) <td>{{ $pet['name'] }}</td> @else <td></td> @endif
                @if(isset($pet['category']['name'])) <td>{{ $pet['category']['name'] }}</td> @else <td></td> @endif
                <td>
                    @if(isset($pet['tags']))
                        @foreach($pet['tags'] as $tag)
                            @if(isset($tag['name']))
                                {{$tag['name']}}
                            @endif
                        @endforeach
                    @endif
                </td>
                <td>{{ $pet['status'] }}</td>
                <td>
                    <a href="{{ route('pets.show', $pet['id']) }}" class="btn btn-warning btn-sm">Szczegóły</a>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
@endsection
