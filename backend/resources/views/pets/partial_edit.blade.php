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

        <form action="{{ route('pets.update.partial', $pet['id']) }}" method="POST">
            @csrf

            <!-- Nazwa -->
            <div class="form-group">
                <label for="name">Nazwa zwierzaka</label>
                <input type="text" name="name" id="name" class="form-control" value="{{ $pet['name'] }}" required>
            </div>

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
