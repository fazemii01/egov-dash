const navbar = document.getElementById("navbar");

window.addEventListener("scroll", () => {
  if (window.scrollY > 50) {
    navbar.classList.remove("nav-transparent");
    navbar.classList.add("nav-scrolled");
  } else {
    navbar.classList.remove("nav-scrolled");
    navbar.classList.add("nav-transparent");
  }
});

function renderServices() {
  const container = document.getElementById("services-container");
  const html = appModel.services
    .map(
      (item, index) => `
        <div class="max-w-sm w-full mx-auto" data-aos="fade-up" data-aos-delay="${index * 100}">
            <div class="bg-white rounded-xl shadow-lg p-6 hover:-translate-y-5 transition duration-300 border-b-4">
                <p class="text-xs font-bold text-gray-400 mb-2">${item.date}</p>
                <h3 class="text-xl font-bold text-blue-500 mb-2">${item.title}</h3>
                <p class="text-sm text-gray-600 mb-4">${item.subtitle}</p>
                <a href="${item.link}" class="text-sm font-semibold text-right block text-gray-500 hover:text-blue-500">
                Lihat Selengkapnya ></a>
            </div>
        </div>
        `
    )
    .join("");
  container.innerHTML = html;
}

//hamburger
document.addEventListener("DOMContentLoaded", function() {
    const btn = document.getElementById('hamburger-btn');
    const menu = document.getElementById('mobile-menu');
    
    //elemen icon dalam tombol
    const iconHamburger = document.getElementById('icon-hamburger');
    const iconClose = document.getElementById('icon-close');

    if (!btn || !menu) return;

    btn.addEventListener('click', () => {
      //cek menu sedang terbuka (berdasarkan max-height)
      const isOpen = menu.style.maxHeight && menu.style.maxHeight !== '0px';

      if (isOpen) {
        // TUGAS: MENUTUP MENU
        menu.style.maxHeight = '0px';
        menu.style.opacity = '0';
        menu.classList.add('invisible');
        
        //ganti Icon X kembali ke hamburger
        iconClose.classList.add('hidden');
        iconHamburger.classList.remove('hidden');
        iconHamburger.classList.remove('rotate-90');
        
      } else {
        // TUGAS: MEMBUKA MENU
        menu.classList.remove('invisible');
        menu.style.maxHeight = menu.scrollHeight + "px";
        menu.style.opacity = '1';
        
        //hamburger menjadi X
        iconHamburger.classList.add('hidden');
        iconClose.classList.remove('hidden');
        iconClose.classList.remove('rotate-90'); 
      }
    });

    //reset saat layar di-resize ke desktop
    window.addEventListener('resize', () => {
      if (window.innerWidth >= 1024) {
        menu.style.maxHeight = '0px';
        menu.style.opacity = '0';
        menu.classList.add('invisible');
        
        //kembalikan ke icon hamburger
        iconClose.classList.add('hidden');
        iconHamburger.classList.remove('hidden');
      }
    });
  });
//hamburger ends

//helper untuk toggle dropdown mobile
  function setupMobileDropdown(btnId, menuId, iconId) {
    const btn = document.getElementById(btnId);
    const menu = document.getElementById(menuId);
    const icon = document.getElementById(iconId);
    const mainMobileMenu = document.getElementById('mobile-menu'); 

    if (!btn || !menu || !icon) return;

    btn.addEventListener('click', (e) => {
      e.preventDefault();
      
      const isOpen = menu.style.maxHeight && menu.style.maxHeight !== '0px';
      
      //hitung tinggi submenu yang akan dibuka
      const contentHeight = menu.scrollHeight; 

      if (isOpen) {
        // --- TUTUP ---
        menu.style.maxHeight = '0px';
        icon.classList.remove('rotate-180');

      } else {
        // --- BUKA ---
        menu.style.maxHeight = contentHeight + "px";
        icon.classList.add('rotate-180');

        if (mainMobileMenu.style.maxHeight !== '0px') {
           const currentMainHeight = mainMobileMenu.scrollHeight;
           mainMobileMenu.style.maxHeight = (currentMainHeight + contentHeight) + "px";
        }
      }
    });
  }

  document.addEventListener("DOMContentLoaded", function() {
    //jalankan setup
    setupMobileDropdown('mobile-profil-btn', 'mobile-profil-menu', 'mobile-profil-icon');
    setupMobileDropdown('mobile-link-btn', 'mobile-link-menu', 'mobile-link-icon');
  });

