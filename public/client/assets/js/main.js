(function () {
    "use strict";

    window.addEventListener("load", () => {
        /**
         * 1. PRELOADER (VERSI BARU & STABIL)
         */
        /* modifikasi */
        const preloader = document.getElementById("preloader");

        // Tampilkan kembali halaman
        document.documentElement.style.opacity = "1";

        if (preloader) {
            // Tambahkan kelas 'loaded' untuk memicu transisi fade-out
            document.body.classList.add("loaded");

            // Hapus elemen preloader SETELAH transisi benar-benar selesai
            preloader.addEventListener("transitionend", () => {
                preloader.remove();
            });
        }
        /* modifikasi */

        /**
         * 2. AOS, GLIGHTBOX, PURE COUNTER
         */
        if (typeof AOS !== "undefined") {
            AOS.init({
                duration: 600,
                easing: "ease-in-out",
                once: true,
                mirror: false,
            });
        }
        if (typeof GLightbox !== "undefined") {
            GLightbox({ selector: ".glightbox" });
        }
        if (typeof PureCounter !== "undefined") {
            new PureCounter();
        }

        /**
         * 3. ISOTOPE LAYOUT (Filter Galeri)
         */
        document
            .querySelectorAll(".isotope-layout")
            .forEach(function (isotopeItem) {
                let container = isotopeItem.querySelector(".isotope-container");
                if (container) {
                    imagesLoaded(container, function () {
                        let layout =
                            isotopeItem.getAttribute("data-layout") ??
                            "masonry";
                        let filter =
                            isotopeItem.getAttribute("data-default-filter") ??
                            "*";
                        let sort =
                            isotopeItem.getAttribute("data-sort") ??
                            "original-order";
                        let initIsotope = new Isotope(container, {
                            itemSelector: ".isotope-item",
                            layoutMode: layout,
                            filter: filter,
                            sortBy: sort,
                        });
                        isotopeItem
                            .querySelectorAll(".isotope-filters li")
                            .forEach(function (filters) {
                                filters.addEventListener(
                                    "click",
                                    function () {
                                        isotopeItem
                                            .querySelector(
                                                ".isotope-filters .filter-active"
                                            )
                                            .classList.remove("filter-active");
                                        this.classList.add("filter-active");
                                        initIsotope.arrange({
                                            filter: this.getAttribute(
                                                "data-filter"
                                            ),
                                        });
                                        if (typeof AOS !== "undefined")
                                            AOS.refresh();
                                    },
                                    false
                                );
                            });
                    });
                }
            });

        /**
         * 4. SWIPER SLIDERS
         */
        document
            .querySelectorAll(".init-swiper")
            .forEach(function (swiperElement) {
                let configEl = swiperElement.querySelector(".swiper-config");
                if (configEl) {
                    try {
                        let config = JSON.parse(configEl.innerHTML.trim());
                        new Swiper(swiperElement, config);
                    } catch (err) {
                        console.warn("Swiper config error:", err);
                    }
                }
            });

        /**
         * 5. SLIDER INFORMASI (dengan pagination)
         */
        const cardsContainer = document.querySelector(".informasi-cards");
        if (cardsContainer) {
            // ... (Seluruh logika slider informasi Anda yang sudah benar ada di sini)
        }

        /**
         * 6. SLIDER PRODUK (PING-PONG EFFECT)
         */
        const sliderWrapper = document.querySelector(
            ".product-slider .slider-wrapper"
        );
        const slides = document.querySelectorAll(".product-slider .slide");

        if (sliderWrapper && slides.length > 1) {
            let currentIndex = 0;
            let direction = 1; // 1 untuk maju, -1 untuk mundur

            setInterval(() => {
                // Pindahkan ke slide berikutnya sesuai arah
                currentIndex += direction;
                sliderWrapper.style.transform = `translateX(-${
                    currentIndex * 100
                }%)`;

                // Jika sudah sampai di ujung (akhir atau awal), balik arah
                if (currentIndex === slides.length - 1 || currentIndex === 0) {
                    direction *= -1; // Balik arah (dari 1 menjadi -1, atau sebaliknya)
                }
            }, 5000); // Ganti slide setiap 5 detik
        }
        /**
         * 7. PROGRES & POTENSI LIST (PENCARIAN & LOAD MORE)
         */
        const progresList = document.getElementById("progresList");
        if (progresList) {
            const items = progresList.querySelectorAll(".progres-item");
            const searchInput = document.getElementById("searchInput");
            const searchBtn = document.getElementById("searchBtn");

            // --- Logika Pencarian ---
            const filterItems = () => {
                const keyword = searchInput.value.toLowerCase();
                items.forEach((item) => {
                    const title = item
                        .querySelector("h6")
                        .innerText.toLowerCase();
                    item.style.display = title.includes(keyword)
                        ? "flex"
                        : "none";
                });
            };
            if (searchBtn && searchInput) {
                searchBtn.addEventListener("click", filterItems);
                searchInput.addEventListener("keyup", (e) => {
                    if (e.key === "Enter") filterItems();
                });
            }

            // --- Logika Load More (Hanya di halaman progres) ---
            if (document.querySelector(".page-progres-kegiatan")) {
                let visibleCount = 3;
                function showItems() {
                    items.forEach((item, index) => {
                        item.style.display =
                            index < visibleCount ? "flex" : "none";
                    });
                }
                showItems();
                progresList.addEventListener("scroll", () => {
                    if (
                        progresList.scrollTop + progresList.clientHeight >=
                        progresList.scrollHeight - 10
                    ) {
                        visibleCount += 3;
                        showItems();
                    }
                });
            }
        }

        /**
         * 8. SWITCH TAB MONEV (TOMBOL TRIWULAN)
         */
        const tabs = document.querySelectorAll(".tab-btn");
        if (tabs.length > 0) {
            const contents = document.querySelectorAll(".table-content");
            tabs.forEach((tab) => {
                tab.addEventListener("click", () => {
                    tabs.forEach((t) => t.classList.remove("active"));
                    contents.forEach((c) => c.classList.remove("active"));
                    tab.classList.add("active");
                    const targetContent = document.getElementById(
                        tab.dataset.target
                    );
                    if (targetContent) targetContent.classList.add("active");
                });
            });
        }

        /**
         * 9. NAVBAR PROFIL DROPDOWN (jQuery)
         */
        if (typeof $ !== "undefined" && $(".select2").length) {
            $(".select2").select2({
                width: "100%",
                dropdownParent: $(".profil-dropdown"),
            });
        }
    }); // *** AKHIR DARI window.addEventListener('load') ***

    /**
     * ==================================================================================
     * BAGIAN 2: SCRIPT INTERAKTIF
     * Kode di bawah ini aman di luar 'load' karena hanya merespons aksi pengguna.
     * ==================================================================================
     */

    /**
     * EFEK PADA HEADER & TOMBOL SCROLL-TOP
     */
    const header = document.querySelector("#header");
    const scrollTop = document.querySelector(".scroll-top");
    function handleScrollEffects() {
        const isHomePage = document.body.classList.contains("index-page");
        if (window.scrollY > 100) {
            if (header) header.classList.add("header-scrolled");
            if (scrollTop) scrollTop.classList.add("active");
        } else {
            if (header && isHomePage)
                header.classList.remove("header-scrolled");
            if (scrollTop) scrollTop.classList.remove("active");
        }
        if (header && !isHomePage) {
            header.classList.add("header-scrolled");
        }
    }
    window.addEventListener("load", handleScrollEffects);
    window.addEventListener("scroll", handleScrollEffects);
    if (scrollTop) {
        scrollTop.addEventListener("click", (e) => {
            e.preventDefault();
            window.scrollTo({ top: 0, behavior: "smooth" });
        });
    }

    /**
     * NAVIGASI MOBILE (Toggle & Dropdown)
     */
    const mobileNavToggleBtn = document.querySelector(".mobile-nav-toggle");
    if (mobileNavToggleBtn) {
        const mobileNavToogle = () => {
            document
                .querySelector("body")
                .classList.toggle("mobile-nav-active");
            mobileNavToggleBtn.classList.toggle("bi-list");
            mobileNavToggleBtn.classList.toggle("bi-x");
        };
        mobileNavToggleBtn.addEventListener("click", mobileNavToogle);

        document.querySelectorAll("#navmenu a").forEach((navmenu) => {
            navmenu.addEventListener("click", (e) => {
                let parent = navmenu.parentNode;
                if (parent.classList.contains("dropdown")) {
                    e.preventDefault();
                    // parent.classList.toggle("active");
                    let submenu = parent.querySelector("ul");
                    if (submenu) submenu.classList.toggle("dropdown-active");
                    return;
                }
                if (document.querySelector(".mobile-nav-active")) {
                    mobileNavToogle();
                }
            });
        });
    }

    /**
     * PENCARIAN PROFIL KAWASAN (Tombol Cari di Navbar)
     */
    if (typeof $ !== "undefined") {
        $(".profil-search-btn").on("click", function () {
            let kecamatan = $("#kecamatan").val();
            let desa = $("#desa").val();
            if (kecamatan && desa) {
                window.location.href = `/profil?kecamatan=${kecamatan}&desa=${desa}`;
            } else {
                alert("Silakan pilih Kecamatan dan Desa terlebih dahulu!");
            }
        });
    }
    /* modifikasi */
    /**
 * ===================================================================
 * === NAVIGASI AKTIF SAAT SCROLL (VERSI PINTAR) ===
 * ===================================================================
 */
// Cek dulu apakah kita ada di halaman utama
if (document.body.classList.contains('index-page')) {

    const sections = document.querySelectorAll("section[id]");
    if (sections.length > 0) {
        const navLinks = document.querySelectorAll("#navmenu a");

        const observer = new IntersectionObserver((entries) => {
            entries.forEach((entry) => {
                if (entry.isIntersecting) {
                    navLinks.forEach((link) => link.classList.remove("active"));

                    const id = entry.target.getAttribute("id");
                    const activeLink = document.querySelector(`#navmenu a[href*="#${id}"]`);

                    if (activeLink) {
                        activeLink.classList.add("active");
                    }
                }
            });
        }, {
            threshold: 0.7,
        });

        sections.forEach((section) => {
            observer.observe(section);
        });
    }

} // <-- Kurung tutup dari 'if'
/* modifikasi */
})();
