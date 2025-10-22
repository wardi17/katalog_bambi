<?php
$menukategori = isset($data['menukategori']) ? $data['menukategori'] : [];
?>

<body class="bg-lime-50 font-sans text-gray-800">
  <main class="max-w-6xl mx-auto my-10 px-4">
    <section class="grid grid-cols-1 md:grid-cols-2 gap-8 items-start">
      
      <!-- KIRI: Gambar -->
      <div class="relative w-full h-[60vh] md:h-[90vh] overflow-hidden rounded-2xl shadow-lg">
        <img 
          src="<?= base_url; ?>/assets/images/katalgokiri.JPG" 
          alt="Bambi Files" 
          class="absolute inset-0 w-full h-full object-cover object-center"
        />
      </div>


      <!-- KANAN: Daftar Index -->
      <div class="flex flex-col justify-start space-y-5">
        <!-- Header Index dengan Logo -->
        <div class="flex items-center justify-between border-b pb-2">
          <h1 class="text-3xl font-bold tracking-wide text-gray-900">
            Index
          </h1>
          <img 
            src="<?= base_url; ?>/assets/images/logobambi.png" 
            alt="Logo Bambi" 
             class="w-35 h-15 md:w-50 md:h-20 lg:w-60 lg:h-25 
              object-contain rounded-2xl shadow-xl 
              bg-white p-2 border border-gray-200"
          />
        </div>

        <!-- Daftar Kategori -->
        <div class="space-y-4">
         <?php foreach ($menukategori as $index => $item): ?>
            <?php if ($item["SubRomawi"] == ""): ?>
                <a href="<?= base_url ?>?category=<?= strtoupper(str_replace(' ', '-', $item['linkheader'])); ?>" 
                  class="block bg-white border border-gray-200 hover:border-lime-400 
                          hover:bg-lime-100 transition-all duration-200 
                          rounded-lg p-3 shadow-sm group no-underline">
                  
                    <div class="flex justify-between items-center">
                        <span class="font-bold text-black group-hover:text-lime-700">
                            <?= $item["Romawi"] ?>. <?= htmlspecialchars($item['NamaMenu']); ?>
                        </span>
                        <span class="text-sm text-gray-500">→</span>
                    </div>
                </a>
            <?php else: ?>
                <a href="#<?= strtoupper(str_replace(' ', '-', $item['linkdetail'])); ?>" 
                  class="block bg-white border border-gray-200 hover:border-lime-400 
                          hover:bg-lime-100 transition-all duration-200 
                          rounded-lg p-3 shadow-sm group no-underline">
                  
                    <div class="flex justify-between items-center pl-6"> <!-- ← tambahkan padding kiri -->
                        <span class="font-medium text-gray-700 group-hover:text-lime-700">
                            <?= $item["SubRomawi"] ?>. <?= htmlspecialchars($item['NamaMenu']); ?>
                        </span>
                        <span class="text-sm text-gray-500">→</span>
                    </div>
                </a>
            <?php endif; ?>
      <?php endforeach; ?>

        </div>

        <!-- Footer -->
        <div class="mt-6 text-sm text-gray-600 border-t pt-2 text-center">
          <p>www.bambifiles.com</p>
        </div>
      </div>
    </section>
  </main>

  <!-- Scroll Smooth -->
  <script>
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
      anchor.addEventListener('click', function (e) {
        e.preventDefault();
        document.querySelector(this.getAttribute('href'))?.scrollIntoView({
          behavior: 'smooth'
        });
      });
    });
  </script>