const appModel = {
  services: [{
      title: "Pelayanan Infomarsi Publik",
      subtitle: "Layanan permohonan informasi dan dokumentasi publik secara transparan sesuai UU KIP",
      date: "Jan - Apr 2025",
      link: "https://diskominfo.lumajangkab.go.id/layanan/detail/1226",
    },
    {
      title: "Pelayanan Internet Terpadu",
      subtitle: "Penyediaan dan pengelolaan akses infrastruktur jaringan internet untuk instansi pemerintah dan fasilitas publik",
      date: "Jan - Apr 2025",
      link: "https://diskominfo.lumajangkab.go.id/layanan/detail/1229",
    },
    {
      title: "Pelayanan Pengaduan Publik",
      subtitle: "Sampaikan aspirasi, kritik, dan laporan terkait kinerja pelayanan publik",
      date: "Jan - Apr 2025",
      link: "https://diskominfo.lumajangkab.go.id/layanan/detail/1228",
    },
    {
      title: "Pelayanan Portal Satu Data",
      subtitle: "Pusat integrasi data statistik sektoral yang akurat dan terbuka untuk mendukung pembangunan daerah",
      date: "Jan - Apr 2025",
      link: "https://diskominfo.lumajangkab.go.id/layanan/detail/1227",
    },
  ],
  newsOPD: [{
      title: "Rapat Koordinasi SPBE",
      date: "12 Nov 2023",
      author: "Admin",
      img: "https://images.unsplash.com/photo-1577962917302-cd874c4e31d2?w=500&auto=format&fit=crop",
    },
    {
      title: "Sosialisasi Keamanan Informasi",
      date: "10 Nov 2023",
      author: "Humas",
      img: "https://images.unsplash.com/photo-1550751827-4bd374c3f58b?w=500&auto=format&fit=crop",
    },
    {
      title: "Pelatihan Digital Marketing UMKM",
      date: "08 Nov 2023",
      author: "Ekonomi",
      img: "https://images.unsplash.com/photo-1556761175-5973dc0f32e7?w=500&auto=format&fit=crop",
    },
    {
      title: "Kunjungan Kerja Kemenkominfo",
      date: "05 Nov 2023",
      author: "Admin",
      img: "https://images.unsplash.com/photo-1542744173-8e7e53415bb0?w=500&auto=format&fit=crop",
    },
  ],
  newsDistrict: [{
      title: "Pemerintah Luncurkan Aplikasi Baru",
      date: "18 Nov 2023",
      category: "Teknologi",
      img: "https://images.unsplash.com/photo-1451187580459-43490279c0fa?w=500&auto=format&fit=crop",
    },
    {
      title: "Bupati Tinjau Pembangunan Infrastruktur",
      date: "17 Nov 2023",
      category: "Pembangunan",
      img: "https://images.unsplash.com/photo-1541888946425-d81bb19240f5?w=500&auto=format&fit=crop",
    },
    {
      title: "Festival Budaya Lumajang 2023",
      date: "15 Nov 2023",
      category: "Budaya",
      img: "https://images.unsplash.com/photo-1533900298318-6b8da08a523e?w=500&auto=format&fit=crop",
    },
  ],
  gallery: [
    "https://images.unsplash.com/photo-1606857521015-7f9fcf423740?w=500&auto=format&fit=crop",
    "https://images.unsplash.com/photo-1570126618953-d437176e8c79?w=500&auto=format&fit=crop",
    "https://images.unsplash.com/photo-1486406146926-c627a92ad1ab?w=500&auto=format&fit=crop",
    "https://images.unsplash.com/photo-1517048676732-d65bc937f952?w=500&auto=format&fit=crop",
    "https://images.unsplash.com/photo-1573164713714-d95e436ab8d6?w=500&auto=format&fit=crop",
    "https://images.unsplash.com/photo-1552664730-d307ca884978?w=500&auto=format&fit=crop",
  ],
  announcements: [{
      title: "Data Pemohon E-KTP Belum Diambil",
      date: "07/11/2023",
      type: "Kependudukan",
    },
    {
      title: "Perbup Nomor 53 Tahun 2023",
      date: "20/09/2023",
      type: "Regulasi",
    },
    {
      title: "Perubahan Jam Pelayanan Ramadhan",
      date: "31/03/2022",
      type: "Pelayanan",
    },
    {
      title: "Undangan Ditjen Dukcapil",
      date: "04/03/2022",
      type: "Undangan",
    },
    {
      title: "Sapa DP3AK Pengurusan KTP Pemula",
      date: "01/03/2022",
      type: "Sosialisasi",
    },
    {
      title: "Undangan Dukcapil Menyapa",
      date: "25/02/2022",
      type: "Undangan",
    },
  ],
};

