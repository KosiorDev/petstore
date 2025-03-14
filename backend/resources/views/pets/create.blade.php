@extends('layouts.main')

@section('content')
    <div class="container">

        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <h1>Dodaj nowego zwierzaka</h1>

        <form action="{{ route('pets.store') }}" method="POST">
            @csrf

            <!-- Id -->
            <div class="form-group">
                <label for="id">Id</label>
                <input type="number" name="id" id="id" class="form-control" value="{{ $pet['id'] ?? '' }}" required>
            </div>

            <!-- Kategoria -->
            <div class="form-group">
                <label for="category_id">Kategoria</label>
                <select name="category[id]" id="category_id" class="form-control" required>
                    @foreach($categories as $category)
                        <option value="{{ $category['id'] }}" data-name="{{ $category['name'] }}">{{ $category['name'] }}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="category_name">Nazwa kategorii</label>
                <input type="text" name="category[name]" id="category_name" class="form-control" value="{{ old('category.name') }}" required>
            </div>

            <!-- Nazwa -->
            <div class="form-group">
                <label for="name">Nazwa zwierzaka</label>
                <input type="text" name="name" id="name" class="form-control" value="{{ old('name') }}" required>
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
                    <input type="number" name="tags[0][id]" placeholder="ID tagu" class="form-control" value="{{ old('tags.0.id') }}">
                    <input type="text" name="tags[0][name]" placeholder="Nazwa tagu" class="form-control mt-1" value="{{ old('tags.0.name') }}">
                </div>
            </div>
            <button type="button" class="btn btn-secondary mt-2" id="addTag">Dodaj kolejny tag</button>

            <!-- Status -->
            <div class="form-group mt-3">
                <label for="status">Status</label>
                <select name="status" id="status" class="form-control" required>
                    @foreach($statuses as $status)
                        <option value="{{ $status }}" {{ old('status') == $status ? 'selected' : '' }}>{{ ucfirst($status) }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Przycisk do zapisania -->
            <button type="submit" class="btn btn-success mt-3">Zapisz</button>
        </form>

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
    </div>

    <!-- JavaScript do obsługi dodawania nowych pól -->
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
