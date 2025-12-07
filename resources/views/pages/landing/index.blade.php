<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Diskominfo Kabupaten Lumajang - Landing Page</title>
   <link rel="stylesheet" href="{{ asset('assets/landing/css/main.css') }}">
  <script src="https://cdn.tailwindcss.com"></script>
  <link
    href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&family=Georgia&family=Mulish:wght@600&family=Raleway:wght@600&display=swap"
    rel="stylesheet" />
  <script src="https://unpkg.com/@phosphor-icons/web"></script>
  <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet" />
</head>

<body class="bg-gray-50 text-[#333333]">

  @include('layout.partials.landing.header')

<main>

  <!-- @include('layout.partials.landing.hero') -->

  <header class="relative w-full bg-cover bg-[center_top] bg-no-repeat min-h-[500px] md:min-h-[1000px] flex flex-col"
    style="background-image: url('{{ asset('assets/landing/img/image 1.png') }}')">
    
    <div class="absolute inset-0 bg-black/10"></div>

    <div class="absolute bottom-0 left-0 w-full h-[350px] bg-gradient-to-t from-white via-white/80 to-transparent z-10">
    </div>

    <div class="container mx-auto px-4 relative z-20 flex-grow flex flex-col justify-between pb-20 pt-32 md:pt-48">
      <div class="text-white">
        <h1 class="text-4xl md:text-6xl font-bold mb-4 leading-tight max-w-2xl drop-shadow-lg text-white">
          Diskominfo Lumajang
        </h1>
        <p class="text-lg md:text-2xl font-light opacity-90 max-w-lg drop-shadow-md">
          Portal Resmi Dinas Komunikasi dan Informatika Kabupaten Lumajang
        </p>
      </div>

      <div class="mt-20">
        <h2 class="text-3xl font-bold text-white mb-8 drop-shadow-md pl-1">
          Layanan
        </h2>

        <div class="grid grid-cols-1 md:grid-cols-4 gap-8" id="services-container"></div>
        
        <div class="flex justify-center mt-12" data-aos="fade-up" data-aos-duration="1000">
          <a href="/layanan"
             class="inline-flex items-center px-6 py-3 text-base font-semibold rounded-lg shadow-md transition-colors duration-300 ease-in-out 
                  bg-blue-600 text-white 
                  hover:bg-white hover:text-blue-600">
            Selengkapnya
          </a>
        </div>
        <!-- <div class="flex justify-center mt-12 gap-2">
          <span class="w-3 h-3 bg-blue-500 rounded-full cursor-pointer" data-slide="0"></span>
          <span class="w-3 h-3 bg-white/50 hover:bg-white transition rounded-full cursor-pointer" data-slide="1"></span>
          <span class="w-3 h-3 bg-white/50 hover:bg-white transition rounded-full cursor-pointer" data-slide="2"></span>
        </div> -->
      </div>
    </div>
  </header>

  <!-- <section class="relative -mt-32 z-10 mb-10">
    <div class="container mx-auto px-4">
      <div class="grid grid-cols-1 md:grid-cols-4 gap-6" id="services-container"></div>
      <div class="flex justify-center mt-8 gap-2">
        <span class="w-3 h-3 bg-blue-500 rounded-full"></span>
        <span class="w-3 h-3 bg-gray-300 rounded-full"></span>
        <span class="w-3 h-3 bg-gray-300 rounded-full"></span>
      </div>
    </div>
  </section> -->
  <!-- <section class="relative -mt-32 z-10 mb-10">
    <div class="container mx-auto px-4 relative -mt-32 z-10 mb-10">
      
      <h2 class="text-3xl font-bold text-white mb-8 drop-shadow-md pl-1">Layanan</h2>

      <div class="grid grid-cols-1 md:grid-cols-3 gap-6" id="services-container">
          </div>

      <div class="flex justify-center mt-12 gap-2">
        <span class="w-3 h-3 bg-blue-500 rounded-full cursor-pointer"></span>
        <span class="w-3 h-3 bg-gray-300 hover:bg-white transition rounded-full cursor-pointer"></span>
        <span class="w-3 h-3 bg-gray-300 hover:bg-white transition rounded-full cursor-pointer"></span>
      </div>
    </div>