//detail layanan
function layananApp() {
  return {
    activeCategory: 'Semua',
    searchQuery: '',
    viewMode: 'grid',
    categories: ["Semua", "Peraturan", "Standar Layanan", "SOP", "Internal"],

    items: [
      { id: 1, title: "Perpres Nomor 21 Tahun 2023", description: "Ketentuan mengenai hari kerja dan jam kerja instansi pemerintah dan pegawai ASN.", category: "Peraturan", year: "2023", type: "PERPRES" },
      { id: 2, title: "SE Larangan Gratifikasi / Suap / Pungli", description: "Surat Edaran terkait pencegahan gratifikasi dalam pelayanan Adminduk.", category: "Peraturan", year: "2025", type: "SE" },
      { id: 3, title: "SE Pencegahan Penipuan Aktivasi IKD", description: "Pencegahan penipuan aktivasi kependudukan digital mengatasnamakan Dukcapil.", category: "Peraturan", year: "2024", type: "SE" },
      { id: 4, title: "SK Kepala Dinas Standar Pelayanan Publik", description: "Keputusan penetapan standar pelayanan publik di lingkungan dinas.", category: "Standar Layanan", year: "2024", type: "SK" },
      { id: 5, title: "SK Kompensasi Layanan", description: "Kebijakan kompensasi apabila layanan tidak sesuai standar.", category: "Standar Layanan", year: "2024", type: "SK" },
      { id: 6, title: "SK Penetapan Jam Pelayanan", description: "Jadwal resmi pelayanan pada Dinas Kependudukan dan Pencatatan Sipil.", category: "Standar Layanan", year: "2025", type: "SK" },
      { id: 7, title: "SK Tim Standar Operasional Prosedur", description: "Pembentukan tim penyusun dan pengawas SOP.", category: "Internal", year: "2024", type: "SK" },
      { id: 8, title: "SOP Akta Kelahiran dari Faskes", description: "Prosedur pengurusan akta kelahiran langsung dari Fasilitas Kesehatan.", category: "SOP", year: "2024", type: "SOP" },
      { id: 9, title: "SOP Akta Kelahiran Online", description: "Panduan lengkap pengurusan dokumen kependudukan secara daring.", category: "SOP", year: "2024", type: "SOP" },
      { id: 10, title: "SOP Akta Kelahiran Same Day Service", description: "Layanan cepat penerbitan akta kelahiran selesai di hari yang sama.", category: "SOP", year: "2024", type: "SOP" },
      { id: 11, title: "SOP Kartu Identitas Anak (KIA)", description: "Prosedur penerbitan KIA untuk anak usia 0-17 tahun kurang sehari.", category: "SOP", year: "2024", type: "SOP" },
      { id: 12, title: "SOP Pindah Datang Penduduk", description: "Tata cara perpindahan penduduk antar kabupaten/kota.", category: "SOP", year: "2024", type: "SOP" }
    ],

    get filteredItems() {
      return this.items.filter(item => {
        const matchesCategory = this.activeCategory === 'Semua' || item.category === this.activeCategory;
        const matchesSearch = item.title.toLowerCase().includes(this.searchQuery.toLowerCase()) ||
          item.description.toLowerCase().includes(this.searchQuery.toLowerCase());
        return matchesCategory && matchesSearch;
      });
    },

    resetFilter() {
      this.searchQuery = "";
      this.activeCategory = "Semua";
    },

    getIcon(type) {
      const icons = {
        'PERPRES': `<svg class="w-5 h-5 text-indigo-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M3 6l3 1m0 0l-3 9a5.002 5.002 0 006.001 0M6 7l3 9M6 7l6-2m6 2l3-1m-3 1l-3 9a5.002 5.002 0 006.001 0M18 7l3 9m-3-9l-6-2m0-2v2m0 16V5m0 16H9m3 0h3" /></svg>`,
        'SE': `<svg class="w-5 h-5 text-orange-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" /></svg>`,
        'SK': `<svg class="w-5 h-5 text-blue-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" /></svg>`,
        'SOP': `<svg class="w-5 h-5 text-emerald-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>`,
        'default': `<svg class="w-5 h-5 text-slate-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z" /></svg>`
      };
      return icons[type] || icons['default'];
    }
  }
}

