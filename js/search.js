document.addEventListener("DOMContentLoaded", function () {
  const searchInput = document.getElementById("searchInput");
  const table = document.getElementById("table");
  const rows = table.getElementsByTagName("tr");

  searchInput.addEventListener("input", function () {
    const searchQuery = searchInput.value.trim().toLowerCase();
    for (let i = 1; i < rows.length; i++) {
      // Start from index 1 to skip header row
      const row = rows[i];
      const cells = row.getElementsByTagName("td");
      let found = false;

      for (let j = 0; j < cells.length; j++) {
        const cell = cells[j];
        if (cell.textContent.toLowerCase().includes(searchQuery)) {
          found = true;
          break;
        }
      }

      if (found) {
        row.style.display = "";
      } else {
        row.style.display = "none";
      }
    }
  });
});