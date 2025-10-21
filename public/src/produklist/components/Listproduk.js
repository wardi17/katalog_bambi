import { baseUrl } from '../../config.js';

class ListProduk {
  constructor() {
    this.root = document.getElementById('root');
    this.appendCustomStyles();
    this.render();
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
      .preview-img {
        width: 60px;
        height: auto;
        border-radius: 5px;
        cursor: pointer;
        transition: transform 0.2s, box-shadow 0.2s;
      }
      .preview-img:hover {
        transform: scale(1.1);
        box-shadow: 0 0 8px rgba(0,0,0,0.3);
      }
      .video-link {
        color: #007bff;
        text-decoration: underline;
        cursor: pointer;
      }
      .video-link:hover {
        color: #0056b3;
      }
      /* === MODAL === */
      .modal {
        display: none;
        position: fixed;
        z-index: 1000;
        inset: 0;
        background-color: rgba(0, 0, 0, 0.85);
        justify-content: center;
        align-items: center;
        overflow: auto;
        padding: 20px;
      }
      .modal-content {
        position: relative;
        max-width: 80vw;
        max-height: 80vh;
        display: flex;
        justify-content: center;
        align-items: center;
        background: #111;
        border-radius: 10px;
        box-shadow: 0 0 25px rgba(0,0,0,0.5);
        padding: 10px;
      }
      .modal-content img,
      .modal-content iframe {
        width: 100%;
        height: auto;
        max-height: 75vh;
        border-radius: 8px;
        object-fit: contain;
        background-color: #000;
      }
      .modal-content iframe {
        height: 70vh;
      }
      .close {
        position: absolute;
        top: 5px;
        right: 15px;
        color: #fff;
        font-size: 32px;
        font-weight: bold;
        cursor: pointer;
        z-index: 1010;
        text-shadow: 0 0 10px #000;
      }
      .close:hover {
        color: #ff4d4d;
      }
      @media (max-width: 768px) {
        .modal-content {
          max-width: 95vw;
          max-height: 70vh;
        }
        .modal-content iframe {
          height: 55vh;
        }
      }
    `;
    document.head.appendChild(style);
  }

  async render() {
    this.root.innerHTML = '';
    const container = document.createElement('div');
    container.style.padding = '20px';

    // 🔹 Modal
    const modal = document.createElement('div');
    modal.id = 'mediaModal';
    modal.className = 'modal';
    modal.innerHTML = `
      <div class="modal-content">
        <span class="close">&times;</span>
        <div id="modalBody"></div>
      </div>
    `;
    container.appendChild(modal);

    const list = document.createElement('div');
    list.id = 'dataList';
    list.innerHTML = `
      <div style="display:flex;justify-content:center;align-items:center;height:200px;color:#666;">
        <div>
          <div class="spinner" style="border:4px solid #f3f3f3;border-top:4px solid #3498db;border-radius:50%;width:40px;height:40px;animation:spin 1s linear infinite;margin:auto;"></div>
          <p style="text-align:center;margin-top:10px;">Memuat data...</p>
        </div>
      </div>
      <style>@keyframes spin{0%{transform:rotate(0)}100%{transform:rotate(360deg)}}</style>
    `;
    container.appendChild(list);
    this.root.appendChild(container);

    try {
      const datalist = await this.getdatalist();
      requestAnimationFrame(() => {
        list.innerHTML = this.settable(datalist);
        this.Tampildatatabel();
        this.initModalBehavior(); // event modal
      });
    } catch (error) {
      list.innerHTML = `
        <div style="text-align:center;padding:50px;color:#e74c3c;">
          <p>Gagal memuat data. Silakan coba lagi.</p>
          <button onclick="location.reload()" style="background:#3498db;color:white;border:none;padding:10px 20px;border-radius:5px;cursor:pointer;">Refresh</button>
        </div>
      `;
    }
  }

  settable(data) {
    return `
      <table id="table1" class="min-w-full border border-gray-400 border-collapse text-sm text-center table-hover">
        <thead id="thead">
          <tr>
            <th class="text-center" rowspan="2">NO</th>
            <th class="text-center" rowspan="2">JENIS</th>
            <th class="text-center" rowspan="2">KATEGORI</th>
            <th class="text-center" rowspan="2">PARTID</th>
            <th class="text-center" rowspan="2">GAMBAR</th>
            <th class="text-center" colspan="3">PRODUK SPESIFIKASI</th>
            <th class="text-center" rowspan="2">UKURAN</th>
            <th class="text-center" rowspan="2">KAPASITAS</th>
            <th class="text-center" rowspan="2">PUNGGUNG</th>
            <th class="text-center" rowspan="2">LABEL PUNGGUNG</th>
            <th class="text-center" rowspan="2">FITUR</th>
            <th class="text-center"  rowspan="2">WARNA</th>
            <th class="text-center" rowspan="2">VIDEO</th>
          </tr>
          <tr>
            <th>UKURAN KARTON</th>
            <th>RAW MATERIAL</th>
            <th>MEKANIK</th>
          </tr>
        </thead>
        <tbody>${this.generateTableRows(data)}</tbody>
      </table>
    `;
  }

  getGoogleDriveFileId(url) {
    if (!url) return null;
    const match = url.match(/(?:\/d\/|id=)([a-zA-Z0-9_-]+)/);
    return match ? match[1] : null;
  }

  getGoogleDriveImage(url) {
    const id = this.getGoogleDriveFileId(url);
    return id ? `https://drive.google.com/thumbnail?id=${id}&sz=w1000` : '';
  }

