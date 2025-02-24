@extends('mobile.users.layout.base')
@section('content')
    @push('css')
        <link href="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.3/css/lightbox.min.css" rel="stylesheet">
        <style>
            /* Ensure the parent container does not overflow */
            .scrollable-table-container {
                width: 100%;
                max-width: 100%;
                overflow-x: auto !important;
                overflow-y: hidden !important;
                display: block;
                position: relative;
            }

            /* Control the table width */
            .scrollable-table-container table {
                width: max-content;
                min-width: 100%;
                border-collapse: collapse;
            }

            /* Prevent the table from affecting page layout */
            .scrollable-table-container th,
            .scrollable-table-container td {
                white-space: nowrap;
                padding: 10px;
            }

            /* Optional: Smooth scrollbar styling */
            .scrollable-table-container::-webkit-scrollbar {
                height: 8px;
            }

            .scrollable-table-container::-webkit-scrollbar-thumb {
                background-color: #ccc;
                border-radius: 10px;
            }

            .scrollable-table-container::-webkit-scrollbar-track {
                background-color: #f1f1f1;
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

            /* General Styles */
            .image-preview-container {
                display: flex;
                flex-wrap: wrap;
                gap: 10px;
                margin-top: 10px;
            }

            .image-preview, .image-previews {
                width: 100px;
                height: 100px;
                object-fit: cover;
                border-radius: 5px;
                border: 1px solid #ddd;
                padding: 5px;
                position: relative;
            }

            .remove-image {
                position: absolute;
                top: 5px;
                right: 5px;
                background: red;
                color: white;
                border: none;
                border-radius: 50%;
                width: 20px;
                height: 20px;
                cursor: pointer;
                font-size: 14px;
                text-align: center;
            }

            .image-wrapper {
                position: relative;
                display: inline-block;
            }
        </style>
    @endpush
<div class="container-fluid mt-3">
    <livewire:mobile.users.store.components.actions.products.detail :product="$product->id" lazy/>
</div>

    @push('js')
        <script>
            document.addEventListener("DOMContentLoaded", function () {
                window.Livewire.on("closeModal", () => {
                    let modal = document.getElementById("addImage");
                    let modalInstance = bootstrap.Modal.getInstance(modal);
                    if (modalInstance) {
                        modalInstance.hide();
                    }
                });
            });
        </script>

        <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <x-livewire-alert::scripts />
        <script src="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.3/js/lightbox.min.js"></script>
        <script>
            // Multiple Product Images Preview
            function previewProductImages(event) {
                const input = event.target;
                const previewContainer = document.getElementById("productImagePreviewContainer");
                const templateImage = document.getElementById("previewImageTemplate");

                // Clear previous previews but keep the template
                previewContainer.innerHTML = "";
                previewContainer.appendChild(templateImage);

                if (input.files) {
                    Array.from(input.files).forEach((file, index) => {
                        if (!file.type.startsWith("image/")) return;

                        const reader = new FileReader();
                        reader.onload = function (e) {
                            // Clone the template image
                            const newImg = templateImage.cloneNode(true);
                            newImg.src = e.target.result;
                            newImg.style.display = "block"; // Show the image
                            newImg.removeAttribute("id"); // Ensure unique ID isn't duplicated

                            previewContainer.appendChild(newImg);
                        };
                        reader.readAsDataURL(file);
                    });
                }
            }
        </script>
    @endpush
@endsection
