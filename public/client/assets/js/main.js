(function () {
    "use strict";

    /** Toggle scrolled class */
    function toggleScrolled() {
        const selectBody = document.querySelector("body");
        const selectHeader = document.querySelector("#header");
        if (!selectHeader) return;
        if (
            !selectHeader.classList.contains("scroll-up-sticky") &&
            !selectHeader.classList.contains("sticky-top") &&
            !selectHeader.classList.contains("fixed-top")
        )
            return;

        if (window.scrollY > 100) {
            selectBody.classList.add("scrolled");
        } else {
            selectBody.classList.remove("scrolled");
        }
    }
    document.addEventListener("scroll", toggleScrolled);
    window.addEventListener("load", toggleScrolled);

    /** Mobile nav toggle */
    const mobileNavToggleBtn = document.querySelector(".mobile-nav-toggle");
    function mobileNavToogle() {
        document.querySelector("body").classList.toggle("mobile-nav-active");
        mobileNavToggleBtn.classList.toggle("bi-list");
        mobileNavToggleBtn.classList.toggle("bi-x");
    }
    if (mobileNavToggleBtn) {
        mobileNavToggleBtn.addEventListener("click", mobileNavToogle);
    }

    // nav menu
    document.querySelectorAll("#navmenu a").forEach((navmenu) => {
        navmenu.addEventListener("click", (e) => {
            let parent = navmenu.parentNode;

            // Jika link punya submenu (dropdown)
            if (parent.classList.contains("dropdown")) {
                e.preventDefault(); // cegah close navbar
                parent.classList.toggle("active"); // ⬅️ ini yang atur icon + submenu
                let submenu = parent.querySelector("ul");
                if (submenu) submenu.classList.toggle("dropdown-active");
                return;
            }

            // Kalau link biasa, tutup navbar
            if (document.querySelector(".mobile-nav-active")) {
                mobileNavToogle();
            }
        });
    });

    /** Preloader */
    const preloader = document.querySelector("#preloader");
    if (preloader) {
        window.addEventListener("load", () => preloader.remove());
    }

    /** Scroll top button */
    let scrollTop = document.querySelector(".scroll-top");
    function toggleScrollTop() {
        if (scrollTop) {
            window.scrollY > 100
                ? scrollTop.classList.add("active")
                : scrollTop.classList.remove("active");
        }
    }
    if (scrollTop) {
        scrollTop.addEventListener("click", (e) => {
            e.preventDefault();
            window.scrollTo({ top: 0, behavior: "smooth" });
        });
    }
    window.addEventListener("load", toggleScrollTop);
    document.addEventListener("scroll", toggleScrollTop);

    /** Animation on scroll */
    function aosInit() {
        if (typeof AOS !== "undefined") {
            AOS.init({
                duration: 600,
                easing: "ease-in-out",
                once: true,
                mirror: false,
            });
        }
    }
    window.addEventListener("load", aosInit);

    /** GLightbox */
    if (typeof GLightbox !== "undefined") {
        GLightbox({ selector: ".glightbox" });
    }

    /** Pure Counter */
    if (typeof PureCounter !== "undefined") {
        new PureCounter();
    }

    /** Init Swiper sliders (with JSON safety) */
    function initSwiper() {
        document
            .querySelectorAll(".init-swiper")
            .forEach(function (swiperElement) {
                let configEl = swiperElement.querySelector(".swiper-config");
                if (!configEl) return;
                try {
                    let config = JSON.parse(configEl.innerHTML.trim());
                    if (swiperElement.classList.contains("swiper-tab")) {
                        if (
                            typeof initSwiperWithCustomPagination === "function"
                        ) {
                            initSwiperWithCustomPagination(
                                swiperElement,
                                config
                            );
                        }
                    } else {
                        new Swiper(swiperElement, config);
                    }
                } catch (err) {
                    console.warn("⚠ Swiper config JSON error:", err);
                }
            });
    }
    window.addEventListener("load", initSwiper);

    /** Init Isotope layout */
    document
        .querySelectorAll(".isotope-layout")
        .forEach(function (isotopeItem) {
            let layout = isotopeItem.getAttribute("data-layout") ?? "masonry";
            let filter = isotopeItem.getAttribute("data-default-filter") ?? "*";
            let sort =
                isotopeItem.getAttribute("data-sort") ?? "original-order";

            let container = isotopeItem.querySelector(".isotope-container");
            if (!container) return;

            let initIsotope;
            imagesLoaded(container, function () {
                initIsotope = new Isotope(container, {
                    itemSelector: ".isotope-item",
                    layoutMode: layout,
                    filter: filter,
                    sortBy: sort,
                });
            });

            isotopeItem
                .querySelectorAll(".isotope-filters li")
                .forEach(function (filters) {
                    filters.addEventListener(
                        "click",
                        function () {
                            let activeFilter = isotopeItem.querySelector(
                                ".isotope-filters .filter-active"
                            );
                            if (activeFilter)
                                activeFilter.classList.remove("filter-active");
                            this.classList.add("filter-active");
                            initIsotope.arrange({
                                filter: this.getAttribute("data-filter"),
                            });
                            aosInit();
                        },
                        false
                    );
                });
        });

    /** Correct scrolling for hash links */
    window.addEventListener("load", function () {
        if (window.location.hash) {
            let target = document.querySelector(window.location.hash);
            if (target) {
                setTimeout(() => {
                    let scrollMarginTop =
                        getComputedStyle(target).scrollMarginTop;
                    window.scrollTo({
                        top: target.offsetTop - parseInt(scrollMarginTop),
                        behavior: "smooth",
                    });
                }, 100);
            }
        }
    });

    /** Navmenu Scrollspy */
    let navmenulinks = document.querySelectorAll(".navmenu a");
    function navmenuScrollspy() {
        navmenulinks.forEach((navmenulink) => {
            if (!navmenulink.hash) return;
            let section = document.querySelector(navmenulink.hash);
            if (!section) return;
            let position = window.scrollY + 200;
            if (
                position >= section.offsetTop &&
                position <= section.offsetTop + section.offsetHeight
            ) {
                document
                    .querySelectorAll(".navmenu a.active")
                    .forEach((link) => link.classList.remove("active"));
                navmenulink.classList.add("active");
            } else {
                navmenulink.classList.remove("active");
            }
        });
    }
    window.addEventListener("load", navmenuScrollspy);
    document.addEventListener("scroll", navmenuScrollspy);
})();

