@extends('component.app')

@section('content')
<div class="banned-container">
    <h1>Your Account Has Been Banned</h1>
    <p>We are sorry, but your account has been banned. If you believe this is a mistake, please contact support.</p>
    <p>Alasan Ban: {{ $ban->Deskripsi ?? 'Data alasan tidak tersedia.' }}</p>
    <p>Ban Sampai : {{ $ban->Ban_Until ?? 'Data tidak tersedia.' }}</p>
    <a href="{{ route('index') }}" class="btn">Go Back to Home</a>
</div>
@endsection

@push('styles')
<style>
    body {
        font-family: 'Roboto', sans-serif;
        background-color: #f7f7f7;
        color: #333;
        display: flex;
        justify-content: center;
        align-items: center;
        height: 100vh;
        margin: 0;
    }
    .banned-container {
        text-align: center;
        padding: 20px;
        background-color: #ffffff;
        box-shadow: 0px 2px 10px rgba(0, 0, 0, 0.1);
        border-radius: 8px;
        width: 400px;
    }
    .banned-container h1 {
        font-size: 24px;
        color: #e74c3c;
        margin-bottom: 20px;
    }
    .banned-container p {
        font-size: 16px;
        color: #7f8c8d;
        margin-bottom: 20px;
    }
    .btn {
        padding: 10px 20px;
        background-color: #e74c3c;
        color: white;
        text-decoration: none;
        border-radius: 5px;
        font-weight: bold;
    }
    .btn:hover {
        background-color: #c0392b;
    }
</style>
@endpush
