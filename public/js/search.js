document.addEventListener("DOMContentLoaded", () => {
    // --- SEARCH ---
    document.querySelectorAll(".searchInput").forEach(input => {
        input.addEventListener("keyup", function () {
            const value = this.value.toLowerCase();
            const tableId = this.dataset.target;
            const rows = document.querySelectorAll(`#${tableId} tbody tr`);

            rows.forEach(row => {
                const text = row.innerText.toLowerCase();
                row.style.display = text.includes(value) ? "" : "none";
            });


        });
    });

});