function renderNewsOPD() {
  const container = document.getElementById("news-opd-container");
  const html = appModel.newsOPD
    .map(
      (item) => `
            <div class="bg-white rounded-lg shadow-sm hover:shadow-md transition overflow-hidden border border-gray-100">
                <div class="h-32 bg-gray-200">
                      <img src="${item.img}" class="w-full h-full object-cover">
                </div>
                <div class="p-4">
                    <div class="flex justify-between text-xs text-gray-400 mb-2">
                        <span>${item.date}</span>
                        <span>${item.author}</span>
                    </div>
                    <h4 class="font-bold font-serif-custom text-gray-800 text-sm line-clamp-2">${item.title}</h4>
                </div>
            </div>
        `
    )
    .join("");
  container.innerHTML = html;
}

function renderDistrictNews() {
  const container = document.getElementById("news-district-container");
  const html = appModel.newsDistrict
    .map(
      (item) => `
            <div class="bg-white rounded-xl shadow-md overflow-hidden hover:shadow-xl transition duration-300 group">
                <div class="h-48 overflow-hidden">
                    <img src="${item.img}" class="w-full h-full object-cover group-hover:scale-110 transition duration-500">
                </div>
                <div class="p-6 relative">
                    <span class="absolute -top-3 left-6 bg-blue-500 text-white text-xs px-3 py-1 rounded shadow-sm">
                        ${item.category}
                    </span>
                    <h3 class="font-bold text-lg font-serif-custom mb-2 mt-2">${item.title}</h3>
                    <div class="flex items-center gap-2 text-xs text-gray-400 mt-4">
                        <i class="ph ph-calendar"></i>
                        <span>${item.date}</span>
                    </div>
                </div>
            </div>
        `
    )
    .join("");
  container.innerHTML = html;
}

function renderGallery() {
  const container = document.getElementById("gallery-container");
  const html = appModel.gallery
    .map(
      (url) => `
            <div class="relative h-48 rounded-lg overflow-hidden group cursor-pointer">
                <img src="${url}" class="w-full h-full object-cover group-hover:scale-110 transition duration-500">
                <div class="absolute inset-0 bg-black/50 opacity-0 group-hover:opacity-100 transition duration-300 flex items-center justify-center">
                    <i class="ph ph-magnifying-glass-plus text-white text-3xl"></i>
                </div>
            </div>
        `
    )
    .join("");
  container.innerHTML = html;
}

function renderAnnouncements() {
  const container = document.getElementById("announcement-container");
  const html = appModel.announcements
    .map(
      (item) => `
            <div class="bg-white p-10 rounded-lg flex items-start gap-4 border-l-4 border-blue-600 shadow-sm hover:shadow-md transition">
                <div class="w-12 h-12 bg-blue-600 rounded flex-shrink-0 flex items-center justify-center text-white">
                    <i class="ph ph-megaphone text-2xl"></i>
                </div>
                <div>
                    <h4 class="font-bold text-sm text-blue-800 mb-1 leading-tight">${item.title}</h4>
                    <div class="flex items-center gap-2 text-xs text-gray-500 mt-2">
                        <i class="ph ph-calendar-blank"></i>
                        <span>${item.date}</span>
                    </div>
                    <div class="mt-2 text-xs text-blue-500 font-semibold cursor-pointer">Selengkapnya</div>
                </div>
            </div>
        `
    )
    .join("");
  container.innerHTML = html;
}

function toggleMobileMenu() {
  const menu = document.getElementById("mobile-menu");
  menu.classList.toggle("hidden");
}

document.addEventListener("DOMContentLoaded", () => {
  renderServices();
  renderNewsOPD();
  renderDistrictNews();
  renderGallery();
  renderAnnouncements();
  AOS.init({
    once: true, 
    duration: 1000, 
  });
});

