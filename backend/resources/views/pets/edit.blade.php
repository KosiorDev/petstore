@extends('layouts.main')

@section('content')
    <div class="container">
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

        <h1>Edytuj zwierzaka</h1>

        <form action="{{ route('pets.update') }}" method="POST">
            @csrf
            @method('PUT')


            <!-- Id -->
            <div class="form-group">
                <label for="id">Id</label>
                <input name="id" id="id" class="form-control" value="{{ $pet['id'] ?? '' }}" required>
            </div>

            <!-- Kategoria -->
            <div class="form-group">
                <label for="category_id">Kategoria</label>
                <select name="category_id" id="category_id" class="form-control" required>
                    @foreach($categories as $category)
                        <option value="{{ $category['id'] }}" data-name="{{ $category['name'] }}" {{ $category['id'] == $pet['category']['id'] ? 'selected' : '' }}>
                            {{ $category['name'] }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="category_name">Nazwa kategorii</label>
                <input type="text" name="category[name]" id="category_name" class="form-control" value="{{ old('category.name', $pet['category']['name']) }}" required>
            </div>

            <!-- Nazwa -->
            <div class="form-group">
                <label for="name">Nazwa zwierzaka</label>
                <input type="text" name="name" id="name" class="form-control" value="{{ $pet['name'] }}" required>
            </div>

            <!-- Zdjęcia -->
            <div class="form-group" id="photos-container">
                <label>Zdjęcia (URL)</label>
                <div class="photo-input">
                    <input type="text" name="photoUrls[]" class="form-control" value="{{ old('photoUrls.0') }}">
                </div>
            </div>
            <button type="button" class="btn btn-secondary mt-2" id="addImage">Dodaj kolejne zdjęcie</button>

            <!-- Tagi -->
            <div class="form-group mt-3" id="tags-container">
                <label>Tagi</label>
                <div class="tag-input">
                    <input type="text" name="tags[0][id]" placeholder="ID tagu" class="form-control" value="{{ old('tags.0.id') }}">
                    <input type="text" name="tags[0][name]" placeholder="Nazwa tagu" class="form-control mt-1" value="{{ old('tags.0.name') }}">
                </div>
            </div>
            <button type="button" class="btn btn-secondary mt-2" id="addTag">Dodaj kolejny tag</button>

            <!-- Status -->
            <div class="form-group">
                <label for="status">Status</label>
                <select name="status" id="status" class="form-control" required>
                    <option value="available" {{ $pet['status'] == 'available' ? 'selected' : '' }}>Dostępny</option>
                    <option value="pending" {{ $pet['status'] == 'pending' ? 'selected' : '' }}>Oczekujący</option>
                    <option value="sold" {{ $pet['status'] == 'sold' ? 'selected' : '' }}>Sprzedany</option>
                </select>
            </div>

            <!-- Przycisk do zapisania -->
            <button type="submit" class="btn btn-warning">Zaktualizuj</button>
        </form>

        <h1>Dodaj zdjęcie</h1>

        <form action="{{route('pets.upload.image', $pet['id'])}}" method="POST" enctype="multipart/form-data">
            @csrf

            <!-- Pole na dodatkowe metadane -->
            <div class="mb-3">
                <label for="additionalMetadata" class="form-label">Dodatkowe metadane:</label>
                <input type="text" class="form-control" id="additionalMetadata" name="additionalMetadata" value="{{ old('additionalMetadata') }}">
            </div>

            <!-- Pole na plik obrazu -->
            <div class="mb-3">
                <label for="file" class="form-label">Wybierz zdjęcie:</label>
                <input type="file" class="form-control" id="file" name="file" accept="image/*" required>
            </div>

            <button type="submit" class="btn btn-primary">Prześlij zdjęcie</button>
        </form>
    </div>

    <script>
        document.getElementById('category_id').addEventListener('change', function() {
            var selectedOption = this.options[this.selectedIndex];
            document.getElementById('category_name').value = selectedOption.getAttribute('data-name');
        });

        document.getElementById('addImage').addEventListener('click', function() {
            var container = document.getElementById('photos-container');
            var newField = document.createElement('div');
            newField.innerHTML = `<input type="text" name="photoUrls[]" class="form-control mt-1">`;
            container.appendChild(newField);
        });

        document.getElementById('addTag').addEventListener('click', function() {
            var container = document.getElementById('tags-container');
            var index = container.getElementsByClassName('tag-input').length;
            var newField = document.createElement('div');
            newField.classList.add('tag-input', 'mt-2');
            newField.innerHTML = `
                <input type="text" name="tags[${index}][id]" placeholder="ID tagu" class="form-control">
                <input type="text" name="tags[${index}][name]" placeholder="Nazwa tagu" class="form-control mt-1">
            `;
            container.appendChild(newField);
        });
    </script>
@endsection
