@extends('mobile.users.layout.base')
@section('content')
    @push('css')
        <style>
            /* Remove horizontal scroll */
            body, html {
                margin: 0;
                padding: 0;
                width: 100%;
                height: 100%;
                overflow-x: hidden;
            }

            /* Full-page card */
            .full-page-form {
                min-height: 100vh;
                display: flex;
                align-items: center;
                justify-content: center;
                background-color: #f8f9fa;
                padding: 20px;
            }

            .form-card {
                width: 100%;
                max-width: 1200px;
                background-color: #ffffff;
                padding: 40px;
                border-radius: 20px;
                box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
            }

            /* File Upload */
            .file-upload {
                position: relative;
                display: inline-block;
                width: 100%;
            }

            .file-upload input[type="file"] {
                display: none;
            }

            .file-upload label {
                cursor: pointer;
                background-color: #f8f9fa;
                padding: 15px;
                border: 2px dashed #ced4da;
                border-radius: 10px;
                display: flex;
                align-items: center;
                justify-content: center;
                gap: 10px;
                width: 100%;
            }

            .file-upload label i {
                font-size: 1.5rem;
            }

            /* Image Preview */
            .image-preview {
                margin-top: 15px;
                width: 100%;
                max-height: 300px;
                object-fit: cover;
                border-radius: 10px;
                border: 1px solid #ced4da;
            }

            /* Adjust form inputs */
            .form-control, .form-select, textarea {
                border-radius: 8px;
            }

            /* Button */
            .btn-submit {
                padding: 10px 30px;
                font-size: 1rem;
            }

            @media (max-width: 768px) {
                .form-card {
                    padding: 20px;
                }
            }
        </style>
    @endpush
    <div class="container-fluid mt-3">

        <livewire:mobile.users.store.components.initialize-store-form lazy />

    </div>


    @push('js')
        <script>
            function previewImage(event) {
                const input = event.target;
                const preview = document.getElementById('imagePreview');
                if (input.files && input.files[0]) {
                    const reader = new FileReader();
                    reader.onload = function (e) {
                        preview.src = e.target.result;
                        preview.style.display = 'block';
                    };
                    reader.readAsDataURL(input.files[0]);
                }
            }
        </script>
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                window.addEventListener('storeCreated', event => {
                    let url = event.detail.url;
                    setTimeout(() => {
                        window.location.href = url;
                    }, 5000);
                });
            });
        </script>
    @endpush
@endsection
