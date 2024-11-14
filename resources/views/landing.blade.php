<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PT. My Spare Parts Company</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css">
    <style>
        /* CSS for zoom animation */
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
            <a href="/" class="text-2xl font-bold text-yellow-500">My Spare Parts</a>
            <nav class="space-x-8 hidden md:flex">
                <a href="#home" class="text-gray-300 hover:text-yellow-500">Home</a>
                <a href="#about" class="text-gray-300 hover:text-yellow-500">About Us</a>
                <a href="#features" class="text-gray-300 hover:text-yellow-500">Features</a>
                <a href="#contact" class="text-gray-300 hover:text-yellow-500">Contact</a>
            </nav>
            <a href="#contact" class="md:hidden text-yellow-500">Menu</a>
        </div>
    </header>

    <!-- Hero Section with Slideshow -->
    <section id="home" class="relative h-screen overflow-hidden">
        <div class="absolute inset-0 flex items-center justify-center text-center z-10 px-8">
            <div class="text-white">
                <h1 class="text-5xl font-bold mb-4">Empowering Your Workshop with Quality Spare Parts</h1>
                <p class="text-lg mb-8">Providing reliable solutions to meet your spare parts needs.</p>
                <a href="#contact" class="bg-yellow-500 text-gray-900 px-6 py-3 rounded-lg font-semibold hover:bg-yellow-400">Get in Touch</a>
            </div>
        </div>
        
        <!-- Slideshow Images -->
        <div class="absolute inset-0">
            <img src="{{ asset('frontend/assets/images/slideshow-1.jpg') }}" alt="Slide 1" class="slideshow-image fade w-full h-full object-cover absolute top-0 left-0 opacity-100">
            <img src="{{ asset('frontend/assets/images/slideshow-2.jpg') }}" alt="Slide 2" class="slideshow-image fade w-full h-full object-cover absolute top-0 left-0 opacity-0">
            <img src="{{ asset('frontend/assets/images/slideshow-3.jpg') }}" alt="Slide 3" class="slideshow-image fade w-full h-full object-cover absolute top-0 left-0 opacity-0">
        </div>
    </section>

    <!-- Features Section -->
    <section id="features" class="py-20 bg-gray-900">
        <div class="container mx-auto text-center">
            <h2 class="text-3xl font-bold text-yellow-400 mb-6">Why Choose Us</h2>
            <p class="max-w-2xl mx-auto text-gray-300 mb-12">At PT. My Spare Parts Company, we offer unmatched quality and service to meet the demands of the automotive industry.</p>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-12">
                <div class="bg-gray-800 p-6 rounded-lg shadow-lg">
                    <h3 class="text-2xl font-semibold text-yellow-400 mb-2">High-Quality Parts</h3>
                    <p class="text-gray-300">Our parts are sourced from trusted manufacturers, ensuring durability and reliability for every application.</p>
                </div>
                <div class="bg-gray-800 p-6 rounded-lg shadow-lg">
                    <h3 class="text-2xl font-semibold text-yellow-400 mb-2">Efficient Inventory Management</h3>
                    <p class="text-gray-300">Our streamlined inventory process guarantees timely delivery, reducing downtime and enhancing efficiency.</p>
                </div>
                <div class="bg-gray-800 p-6 rounded-lg shadow-lg">
                    <h3 class="text-2xl font-semibold text-yellow-400 mb-2">Partner-Focused Service</h3>
                    <p class="text-gray-300">We work closely with our partners to provide personalized support that aligns with their business goals.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- About Us Section -->
    <section id="about" class="py-20 px-8 bg-gray-900">
        <div class="container mx-auto flex flex-col lg:flex-row items-center lg:space-x-12">
            <img src="{{ asset('frontend/assets/images/about-image.jpg') }}" alt="About Us" class="w-full lg:w-1/2 rounded-lg shadow-lg mb-8 lg:mb-0">
            <div class="w-full lg:w-1/2 text-gray-300">
                <h2 class="text-4xl font-bold text-yellow-500 mb-6">About Us</h2>
                <p class="mb-6">
                    PT. My Spare Parts Company partners with distributors to supply high-quality vehicle spare parts for retail workshops. We focus on enhancing operational efficiency and customer satisfaction by providing reliable products to support the automotive industry.
                </p>
                <p>
                    Our goal is to overcome inventory management challenges and support the growth and success of retail workshops across the region.
                </p>
            </div>
        </div>
    </section>

    <!-- Contact Section -->
    <section id="contact" class="py-20 bg-gray-800">
        <div class="container mx-auto flex flex-col lg:flex-row lg:space-x-8">
            <!-- Map -->
            <div class="w-full lg:w-1/2 h-96 mb-8 lg:mb-0">
                <iframe 
                    src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d253840.69768053792!2d107.49774950365745!3d-6.914867842760575!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e68e64ef52fcf77%3A0xb0b119de37b4400!2sInstitut%20Teknologi%20Bandung!5e0!3m2!1sen!2sid!4v1638283944007!5m2!1sen!2sid" 
                    class="w-full h-full border-0 rounded-lg shadow-lg" 
                    allowfullscreen="" 
                    loading="lazy"></iframe>
            </div>
            <!-- Contact Form -->
            <div class="w-full lg:w-1/2 bg-gray-700 p-8 rounded-lg shadow-lg">
                <h3 class="text-3xl font-semibold text-yellow-400 mb-6">Get in Touch</h3>
                <form>
                    <div class="mb-4">
                        <input type="text" placeholder="Name" class="w-full p-3 rounded-lg bg-gray-800 border border-gray-600 text-gray-100 focus:border-yellow-500" required>
                    </div>
                    <div class="mb-4">
                        <input type="email" placeholder="Email" class="w-full p-3 rounded-lg bg-gray-800 border border-gray-600 text-gray-100 focus:border-yellow-500" required>
                    </div>
                    <div class="mb-4">
                        <input type="text" placeholder="Phone Number" class="w-full p-3 rounded-lg bg-gray-800 border border-gray-600 text-gray-100 focus:border-yellow-500" required>
                    </div>
                    <button type="submit" class="w-full bg-yellow-500 text-gray-900 py-3 rounded-lg font-semibold hover:bg-yellow-400">Send Message</button>
                </form>
            </div>
        </div>
    </section>


    <!-- JavaScript for Slideshow -->
    <script>
        // JavaScript for slideshow effect
        let currentSlide = 0;
        const slides = document.querySelectorAll('.slideshow-image');
        const totalSlides = slides.length;

        function showNextSlide() {
            // Hide current slide
            slides[currentSlide].classList.remove('opacity-100');
            slides[currentSlide].classList.add('opacity-0');

            // Move to next slide
            currentSlide = (currentSlide + 1) % totalSlides;

            // Show next slide
            slides[currentSlide].classList.remove('opacity-0');
            slides[currentSlide].classList.add('opacity-100');
        }

        // Set interval for slideshow transition
        setInterval(showNextSlide, 4000);
    </script>

    <!-- Footer -->
    <footer class="bg-gray-900 py-6 text-center text-gray-500">
        <div class="container mx-auto">
            <p>&copy; 2023 PT. My Spare Parts Company. All rights reserved.</p>
            <div class="flex justify-center space-x-6 mt-4">
                <a href="#" class="hover:text-yellow-500">Facebook</a>
                <a href="#" class="hover:text-yellow-500">Twitter</a>
                <a href="#" class="hover:text-yellow-500">Instagram</a>
            </div>
        </div>
    </footer>

</body>
</html>