(function() {
  "use strict";

  /**
   * Apply .scrolled class to the body as the page is scrolled down
   */
  function toggleScrolled() {
    const selectBody = document.querySelector('body');
    const selectHeader = document.querySelector('#header');
    if (!selectHeader.classList.contains('scroll-up-sticky') && !selectHeader.classList.contains('sticky-top') && !selectHeader.classList.contains('fixed-top')) return;
    window.scrollY > 100 ? selectBody.classList.add('scrolled') : selectBody.classList.remove('scrolled');
  }

  document.addEventListener('scroll', toggleScrolled);
  window.addEventListener('load', toggleScrolled);

  /**
   * Mobile nav toggle
   */
  const mobileNavToggleBtn = document.querySelector('.mobile-nav-toggle');

  function mobileNavToogle() {
    document.querySelector('body').classList.toggle('mobile-nav-active');
    mobileNavToggleBtn.classList.toggle('bi-list');
    mobileNavToggleBtn.classList.toggle('bi-x');
  }
  mobileNavToggleBtn.addEventListener('click', mobileNavToogle);

  /**
   * Hide mobile nav on same-page/hash links
   */
  document.querySelectorAll('#navmenu a').forEach(navmenu => {
    navmenu.addEventListener('click', () => {
      if (document.querySelector('.mobile-nav-active')) {
        mobileNavToogle();
      }
    });

  });

  /**
   * Toggle mobile nav dropdowns
   */
  document.querySelectorAll('.navmenu .toggle-dropdown').forEach(navmenu => {
    navmenu.addEventListener('click', function(e) {
      e.preventDefault();
      this.parentNode.classList.toggle('active');
      this.parentNode.nextElementSibling.classList.toggle('dropdown-active');
      e.stopImmediatePropagation();
    });
  });

  /**
   * Preloader
   */
  const preloader = document.querySelector('#preloader');
  if (preloader) {
    window.addEventListener('load', () => {
      preloader.remove();
    });
  }

  /**
   * Scroll top button
   */
  let scrollTop = document.querySelector('.scroll-top');

  function toggleScrollTop() {
    if (scrollTop) {
      window.scrollY > 100 ? scrollTop.classList.add('active') : scrollTop.classList.remove('active');
    }
  }
  scrollTop.addEventListener('click', (e) => {
    e.preventDefault();
    window.scrollTo({
      top: 0,
      behavior: 'smooth'
    });
  });

  window.addEventListener('load', toggleScrollTop);
  document.addEventListener('scroll', toggleScrollTop);

  /**
   * Animation on scroll function and init
   */
  function aosInit() {
    AOS.init({
      duration: 600,
      easing: 'ease-in-out',
      once: true,
      mirror: false
    });
  }
  window.addEventListener('load', aosInit);

  /**
   * Initiate glightbox
   */
  const glightbox = GLightbox({
    selector: '.glightbox'
  });

  /**
   * Init isotope layout and filters
   */
  document.querySelectorAll('.isotope-layout').forEach(function(isotopeItem) {
    let layout = isotopeItem.getAttribute('data-layout') ?? 'masonry';
    let filter = isotopeItem.getAttribute('data-default-filter') ?? '*';
    let sort = isotopeItem.getAttribute('data-sort') ?? 'original-order';

    let initIsotope;
    imagesLoaded(isotopeItem.querySelector('.isotope-container'), function() {
      initIsotope = new Isotope(isotopeItem.querySelector('.isotope-container'), {
        itemSelector: '.isotope-item',
        layoutMode: layout,
        filter: filter,
        sortBy: sort
      });
    });

    isotopeItem.querySelectorAll('.isotope-filters li').forEach(function(filters) {
      filters.addEventListener('click', function() {
        isotopeItem.querySelector('.isotope-filters .filter-active').classList.remove('filter-active');
        this.classList.add('filter-active');
        initIsotope.arrange({
          filter: this.getAttribute('data-filter')
        });
        if (typeof aosInit === 'function') {
          aosInit();
        }
      }, false);
    });

  });

  /**
   * Init swiper sliders
   */
  function initSwiper() {
    document.querySelectorAll(".init-swiper").forEach(function(swiperElement) {
      let config = JSON.parse(
        swiperElement.querySelector(".swiper-config").innerHTML.trim()
      );

      if (swiperElement.classList.contains("swiper-tab")) {
        initSwiperWithCustomPagination(swiperElement, config);
      } else {
        new Swiper(swiperElement, config);
      }
    });
  }

  window.addEventListener("load", initSwiper);

  /**
   * Initiate Pure Counter
   */
  new PureCounter();

})();