// Efek pop-up Informasi Section
const informasiSection = document.querySelector(".informasi-section");

if (informasiSection) {
    function showInformasiOnScroll() {
        const rect = informasiSection.getBoundingClientRect();
        if (rect.top < window.innerHeight - 100) {
            informasiSection.classList.add("show");
            window.removeEventListener("scroll", showInformasiOnScroll); // supaya cuma sekali jalan
        }
    }
    window.addEventListener("scroll", showInformasiOnScroll);
}

document
    .querySelector(".profil-search-btn")
    .addEventListener("click", function () {
        const kec = document.getElementById("kecamatan").value;
        const desa = document.getElementById("desa").value;

        if (kec && desa) {
            window.location.href = `/profil?kecamatan=${kec}&desa=${desa}`;
        } else {
            alert("Silakan pilih Kecamatan dan Desa terlebih dahulu!");
        }
    });

// section informasi


document.addEventListener("DOMContentLoaded", function () {
  const cardsContainer = document.querySelector(".informasi-cards");
  const pagination = document.querySelector(".informasi-pagination");
  if (!cardsContainer || !pagination) return;

  let cardFullWidth = 0;   // lebar 1 card + gap
  let scrollStep = 0;
  let totalPages = 0;

  function computeSizes() {
    const firstCard = cardsContainer.querySelector(".informasi-card");
    if (!firstCard) return;

    // Ambil GAP dari container (bukan margin card)
    const cs = window.getComputedStyle(cardsContainer);
    const gap = parseInt(cs.columnGap || cs.gap || 0) || 0;

    cardFullWidth = firstCard.offsetWidth + gap;

    // Berapa card yang muat di viewport saat ini
    const cardsPerView = Math.max(
      1,
      Math.floor((cardsContainer.clientWidth + gap) / cardFullWidth)
    );

    // Step geser:
    // Desktop (>=4) geser 3; selain itu geser = jumlah card yang terlihat
    if (cardsPerView >= 4) {
      scrollStep = cardFullWidth * 3;
    } else {
      scrollStep = cardFullWidth * cardsPerView;
    }

    buildDots();
    setActiveDot(); // sinkron awal
  }

  function buildDots() {
    pagination.innerHTML = "";
    const maxScroll = cardsContainer.scrollWidth - cardsContainer.clientWidth;
    totalPages = Math.max(1, Math.ceil(maxScroll / scrollStep) + 1);

    for (let i = 0; i < totalPages; i++) {
      const dot = document.createElement("span");
      dot.className = "dot" + (i === 0 ? " active" : "");
      dot.addEventListener("click", () => {
        const max = cardsContainer.scrollWidth - cardsContainer.clientWidth;
        const target = Math.min(i * scrollStep, max);
        cardsContainer.scrollTo({ left: target, behavior: "smooth" });
      });
      pagination.appendChild(dot);
    }
  }

  function setActiveDot() {
    const dots = pagination.querySelectorAll(".dot");
    if (!dots.length || !scrollStep) return;
    let index = Math.round(cardsContainer.scrollLeft / scrollStep);
    index = Math.min(index, dots.length - 1);
    dots.forEach((d, i) => d.classList.toggle("active", i === index));
  }

  // Recalc saat resize & setelah semua asset (gambar) loaded
  window.addEventListener("resize", computeSizes);
  window.addEventListener("load", computeSizes);

  // Update dot saat discroll
  cardsContainer.addEventListener("scroll", setActiveDot);

  // Inisialisasi awal
  computeSizes();
});

