@extends('layouts.theme.master')

@section('content')
    <main>
        <div class="container margin_detail_2">
            <div class="row">
                <div class="col-lg-12">
                    <div class="detail_page_head clearfix">
                        <div class="title">
                            <h1 class="about-title">About Us</h1>
                        </div>
                    </div>
                    <br>
                    <div class="about-section">
                        <div class="row">
                            <!-- Image Section -->
                            <div class="col-lg-6">
                                <div class="about-image">
                                    <img src="{{ asset('themeAssets/images/about_us.jpg') }}" alt="About Us" class="img-fluid rounded shadow">
                                </div>
                            </div>

                            <!-- Content Section -->
                            <div class="col-lg-6">
                                <div class="about-text">
                                    <p>
                                        <strong>Bright Matrimony</strong> is dedicated to helping individuals find their perfect match with ease and confidence. Our platform brings people from all backgrounds together, focusing on authentic connections built on trust, mutual respect, and shared values.
                                    </p>
                                    <p>
                                        Our team works tirelessly to ensure the highest standards of safety, privacy, and user experience. Whether you're looking for a life partner or seeking to explore meaningful relationships, Bright Matrimony is here to guide you every step of the way.
                                    </p>
                                    <p>
                                        Our platform provides easy-to-use tools and resources to help you connect with others based on shared interests, backgrounds, and goals. From initial interactions to meaningful conversations, Bright Matrimony is your trusted partner in the journey of love.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection

@section('styles')
    <style>
        .about-title {
            font-size: 32px;
            font-weight: bold;
            color: #cc2727;
            text-align: center;
            margin-bottom: 20px;
        }

        .about-section {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-between;
            padding: 30px;
            background-color: #f9f9f9;
            border-radius: 8px;
        }

        .about-text {
            font-size: 18px;
            line-height: 1.6;
            color: #333;
        }

        .about-image img {
            border-radius: 8px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }

        .about-text p {
            margin-bottom: 15px;
        }

        .about-text strong {
            color: #cc2727;
        }

        .about-image {
            position: relative;
            width: 100%;
            height: 350px; /* Set the desired height */
            overflow: hidden;
            border-radius: 12px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2); /* Add a subtle shadow around the image */
            border: 5px solid #fff; /* Create a border frame effect */
            transition: transform 0.3s ease; /* Smooth hover transition */
        }

        .about-image img {
            width: 100%;
            height: 100%;
            object-fit: cover; /* Ensure the image covers the container without distortion */
            border-radius: 10px; /* Optional: round the corners of the image */
        }

        /* Hover effect for the image */
        .about-image:hover {
            transform: scale(1.05); /* Slight zoom-in effect on hover */
        }

        /* Apply the scroll effect */
        .scroll-container {
            height: 300px;
            width: 100%;
            overflow-y: scroll;
            padding-right: 10px;
            background-color: #f4e1d2;
            border: 2px solid #cc2727;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
            margin-top: 20px;
        }

        .scroll-content {
            padding: 20px;
            font-size: 18px;
            line-height: 1.8;
        }

        /* Styling the "scrolling" container */
        .scroll-container::-webkit-scrollbar {
            width: 12px;
        }

        .scroll-container::-webkit-scrollbar-thumb {
            background-color: #cc2727;
            border-radius: 10px;
        }

        .scroll-container::-webkit-scrollbar-track {
            background: #f1f1f1;
        }

        /* Responsive design adjustments */
        @media (max-width: 768px) {
            .about-image {
                height: 250px; /* Adjust height for smaller screens */
            }

            .about-section {
                flex-direction: column;
            }

            .about-image img {
                width: 100%;
                height: auto;
            }
        }
    </style>
@endsection
