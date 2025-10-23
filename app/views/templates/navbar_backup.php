<?php
$page = isset($data['page']) ? $data['page'] : '';
$categories = isset($data['categories']) ? $data['categories'] : [];
$currentCategory = isset($_GET['category']) ? $_GET['category'] : '';
?>

<!-- DESKTOP NAVBAR TOP -->
<nav class="hidden md:block fixed top-0 left-0 w-full bg-indigo-600 shadow-lg z-50">
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="flex justify-between items-center h-16">
      <ul class="flex items-center space-x-4 list-none m-0 p-0">
        <li>
          <a href="<?= base_url ?>" class="transition-all duration-200 font-semibold px-4 py-2 rounded-lg text-base block <?= $page == 'home' ? 'bg-indigo-400 text-white shadow-md' : 'text-white hover:bg-indigo-500 hover:text-gray-100' ?>" style="text-decoration:none;">
            HOME
          </a>
        </li>
        <?php foreach($categories as $cat): ?>
          <?php $kategori = str_replace(' ', '-', $cat['Kategori']); ?>
          <li>
            <a href="<?= base_url ?>?category=<?= urlencode($kategori) ?>" class="transition-all duration-200 font-medium px-4 py-2 rounded-lg text-base block <?= ($currentCategory === $kategori) ? 'bg-indigo-400 text-white shadow-md' : 'text-white hover:bg-indigo-500 hover:text-gray-100' ?>">
              <?= htmlspecialchars($kategori) ?>
            </a>
          </li>
        <?php endforeach; ?>
      </ul>
    </div>
  </div>
</nav>

<!-- MOBILE NAVBAR BOTTOM -->
<div class="md:hidden fixed bottom-0 left-0 w-full bg-indigo-600 border-t border-indigo-500 z-50">
  <ul class="flex justify-around items-center p-2">
    <li>
      <a href="<?= base_url ?>" class="flex flex-col items-center text-white hover:text-gray-100 <?= $page == 'home' ? 'text-yellow-300' : '' ?>">
        <svg class="w-6 h-6 mb-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M13 5v6h6"></path>
        </svg>
        <span class="text-xs">Home</span>
      </a>
    </li>
    <?php foreach($categories as $cat): ?>
      <?php $kategori = str_replace(' ', '-', $cat['Kategori']); ?>
      <li>
        <a href="<?= base_url ?>?category=<?= urlencode($kategori) ?>" class="flex flex-col items-center text-white hover:text-gray-100 <?= ($currentCategory === $kategori) ? 'text-yellow-300' : '' ?>">
          <svg class="w-6 h-6 mb-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
          </svg>
          <span class="text-xs"><?= htmlspecialchars($kategori) ?></span>
        </a>
      </li>
    <?php endforeach; ?>
  </ul>
</div>
          