<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Homepage</title>
            <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Kalam:wght@400;700&display=swap" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />
    <script src="https://cdn.tailwindcss.com"></script>

</head>
<style>
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

  .animate-unif2 { top: 0%; opacity: 1; visibility: visible; }

  /* Responsive handling for image scaling */
  img.img-fluid {
    width: 100%;
    height: auto;
    max-width: 100%;
  }
</style>

<body>
    <!---------------------------------------------------- NAVIGATION BAR ---------------------------------------------------->
    <header>
        <nav class="fixed top-0 left-0 z-[100] w-[calc(100%-80px)] mx-10 mt-7 h-[70px] bg-gradient-to-r from-[#1F1E1E]/100 to-[#001C00]/10 border-[.5px] border-white rounded-[44px]">
            <div class="px-2 flex justify-between items-center h-full w-full">
                <!-- Left: Logo and Cooperatiba Text -->
                <div class="flex items-center">
                    <!-- Logo Image -->
                    <img src="/images/homepage/logo.png" alt="Logo" class="h-15 mt-1"> <!-- Adjust size with h-15 -->
                    <!-- Text -->
                    <a href="#" class="text-lg font-semibold text-white hover:text-[#047705] transition" style="font-family: 'Kalam', cursive; text-shadow: -2px 1px 0px #047705; padding-top: 5px;">
                        COOPERATIBA
                    </a>
                </div>

                <!-- Right: Buttons (example) -->
                <div class="flex items-center space-x-4 mr-5">
                    <a href="#" class="text-white hover:text-[#EDD100] transition" style="font-family: 'Inria Sans', sans-serif; font-weight: 300; text-shadow: -2px 2px 4px #000000; margin-right: 20px;">
                        Home
                    </a>
                    <a href="#" class="text-white hover:text-[#EDD100] transition" style="font-family: 'Inria Sans', sans-serif; font-weight: 300; text-shadow: -2px 2px 4px #000000; margin-right: 20px;">
                        Orders
                    </a>
                    <a href="#" class="text-white hover:text-[#EDD100] transition" style="font-family: 'Inria Sans', sans-serif; font-weight: 300; text-shadow: -2px 2px 4px #000000; margin-right: 20px;">
                        About
                    </a>
                    <a href="#" class="text-white hover:text-[#EDD100] transition" style="font-family: 'Inria Sans', sans-serif; font-weight: 300; text-shadow: -2px 2px 4px #000000; margin-right: 20px;">
                        Account
                    </a>

                </div>
            </div>   
        </nav>
    </header>

<!-- ---------------------- HOMEPAGE / FADED BACKGROUND / WAVE TRANSITION ---------------------- -->
<section class="relative w-full bg-cover bg-center  min-h-screen" style="background-image: url('/images/homepage/homeBG.png');">

   <!-- FADED BACKGROUND IMAGE with shadow effect on top -->
   <div class="absolute top-[85%] left-0 w-full h-[100vh] object-cover z-50 pointer-events-none" 
         style="background-image: url('/images/homepage/2ndBG.png')">
    </div>

    <!-- MAIN IMAGE CONTENT (like Topher, blurry layers, etc) -->
    <div class="relative flex justify-center items-center w-full min-h-screen z-30" onmouseover="animateImages(); animateImages2();" onmouseleave="resetImages();">
        <img src="/images/homepage/malabo.png" alt="Malabo" class="img-fluid absolute z-10 animated-img" style="width:80%;">
        <img src="/images/homepage/medjmalabo.png" alt="Medyo Malabo" class="img-fluid absolute z-20 animated-img" style="width:80%;">
        <img src="/images/homepage/medjmalinaw.png" alt="Medyo Malinaw" class="img-fluid absolute z-30 animated-img" style="width:80%;">
        <img src="/images/homepage/medjmalinaw.png" alt="Medyo Malinaw" class="img-fluid absolute z-30 animated-img" style="width:80%;">
        <img src="/images/homepage/topher.png" alt="Topher" class="img-fluid absolute z-40 animated-unif" style="width:60%;">
        <img src="/images/homepage/malinaw.png" alt="Malinaw" class="img-fluid absolute z-40 animated-img" style="width:80%;">
    </div>

    <!-- WAVE TRANSITION IMAGE: sits at the top visually, above everything -->
    <img src="/images/homepage/wave.png"
         alt="Wave Transition"
         class="absolute bottom-[-25%] left-0 w-full z-50 pointer-events-none" />

</section>

</body>
</html>
<script>
    
    function animateImages() {
        const images = document.querySelectorAll('.animated-img');
        images[0].classList.add('animate-top');
        images[1].classList.add('animate-middle');
        images[2].classList.add('animate-middle2');
        images[3].classList.add('animate-clearer');
        images[4].classList.add('animate-clear');
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

        const unif = document.querySelectorAll('.animated-unif');
        unif[0].classList.remove('animate-unif2');
    }

</script>
