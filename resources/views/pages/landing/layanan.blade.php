<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Daftar Layanan & Regulasi - Diskominfo Lumajang</title>

    {{-- 1. Use the same Assets as Landing Page --}}
    <link rel="stylesheet" href="{{ asset('assets/landing/css/main.css') }}">
    <script src="https://cdn.tailwindcss.com"></script>
    
    {{-- Alpine JS for the Search Logic --}}
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>

    {{-- Fonts from Landing Page --}}
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&family=Georgia&family=Mulish:wght@600&family=Raleway:wght@600&display=swap" rel="stylesheet" />
    <script src="https://unpkg.com/@phosphor-icons/web"></script>
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet" />

    <style>
        /* Hide Scrollbar */
        .no-scrollbar::-webkit-scrollbar { display: none; }
        .no-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }
    </style>
</head>

<body class="bg-gray-50 text-[#333333] font-['Poppins']">

    {{-- 2. Header Partial --}}
    <div class="bg-[#0d85c8]">
        @include('partials.header')
    </div>

    <main x-data="layananApp()">
        
        {{-- 3. Page Hero Section --}}
        <section class="relative w-full bg-cover bg-center h-[600px] flex items-center"
            style="background-image: url('{{ asset('assets/landing/img/image 1.png') }}');">
            
            {{-- Dark Overlay --}}
            <div class="absolute inset-0 bg-black/60"></div>

            <div class="container mx-auto px-4 relative z-10 text-white mt-10" data-aos="fade-up">
                <nav class="text-sm text-gray-300 mb-2 font-medium">
                    <a href="{{ url('/index') }}" class="hover:text-white transition-colors">Beranda</a>
                    <span class="mx-2">/</span>
                    <span class="text-white">Layanan Publik</span>
                </nav>
                <h1 class="text-3xl md:text-5xl font-bold mb-4 drop-shadow-lg">
                    Daftar Layanan & Regulasi
                </h1>
                <p class="text-gray-200 text-lg max-w-2xl font-light">
                    Akses dokumen resmi, standar operasional prosedur (SOP), dan dasar hukum pelayanan publik secara transparan.
                </p>
            </div>
        </section>

        {{-- 4. Main Content Area --}}
        {{-- FIX: Removed '-mt-30' and 'z-50' so it sits below the header normally --}}
        <section class="container mx-auto px-4 py-12">
            
            {{-- Control Bar (Search & Filter) --}}
            <div class="bg-white rounded-xl shadow-lg p-6 mb-8 border border-gray-100" data-aos="fade-up" data-aos-delay="100">
                <div class="flex flex-col md:flex-row gap-6 items-center justify-between">
                    
                    {{-- Search Input --}}
                    <div class="relative w-full md:w-1/2 group">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                            <i class="ph ph-magnifying-glass text-xl text-gray-400 group-focus-within:text-blue-500 transition-colors"></i>
                        </div>
                        <input x-model="searchQuery" type="text" placeholder="Cari layanan, SOP, atau SK..."
                            class="block w-full pl-11 pr-4 py-3 bg-gray-50 border border-gray-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:bg-white transition-all shadow-inner" />
                    </div>

                    {{-- View Toggles --}}
                    <div class="flex items-center gap-2 bg-gray-50 p-1.5 rounded-lg border border-gray-200">
                        <button @click="viewMode = 'grid'"
                            :class="viewMode === 'grid' ? 'bg-white text-blue-600 shadow-sm' : 'text-gray-500 hover:text-gray-700'"
                            class="p-2.5 rounded-md transition-all">
                            <i class="ph ph-squares-four text-xl"></i>
                        </button>
                        <button @click="viewMode = 'list'"
                            :class="viewMode === 'list' ? 'bg-white text-blue-600 shadow-sm' : 'text-gray-500 hover:text-gray-700'"
                            class="p-2.5 rounded-md transition-all">
                            <i class="ph ph-list-dashes text-xl"></i>
                        </button>
                    </div>
                </div>

                {{-- Category Chips --}}
                <div class="flex gap-3 overflow-x-auto pt-6 pb-2 no-scrollbar border-t border-gray-100 mt-6">
                    <template x-for="cat in categories" :key="cat">
                        <button @click="activeCategory = cat" x-text="cat"
                            class="whitespace-nowrap px-5 py-2 rounded-full text-sm font-semibold transition-all duration-300 border"
                            :class="activeCategory === cat 
                                ? 'bg-blue-600 text-white border-blue-600 shadow-md transform scale-105' 
                                : 'bg-white text-gray-500 border-gray-200 hover:border-blue-300 hover:text-blue-500'">
                        </button>
                    </template>
                </div>
            </div>

            {{-- Results Grid/List --}}
            <div :class="viewMode === 'grid' ? 'grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6' : 'flex flex-col gap-4'"
                 data-aos="fade-up" data-aos-delay="200">
                
                <template x-for="item in filteredItems" :key="item.id">
                    <div class="group bg-white border border-gray-100 rounded-xl overflow-hidden hover:shadow-xl hover:-translate-y-1 transition-all duration-300 cursor-pointer"
                        :class="viewMode === 'list' ? 'flex items-center p-5 gap-6' : 'p-6 flex flex-col h-full'">

                        {{-- Icon & Year Badge --}}
                        <div :class="viewMode === 'list' ? 'shrink-0' : 'mb-5 flex justify-between items-start'">
                            <div class="w-12 h-12 rounded-lg bg-blue-50 flex items-center justify-center group-hover:bg-blue-600 transition-colors duration-300">
                                {{-- We use a wrapper div to target the SVG inside for color change --}}
                                <div class="text-blue-600 group-hover:text-white transition-colors duration-300" x-html="getIcon(item.type)"></div>
                            </div>
                            
                            <template x-if="viewMode === 'grid'">
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-gray-100 text-gray-600 group-hover:bg-blue-100 group-hover:text-blue-700 transition-colors"
                                    x-text="item.year"></span>
                            </template>
                        </div>

                        {{-- Text Content --}}
                        <div class="flex-1 min-w-0">
                            <div class="flex items-center gap-3 mb-2">
                                <span class="text-[11px] font-extrabold tracking-widest text-blue-500 uppercase" x-text="item.type"></span>
                                <template x-if="viewMode === 'list'">
                                    <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-bold bg-gray-100 text-gray-600" x-text="item.year"></span>
                                </template>
                            </div>
                            
                            <h3 class="text-lg font-bold text-gray-800 mb-2 leading-snug group-hover:text-blue-600 transition-colors line-clamp-2"
                                x-text="item.title"></h3>
                            
                            <p class="text-sm text-gray-500 leading-relaxed line-clamp-2" x-text="item.description"></p>
                        </div>

                        {{-- Footer (Grid Only) --}}
                        <template x-if="viewMode === 'grid'">
                             <div class="mt-6 pt-4 border-t border-gray-100 flex items-center justify-between">
                                <span class="text-xs font-semibold text-gray-400 group-hover:text-blue-500 transition-colors">Lihat Detail</span>
                                <i class="ph-bold ph-arrow-right text-gray-300 group-hover:text-blue-500 transition-colors"></i>
                             </div>
                        </template>
                    </div>
                </template>
            </div>

            {{-- Empty State --}}
            <div x-show="filteredItems.length === 0"
                class="text-center py-24 bg-white rounded-xl border border-dashed border-gray-300 mt-8"
                style="display: none;">
                <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-gray-50 mb-4">
                    <i class="ph ph-files text-3xl text-gray-300"></i>
                </div>
                <h3 class="text-xl font-bold text-gray-800 mb-2">Data Tidak Ditemukan</h3>
                <p class="text-gray-500 mb-6">Kami tidak dapat menemukan dokumen yang Anda cari.</p>
                <button @click="resetFilter" 
                    class="px-6 py-2 bg-blue-600 text-white rounded-lg font-semibold hover:bg-blue-700 transition shadow-md hover:shadow-lg">
                    Reset Filter
                </button>
            </div>

        </section>
    </main>

    {{-- 5. Footer Partial --}}
    @include('partials.footer')

    {{-- JS Scripts --}}
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    
    {{-- Inline logic for immediate rendering, or link your external file --}}
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script src="{{ asset('assets/landing/js/main.js') }}"></script>

    <script>
        // Initialize AOS Animation
        AOS.init();
    </script>
</body>

</html>