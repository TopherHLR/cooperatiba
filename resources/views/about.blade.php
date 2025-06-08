@extends('layouts.sharedlayout')

@section('title', 'About')

@section('styles')
<style>
    /* Import Kalam and Jost fonts from Google Fonts */
    @import url('https://fonts.googleapis.com/css2?family=Kalam:wght@300;400;700&family=Jost:ital,wght@0,100..900;1,100..900&display=swap');
    
    /* Apply fonts */
    body, p, ul, li, a:not(.navbar-brand), button {
        font-family: 'Jost', sans-serif;
    }
    
    .kalam-font {
        font-family: 'Kalam', cursive;
    }
        /* Liquid UI Background Effects */
    body {
        background: linear-gradient(135deg, #1F1E1E 0%, #001C00 100%);
        min-height: 100vh;
        font-family: 'Inria Sans', sans-serif;
        overflow-x: hidden;
    }
        
    .liquid-card {
        position: relative;
        overflow: hidden;
        border-radius: 15px;
        backdrop-filter: blur(10px);
        background: rgba(31, 30, 30, 0.7);
        box-shadow: 0 8px 32px rgba(0, 28, 0, 0.3);
        transition: all 0.5s ease;
    }
    
    .liquid-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: linear-gradient(
            45deg,
            rgba(4, 119, 5, 0.1) 0%,
            rgba(237, 209, 0, 0.1) 50%,
            rgba(4, 119, 5, 0.1) 100%
        );
        animation: cardShine 8s ease infinite;
        z-index: -1;
    }
        @keyframes cardShine {
        0% { opacity: 0.3; }
        50% { opacity: 0.1; }
        100% { opacity: 0.3; }
    }
    /* Main content background */
    .content-section {
        padding-top: 100px;
    }
    
    /* Container styling based on notification theme */
    .gradient-container {
        border: 0.5px solid white;
        box-shadow: 0 4px 30px rgba(0, 0, 0, 0.4);
        border-radius: 15px;
        padding: 30px;
        backdrop-filter: blur(10px);
        margin-bottom: 40px;
    }
    
    .section-header {
        display: flex;
        align-items: center;
        margin-bottom: 20px;
    }
    
    .section-title {
        font-size: 2rem;
        font-weight: bold;
        color: white;
        display: flex;
        align-items: center;
        text-shadow: -2px 1px 0px #047705;
    }
    
    .section-icon {
        height: 40px;
        width: 40px;
        margin-right: 15px;
        color: white;
    }
    
    .divider {
        border-top: 0.5px solid white;
        margin: 20px -30px;
    }
    
    /* About content styling */
    .about-content {
        color: white;
        line-height: 1.8;
        font-size: 1.1rem;
    }
    
    .highlight {
        color: #EDD100;
        font-weight: 500;
    }
    
    /* Team section */
    .team-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
        gap: 25px;
        margin-top: 30px;
    }
    
    .team-card {
        background: rgba(31, 30, 30, 0.7);
        border-radius: 15px;
        padding: 20px;
        border: 0.5px solid rgba(255, 255, 255, 0.2);
        transition: all 0.3s ease;
    }
    
    .team-card:hover {
        transform: translateY(-5px);
        background: rgba(0, 28, 0, 0.4);
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.3);
    }
    
    .member-image {
        width: 100%;
        height: 250px;
        object-fit: cover;
        border-radius: 15px;
        margin-bottom: 15px;
        border: 1px solid rgba(4, 119, 5, 0.5);
    }
    
    .member-name {
        font-size: 1.3rem;
        font-weight: 600;
        color: #EDD100;
        margin-bottom: 5px;
    }
    
    .member-role {
        font-size: 0.9rem;
        color: #047705;
        margin-bottom: 15px;
        font-weight: 500;
    }
    
    .member-bio {
        font-size: 0.95rem;
        color: rgba(255, 255, 255, 0.8);
        margin-bottom: 15px;
    }
    
    .social-links {
        display: flex;
        gap: 15px;
    }
    
    .social-link {
        color: white;
        transition: color 0.3s ease;
    }
    
    .social-link:hover {
        color: #047705;
    }
    
    /* Stats section */
    .stats-container {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 20px;
        margin-top: 30px;
    }
    
    .stat-card {
        background: rgba(31, 30, 30, 0.7);
        border-radius: 15px;
        padding: 20px;
        text-align: center;
        border: 0.5px solid rgba(255, 255, 255, 0.2);
    }
    
    .stat-number {
        font-size: 2.5rem;
        font-weight: 700;
        color: #EDD100;
        margin-bottom: 5px;
    }
    
    .stat-label {
        font-size: 1rem;
        color: white;
    }
    .team-carousel-container {
        position: relative;
        max-width: 1200px;
        margin: 0 auto;
        padding: 0 40px;
    }

    .team-carousel {
        display: flex;
        overflow-x: auto;
        scroll-snap-type: x mandatory;
        scroll-behavior: smooth;
        -webkit-overflow-scrolling: touch;
        gap: 20px;
        padding: 20px 0;
        scrollbar-width: none; /* Hide scrollbar for Firefox */
    }

    .team-carousel::-webkit-scrollbar {
        display: none; /* Hide scrollbar for Chrome/Safari */
    }

    .team-card {
        flex: 0 0 calc(33.333% - 20px);
        scroll-snap-align: start;
        transition: transform 0.3s ease;
    }
    /* Navigation Buttons */
    .carousel-button {
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
        margin-top: 15px;
    }

    .carousel-button:hover {
        background: #047705;
        transform: scale(1.05);
    }

    .carousel-button:hover svg {
        stroke: white;
    }

    .carousel-button svg {
        width: 24px;
        height: 24px;
        stroke: #047705;
        transition: stroke 0.3s ease;
    }

    .carousel-indicators {
        display: flex;
        justify-content: center;
        gap: 10px;
        margin-top: 20px;
    }

    .carousel-indicator {
        width: 12px;
        height: 12px;
        border-radius: 50%;
        background: #ccc;
        cursor: pointer;
        transition: background 0.3s ease;
    }

    .carousel-indicator.active {
        background: #333;
    }

    /* Responsive adjustments */
    @media (max-width: 900px) {
        .team-card {
            flex: 0 0 calc(50% - 15px);
        }
    }

    @media (max-width: 600px) {
        .team-card {
            flex: 0 0 100%;
        }
        
        .team-carousel-container {
            padding: 0 30px;
        }
    }
