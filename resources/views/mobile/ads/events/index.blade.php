@extends('mobile.ads.layout.eventBase')
@section('content')
@push('css')
    <style>
        .suggestions-box {
            position: absolute;
            background-color: white;
            border: 1px solid #ccc;
            width: 100%;
            max-height: 300px; /* Adjust the height as needed */
            overflow-y: auto;
            z-index: 1000; /* Ensure the suggestions box is on top */
            box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1); /* Optional: adds a subtle shadow */
        }

        .form-input {
            position: relative;
        }

        .suggestion-item {
            padding: 10px;
            cursor: pointer;
        }

        .suggestion-item:hover {
            background-color: #f0f0f0;
        }


    </style>
@endpush


@endsection