// Product Kups

document.addEventListener("DOMContentLoaded", () => {
  const slides = document.querySelectorAll(".slide");
  let currentIndex = 0;

  function showSlide(index) {
    slides.forEach((slide, i) => {
      slide.classList.remove("active");
      if (i === index) {
        slide.classList.add("active");
      }
    });
  }

  function nextSlide() {
    currentIndex = (currentIndex + 1) % slides.length;
    showSlide(currentIndex);
  }

  setInterval(nextSlide, 3000); // 3 detik ganti slide
});

// navbar global
document.addEventListener("DOMContentLoaded", () => {
    const header = document.querySelector("#header");

    if (!header) return;

    function toggleHeaderScrolled() {
        if (window.scrollY > 608) {
            header.classList.add("header-scrolled");
        } else {
            // hanya untuk halaman home yang bisa balik transparan
            if (document.body.classList.contains("index-page")) {
                header.classList.remove("header-scrolled");
            }
        }
    }

    // jalankan saat load pertama
    toggleHeaderScrolled();

    // jalankan tiap kali scroll
    window.addEventListener("scroll", toggleHeaderScrolled);
});


/*--------------------------------------------------------------
# Progres Section
--------------------------------------------------------------*/
document.addEventListener("DOMContentLoaded", () => {
    const items = document.querySelectorAll(".progres-item");
    const progresList = document.getElementById("progresList");

    let visibleCount = 3;

    function showItems() {
        items.forEach((item, index) => {
            if (index < visibleCount) {
                item.style.display = "flex";
            } else {
                item.style.display = "none";
            }
        });
    }

    // awal load tampil 3
    showItems();

    // scroll untuk load lebih banyak
    progresList.addEventListener("scroll", () => {
        if (progresList.scrollTop + progresList.clientHeight >= progresList.scrollHeight) {
            visibleCount += 3; // load 3 lagi
            showItems();
        }
    });

    // search filter
    document.getElementById("searchBtn").addEventListener("click", () => {
        const keyword = document.getElementById("searchInput").value.toLowerCase();
        items.forEach(item => {
            const title = item.querySelector("h6").innerText.toLowerCase();
            item.style.display = title.includes(keyword) ? "flex" : "none";
        });
    });
});


// switch triwulan monev client

document.addEventListener("DOMContentLoaded", function () {
  const tabs = document.querySelectorAll(".tab-btn");
  const contents = document.querySelectorAll(".table-content");

  tabs.forEach(tab => {
    tab.addEventListener("click", () => {
      // hapus semua active
      tabs.forEach(t => t.classList.remove("active"));
      contents.forEach(c => c.classList.remove("active"));

      // tambahkan active ke tab yg diklik
      tab.classList.add("active");
      document.getElementById(tab.dataset.target).classList.add("active");
    });
  });
});

// navbar profill

$(document).ready(function() {
    // Aktifkan searchable dropdown
    $('.select2').select2({
      width: '100%',
      dropdownParent: $('.profil-dropdown') // biar dropdown gak kabur
    });

    // Tombol Cari
    $('.profil-search-btn').on('click', function(){
      let kecamatan = $('#kecamatan').val();
      let desa = $('#desa').val();
      alert("Kecamatan: " + kecamatan + " | Desa: " + desa);
      // nanti tinggal arahkan ke halaman sesuai filter
    });
  });



//   detail dokumentasi page profil progres regulasi



    
