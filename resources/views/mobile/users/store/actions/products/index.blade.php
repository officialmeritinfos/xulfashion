@extends('mobile.users.layout.base')
@section('content')
    @push('css')
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

            /* Image Preview */
            .image-preview {
                margin-top: 15px;
                width: 100%;
                max-height: 300px;
                object-fit: cover;
                border-radius: 10px;
                border: 1px solid #ced4da;
            }

        </style>
    @endpush
    <div class="container-fluid mt-5">
        <livewire:mobile.users.store.components.actions.products.index lazy/>
    </div>

    @push('js')

        <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <x-livewire-alert::scripts />

        <script>
            document.addEventListener('livewire:init', () => {
                Livewire.on('open-share-modal', () => {
                    var shareModal = new bootstrap.Modal(document.getElementById('shareModal'));
                    shareModal.show();
                });
            });

            function shareToSocial(platform) {
                let url = document.getElementById('shareLink').value;
                let shareUrl = "";

                switch (platform) {
                    case 'facebook':
                        shareUrl = `https://www.facebook.com/sharer/sharer.php?u=${encodeURIComponent(url)}`;
                        break;
                    case 'twitter':
                        shareUrl = `https://twitter.com/intent/tweet?url=${encodeURIComponent(url)}&text=Check%20out%20this%20catalog`;
                        break;
                    case 'whatsapp':
                        shareUrl = `https://wa.me/?text=${encodeURIComponent(url)}`;
                        break;
                    case 'telegram':
                        shareUrl = `https://t.me/share/url?url=${encodeURIComponent(url)}`;
                        break;
                    case 'messenger':
                        shareUrl = `https://www.messenger.com/t/?link=${encodeURIComponent(url)}`;
                        break;
                }
                window.open(shareUrl, '_blank');
            }
        </script>

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
            document.addEventListener("DOMContentLoaded", function () {
                // Featured Photo Preview
                document.getElementById("featuredPhoto").addEventListener("change", function (event) {
                    let file = event.target.files[0];
                    if (file) {
                        let reader = new FileReader();
                        reader.onload = function (e) {
                            document.getElementById("featuredPhotoPreview").innerHTML = `<img src="${e.target.result}" class="img-preview">`;
                        };
                        reader.readAsDataURL(file);
                    }
                });

                // Multiple Image Previews
                document.getElementById("productImages").addEventListener("change", function (event) {
                    document.getElementById("productImagesPreview").innerHTML = "";
                    let files = event.target.files;
                    for (let i = 0; i < files.length; i++) {
                        let reader = new FileReader();
                        reader.onload = function (e) {
                            document.getElementById("productImagesPreview").innerHTML += `<img src="${e.target.result}" class="img-preview">`;
                        };
                        reader.readAsDataURL(files[i]);
                    }
                });
            });

            // Add Size Variation
            function addSizeVariation() {
                let sizeVariations = document.getElementById("sizeVariations");
                let div = document.createElement("div");
                div.classList.add("variation-group");
                div.innerHTML = `
            <input type="text" class="form-control" name="sizeName[]" placeholder="Size Name">
            <button type="button" class="btn btn-danger" onclick="this.parentElement.remove()">Remove</button>
        `;
                sizeVariations.appendChild(div);
            }

            // Add Color Variation
            function addColorVariation() {
                let colorVariations = document.getElementById("colorVariations");
                let div = document.createElement("div");
                div.classList.add("variation-group");
                div.innerHTML = `
            <input type="text" class="form-control" name="colorName[]" placeholder="Color Name">
            <button type="button" class="btn btn-danger" onclick="this.parentElement.remove()">Remove</button>
        `;
                colorVariations.appendChild(div);
            }
        </script>

    @endpush
@endsection
