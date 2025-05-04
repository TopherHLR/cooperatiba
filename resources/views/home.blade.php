@extends('layouts.sharedlayout')

@section('title', 'Homepage')

@section('styles')
<style>
      /* Import Jost font from Google Fonts */
      @import url('https://fonts.googleapis.com/css2?family=Jost:ital,wght@0,100..900;1,100..900&display=swap');
    
    /* Apply Jost to all regular text elements */
    body, 
    p,
    ul, 
    li,
    a:not(.navbar-brand), /* Exclude specific elements if needed */
    button,
    .text-gray-800, /* Targeting your carousel text specifically */
    .carousel-item p,
    .carousel-item ul,
    .carousel-item li {
      font-family: 'Jost', sans-serif;
    }

    /* Preserveyour existing special fonts */
    .navbar-brand, /* Your COOPERATIBA logo text */
    h1, h2, h3, h4, h5, h6 /* Headings keep their original font */ {
      font-family: inherit; /* This maintains their existing font */
    }
  .animated-img,
  .animated-unif {
    position: absolute;
    transition: top 1s ease, opacity 1s ease;
    top: 80%;
    opacity: 0;
    visibility: hidden;
  }

  .animate-top { top: 0%; opacity: 1; visibility: visible; }
  .animate-middle { top: 15%; opacity: 1; visibility: visible; }
  .animate-middle2 { top: 30%; opacity: 1; visibility: visible; }
  .animate-clearer { top: 45%; opacity: 1; visibility: visible; }
  .animate-clear { top: 60%; opacity: 1; visibility: visible; }
  .animate-btn { top: 55%; opacity: 1; visibility: visible; }
  .animate-unif2 { top: 10%; opacity: 1; visibility: visible; }

  /* Responsive handling for image scaling */
  img.img-fluid {
    width: 100%;
    height: auto;
    max-width: 100%;
  }

  /* Carousel Styles */
  .carousel-container {
    position: relative;
    width: 100%;
    overflow: hidden; 
  }
  
  .carousel-slide {
    display: flex;
    transition: transform 0.5s ease;
    width: 100%;
  }
  
  .carousel-item {
    min-width: 100%;
    box-sizing: border-box;
  }
  
  .carousel-nav {
  position: absolute;
  top: 50%;
  width: 100%;
  display: flex;
  justify-content: space-between;
  transform: translateY(-50%);
  z-index: 60;
  box-sizing: border-box;
}

.carousel-btn {
  background: rgba(255, 255, 255, 0.7);
  border: none;
  border-radius: 50%;
  width: 40px;
  height: 40px;
  font-size: 20px;
  cursor: pointer;
  display: flex;
  align-items: center;
  justify-content: center;
  /* Adjust margin to create space from content */
  margin: 0 -20px;
  transition: background 0.3s;
  box-shadow: 0 2px 5px rgba(0,0,0,0.1);
}

  .carousel-btn:hover {
    background: rgba(255, 255, 255, 0.9);
    transform: scale(1.05);
  }
  
  .carousel-indicators {
    display: flex;
    justify-content: center;
    margin-top: 15px;
  }
  
  .carousel-indicator {
    width: 10px;
    height: 10px;
    border-radius: 50%;
    background: #ccc;
    margin: 0 5px;
    cursor: pointer;
  }
  
  .carousel-indicator.active {
    background: #047705;
  }
  
</style>
@endsection

