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
    .liquid-btn-effect {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.3), transparent);
        transition: all 0.6s ease;
    }
    
    a:hover .liquid-btn-effect {
        left: 100%;
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
    position: static;
    transform: none;
    justify-content: center;
    margin-top: 1rem;
}

.carousel-btn-prev,
.carousel-btn-next {
    background: white;
    border: 2px solid #047705;
    border-radius: 50%;
    width: 50px;
    height: 50px;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: all 0.3s ease;
    box-shadow: 0 2px 8px rgba(4, 119, 5, 0.2);
}

.carousel-btn-prev:hover,
.carousel-btn-next:hover {
    background: #047705;
    transform: scale(1.05);
}

.carousel-btn-prev:hover svg,
.carousel-btn-next:hover svg {
    stroke: white;
}

.carousel-indicators {
    display: flex;
    justify-content: center;
    margin-top: 15px;
    gap: 8px;
}
  
.carousel-indicator {
    width: 12px;
    height: 12px;
    border-radius: 50%;
    background: #e0e0e0;
    cursor: pointer;
    transition: all 0.3s ease;
}

.carousel-indicator.active {
    background: #047705;
    transform: scale(1.2);
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
        
    <!-- Button Container - positioned absolutely like other elements -->
    <div class="absolute flex gap-6 z-50 animated-img" style="top: 65%; transform: translateY(-50%);">
        <!-- Login Button with liquid effect -->
        <a href="{{ route('web.login') }}"
        class="flex items-center justify-center px-8 py-3 rounded-full font-[Inria Sans] text-white relative overflow-hidden transition-all duration-400"
        style="background: linear-gradient(90deg, #047705 0%, #0aad0a 100%); box-shadow: 0 4px 15px rgba(4, 119, 5, 0.4);">
            <span class="relative z-10 flex items-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd" />
                </svg>
                Login Account
            </span>
            <span class="liquid-btn-effect"></span>
        </a>
        
        <!-- Shop Now Button with liquid effect -->
        <a href="{{ route('web.items') }}"
        class="flex items-center justify-center px-8 py-3 rounded-full font-[Inria Sans] text-[#047705] bg-white border-2 border-[#ffffff] relative overflow-hidden transition-all duration-400 hover:bg-gray-50"
        style="box-shadow: 0 4px 15px rgba(4, 119, 5, 0.2);">
            <span class="relative z-10 flex items-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                    <path d="M3 1a1 1 0 000 2h1.22l.305 1.222a.997.997 0 00.01.042l1.358 5.43-.893.892C3.74 11.846 4.632 14 6.414 14H15a1 1 0 000-2H6.414l1-1H14a1 1 0 00.894-.553l3-6A1 1 0 0017 3H6.28l-.31-1.243A1 1 0 005 1H3zM16 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0zM6.5 18a1.5 1.5 0 100-3 1.5 1.5 0 000 3z" />
                </svg>
                Shop Now
            </span>
            <span class="liquid-btn-effect" style="background: linear-gradient(90deg, transparent, rgba(4, 119, 5, 0.1), transparent);"></span>
        </a>
    </div>
            
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
                
                <!-- Slide 2 - PE Uniform -->
                <div class="carousel-item flex gap-20 group">
                  <!-- LEFT CARD -->
                  <div class="w-[40%] bg-white rounded-[20px] p-4 flex flex-col items-center relative overflow-hidden " style="box-shadow: 0px 4px 10px 0px rgba(0, 0, 0, 0.25);">
                        <!-- Main Image -->
                        <img src="/images/clothes/womensunif.png" alt="PE Clothes" 
                            class="w-full rounded-[20px] object-cover transition-opacity duration-500 group-hover:opacity-20">
                        
                        <!-- Hover Image -->
                        <img src="/images/clothes/franz.PNG" alt="PE Clothes Alternate View" 
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

                <!-- Slide 3 - PE Uniform -->
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
            </div>
            
            <!-- Indicators -->
            <div class="carousel-indicators" id="carouselIndicators">
                <span class="carousel-indicator active" data-index="0"></span>
                <span class="carousel-indicator" data-index="1"></span>
                <span class="carousel-indicator" data-index="2"></span>
            </div>
            
            <!-- Navigation Buttons - Now below indicators -->
            <div class="flex justify-center items-center gap-8 mt-4">
                <button class="carousel-btn-prev" id="prevBtn">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="#047705">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                    </svg>
                </button>
                <button class="carousel-btn-next" id="nextBtn">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="#047705">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                </button>
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