    document.getElementsByClassName('searchInput').addEventListener('keyup', function() {
                        let value = this.value.toLowerCase();
                        let rows = document.querySelectorAll('#infoTable tbody tr');
                        rows.forEach(row => {
                            let text = row.innerText.toLowerCase();
                            row.style.display = text.includes(value) ? '' : 'none';
                        });
                    });
