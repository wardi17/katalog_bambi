import { baseUrl } from '../../config.js';

class SaveImport {
  constructor(containerSelector) {
    this.container = document.querySelector(containerSelector);
    this.handleAddClick();
    this.appendCustomStyles();
  }

  appendCustomStyles() {
    const style = document.createElement('style');
    style.textContent = `
      #thead {
        background-color: #E7CEA6 !important;
      }
      .table-hover tbody tr:hover td,
      .table-hover tbody tr:hover th {
        background-color: #F3FEB8;
      }
      .dataTables_filter {
        padding-bottom: 20px !important;
      }
    `;
    document.head.appendChild(style);
  }

  handleAddClick() {
    // Saat pilih file
    document.getElementById('upload_file').addEventListener('change', function (e) {
      const fileName = e.target.files.length ? e.target.files[0].name : 'Belum ada file dipilih';
      document.getElementById('file_name').textContent = fileName;
    });

    // Submit form
    const self = this;
    document.getElementById('form_upload_excel').addEventListener('submit', async function (e) {
      e.preventDefault();
      await self.saveDataFrom(e);
    });
  }

  async saveDataFrom(e) {
    const dataInput = await this.validateInput(e);
    if (!dataInput) return;

    try {
      const response = await this.sendDataToApi(dataInput);

      // ✅ tampilkan pesan berhasil
      this.showSuccessMessage(response);

      // reset file input
      document.getElementById("upload_file").value = "";
      document.getElementById("file_name").textContent = "Belum ada file dipilih";
      this.hideProgressBar();

    } catch (error) {
      this.hideProgressBar();
      this.showErrorMessage(error);
    }
  }

  async validateInput(event) {
    const file_excel = $("#upload_file")[0].files[0];
    const data = { idimport: this.generateUniqueId() };
    let valid = true;

    if (!file_excel) {
      $("#file_name")
        .removeClass()
        .addClass("text-red-600 font-semibold animate-pulse")
        .text("Tidak ada file yang diupload");
      valid = false;
    }

    if (!valid) {
      event.preventDefault();
      return false;
    }

    const formData = new FormData();
    formData.append("data", JSON.stringify(data));
    formData.append("files", file_excel);

    return formData;
  }

  async sendDataToApi(formData) {
    return new Promise((resolve, reject) => {
      const xhr = new XMLHttpRequest();

      xhr.open("POST", `${baseUrl}/router/seturl`);
      xhr.setRequestHeader("url", "import/savedata");

      // Progress bar update
      const progressContainer = document.getElementById("progressbar");
      const progressInner = document.getElementById("progress-inner");
      const progressText = document.getElementById("progress-text");

      progressContainer.classList.remove("hidden");

      xhr.upload.addEventListener("progress", (event) => {
        if (event.lengthComputable) {
          const percent = Math.round((event.loaded / event.total) * 100);
          progressInner.style.width = percent + "%";
          progressText.textContent = `Uploading... ${percent}%`;
        }
      });

      xhr.onload = function () {
        try {
          const result = JSON.parse(xhr.responseText);
          if (result?.data?.status === "success") {
            resolve(result.data.message || "File berhasil diupload!");
          } else {
            reject(result?.data?.message || "Upload gagal, periksa kembali file Anda.");
          }
        } catch (err) {
          reject("Respon server tidak valid.");
        }
      };

      xhr.onerror = function () {
        reject("Terjadi kesalahan pada koneksi server.");
      };

      xhr.send(formData);
    });
  }

  hideProgressBar() {
    const bar = document.getElementById("progressbar");
    if (bar) bar.classList.add("hidden");
  }

  showSuccessMessage(message) {
    Swal.fire({
      position: 'center',
      icon: 'success',
      title: 'Berhasil!',
      text: message || 'Data berhasil disimpan.',
      showConfirmButton: false,
      timer: 1500
    });
  }

  showErrorMessage(message) {
    Swal.fire({
      icon: "error",
      title: "Gagal!",
      text: message || "Terjadi kesalahan saat menyimpan data."
    });
  }

  generateUniqueId() {
    const hashHex = Date.now() + Math.random().toString(36).substring(2, 10);
    return `GMA-${hashHex.substring(0, 8)}`;
  }
}

export default SaveImport;
