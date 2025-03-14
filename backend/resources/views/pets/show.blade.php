@extends('layouts.main')

@section('content')
    <div class="container mt-4">
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

        <div class="card shadow-sm">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h4>🐾 Szczegóły zwierzaka</h4>
                <a href="{{ route('pets.index') }}" class="btn btn-outline-secondary btn-sm">
                    ⬅ Powrót
                </a>
            </div>

            <div class="card-body">
                <h5 class="card-title">{{ isset($pet['name']) ?? ''}}</h5>

                <!-- Kategoria -->
                <p><strong>Kategoria:</strong> {{ $pet['category']['name'] ?? 'Brak' }}</p>

                <!-- Status -->
                <p>
                    <strong>Status:</strong>
                    <span class="badge
                    @if($pet['status'] === 'available') badge-success
                    @elseif($pet['status'] === 'pending') badge-warning
                    @else badge-danger
                    @endif">
                    {{ ucfirst($pet['status']) }}
                </span>
                </p>

                <!-- Tagi -->
                <p>
                    <strong>Tagi:</strong>
                    @if(!empty($pet['tags']))
                        @foreach($pet['tags'] as $tag)
                            <span class="badge badge-info">{{ $tag['name'] }}</span>
                        @endforeach
                    @else
                        <span class="text-muted">Brak</span>
                    @endif
                </p>

                <!-- Zdjęcia -->
                <div class="mb-3">
                    <strong>Zdjęcia:</strong>
                    <div class="d-flex flex-wrap mt-2">
                        @if(!empty($pet['photoUrls']))
                            @foreach($pet['photoUrls'] as $photo)
                                <img src="{{ $photo }}" alt="Zdjęcie zwierzaka" class="img-thumbnail m-1" style="width: 150px; height: 150px; object-fit: cover;">
                            @endforeach
                        @else
                            <p class="text-muted">Brak zdjęć</p>
                        @endif
                    </div>
                </div>

                <!-- Akcje -->
                <div class="d-flex justify-content-between">
                    <a href="{{ route('pets.edit', $pet['id']) }}" class="btn btn-primary">
                        ✏ Edytuj
                    </a>
                    <form action="{{ route('pets.destroy', $pet['id']) }}" method="POST" onsubmit="return confirm('Czy na pewno chcesz usunąć?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">🗑 Usuń</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
