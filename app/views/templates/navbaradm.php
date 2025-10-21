<?php
$page = isset($data['page']) ? $data['page'] : '';
?>

<nav class="fixed top-0 left-0 w-full bg-indigo-600 shadow-lg z-50">
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="flex justify-between items-center h-16">
      
      <!-- LEFT: Semua Menu dalam satu UL (untuk rata sempurna) -->
      <ul id="menu" class="hidden md:flex items-center space-x-6 list-none m-0 p-0">
        <!-- Beranda sebagai li pertama -->
        <li class="list-none">
          <a href="<?= base_url ?>" 
             class="no-underline transition-all duration-200 font-semibold px-4 py-2 rounded-lg text-base block 
                    <?= $page == 'import' 
                        ? 'bg-indigo-400 text-white shadow-md' 
                        : 'text-white hover:bg-indigo-500 hover:text-gray-100' ?>"
             style="text-decoration: none;">
            Import Excel
          </a>
        </li>
      </ul>
      
      <!-- RIGHT: Logout Link (Desktop) + Mobile Menu Button -->
      <div class="flex items-center space-x-4">
        <!-- Logout Link (visible di desktop) -->
        <a href="<?= base_url ?>/logout" 
           class="hidden md:block no-underline transition-all duration-200 font-semibold px-4 py-2 rounded-lg text-base 
                  text-white hover:bg-indigo-500 hover:text-gray-100"
           style="text-decoration: none;">
          Logout
        </a>
        
        <!-- Mobile Menu Button -->
        <button id="menu-btn" class="md:hidden text-white focus:outline-none transition-transform duration-200 hover:scale-110">
          <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
          </svg>
        </button>
      </div>
    </div>
  </div>
  
  <!-- Mobile Dropdown Menu (sekarang include Beranda dan Logout) -->
  <div id="mobile-menu" class="hidden md:hidden bg-indigo-700 border-t border-indigo-500">
    <ul class="flex flex-col space-y-4 p-6 list-none m-0">
      <li class="list-none">
        <a href="<?= base_url ?>" 
           class="no-underline block px-4 py-3 rounded-lg transition-all duration-200 font-semibold text-base 
                  <?= $page == 'import' 
                      ? 'bg-indigo-500 text-white shadow-md' 
                      : 'text-white hover:bg-indigo-600 hover:text-gray-100' ?>"
           style="text-decoration: none;">
          Import Excel
        </a>
      </li>
      <!-- Logout Item di Mobile -->
      <li class="list-none">
        <a href="<?= base_url ?>/logout" 
           class="no-underline block px-4 py-3 rounded-lg transition-all duration-200 font-semibold text-base 
                  text-white hover:bg-indigo-600 hover:text-gray-100"
           style="text-decoration: none;">
          Logout
        </a>
      </li>
    </ul>
  </div>
</nav>

<script>
  // Toggle mobile menu
  document.getElementById('menu-btn').addEventListener('click', (e) => {
    e.preventDefault();
    const mobileMenu = document.getElementById('mobile-menu');
    mobileMenu.classList.toggle('hidden');
  });
  
  // Optional: Close mobile menu when clicking outside
  document.addEventListener('click', (e) => {
    const mobileMenu = document.getElementById('mobile-menu');
    const menuBtn = document.getElementById('menu-btn');
    if (!mobileMenu.contains(e.target) && !menuBtn.contains(e.target) && !mobileMenu.classList.contains('hidden')) {
      mobileMenu.classList.add('hidden');
    }
  });
</script>