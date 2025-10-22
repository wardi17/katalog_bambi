<?php
$menukategori = isset($data['menukategori']) ? $data['menukategori'] : [];

// Pagination
$limit = 10;
$pageNum = isset($_GET['page']) ? intval($_GET['page']) : 1;
$totalItems = count($menukategori);
$totalPages = ceil($totalItems / $limit);
$startIndex = ($pageNum - 1) * $limit;
$currentItems = array_slice($menukategori, $startIndex, $limit);
?>
<style>
  a{
    text-decoration: none !important;
  }
</style>
<body class="bg-lime-50 font-sans text-gray-800 pt-16">
  <main class="max-w-6xl mx-auto my-10 px-4">
    <section class="grid md:grid-cols-2 gap-8 items-start">

      <!-- KIRI: Gambar -->
      <div class="relative w-full overflow-hidden rounded-2xl shadow-lg" style="height:auto;">
        <img src="<?= base_url; ?>/assets/images/katalgokiri.JPG" 
             alt="Bambi Files" 
             class="absolute inset-0 w-full h-full object-cover object-center" 
             id="leftImage" />
      </div>

      <!-- KANAN: Daftar Index -->
      <div class="flex flex-col justify-start space-y-5" id="rightContent">
        
        <!-- Header Index -->
        <div class="flex items-center justify-between border-b pb-2">
          <h1 class="text-3xl font-bold tracking-wide text-gray-900">Index</h1>
          <img src="<?= base_url; ?>/assets/images/logobambi.png" 
               alt="Logo Bambi" 
               class="w-32 h-12 md:w-40 md:h-16 lg:w-52 lg:h-20 object-contain rounded-2xl shadow-xl bg-white p-2 border border-gray-200" />
        </div>

        <!-- Daftar Kategori -->
        <div class="space-y-4">
          <?php foreach($currentItems as $item): ?>
            <?php if($item["SubRomawi"] == ""): ?>
              <a href="<?= base_url ?>?category=<?= strtoupper(str_replace(' ', '-', $item['linkheader'])) ?>" 
                 class="block bg-white border border-gray-200 hover:border-lime-400 hover:bg-lime-100 transition-all duration-200 rounded-lg p-3 shadow-sm group no-underline"
                 style="text-decoration: none;">
                <div class="flex justify-between items-center">
                  <span class="font-bold text-black group-hover:text-lime-700"><?= $item["Romawi"] ?>. <?= htmlspecialchars($item['NamaMenu']); ?></span>
                  <span class="text-sm text-gray-500">→</span>
                </div>
              </a>
            <?php else: ?>
              <a href="#<?= strtoupper(str_replace(' ', '-', $item['linkdetail'])) ?>" 
                 class="block bg-white border border-gray-200 hover:border-lime-400 hover:bg-lime-100 transition-all duration-200 rounded-lg p-3 shadow-sm group no-underline"
                 style="text-decoration: none;">
                <div class="flex justify-between items-center pl-6">
                  <span class="font-medium text-gray-700 group-hover:text-lime-700"><?= $item["SubRomawi"] ?>. <?= htmlspecialchars($item['NamaMenu']); ?></span>
                  <span class="text-sm text-gray-500">→</span>
                </div>
              </a>
            <?php endif; ?>
          <?php endforeach; ?>
        </div>

        <!-- Pagination -->
        <div class="flex flex-wrap justify-center mt-4 gap-2">
          <?php if($pageNum > 1): ?>
            <a href="?page=<?= $pageNum - 1 ?>" class="px-3 py-1 border rounded hover:bg-gray-200">Previous</a>
          <?php endif; ?>
          <?php for($i = 1; $i <= $totalPages; $i++): ?>
            <a href="?page=<?= $i ?>" class="px-3 py-1 border rounded <?= $i == $pageNum ? 'bg-gray-300 font-bold' : 'hover:bg-gray-200' ?>"><?= $i ?></a>
          <?php endfor; ?>
          <?php if($pageNum < $totalPages): ?>
            <a href="?page=<?= $pageNum + 1 ?>" class="px-3 py-1 border rounded hover:bg-gray-200">Next</a>
          <?php endif; ?>
        </div>

        <!-- Footer -->
        <div class="mt-6 text-sm text-gray-600 border-t pt-2 text-center">
          <p>www.bambifiles.com</p>
        </div>

      </div>
    </section>
  </main>

  <script>
    // Smooth scroll anchor
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
      anchor.addEventListener('click', function(e) {
        e.preventDefault();
        document.querySelector(this.getAttribute('href'))?.scrollIntoView({ behavior: 'smooth' });
      });
    });

    // Adjust left image height mengikuti right content
    function adjustImageHeight() {
      const rightContent = document.getElementById('rightContent');
      const leftImage = document.getElementById('leftImage');
      if(rightContent && leftImage) {
           const footer = rightContent.querySelector('div.mt-6');
            let footerHeight = footer ? footer.offsetHeight : 0;
           const newHeight = rightContent.offsetHeight - footerHeight;
          leftImage.parentElement.style.height = newHeight + 'px';
      }
    }

    window.addEventListener('load', adjustImageHeight);
    window.addEventListener('resize', adjustImageHeight);
  </script>
</body>
