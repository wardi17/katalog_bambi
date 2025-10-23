<?php
$kategori = isset($data['category']) ? $data['category'] : '';
$waranaList = isset($data['mswarna']) ? $data['mswarna'] : '';
$labeltitle = isset($data['labeltitle']) ? $data['labeltitle'] : '';
$jmlwarna = count($waranaList);
?>
<style>
  .text-gray-custom {
  color: #B3B3B3; /* Warna abu-abu muda */
}
</style>
<!-- <main class="max-w-6xl mx-auto mt-4 px-4"> -->
<main class="w-full mx-auto my-10 px-6 mt-4">
  <!-- CARD UTAMA -->
  <div class="bg-lime-50 shadow-xl rounded-2xl p-8 border border-gray-100 w-full">
    <input type="hidden" id="kategori" value="<?= $kategori ?>">
    <!-- FLEX: KIRI = TEKS, KANAN = WARNA -->
    <div class="flex flex-col lg:flex-row justify-between items-start gap-10 bg-gray-100 p-8 rounded-xl">
      
      <!-- KIRI: TEKS PRODUK -->
      <div class="w-full lg:w-1/2 flex flex-col justify-center items-center text-center p-6 bg-white rounded-xl shadow-lg border border-gray-200">
        <h2 class="text-3xl font-extrabold text-gray-800 mb-2 tracking-wide"><?= $labeltitle ?></h2>
        <?php if (!empty($waranaList)) : ?>
          <p class="text-md text-gray-600 font-medium">TERSEDIA DALAM <?= $jmlwarna ?> WARNA PILIHAN</p>
        <?php else : ?>
          <p class="text-gray-500 italic">Tidak ada warna tersedia</p>
        <?php endif; ?>
      </div>

      <!-- KANAN: GRID WARNA -->
      <div class="w-full lg:w-1/2 bg-white p-6 rounded-xl shadow-lg border border-gray-200">
        <div class="grid grid-cols-4 sm:grid-cols-5 md:grid-cols-7 gap-4">
          <?php if (!empty($waranaList) && is_array($waranaList)) : ?>
            <?php foreach ($waranaList as $warna): ?>
               <?php 
                    $textColor = $warna['KodeWarna']  == "07" ? 'text-gray-custom' : 'text-white';
                ?>
              <div class="flex flex-col items-center text-center">
                <div class=" <?=$textColor?> w-14 h-14 border border-gray-300 rounded-md shadow-sm flex items-center justify-center font-bold"
                     style="background-color: <?= $warna['HexCode'] ?>;">
                  <?= htmlspecialchars($warna['KodeWarna']) ?>
                </div>
                <div class="text-xs mt-2 font-medium text-gray-800">
                  <?= htmlspecialchars($warna['NamaWarna']) ?>
                </div>
              </div>
            <?php endforeach; ?>
          <?php endif; ?>
        </div>
      </div>
    </div>
  </div>

  <!-- JARAK ANTARA WARNA DAN TABEL -->
  <div class="mt-12"></div>

  <!-- TABEL PRODUK -->
  <div id="root" class="bg-white shadow-md rounded-2xl p-6 border border-gray-100 w-full"></div>
</main>

<!-- Script -->
<script type="module" src="<?= base_url; ?>/src/produklist/main.js"></script>