@section('content')
<!-- ---------------------- HOMEPAGE / FADED BACKGROUND / WAVE TRANSITION ---------------------- -->
<section class="relative w-full bg-cover bg-center min-h-screen z-0" style="background-image: url('/images/homepage/homeBG.png'); margin-bottom: 1000px;">

    <!-- FADED BACKGROUND IMAGE with shadow effect on top -->
    <div class="absolute top-[85%] left-0 w-full h-[100vh] object-cover z-50 pointer-events-none" 
         style="background-image: url('/images/homepage/faded.png')">
    </div>

    <!-- MAIN IMAGE CONTENT (like Topher, blurry layers, etc) -->
    <div class="relative flex justify-center items-center w-full min-h-screen z-30" onmouseover="animateImages(); animateImages2();" onmouseleave="resetImages();">
        <img src="/images/homepage/malabo.png" alt="Malabo" class="img-fluid absolute z-10 animated-img" style="width:80%;">
        <img src="/images/homepage/medjmalabo.png" alt="Medyo Malabo" class="img-fluid absolute z-20 animated-img" style="width:80%;">
        <img src="/images/homepage/medjmalinaw.png" alt="Medyo Malinaw" class="img-fluid absolute z-30 animated-img" style="width:80%;">
        <img src="/images/homepage/medjmalinaw.png" alt="Medyo Malinaw" class="img-fluid absolute z-30 animated-img" style="width:80%;">
        <img src="/images/homepage/trio.png" alt="Trio" class="img-fluid absolute z-40 animated-unif" style="width:55%;">
        <a href="{{ route('web.login') }}"
                          class="inline-block mt-4 animated-img text-white px-6 py-2 rounded-[20px] hover:brightness-110 transition font-[Inria Sans] bg-[#047705] hover:bg-[#036603] z-50 ">
                          Login Account
        </a>
        <img src="/images/homepage/malinaw.png" alt="Malinaw" class="img-fluid absolute z-40 animated-img" style="width:80%;">
    </div>

    <!-- CAROUSEL CONTAINER ON TOP OF THE WAVE -->
    <div class="absolute top-[130%]  left-1/2 transform -translate-x-1/2 w-11/12 max-w-6xl  z-50">
        <div class="carousel-container ">
            <div class="carousel-slide" id="carouselSlide">
                <!-- Slide 1 - PE Uniform -->
                <div class="carousel-item flex gap-20 group">
                  <!-- LEFT CARD -->
                  <div class="w-[40%] bg-white rounded-[20px] p-4 flex flex-col items-center relative overflow-hidden " style="box-shadow: 0px 4px 10px 0px rgba(0, 0, 0, 0.25);">
                        <!-- Main Image -->
                        <img src="/images/clothes/pe.png" alt="PE Clothes" 
                            class="w-full rounded-[20px] object-cover transition-opacity duration-500 group-hover:opacity-20">
                        
                        <!-- Hover Image -->
                        <img src="/images/clothes/kurt.PNG" alt="PE Clothes Alternate View" 
                            class="absolute inset-0 w-full h-full rounded-[20px] object-cover opacity-0 transition-opacity duration-500 group-hover:opacity-100 p-2">
                        
                        <a href="{{ route('web.items') }}"
                          class="inline-block mt-4 text-white px-6 py-2 rounded-[20px] hover:brightness-110 transition font-[Inria Sans] bg-[#047705] hover:bg-[#036603] z-10 relative">
                          Order Now
                        </a>
                    </div>

                    <!-- RIGHT DESCRIPTION -->
                    <div class="w-[60%] pl-8 flex flex-col justify-center text-gray-800 text-[17px] leading-relaxed">
                        <h2 class="text-3xl font-bold mb-4">PE Uniform</h2>
                        <p class="mb-4 font-semibold">
                            Elevate Your Game with Our Premium PE Uniform!
                        </p>
                        <p class="mb-4">
                            Get ready to move in style and comfort with our official PE uniform—designed for performance, durability, and school spirit! Featuring a sleek white base for a clean, professional look and bold green sleeves that showcase energy and enthusiasm, this uniform is made to keep you feeling fresh and confident during every activity.
                        </p>
                        <ul class="list-disc list-inside mb-4">
                            <li><span class="font-medium">Perfect Fit</span> – Designed for movement and flexibility.</li>
                            <li><span class="font-medium">Durable Fabric</span> – Built to last through every game and training session.</li>
                            <li><span class="font-medium">Breathable & Lightweight</span> – Stay cool and comfortable during workouts.</li>
                        </ul>
                        <p class="font-semibold">
                            Gear up with the best—because your performance deserves the best uniform! Order yours today!
                        </p>
                    </div>
                </div>
                
                <!-- Slide 2 - School Uniform (example) -->
                <div class="carousel-item flex gap-20">
                    <!-- LEFT CARD -->
                    <div class="w-[40%] bg-white rounded-[20px] p-4 flex flex-col items-center" style="box-shadow: 0px 4px 10px 0px rgba(0, 0, 0, 0.25);">
                        <img src="/images/clothes/school-uniform.png" alt="School Uniform" class="w-full rounded-[20px] object-cover">
                        <button 
                            class="mt-4 text-white px-6 py-2 rounded-[20px] hover:brightness-110 transition font-[Inria Sans]" 
                            style="background-color: #047705;">
                            Order Now
                        </button>
                    </div>

                    <!-- RIGHT DESCRIPTION -->
                    <div class="w-[60%] pl-8 flex flex-col justify-center text-gray-800 text-[17px] leading-relaxed">
                        <h2 class="text-3xl font-bold mb-4">School Uniform</h2>
                        <p class="mb-4 font-semibold">
                            Professional Look for Academic Excellence!
                        </p>
                        <p class="mb-4">
                            Our official school uniform combines tradition with modern comfort. The crisp white shirt and tailored bottoms create a polished appearance while allowing for all-day comfort during classes and activities.
                        </p>
                        <ul class="list-disc list-inside mb-4">
                            <li><span class="font-medium">Premium Cotton Blend</span> – Soft, breathable, and easy to care for.</li>
                            <li><span class="font-medium">Classic Design</span> – Timeless style that meets school requirements.</li>
                            <li><span class="font-medium">Comfortable Fit</span> – Designed for sitting through long classes.</li>
                        </ul>
                        <p class="font-semibold">
                            Dress for success with our high-quality school uniforms!
                        </p>
                    </div>
                </div>
                
                <!-- Slide 3 - Lab Gown (example) -->
                <div class="carousel-item flex gap-20">
                    <!-- LEFT CARD -->
                    <div class="w-[40%] bg-white rounded-[20px] p-4 flex flex-col items-center" style="box-shadow: 0px 4px 10px 0px rgba(0, 0, 0, 0.25);">
                        <img src="/images/clothes/lab-gown.png" alt="Lab Gown" class="w-full rounded-[20px] object-cover">
                        <button 
                            class="mt-4 text-white px-6 py-2 rounded-[20px] hover:brightness-110 transition font-[Inria Sans]" 
                            style="background-color: #047705;">
                            Order Now
                        </button>
                    </div>

                    <!-- RIGHT DESCRIPTION -->
                    <div class="w-[60%] pl-8 flex flex-col justify-center text-gray-800 text-[17px] leading-relaxed">
                        <h2 class="text-3xl font-bold mb-4">Lab Gown</h2>
                        <p class="mb-4 font-semibold">
                            Safety and Professionalism for Science Classes!
                        </p>
                        <p class="mb-4">
                            Our durable lab gowns provide protection during science experiments while maintaining a professional appearance. The full-length design with secure closures ensures safety in the laboratory environment.
                        </p>
                        <ul class="list-disc list-inside mb-4">
                            <li><span class="font-medium">Protective Material</span> – Resistant to common lab chemicals.</li>
                            <li><span class="font-medium">Functional Design</span> – Pockets for tools and secure fastenings.</li>
                            <li><span class="font-medium">Easy to Clean</span> – Withstands frequent washing.</li>
                        </ul>
                        <p class="font-semibold">
                            Stay safe and look professional in our high-quality lab gowns!
                        </p>
                    </div>
                </div>
            </div>
            
            <!-- Navigation Buttons -->
            <div class="carousel-nav ">
                <button class="carousel-btn" id="prevBtn">&#10094;</button>
                <button class="carousel-btn" id="nextBtn">&#10095;</button>
            </div>
            
            <!-- Indicators -->
            <div class="carousel-indicators" id="carouselIndicators">
                <span class="carousel-indicator active" data-index="0"></span>
                <span class="carousel-indicator" data-index="1"></span>
                <span class="carousel-indicator" data-index="2"></span>
            </div>
        </div>
    </div>

    <!-- WAVE TRANSITION IMAGE -->
    <img src="/images/homepage/wave.png"
         alt="Wave Transition"
         class="absolute bottom-[-25%] left-0 w-full z-50 pointer-events-none" />

