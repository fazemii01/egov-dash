<nav id="navbar" class="fixed top-0 w-full z-50 text-white transition-all duration-300 nav-transparent">
    <div class="container mx-auto px-4 flex justify-between items-center">
        <div class="font-bold text-2xl tracking-wide flex items-center gap-2 text-white">
            <i class="ph ph-buildings text-3xl"></i>
            Diskominfo
        </div>

        <button onclick="toggleMobileMenu()" class="lg:hidden text-white focus:outline-none">
            <i class="ph ph-list text-3xl"></i>
        </button>

        <ul class="hidden lg:flex gap-6 text-sm font-medium items-center text-white">
            <li>
                <a href="{{ route('landing.index') }}" class="hover:text-blue-100 transition">Beranda</a>
            </li>
            <li>
                <a href="#" class="flex items-center gap-1 hover:text-blue-100 transition">
                    Profil <i class="ph ph-caret-down"></i>
                </a>
            </li>

            <li>
                <a href="{{ route('landing.layanan') }}" class="flex items-center gap-1 hover:text-blue-100 transition">
                    Layanan <i class="ph ph-caret-down"></i>
                </a>
            </li>
            <li><a href="#" class="hover:text-blue-100">UPG</a></li>
            <li>
                <a href="#" class="hover:text-blue-100">Benturan Kepentingan</a>
            </li>
            <li><a href="#" class="hover:text-blue-100">FAQ</a></li>
            <li>
                <a href="#" class="flex items-center gap-1 hover:text-blue-100 transition">
                    Situs Link <i class="ph ph-caret-down"></i>
                </a>
            </li>
        </ul>
    </div>

    <div id="mobile-menu"
        class="hidden lg:hidden bg-[#0d85c8] p-4 absolute w-full top-full left-0 border-t border-blue-400">
        <ul class="flex flex-col gap-4 text-white">
            <li><a href="#" class="block py-2">Beranda</a></li>
            <li><a href="#" class="block py-2">Profil</a></li>
            <li><a href="#" class="block py-2">Layanan</a></li>
            <li><a href="#" class="block py-2">Kontak</a></li>
        </ul>
    </div>
</nav>