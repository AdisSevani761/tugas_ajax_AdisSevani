<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Live Search Mahasiswa</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
</head>
<body class="p-4">
<div class="container">
    <h2 class="mb-4">Live Search Mahasiswa (AJAX + MySQL)</h2>
    <div class="d-flex mb-3">
        <input type="text" id="search" class="form-control me-2" placeholder="Ketik nama atau NIM...">
        <button type="button" class="btn btn-success me-2" id="exportBtn">Export Excel</button>
        <button type="button" class="btn btn-danger" id="exportPdfBtn">Export PDF</button>
    </div>
    <div id="loading" class="text-primary mb-2" style="display:none;">
        <div class="spinner-border spinner-border-sm" role="status"></div> Mencari...
    </div>
    <table class="table table-bordered table-striped">
        <thead>
        <tr>
            <th>NIM</th>
            <th>Nama</th>
            <th>Jurusan</th>
        </tr>
        </thead>
        <tbody id="result"></tbody>
    </table>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
const searchBox = document.getElementById("search");
const result = document.getElementById("result");
const loading = document.getElementById("loading");

searchBox.addEventListener("keyup", function () {
    const keyword = searchBox.value.trim();
    if (keyword.length === 0) {
        result.innerHTML = "";
        return;
    }

    loading.style.display = "block";
    fetch("search.php?keyword=" + encodeURIComponent(keyword))
        .then(res => res.json())
        .then(data => {
            loading.style.display = "none";
            result.innerHTML = "";

            if (data.length === 0) {
                result.innerHTML = "<tr><td colspan='3' class='text-center'>Data tidak ditemukan</td></tr>";
            } else {
                data.forEach(row => {
                    const tr = document.createElement("tr");
                    tr.innerHTML = `<td>${row.nim}</td><td>${row.nama}</td><td>${row.jurusan}</td>`;
                    tr.classList.add("fade-in");
                    result.appendChild(tr);
                });
            }
        });
});

const exportBtn = document.getElementById("exportBtn");
exportBtn.addEventListener("click", function () {
    const keyword = searchBox.value.trim();
    const url = "export_excel.php?keyword=" + encodeURIComponent(keyword);
    window.open(url, "_blank");
});

const exportPdfBtn = document.getElementById("exportPdfBtn");
exportPdfBtn.addEventListener("click", function () {
    const keyword = searchBox.value.trim();
    const url = "export_pdf.php?keyword=" + encodeURIComponent(keyword);
    window.open(url, "_blank");
});
</script>
</body>
</html>
