document.addEventListener("DOMContentLoaded", () => {
    document.querySelectorAll(".searchInput").forEach(input => {
        input.addEventListener("keyup", function () {
            const value = this.value.toLowerCase();
            const tableId = this.dataset.target;
            const rows = document.querySelectorAll(`#${tableId} tbody tr`);

            if (value) {
                // --- Search aktif: tampilkan semua data ---
                rows.forEach(row => {
                    const text = row.innerText.toLowerCase();
                    row.style.display = text.includes(value) ? "" : "none";
                });

                // Matikan pagination sementara
                document.querySelector(".pagination").style.display = "none";
            } else {
                // --- Search kosong: tampilkan data sesuai pagination lagi ---
                rows.forEach(row => (row.style.display = ""));
                document.querySelector(".pagination").style.display = "block";
                // jalankan ulang fungsi showPage(1) atau apapun logika pagination Anda
            }
        });
    });
});