</section> -->

  <section class="container mx-auto px-4 mb-20">
    <div class="flex items-center gap-4 mb-8" data-aos="fade-up" data-aos-duration="1000">
      <h2 class="text-3xl font-bold text-black">Berita OPD</h2>
      <div class="h-1 flex-grow bg-gray-200 rounded-full"></div>
      <button class="text-blue-500 font-semibold text-sm">Lihat Semua</button>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8" data-aos="fade-up" data-aos-duration="1200">
      <div class="lg:col-span-5 flex flex-col gap-4">
        <div class="bg-gray-300 w-full h-64 md:h-80 rounded-lg overflow-hidden relative group">
          <img src="https://images.unsplash.com/photo-1586023492125-27b2c045efd7?q=80&w=1000&auto=format&fit=crop"
            class="w-full h-full object-cover group-hover:scale-105 transition duration-500" />
        </div>
        <div>
          <div class="flex items-center gap-4 text-sm text-gray-500 mb-2">
            <span class="flex items-center gap-1"><i class="ph ph-user"></i> Admin</span>
            <span class="flex items-center gap-1"><i class="ph ph-calendar"></i> 20 Nov 2023</span>
          </div>
          <h3 class="text-2xl font-bold font-serif-custom text-[#333333] mb-3 leading-snug">
            Kasus infiltrasi ribuan situs pemerintah oleh konten judi
            online...
          </h3>
          <p class="text-gray-600 leading-relaxed line-clamp-3">
            Kasus infiltrasi ribuan situs pemerintah oleh konten judi online
            pada tahun 2023 adalah sebuah kegagalan kolektif. Ini bukan
            sekadar kegagalan teknis...
          </p>
        </div>
      </div>

      <div class="lg:col-span-7 grid grid-cols-1 sm:grid-cols-2 gap-6" id="news-opd-container"></div>
    </div>
  </section>

  <section class="bg-gray-50 py-16 mb-20 border-t border-b border-gray-200">
    <div class="container mx-auto px-4" data-aos="fade-up" data-aos-duration="1400">
      <div class="flex items-center gap-4 mb-8">
        <h2 class="text-3xl font-bold text-black">Berita Kabupaten</h2>
        <div class="h-1 flex-grow bg-gray-200 rounded-full"></div>
      </div>
      <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8" id="news-district-container"></div>
    </div>
  </section>

  <section class="container mx-auto px-4 mb-20">
    <h2 class="text-3xl font-bold text-black mb-8" data-aos="fade-up" data-aos-duration="1600">Galeri</h2>
    <div class="grid grid-cols-2 md:grid-cols-3 gap-4" data-aos="fade-up" data-aos-duration="1600" id="gallery-container"></div>
  </section>

  <section style="padding-top: 10rem; padding-bottom: 10rem;" class="bg-[#DADADA] mb-0">
    <div class="container mx-auto px-4" data-aos="fade-up" data-aos-duration="1800">
      <h2 class="text-3xl font-bold text-black mb-10 text-center">
        Pengumuman
      </h2>
      <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6" id="announcement-container"></div>
    </div>
  </section>

  <section class="relative py-[13rem] bg-blue-900 text-white overflow-hidden">
    <div class="absolute inset-0 z-0 opacity-40">
      <img src="https://images.unsplash.com/photo-1557804506-669a67965ba0?q=80&w=2600&auto=format&fit=crop"
        class="w-full h-full object-cover" />
    </div>
    <div class="relative z-10 container mx-auto px-4 text-center" data-aos="fade-up" data-aos-duration="2000">
     <h2 class="text-3xl font-bold mb-12 text-white">Pengaduan</h2>
      <div class="flex flex-col md:flex-row justify-center gap-8">
        <div class="bg-white/10 backdrop-blur-md border border-white/30 p-10 rounded-lg max-w-lg mx-auto">
          <div class="text-xl font-bold mb-2">Bima Ari Wibowo</div>
          <div class="text-sm font-light mb-4">
            13/01/2025, Ditotrunan Kec. Lumajang
          </div>
          <hr class="border-white/40 w-24 mx-auto mb-4" />
          <p class="text-sm italic">
            "Ingin memperbarui fisik KTP, karena fisik KTP yang ada sudah
            rusak dan tulisan pada KTP sudah tidak terbaca."
          </p>
        </div>
        <div class="bg-white/10 backdrop-blur-md border border-white/30 p-8 rounded-lg max-w-lg mx-auto">
          <div class="text-xl font-bold mb-2">Bima Ari Wibowo</div>
          <div class="text-sm font-light mb-4">
            13/01/2025, Ditotrunan Kec. Lumajang
          </div>
          <hr class="border-white/40 w-24 mx-auto mb-4" />
          <p class="text-sm italic">
            "Ingin memperbarui fisik KTP, karena fisik KTP yang ada sudah
            rusak dan tulisan pada KTP sudah tidak terbaca."
          </p>
        </div>
      </div>
    </div>
  </section>
</main>

@include('layout.partials.landing.footer')  

    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script src="{{ asset('assets/landing/js/main.js') }}"></script>
</body>

</html> 