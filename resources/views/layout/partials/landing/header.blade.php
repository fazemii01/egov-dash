<nav id="navbar" class="fixed top-0 w-full z-50 text-white transition-all duration-300 nav-transparent">
    <div class="container mx-auto px-4 flex justify-between items-center">
        <div class="font-bold text-2xl tracking-wide flex items-center gap-2 text-white">
            <i class="ph ph-buildings text-3xl"></i>
            Diskominfo
        </div>

        <button id="hamburger-btn" class="lg:hidden text-white focus:outline-none p-2 rounded hover:bg-white/10 transition-colors">
            <svg id="icon-hamburger" class="w-8 h-8 transform transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7"></path>
            </svg>
            <svg id="icon-close" class="hidden w-8 h-8 transform transition-transform duration-300 rotate-90" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
            </svg>
        </button>

        <ul class="hidden lg:flex gap-6 text-sm font-medium items-center text-white h-full">
        <li>
            <a href="{{ route('landing.index') }}" class="hover:text-blue-100 transition">Beranda</a>
        </li>

        <li class="relative group h-full flex items-center">
            
            <a href="#" class="flex items-center gap-1 hover:text-blue-100 transition py-4">
            Profil 
            <i class="ph ph-caret-down transition-transform duration-300 group-hover:rotate-180"></i>
            </a>

            <div class="absolute top-full left-0 mt-0 w-56 bg-white rounded-lg shadow-xl border border-gray-100 
                        opacity-0 invisible translate-y-2 
                        group-hover:opacity-100 group-hover:visible group-hover:translate-y-0 
                        transition-all duration-300 ease-in-out z-50">
            
                <ul class="py-2 text-gray-600 font-normal">
                    <li><a href="https://diskominfo.lumajangkab.go.id/ppid/kelembagaan" class="block px-4 py-2 hover:bg-blue-50 hover:text-blue-600 hover:pl-6 transition-all duration-300">
                        Kelembagaan
                    </a>
                    </li>
                    <li><a href="https://diskominfo.lumajangkab.go.id/ppid/tupoksi" class="block px-4 py-2 hover:bg-blue-50 hover:text-blue-600 hover:pl-6 transition-all duration-300">
                        Tupoksi
                    </a>
                    </li>
                    <li>
                    <a href="https://diskominfo.lumajangkab.go.id/produk_hukum" class="block px-4 py-2 hover:bg-blue-50 hover:text-blue-600 hover:pl-6 transition-all duration-300">
                        Produk Hukum
                    </a>
                    </li>
                    <li>
                    <a href="https://diskominfo.lumajangkab.go.id/profil/index/2" class="block px-4 py-2 hover:bg-blue-50 hover:text-blue-600 hover:pl-6 transition-all duration-300">
                        Maklumat Pelayanan
                    </a>
                    </li>
                </ul>
                </div>
            </li>
            <li><a href="{{ route('landing.layanan') }}" class="hover:text-blue-100 transition">Layanan</a>
            </li>
        <!-- <li><a href="#" class="hover:text-blue-100">SAKIP</a></li> -->
        <!-- <li>
          <a href="#" class="flex items-center gap-1 hover:text-blue-100 transition">
            PPID <i class="ph ph-caret-down"></i>
          </a>
        </li> -->
        <!-- <li><a href="#" class="hover:text-blue-100">Data</a></li> -->
        <!-- <li><a href="#" class="hover:text-blue-100">WBS</a></li> -->
            <li><a href="https://itdalumajang.id/halaman/detail/pelaporan-gratifikasi-melalui-upg-daring" class="hover:text-blue-100 transition">UPG</a>
            </li>
            <li><a href="https://itdalumajang.id/halaman/detail/laporan-benturan-kepentingan" class="hover:text-blue-100 transition">Benturan Kepentingan</a>
            </li>
            <li><a href="#" class="hover:text-blue-100 transition">FAQ</a>
            </li>
            <li class="relative group h-full flex items-center"><a href="#" class="flex items-center gap-1 hover:text-blue-100 transition py-4">
                Situs Link 
                <i class="ph ph-caret-down transition-transform duration-300 group-hover:rotate-180"></i>
                </a>

            <div class="absolute top-full right-0 mt-0 w-64 bg-white rounded-lg shadow-xl border border-gray-100 
                        opacity-0 invisible translate-y-2 
                        group-hover:opacity-100 group-hover:visible group-hover:translate-y-0 
                        transition-all duration-300 ease-in-out z-50">
    
                <ul class="py-2 text-gray-600 font-normal">
                    <li>
                    <a href="https://lumajangkab.go.id/" 
                        class="block px-4 py-2 hover:bg-blue-50 hover:text-blue-600 hover:pl-6 transition-all duration-300 whitespace-nowrap">
                        Website Resmi Pemkab Lumajang
                    </a>
                    </li>
                    <li>
                    <a href="https://laporlumajang.lumajangkab.go.id/" class="block px-4 py-2 hover:bg-blue-50 hover:text-blue-600 hover:pl-6 transition-all duration-300">
                        Lapor Lumajang
                    </a>
                    </li>
                    <li>
                    <a href="https://jdih.lumajangkab.go.id/" class="block px-4 py-2 hover:bg-blue-50 hover:text-blue-600 hover:pl-6 transition-all duration-300">
                        JDIH Lumajang
                    </a>
                    </li>
                    <li>
                    <a href="https://www.lapor.go.id/" class="block px-4 py-2 hover:bg-blue-50 hover:text-blue-600 hover:pl-6 transition-all duration-300">
                        SP4N LAPOR
                    </a>
                    </li>
                </ul>
                </div>
            </li>
        </ul>
    </div>

    <div id="mobile-menu"
    class="lg:hidden block bg-white/95 backdrop-blur-sm absolute w-full top-full left-0 border-t border-gray-200 shadow-lg 
            max-h-0 overflow-hidden opacity-0 invisible transition-all duration-500 ease-in-out z-40">
        
        <ul class="flex flex-col gap-0 text-[#555555] font-medium p-0">
            
            <li class="border-b border-gray-100">
            <a href="{{ route('landing.index') }}" class="block px-6 py-4 hover:text-blue-600 transition-colors">Beranda</a>
            </li>

            <li class="border-b border-gray-100">
            <button id="mobile-profil-btn" class="w-full px-6 py-4 text-left flex justify-between items-center hover:text-blue-600 transition-colors group">
                Profil 
                <i id="mobile-profil-icon" class="ph ph-caret-down transition-transform duration-300"></i>
            </button>
            
            <ul id="mobile-profil-menu" class="max-h-0 overflow-hidden transition-all duration-300 ease-in-out">
                <li><a href="https://diskominfo.lumajangkab.go.id/ppid/kelembagaan" class="block pl-12 pr-6 py-3 text-gray-500 text-sm hover:text-blue-600">Kelembagaan</a></li>
                <li><a href="https://diskominfo.lumajangkab.go.id/ppid/tupoksi" class="block pl-12 pr-6 py-3 text-gray-500 text-sm hover:text-blue-600">Tupoksi</a></li>
                <li><a href="https://diskominfo.lumajangkab.go.id/produk_hukum" class="block pl-12 pr-6 py-3 text-gray-500 text-sm hover:text-blue-600">Produk Hukum</a></li>
                <li><a href="https://diskominfo.lumajangkab.go.id/profil/index/2" class="block pl-12 pr-6 py-3 text-gray-500 text-sm hover:text-blue-600">Maklumat Pelayanan</a></li>
            </ul>
            </li>

            <li class="border-b border-gray-100">
            <a href="{{ route('landing.layanan') }}" class="block px-6 py-4 hover:text-blue-600 transition-colors">Layanan</a>
            </li>

            <li class="border-b border-gray-100">
            <a href="https://itdalumajang.id/halaman/detail/pelaporan-gratifikasi-melalui-upg-daring" class="block px-6 py-4 hover:text-blue-600 transition-colors">UPG</a>
            </li>

            <li class="border-b border-gray-100">
            <a href="https://itdalumajang.id/halaman/detail/laporan-benturan-kepentingan" class="block px-6 py-4 hover:text-blue-600 transition-colors">Benturan Kepentingan</a>
            </li>

            <li class="border-b border-gray-100">
            <a href="#" class="block px-6 py-4 hover:text-blue-600 transition-colors">FAQ</a>
            </li>

            <li class="border-b border-gray-100">
            <button id="mobile-link-btn" class="w-full px-6 py-4 text-left flex justify-between items-center hover:text-blue-600 transition-colors group">
                Situs Link 
                <i id="mobile-link-icon" class="ph ph-caret-down transition-transform duration-300"></i>
            </button>
            
            <ul id="mobile-link-menu" class="max-h-0 overflow-hidden transition-all duration-300 ease-in-out">
                <li><a href="https://lumajangkab.go.id/" class="block pl-12 pr-6 py-3 text-gray-500 text-sm hover:text-blue-600">Website Resmi Pemkab Lumajang</a></li>
                <li><a href="https://laporlumajang.lumajangkab.go.id/" class="block pl-12 pr-6 py-3 text-gray-500 text-sm hover:text-blue-600">Lapor Lumajang</a></li>
                <li><a href="https://jdih.lumajangkab.go.id/" class="block pl-12 pr-6 py-3 text-gray-500 text-sm hover:text-blue-600">JDIH Lumajang</a></li>
                <li><a href="https://www.lapor.go.id/" class="block pl-12 pr-6 py-3 text-gray-500 text-sm hover:text-blue-600">SP4N LAPOR</a></li>
            </ul>
            </li>

        </ul>
    </div>
</nav>