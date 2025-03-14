@extends('layouts.main')

@section('content')
    <div style="padding: 20px; border: 1px solid red; background-color: #f8d7da; color: #721c24; border-radius: 5px;">
        <h2>Wystąpił błąd!</h2>
        <p><strong>Kod błędu:</strong> {{ $errorCode }}</p>
        <p><strong>Wiadomość:</strong> {{ $errorMessage }}</p>
    </div>
@endsection