</section>
@endsection

@section('scripts')
<script>
    // Image animation functions
    function animateImages() {
        const images = document.querySelectorAll('.animated-img');
        images[0].classList.add('animate-top');
        images[1].classList.add('animate-middle');
        images[2].classList.add('animate-middle2');
        images[3].classList.add('animate-clearer');
        images[4].classList.add('animate-clear');
        images[5].classList.add('animate-btn');
    }
    
    function animateImages2() {
        const images = document.querySelectorAll('.animated-unif');
        images[0].classList.add('animate-unif2');
    }
    
    function resetImages() {
        const images = document.querySelectorAll('.animated-img');
        images[0].classList.remove('animate-top');
        images[1].classList.remove('animate-middle');
        images[2].classList.remove('animate-middle2');
        images[3].classList.remove('animate-clearer');
        images[4].classList.remove('animate-clear');
        images[5].classList.remove('animate-btn');

        const unif = document.querySelectorAll('.animated-unif');
        unif[0].classList.remove('animate-unif2');
    }

    // Carousel functionality
    document.addEventListener('DOMContentLoaded', function() {
        const slide = document.getElementById('carouselSlide');
        const items = document.querySelectorAll('.carousel-item');
        const prevBtn = document.getElementById('prevBtn');
        const nextBtn = document.getElementById('nextBtn');
        const indicators = document.querySelectorAll('.carousel-indicator');
        const carouselContainer = document.querySelector('.carousel-container');
        
        let currentIndex = 0;
        const totalItems = items.length;
        let autoplayInterval;
        const autoplaySpeed = 3000; // 2seconds
        
        function updateCarousel() {
            slide.style.transform = `translateX(-${currentIndex * 100}%)`;
            
            // Update indicators
            indicators.forEach((indicator, index) => {
                if (index === currentIndex) {
                    indicator.classList.add('active');
                } else {
                    indicator.classList.remove('active');
                }
            });
        }
        
        function nextSlide() {
            currentIndex = (currentIndex + 1) % totalItems;
            updateCarousel();
        }
        
        function prevSlide() {
            currentIndex = (currentIndex - 1 + totalItems) % totalItems;
            updateCarousel();
        }
        
        function startAutoplay() {
            autoplayInterval = setInterval(nextSlide, autoplaySpeed);
        }
        
        function stopAutoplay() {
            clearInterval(autoplayInterval);
        }
        
        // Button events
        nextBtn.addEventListener('click', () => {
            nextSlide();
            stopAutoplay();
        });
        
        prevBtn.addEventListener('click', () => {
            prevSlide();
            stopAutoplay();
        });
        
        // Indicator events
        indicators.forEach(indicator => {
            indicator.addEventListener('click', function() {
                currentIndex = parseInt(this.getAttribute('data-index'));
                updateCarousel();
                stopAutoplay();
            });
        });
        
        // Start autoplay initially
        startAutoplay();
        
        // Pause on hover
        carouselContainer.addEventListener('mouseenter', stopAutoplay);
        carouselContainer.addEventListener('mouseleave', startAutoplay);
        
        // Handle window resize
        window.addEventListener('resize', updateCarousel);
    });
</script>
@endsection