import ListProduk from './components/Listproduk.js';
// Pastikan kode jalan setelah DOM siap
document.addEventListener("DOMContentLoaded", () => {
  const url = new URL(window.location.href);
  const pathSegments = url.pathname.split("/").filter(Boolean);
  const lastSegment = pathSegments.pop();

  // Inisialisasi komponen Listproduk sekali
  const Listproduk = new ListProduk();

  // Delegasi event click secara efisien
  document.body.addEventListener("click", (event) => {
    const target = event.target;

    if (target.matches("#BtnBatal, #kembalihider")) {
      event.preventDefault();
      goBack(Listproduk);
    }
  });
});








// Fungsi untuk kembali dan refresh data (tanpa membuat instance baru)
export default function goBack(ListprodukInstance) {
  if (ListprodukInstance && typeof ListprodukInstance.refresh === "function") {
    ListprodukInstance.refresh(); // Jika Listproduk punya method refresh()
  } else {
    new Listproduk(); // fallback jika belum ada instance reuse
  }
}