  getGoogleDriveVideo(url) {
    const id = this.getGoogleDriveFileId(url);
    return id ? `https://drive.google.com/file/d/${id}/preview` : '';
  }

  generateTableRows(data) {
    if (!Array.isArray(data)) return `<tr><td colspan="15">Tidak ada data</td></tr>`;
    const isOffline = !navigator.onLine;
    const fallback = isOffline ? '/assets/no-image.png' : 'https://placehold.co/60x60?text=No+Image';

    return data
      .map(item => {
        const imgUrl = item.Gambar ? this.getGoogleDriveImage(item.Gambar) : '';
        const vidUrl = item.Video ? this.getGoogleDriveVideo(item.Video) : '';
        const imgTag = `
          <img src="${imgUrl || fallback}" 
               class="preview-img" 
               data-url="${imgUrl}" 
               alt="gambar"
               onerror="this.src='${fallback}'">
        `;
        const vidTag = vidUrl
          ? `<span class="video-link" data-url="${vidUrl}">Lihat Video</span>`
          : `<span style="color:gray;">Tidak ada video</span>`;

        return `
          <tr>
            <td>${item.NoExel || ''}</td>
            <td>${item.Jenis || ''}</td>
            <td>${item.Kategori || ''}</td>
            <td>${item.Partid || ''}</td>
            <td>${imgTag}</td>
            <td>${item.UkuranKarton || ''}</td>
            <td>${item.RawMaterial || ''}</td>
            <td>${item.Mekanik || ''}</td>
            <td>${item.Ukuran || ''}</td>
            <td>${item.Kapasitas || ''}</td>
            <td>${item.Punggung || ''}</td>
            <td>${item.LabelPunggung || ''}</td>
            <td>${item.Fitur || ''}</td>
            <td>${item.KodeWarna || ''}</td>
            <td>${vidTag}</td>
          </tr>`;
      })
      .join('');
  }

  initModalBehavior() {
    const modal = document.getElementById('mediaModal');
    const modalBody = document.getElementById('modalBody');
    const closeBtn = modal.querySelector('.close');

    // 🔹 Delegated event agar tetap berfungsi setelah pagination DataTables
    document.addEventListener('click', (e) => {
      if (e.target.classList.contains('preview-img')) {
        const url = e.target.getAttribute('data-url');
        if (url) this.openModal(url, 'image');
      } else if (e.target.classList.contains('video-link')) {
        const url = e.target.getAttribute('data-url');
        if (url) this.openModal(url, 'video');
      }
    });

    closeBtn.onclick = () => (modal.style.display = 'none');
    modal.onclick = (e) => {
      if (e.target === modal) modal.style.display = 'none';
    };
  }

  openModal(url, type) {
    const modal = document.getElementById('mediaModal');
    const modalBody = document.getElementById('modalBody');
    const fallback = 'https://placehold.co/600x400?text=No+Image';

    modalBody.innerHTML =
      type === 'image'
        ? `<img src="${url}" alt="Gambar" onerror="this.src='${fallback}'">`
        : `<iframe src="${url}" frameborder="0" allowfullscreen></iframe>`;

    modal.style.display = 'flex';
  }

  async getdatalist() {
    const kategoriInput = document.getElementById('kategori');
    const kategori = kategoriInput ? kategoriInput.value : '';
    const cacheKey = 'msbarang_data_cache';

    try {
      const cached = sessionStorage.getItem(cacheKey);
      if (cached) {
        const { data, timestamp } = JSON.parse(cached);
        if (Date.now() - timestamp < 5 * 60 * 1000) return data;
      }

      const response = await fetch(`${baseUrl}/router/seturl`, {
        method: 'POST',
        body: JSON.stringify({ kategori }),
        headers: { 'Content-Type': 'application/json', 'url': 'produk/listdata' },
        cache: 'no-store'
      });

      if (!response.ok) throw new Error('Network error ' + response.status);
      const result = await response.json();
      if (result.error) throw new Error(result.error);

      sessionStorage.setItem(cacheKey, JSON.stringify({ data: result.data, timestamp: Date.now() }));
      return result.data;
    } catch (err) {
      console.error('❌ Gagal memuat data:', err.message);
      throw err;
    }
  }

  Tampildatatabel() {
    const table = $('#table1').DataTable({
      order: [[0, 'asc']],
      responsive: true,
      destroy: true,
      pageLength: 5,
      lengthMenu: [[5, 10, 20, -1], [5, 10, 20, 'All']],
      fixedColumns: { right: 1 }
    });

    // 🔹 Reattach events setiap kali tabel redraw
    table.on('draw', () => this.initModalBehavior());
  }
}

export default ListProduk;
