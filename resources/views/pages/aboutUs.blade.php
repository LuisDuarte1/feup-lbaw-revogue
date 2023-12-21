@extends('layouts.app', ['search_bar' => true])

@section('content')
<div class="about-us-wrapper column gap-3 items-center justify-center">
    <div class="about-us column gap-2 page-center">
        <h1 class="title">About Us</h1>
        <div class="about-us-content column gap-1">
            <p>Welcome to ReVogue, where timeless fashion meets modern style! Founded by the visionary Joseph Waldor, ReVogue is more than just a marketplace; it's a curated space where fashion enthusiasts and trendsetters unite to redefine the way we experience vintage and pre-loved fashion.</p>

            At ReVogue, we believe in the enduring charm of vintage clothing and the sustainability it brings to the fashion industry. Joseph Waldor, driven by a passion for fashion and a commitment to environmental responsibility, established ReVogue to provide a platform where individuals can buy, sell, and discover unique pieces that tell a story.

            Our platform is designed to echo the spirit of traditional thrift shopping while embracing the convenience of a modern, online marketplace.

            What sets ReVogue apart is our dedication to creating a seamless and enjoyable experience for our users. Whether you're a seller looking to find a new home for your cherished pieces or a buyer on the hunt for that one-of-a-kind fashion gem, ReVogue is the go-to destination for all things vintage, pre-loved, and effortlessly chic.

            <p>Join Joseph Waldor and the ReVogue community in our mission to redefine the fashion landscape, one fabulous find at a time. Together, let's celebrate the beauty of fashion that transcends time and make sustainable choices that leave a lasting impact.</p>

            Welcome to ReVogue – where style meets sustainability, and every piece has a story to tell.
        </div>
    </div>
    <div class="social-media column">
        <div class="social-media-content row gap-1">
            <a href="https://www.facebook.com/NIAEFEUP/?locale=pt_PT" target="_blank" class="social-media-link" aria-label="facebook-link">
                <ion-icon name="logo-facebook" aria-label="facebook-logo"></ion-icon>
            </a>
            <a href="https://www.instagram.com/niaefeup/" target="_blank" class="social-media-link" aria-label="instagram-link">
                <ion-icon name="logo-instagram" aria-label="instagram-icon"></ion-icon>
            </a>
            <a href="https://pt.linkedin.com/company/niaefeup" target="_blank" class="social-media-link" aria-label="linkedin-link">
                <ion-icon name="logo-linkedin" aria-label="linkedin-icon"></ion-icon>
            </a>
        </div>
    </div>
</div>
@endsection