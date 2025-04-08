document.addEventListener("DOMContentLoaded", function () {
    updateFileList();

    let fileInput = document.getElementById("fileUploadInput");
    if (fileInput) {
        fileInput.removeEventListener("change", uploadFile); // Hapus dulu jika ada (opsional)
        fileInput.addEventListener("change", uploadFile); // Tambahkan event listener
    } else {
        console.error("Elemen dengan ID 'fileUploadInput' tidak ditemukan.");
    }
});

function updateFileList() {
    let fileContainer = document.getElementById("fileContainer");
    if (!fileContainer) {
        console.error("❌ Elemen fileContainer tidak ditemukan!");
        return;
    }

    fetch("http://localhost/plnmanagement/backend/get_files.php")
        .then(response => response.json())
        .then(data => {
            console.log("🔥 Data dari backend:", data); // Debug hasil dari backend

            fileContainer.innerHTML = "";

            // ✅ Perbaiki pengecekan apakah ada file
            if (!data.files || !Array.isArray(data.files) || data.files.length === 0) {
                console.warn("⚠ Tidak ada file yang diunggah.");
                fileContainer.innerHTML = "<p class='text-center'>Tidak ada file yang diunggah.</p>";
                return;
            }

            // ✅ Looping file dengan tampilan card
            data.files.forEach(file => {
                let filePath = `http://localhost/plnmanagement/uploads/${file}`; // Sesuaikan path

                let fileItem = `
    <div class="col-md-2 mb-2">
        <div class="card">
            <a href="${filePath}" target="_blank">
                <img src="https://upload.wikimedia.org/wikipedia/commons/8/87/PDF_file_icon.svg"
                    class="card-img-top" style="height:50px; object-fit:contain;">
            </a>
            <div class="card-body text-center">
                <p class="card-text">${file.replace(/^\/+/, '')}</p>
                <button class="btn btn-sm btn-danger" onclick="deleteFile('${file}')">🗑 Hapus</button>
            </div>
        </div>
    </div>`;
                fileContainer.innerHTML += fileItem;
            });
        })
        .catch(error => console.error("❌ Error fetching file list:", error));
}

async function uploadFile() {
    let fileInput = document.getElementById("fileUploadInput");
    if (!fileInput || !fileInput.files.length) {
        alert("Tidak ada file yang dipilih.");
        return;
    }

    let formData = new FormData();
    for (let file of fileInput.files) {
        console.log(`File: ${file.name}`);
        formData.append("files[]", file); // Pastikan konsisten dengan backend
    }

    try {
        let response = await fetch('backend/upload.php', {
            method: 'POST',
            body: formData
        });

        let text = await response.text();
        console.log("Raw response:", text);

        let data = JSON.parse(text);
        console.log("Parsed JSON:", data);

        alert(data.message);
        if (data.status === "success") {
            updateFileList(); // Perbarui daftar file setelah upload sukses
        }
    } catch (error) {
        console.error("Upload error:", error);
        alert("Terjadi kesalahan saat mengunggah file.");
    }
}

function deleteFile(fileName) {
    let formData = new FormData();
    formData.append("filename", fileName);

    fetch("backend/delete_file.php", {
        method: "POST",
        body: formData
    })
        .then(response => response.json())
        .then(data => {
            if (data.status === "success") {
                alert("File berhasil dihapus!");
                updateFileList(); // 🔄 Refresh daftar file
            } else {
                alert("Gagal menghapus file: " + data.message);
            }
        })
        .catch(error => console.error("Error deleting file:", error));
}

function downloadFile(fileName) {
    window.location.href = `http://localhost/plnmanagement/backend/download.php?file=${fileName}`;
}

function createFolder() {
    let folderName = document.getElementById("folderName").value;
    if (folderName.trim() === "") {
        alert("Nama folder tidak boleh kosong");
        return;
    }

    let formData = new FormData();
    formData.append("folder_name", folderName);

    fetch("http://localhost/plnmanagement/backend/create_folder.php", {
        method: "POST",
        body: formData
    })
        .then(response => response.json())
        .then(data => {
            alert(data.message);
            updateFileList();
        })
        .catch(error => console.error("Error creating folder:", error));
}

function uploadFolder() {
    let folderInput = document.getElementById("folderUploadInput");
    if (!folderInput || !folderInput.files.length) {
        alert("Tidak ada folder yang dipilih.");
        return;
    }

    let formData = new FormData();
    for (let file of folderInput.files) {
        let relativePath = file.webkitRelativePath;
        console.log(`File: ${file.name}, Path: ${relativePath}`);
        formData.append("files[]", file);
        formData.append("paths[]", relativePath);
    }

    fetch("http://localhost/plnmanagement/backend/upload.php", {
        method: "POST",
        body: formData
    })
        .then(response => response.text())
        .then(text => {
            console.log("Server response:", text); // Debugging
            let data;
            try {
                data = JSON.parse(text);
            } catch (error) {
                console.error("Response bukan JSON:", text);
                alert("Terjadi kesalahan: Server tidak mengembalikan JSON yang valid.");
                return;
            }

            if (data.status === "success") {
                alert("Upload folder berhasil: " + data.message);
                location.reload();
            } else {
                alert("Upload gagal: " + data.message);
            }
        })
        .catch(error => {
            console.error("Error:", error);
            alert("Upload gagal: " + error.message);
        });
}
