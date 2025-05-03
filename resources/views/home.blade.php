@extends('layouts.sharedlayout')

@section('title', 'Homepage')

@section('styles')
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

  .animate-unif2 { top: 10%; opacity: 1; visibility: visible; }

  /* Responsive handling for image scaling */
  img.img-fluid {
    width: 100%;
    height: auto;
    max-width: 100%;
  }
</style>
@endsection

@section('content')
<!-- ---------------------- HOMEPAGE / FADED BACKGROUND / WAVE TRANSITION ---------------------- -->
<section class="relative w-full bg-cover bg-center min-h-screen" style="background-image: url('/images/homepage/homeBG.png');">

   <!-- FADED BACKGROUND IMAGE with shadow effect on top -->
   <div class="absolute top-[80%] left-0 w-full h-[100vh] object-cover z-50 pointer-events-none" 
         style="background-image: url('/images/homepage/2ndBG.png')">
    </div>

    <!-- MAIN IMAGE CONTENT (like Topher, blurry layers, etc) -->
    <div class="relative flex justify-center items-center w-full min-h-screen z-30" onmouseover="animateImages(); animateImages2();" onmouseleave="resetImages();">
        <img src="/images/homepage/malabo.png" alt="Malabo" class="img-fluid absolute z-10 animated-img" style="width:80%;">
        <img src="/images/homepage/medjmalabo.png" alt="Medyo Malabo" class="img-fluid absolute z-20 animated-img" style="width:80%;">
        <img src="/images/homepage/medjmalinaw.png" alt="Medyo Malinaw" class="img-fluid absolute z-30 animated-img" style="width:80%;">
        <img src="/images/homepage/medjmalinaw.png" alt="Medyo Malinaw" class="img-fluid absolute z-30 animated-img" style="width:80%;">
        <img src="/images/homepage/trio.png" alt="Trio" class="img-fluid absolute z-40 animated-unif" style="width:55%;">
        <img src="/images/homepage/malinaw.png" alt="Malinaw" class="img-fluid absolute z-40 animated-img" style="width:80%;">
    </div>

    <!-- WAVE TRANSITION IMAGE: sits at the top visually, above everything -->
    <img src="/images/homepage/wave.png"
         alt="Wave Transition"
         class="absolute bottom-[-25%] left-0 w-full z-50 pointer-events-none" />

</section>
@endsection

@section('scripts')
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
@endsection