</style>
@endsection

@section('content')
<section class="content-section p-11">
    <div  class="bg-gradient-to-r from-[#1F1E1E]/100 to-[#100E00]/80 border-[.5px] border-white shadow-lg shadow-[#000000]/40 rounded-[15px] p-6 w-[100%] mt-8 mb-10 h-full backdrop-blur-sm flex flex-col">
        <!-- About Section -->
        <div class="liquid-card gradient-container ">
            <div class="section-header">
                <svg xmlns="http://www.w3.org/2000/svg" class="section-icon" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <h2 class="section-title kalam-font">ABOUT COOPERATIBA</h2>
            </div>
            <hr class="divider">
            
            <div class="about-content">
                <p>Welcome to <span class="highlight">Cooperatiba</span>, your trusted cooperative dedicated to delivering smooth and fast transactions for students. Established in 2025, we are driven by a mission to provide high-quality uniforms that are accessible, affordable, and tailored to meet the needs of the academic community.</p>
                
                <p>Our <span class="highlight">team</span>, is committed to ensuring efficient operations and delivering exceptional service to our members. We understand the importance of convenience in today’s fast-paced environment, and we strive to make your uniform purchasing experience as seamless as possible.</p>
                
                <p>What sets Cooperatiba apart is our focus on <span class="highlight">speed, efficiency, and quality.</span>With a fair pricing policy and a dedication to member satisfaction, we’re not just a supplier—we’re an essential part of your academic journey, helping you get ready to succeed.</p>
            </div>
            
            <!-- Stats -->
            <div class="stats-container">
                <div class="stat-card">
                    <div class="stat-number">00</div>
                    <div class="stat-label">Satisfied Customers</div>
                </div>
                <div class="stat-card">
                    <div class="stat-number">1</div>
                    <div class="stat-label">Quality Products</div>
                </div>
                <div class="stat-card">
                    <div class="stat-number">2025</div>
                    <div class="stat-label">Established Since</div>
                </div>
                <div class="stat-card">
                    <div class="stat-number">8 A.M. - 5 P.M.</div>
                    <div class="stat-label">Member Support</div>
                </div>
            </div>
        </div>
        <!-- Mission Section -->
        <div class=" liquid-card gradient-container">
            <div class="section-header">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="section-icon">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 3v1.5M3 21v-6m0 0 2.77-.693a9 9 0 0 1 6.208.682l.108.054a9 9 0 0 0 6.086.71l3.114-.732a48.524 48.524 0 0 1-.005-10.499l-3.11.732a9 9 0 0 1-6.085-.711l-.108-.054a9 9 0 0 0-6.208-.682L3 4.5M3 15V4.5" />
                </svg>
                <h2 class="section-title kalam-font">OUR MISSION</h2>
            </div>
            <hr class="divider">
            
            <div class="about-content">
                <p>At <span class="highlight">Cooperatiba</span>, our mission is twofold:</p>
                
                <ul class="space-y-4 mt-4">
                    <li class="flex items-start">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-[#047705] mr-2 mt-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                        <span>To provide <span class="highlight">high-quality academic essentials</span> at student-friendly prices through cooperative economics</span>
                    </li>
                    <li class="flex items-start">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-[#047705] mr-2 mt-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                        <span>To simplify <span class="highlight">the uniform-buying process</span>, reducing the hassle of physical shopping</span>
                    </li>
                </ul>
                
                <p class="mt-6">We believe that "by students, for students" is more than just a motto—it’s the foundation of everything we do. While speed is at the heart of our service, we remain committed to delivering the quality you can trust.</p>
            </div>
        </div>
        <!-- Team Section -->
        <div class="liquid-card gradient-container">
            <div class="section-header">
                <svg xmlns="http://www.w3.org/2000/svg" class="section-icon" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                </svg>
                <h2 class="section-title kalam-font">OUR TEAM</h2>
            </div>
            <hr class="divider">
            
            <div class="team-carousel-container">          
                <div class="team-carousel">
                    <!-- Team Member 1 -->
                    <div class="team-card">
                        <img src="/images/team/topher.png" alt="Christopher Hilairon" class="member-image">
                        <h3 class="member-name">Christopher Hilairon</h3>
                        <p class="member-role">Programmer</p>
                        <p class="member-bio">Designs and develops system functionalities, ensuring seamless performance across all platforms.</p>
                        <div class="social-links">
                            <a href="https://www.facebook.com/topher.hilairon.2024/" class="social-link"><i class="fab fa-facebook-f"></i></a>
                            <a href="#" class="social-link"><i class="fab fa-twitter"></i></a>
                            <a href="#" class="social-link"><i class="fab fa-instagram"></i></a>
                            <a href="#" class="social-link"><i class="fab fa-linkedin-in"></i></a>
                        </div>
                    </div>

                    <!-- Team Member 2 -->
                    <div class="team-card">
                        <img src="/images/team/franz.jpg" alt="Franz Abad" class="member-image">
                        <h3 class="member-name">Franz Abad</h3>
                        <p class="member-role">Technical Writer</p>
                        <p class="member-bio">Documents technical processes and creates user-friendly guides to ensure clarity and consistency.</p>
                        <div class="social-links">
                            <a href="https://www.facebook.com/franzdianneabad" class="social-link"><i class="fab fa-facebook-f"></i></a>
                            <a href="#" class="social-link"><i class="fab fa-twitter"></i></a>
                            <a href="#" class="social-link"><i class="fab fa-instagram"></i></a>
                            <a href="#" class="social-link"><i class="fab fa-linkedin-in"></i></a>
                        </div>
                    </div>

                    <!-- Team Member 3 -->
                    <div class="team-card">
                        <img src="/images/team/kurt.jpg" alt="Kurt Virina" class="member-image">
                        <h3 class="member-name">Kurt Virina</h3>
                        <p class="member-role">Project Manager</p>
                        <p class="member-bio">Leads the planning and execution of projects, ensuring goals are met on time and within scope.</p>
                        <div class="social-links">
                            <a href="https://www.facebook.com/100020702175369/" class="social-link"><i class="fab fa-facebook-f"></i></a>
                            <a href="#" class="social-link"><i class="fab fa-twitter"></i></a>
                            <a href="#" class="social-link"><i class="fab fa-instagram"></i></a>
                            <a href="#" class="social-link"><i class="fab fa-linkedin-in"></i></a>
                        </div>
                    </div>

                    <!-- Team Member 4 -->
                    <div class="team-card">
                        <img src="/images/team/randel.jpg" alt="Randel Hernandez" class="member-image">
                        <h3 class="member-name">Randel Hernandez</h3>
                        <p class="member-role">System Analyst</p>
                        <p class="member-bio">Analyzes system requirements and bridges the gap between technical teams and business goals.</p>
                        <div class="social-links">
                            <a href="https://www.facebook.com/100061279010860/" class="social-link"><i class="fab fa-facebook-f"></i></a>
                            <a href="#" class="social-link"><i class="fab fa-twitter"></i></a>
                            <a href="#" class="social-link"><i class="fab fa-instagram"></i></a>
                            <a href="#" class="social-link"><i class="fab fa-linkedin-in"></i></a>
                        </div>
                    </div>

                    <!-- Team Member 5 -->
                    <div class="team-card">
                        <img src="/images/team/cholo.jpg" alt="Cholo Belen" class="member-image">
                        <h3 class="member-name">Cholo Belen</h3>
                        <p class="member-role">Tester</p>
                        <p class="member-bio">Conducts rigorous testing to identify bugs and ensure the system meets quality standards.</p>
                        <div class="social-links">
                            <a href="https://www.facebook.com/profile.php?id=100008716783216" class="social-link"><i class="fab fa-facebook-f"></i></a>
                            <a href="#" class="social-link"><i class="fab fa-twitter"></i></a>
                            <a href="#" class="social-link"><i class="fab fa-instagram"></i></a>
                            <a href="#" class="social-link"><i class="fab fa-linkedin-in"></i></a>
                        </div>
                    </div>

                    <!-- Team Member 6 -->
                    <div class="team-card">
                        <img src="/images/team/lance.jpg" alt="Lance Dimaliabot" class="member-image">
                        <h3 class="member-name">Lance Dimaliabot</h3>
                        <p class="member-role">Tester</p>
                        <p class="member-bio">Validates product functionality and collaborates with developers to ensure optimal performance.</p>
                        <div class="social-links">
                            <a href="https://www.facebook.com/kenneth.dimalibot.528" class="social-link"><i class="fab fa-facebook-f"></i></a>
                            <a href="#" class="social-link"><i class="fab fa-twitter"></i></a>
                            <a href="#" class="social-link"><i class="fab fa-instagram"></i></a>
                            <a href="#" class="social-link"><i class="fab fa-linkedin-in"></i></a>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="carousel-indicators">
                <!-- Indicators will be added by JavaScript or manually -->
            </div>
            <!-- Navigation Buttons - Now below indicators -->
            <div class="flex justify-center items-center gap-8 mt-4">
                <button class="carousel-button prev" id="prevBtn">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="#047705">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                    </svg>
                </button>
                <button class="carousel-button next" id="nextBtn">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="#047705">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

</section>

<!-- Font Awesome for social icons -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
<script>
document.addEventListener('DOMContentLoaded', function() {
    const carousel = document.querySelector('.team-carousel');
    const cards = document.querySelectorAll('.team-card');
    const prevBtn = document.querySelector('.carousel-button.prev');
    const nextBtn = document.querySelector('.carousel-button.next');
    const indicatorsContainer = document.querySelector('.carousel-indicators');
    
    let currentIndex = 0;
    const cardCount = cards.length;
    
    // Create indicators
    cards.forEach((_, index) => {
        const indicator = document.createElement('div');
        indicator.classList.add('carousel-indicator');
        if (index === 0) indicator.classList.add('active');
        indicator.addEventListener('click', () => goToSlide(index));
        indicatorsContainer.appendChild(indicator);
    });
    
    // Update indicators
    function updateIndicators() {
        const indicators = document.querySelectorAll('.carousel-indicator');
        indicators.forEach((indicator, index) => {
            if (index === currentIndex) {
                indicator.classList.add('active');
            } else {
                indicator.classList.remove('active');
            }
        });
    }
    
    // Go to specific slide
    function goToSlide(index) {
        currentIndex = index;
        const cardWidth = cards[0].offsetWidth + 20; // including gap
        carousel.scrollTo({
            left: cardWidth * index,
            behavior: 'smooth'
        });
        updateIndicators();
    }
    
    // Next slide
    function nextSlide() {
        currentIndex = (currentIndex + 2) % cardCount;
        goToSlide(currentIndex);
    }
    
    // Previous slide
    function prevSlide() {
        currentIndex = (currentIndex - 2 + cardCount) % cardCount;
        goToSlide(currentIndex);
    }
    
    // Event listeners
    prevBtn.addEventListener('click', prevSlide);
    nextBtn.addEventListener('click', nextSlide);
    
    // Auto-advance (optional)
    // let autoSlide = setInterval(nextSlide, 5000);
    
    // Pause on hover
    carousel.addEventListener('mouseenter', () => {
        // clearInterval(autoSlide);
    });
    
    carousel.addEventListener('mouseleave', () => {
        // autoSlide = setInterval(nextSlide, 5000);
    });
    
    // Handle window resize
    window.addEventListener('resize', () => {
        goToSlide(currentIndex);
    });
});
</script>
@endsection