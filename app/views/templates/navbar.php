<?php
$page = isset($data['page']) ? $data['page'] : '';
$categories = isset($data['categories']) ? $data['categories'] : [];
$currentCategory = isset($_GET['category']) ? $_GET['category'] : '';
?>

<nav class="fixed top-0 left-0 w-full bg-indigo-600 shadow-lg z-50">
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="flex justify-between items-center h-16">
      <!-- NAVBAR MENU -->
      <ul id="menu" class="hidden md:flex items-center space-x-4 list-none m-0 p-0">
        <?php if (!empty($categories) && is_array($categories)) : ?>
          <?php foreach ($categories as $cat): ?>
            <?php $kategori = $cat['Kategori']; ?>
            <li>
              <a href="<?= base_url ?>?category=<?= urlencode($kategori) ?>"
                 class="no-underline transition-all duration-200 font-medium px-4 py-2 rounded-lg text-base block 
                        <?= ($currentCategory === $kategori)
                            ? 'bg-indigo-400 text-white shadow-md' 
                            : 'text-white hover:bg-indigo-500 hover:text-gray-100' ?>"
                 style="text-decoration: none; white-space: nowrap;">
                <?= htmlspecialchars($kategori) ?>
              </a>
            </li>
          <?php endforeach; ?>
        <?php else : ?>
          <li><em>Tidak ada kategori</em></li>
        <?php endif; ?>
      </ul>

      <!-- MOBILE BUTTON -->
      <button id="menu-btn" class="md:hidden text-white focus:outline-none transition-transform duration-200 hover:scale-110">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
        </svg>
      </button>
    </div>
  </div>

  <!-- MOBILE MENU -->
  <div id="mobile-menu" class="hidden md:hidden bg-indigo-700 border-t border-indigo-500">
    <ul class="flex flex-col space-y-4 p-6 list-none m-0">
      <?php if (!empty($categories) && is_array($categories)) : ?>
        <?php foreach ($categories as $cat): ?>
          <?php $kategori = $cat['Kategori']; ?>
          <li>
            <a href="<?= base_url ?>?category=<?= urlencode($kategori) ?>"
               class="no-underline block px-4 py-3 rounded-lg transition-all duration-200 font-medium text-base 
                      <?= ($currentCategory === $kategori)
                          ? 'bg-indigo-500 text-white shadow-md'
                          : 'text-white hover:bg-indigo-600 hover:text-gray-100' ?>"
               style="text-decoration: none;">
              <?= htmlspecialchars($kategori) ?>
            </a>
          </li>
        <?php endforeach; ?>
      <?php else : ?>
        <li><em>Tidak ada kategori</em></li>
      <?php endif; ?>
    </ul>
  </div>
</nav>

<script>
  // Toggle menu mobile
  document.getElementById('menu-btn').addEventListener('click', () => {
    document.getElementById('mobile-menu').classList.toggle('hidden');
  });
</script>
