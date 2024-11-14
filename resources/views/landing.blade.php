<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PT. My Spare Parts Company</title>
    <link rel="shortcut icon" href="{{ asset('frontend/assets/images/logo-myspareparts.png') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css">
    <style>
        /* Custom colors */
        .custom-color {
            color: #00B9B9;
        }
        .custom-hover:hover {
            color: #00B9B9;
        }
        .custom-bg {
            background-color: #00B9B9;
        }
        .slideshow-image {
            animation: zoom 12s ease-in-out infinite;
        }
        @keyframes zoom {
            0%, 100% {
                transform: scale(1);
            }
            50% {
                transform: scale(1.1);
            }
        }
        /* Transition effect */
        .fade {
            transition: opacity 1s ease-in-out;
        }
    </style>
</head>
<body class="bg-gray-900 text-gray-200 font-sans">

    <!-- Header -->
    <header class="bg-gray-800 shadow-lg py-4 px-8">
        <div class="container mx-auto flex justify-between items-center">
            <a href="/">
                <img src="{{ asset('frontend/assets/images/auth-login-dark.png') }}" alt="My Spare Parts Logo" class="h-10 w-auto">
            </a>
            <nav class="space-x-8 hidden md:flex">
                <a href="#home" class="text-gray-300 custom-hover">Home</a>
                <a href="#about" class="text-gray-300 custom-hover">About Us</a>
                <a href="#services" class="text-gray-300 custom-hover">Services</a>
                <a href="#contact" class="text-gray-300 custom-hover">Contact</a>
            </nav>
            <a href="#contact" class="md:hidden custom-color">Menu</a>
        </div>
    </header>

    <!-- Hero Section with Slideshow -->
    <section id="home" class="relative h-screen overflow-hidden">
        <!-- Dark overlay for slideshow images -->
        <div class="absolute inset-0 bg-black opacity-50 z-10"></div>
        
        <!-- Content on top of slideshow -->
        <div class="absolute inset-0 flex items-center justify-center text-center z-20 px-8">
            <div class="text-white">
                <h1 class="text-5xl font-bold mb-4">Supporting Your Auto Center with Quality Spare Parts</h1>
                <p class="text-lg mb-8">Providing reliable solutions to meet your spare parts needs.</p>
                <a href="#contact" class="custom-bg text-gray-900 px-6 py-3 rounded-lg font-semibold hover:bg-opacity-80">Get in Touch</a>
            </div>
        </div>
        
        <!-- Slideshow Images -->
        <div class="absolute inset-0">
            <img src="{{ asset('frontend/assets/images/slideshow-1.jpg') }}" alt="Slide 1" class="slideshow-image fade w-full h-full object-cover absolute top-0 left-0 opacity-100">
            <img src="{{ asset('frontend/assets/images/slideshow-2.jpg') }}" alt="Slide 2" class="slideshow-image fade w-full h-full object-cover absolute top-0 left-0 opacity-0">
            <img src="{{ asset('frontend/assets/images/slideshow-3.jpg') }}" alt="Slide 3" class="slideshow-image fade w-full h-full object-cover absolute top-0 left-0 opacity-0">
        </div>
    </section>

    <!-- About Us Section -->
    <section id="about" class="py-28 px-8 bg-gray-900">
        <div class="container mx-auto flex flex-col lg:flex-row items-center lg:space-x-12">
            <img src="{{ asset('frontend/assets/images/about-us.jpg') }}" alt="About Us" class="w-full lg:w-1/2 rounded-lg shadow-lg mb-8 lg:mb-0">
            <div class="w-full lg:w-1/2 text-gray-300">
                <h2 class="text-4xl font-bold custom-color mb-6">About Us</h2>
                <p class="mb-6 text-justify">
                    PT. My Spare Parts Company is dedicated to providing high-quality vehicle spare parts to retail workshops and distributors across the region. With years of experience in the industry, we understand the challenges that workshops face, from inventory management to ensuring consistent quality. Our mission is to bridge these gaps and support our clients with reliable solutions tailored to their unique needs.
                </p>
                <p class="mb-6 text-justify">
                    At the heart of our company lies a commitment to operational excellence and customer satisfaction. We work closely with trusted manufacturers and suppliers to bring you products that meet stringent quality standards. Our team continually evaluates our inventory and distribution practices to ensure timely delivery and minimal downtime for our clients, helping them keep their operations running smoothly.
                </p>
                <p class="mb-6 text-justify">
                    Beyond providing spare parts, we strive to build lasting partnerships with our clients, understanding that their success is intertwined with our own. Our values—integrity, transparency, and customer-centric service—drive us to not only meet but exceed expectations in every interaction.
                </p>
                <p class="mb-6 text-justify">
                    Looking to the future, PT. My Spare Parts Company envisions a more streamlined and accessible automotive industry where quality parts are readily available to those who need them. By leveraging the latest in supply chain technology and maintaining strong relationships with our partners, we aim to be at the forefront of innovation in spare parts distribution.
                </p>
                <p>
                    Our goal remains steadfast: to empower retail workshops by providing the resources they need to grow and succeed. Whether you are a small workshop or a large distributor, we are here to support you with dedication, expertise, and a genuine commitment to your business's prosperity.
                </p>
            </div>
        </div>
    </section>

    <!-- Services Section -->
    <section id="services" class="py-32 bg-gray-900">
        <div class="container mx-auto text-center">
            <h2 class="text-3xl font-bold custom-color mb-6">Our Services</h2>
            <p class="max-w-2xl mx-auto text-gray-300 mb-12">At PT. My Spare Parts Company, we provide a range of services to ensure quality, convenience, and efficiency for our customers in the automotive industry.</p>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-12">
                <div class="bg-gray-800 p-6 rounded-lg shadow-lg">
                    <h3 class="text-2xl font-semibold custom-color mb-2">Easy Part Search</h3>
                    <p class="text-gray-300">Simply enter the part code, name, or type of vehicle to find the products you need.</p>
                </div>
                <div class="bg-gray-800 p-6 rounded-lg shadow-lg">
                    <h3 class="text-2xl font-semibold custom-color mb-2">Authenticity Guarantee</h3>
                    <p class="text-gray-300">We only provide parts that are guaranteed to be original and high quality.</p>
                </div>
                <div class="bg-gray-800 p-6 rounded-lg shadow-lg">
                    <h3 class="text-2xl font-semibold custom-color mb-2">Fast & Reliable Shipping</h3>
                    <p class="text-gray-300">Supported by trusted shipping services to ensure prompt delivery.</p>
                </div>
                <div class="bg-gray-800 p-6 rounded-lg shadow-lg">
                    <h3 class="text-2xl font-semibold custom-color mb-2">Wide Range of Brands</h3>
                    <p class="text-gray-300">Available for popular car brands with guaranteed quality and authenticity.</p>
                </div>
                <div class="bg-gray-800 p-6 rounded-lg shadow-lg">
                    <h3 class="text-2xl font-semibold custom-color mb-2">Error-Free Ordering</h3>
                    <p class="text-gray-300">All items are double-checked by our team to ensure accuracy.</p>
                </div>
                <div class="bg-gray-800 p-6 rounded-lg shadow-lg">
                    <h3 class="text-2xl font-semibold custom-color mb-2">Competitive Pricing</h3>
                    <p class="text-gray-300">We offer the best prices with various discounts.</p>
                </div>
                <div class="bg-gray-800 p-6 rounded-lg shadow-lg">
                    <h3 class="text-2xl font-semibold custom-color mb-2">Transparency</h3>
                    <p class="text-gray-300">All ordering and shipping processes can be tracked easily.</p>
                </div>
                <div class="bg-gray-800 p-6 rounded-lg shadow-lg">
                    <h3 class="text-2xl font-semibold custom-color mb-2">Warehouse Support</h3>
                    <p class="text-gray-300">We collaborate with suppliers across Indonesia to ensure fast fulfillment from strategically located warehouses.</p>
                </div>
                <div class="bg-gray-800 p-6 rounded-lg shadow-lg">
                    <h3 class="text-2xl font-semibold custom-color mb-2">Delivery Options</h3>
                    <p class="text-gray-300">Choose between regular (1-3 days) and instant (1-3 hours) delivery, supported by our reliable shipping partners.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Contact Section -->
    <section id="contact" class="py-20 bg-gray-800">
        <div class="container mx-auto flex flex-col lg:flex-row lg:space-x-8">
            <!-- Map -->
            <div class="w-full lg:w-1/2 h-96 mb-8 lg:mb-0">
            <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d7921.9066476572825!2d107.61214425510869!3d-6.896186596095702!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e68e65767c9b183%3A0x2478e3dcdce37961!2sInstitut%20Teknologi%20Bandung!5e0!3m2!1sen!2sid!4v1731587840568!5m2!1sen!2sid" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
            </div>
            <!-- Contact Form -->
            <div class="w-full lg:w-1/2 bg-gray-700 p-8 rounded-lg shadow-lg">
                <h3 class="text-3xl font-semibold custom-color mb-6 text-center">Contact Us</h3>
                <form>
                    <div class="mb-4">
                        <input type="text" placeholder="Name" class="w-full p-3 rounded-lg bg-gray-800 border border-gray-600 text-gray-100 focus:border-custom-color" required>
                    </div>
                    <div class="mb-4">
                        <input type="email" placeholder="Email" class="w-full p-3 rounded-lg bg-gray-800 border border-gray-600 text-gray-100 focus:border-custom-color" required>
                    </div>
                    <div class="mb-4">
                        <input type="text" placeholder="Phone Number" class="w-full p-3 rounded-lg bg-gray-800 border border-gray-600 text-gray-100 focus:border-custom-color" required>
                    </div>
                    <button type="submit" class="w-full custom-bg text-gray-900 py-3 rounded-lg font-semibold hover:bg-opacity-80">Send Message</button>
                </form>
            </div>
        </div>
    </section>

    <!-- JavaScript for Slideshow -->
    <script>
        let currentSlide = 0;
        const slides = document.querySelectorAll('.slideshow-image');
        const totalSlides = slides.length;

        function showNextSlide() {
            slides[currentSlide].classList.remove('opacity-100');
            slides[currentSlide].classList.add('opacity-0');
            currentSlide = (currentSlide + 1) % totalSlides;
            slides[currentSlide].classList.remove('opacity-0');
            slides[currentSlide].classList.add('opacity-100');
        }

        setInterval(showNextSlide, 3000);
    </script>

    <!-- Footer -->
    <footer class="bg-gray-900 py-6 text-center text-gray-500">
        <div class="container mx-auto">
            <p>&copy; 2024 PT. My Spare Parts. All rights reserved.</p>
            <div class="flex justify-center space-x-6 mt-4">
                <a href="#" class="hover:text-custom-color">Facebook</a>
                <a href="#" class="hover:text-custom-color">Twitter</a>
                <a href="#" class="hover:text-custom-color">Instagram</a>
            </div>
        </div>
    </footer>

</body>
</html>
