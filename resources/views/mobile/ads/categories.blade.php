@extends('mobile.ads.layout.innerBase')
@section('content')
@push('css')
    <!-- Custom CSS -->
    <style>
        .category-item {
            background: #fff;
            padding: 15px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease-in-out;
            display: flex;
            align-items: center;
            justify-content: space-between;
            overflow: hidden; /* Prevents any overflow issues */
        }

        .category-item:hover {
            transform: scale(1.02);
        }

        .category-link {
            display: flex;
            justify-content: space-between;
            align-items: center;
            text-decoration: none;
            color: inherit;
            padding: 15px;
            width: 100%;
        }

        .category-text {
            flex-grow: 1;
            max-width: 65%;
        }

        .category-title {
            font-size: 20px;
            font-weight: 600;
            margin-bottom: 5px;
        }

        .category-description {
            font-size: 14px;
            color: #555;
            overflow: hidden;
            text-overflow: ellipsis;
            display: -webkit-box;
            -webkit-line-clamp: 2; /* Limits to 2 lines */
            -webkit-box-orient: vertical;
        }

        .category-image {
            flex-shrink: 0;
            width: 90px;
            height: 90px;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden; /* Ensures image stays within container */
            border-radius: 8px;
            background: #fff;
        }

        .category-image img {
            width: 100%;
            height: auto;
            object-fit: contain; /* Ensures the full image is visible without cropping */
            display: block;
        }

        @media (max-width: 768px) {
            .category-text {
                max-width: 60%;
            }

            .category-title {
                font-size: 18px;
            }

            .category-description {
                font-size: 13px;
            }

            .category-image {
                width: 70px;
                height: 70px;
            }
        }
    </style>
@endpush

<!-- Categories section start -->
<section class="mt-3">
    <div class="custom-container">
        <ul class="categories-list list-unstyled">

            <li class="category-item mt-0">
                <a href="{{route('mobile.marketplace.categories.list', ['category'=>'fashion'])}}" class="category-link d-flex align-items-center">
                    <div class="category-text">
                        <h2 class="category-title">Fashion</h2>
                        <h4 class="category-description">
                            A category for businesses specializing in clothing, footwear, and accessories, including fashion designers, boutiques, and tailors.
                        </h4>
                    </div>
                    <div class="category-image">
                        <img src="{{ asset('fashion.png') }}" alt="Fashion" loading="lazy">
                    </div>
                </a>
            </li>

            <li class="category-item mt-5">
                <a href="{{route('mobile.marketplace.categories.list', ['category'=>'beauty'])}}" class="category-link d-flex align-items-center">
                    <div class="category-text">
                        <h2 class="category-title">Beauty</h2>
                        <h4 class="category-description">
                            A category for businesses offering beauty and personal care products and services, including makeup artists, skincare specialists, hair stylists, and beauty salons.
                        </h4>
                    </div>
                    <div class="category-image">
                        <img src="{{ asset('beauty.png') }}" alt="Beauty" loading="lazy">
                    </div>
                </a>
            </li>

        </ul>
    </div>
</section>


@endsection
