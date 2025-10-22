<!DOCTYPE html>
<html lang="en" class="h-full bg-gradient-to-br from-blue-500 via-purple-500 to-pink-500">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Kategori Bambi - Login</title>
  
  <!-- Tailwind CSS CDN -->
  <script src="https://cdn.tailwindcss.com"></script>
  
  <!-- Custom Styles (opsional, untuk animasi tambahan) -->
  <style>
    .fade-in {
      animation: fadeIn 1s ease-in-out;
    }
    @keyframes fadeIn {
      from { opacity: 0; transform: translateY(-20px); }
      to { opacity: 1; transform: translateY(0); }
    }
    .hover-scale:hover {
      transform: scale(1.05);
      transition: transform 0.3s ease, box-shadow 0.3s ease;
    }
  </style>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>

<body class="h-full flex items-center justify-center p-4">
  <div class="w-full max-w-md bg-white bg-opacity-90 backdrop-blur-md rounded-2xl shadow-2xl p-8 fade-in">
    <!-- Logo -->
    <div class="text-center mb-8">
      <h1 class="text-3xl font-bold text-gray-800">Admin Katalog Bambi</h1>
      <p class="text-gray-600 mt-2">Silahkan login terlebih dahulu.</p>
    </div>

    <!-- Form -->
    <form action="<?= base_url; ?>/login/prosesLogin" method="post" class="space-y-6">
      <!-- Username Input -->
      <div class="relative">
        <input 
          type="text" 
          class="w-full px-4 py-3 pl-12 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-300" 
          placeholder="Ketikkan username.." 
          name="username"
        >
        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
          <span class="text-gray-500 fas fa-user"></span>
        </div>
      </div>

      <!-- Password Input with Toggle -->
      <div class="relative">
        <input 
          id="password" 
          type="password" 
          class="w-full px-4 py-3 pl-12 pr-12 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-300" 
          placeholder="Ketikkan password.." 
          name="password"
        >
        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
          <span class="text-gray-500 fas fa-lock"></span>
        </div>
        <span 
          toggle="#password" 
          class="fa fa-fw fa-eye field-icon toggle-password absolute inset-y-0 right-0 pr-3 flex items-center cursor-pointer text-gray-500 hover:text-blue-500 transition-colors duration-300"
        ></span>
      </div>

      <!-- Submit Button -->
      <div class="flex justify-center">
        <button 
          type="submit" 
          class="w-full max-w-xs bg-gradient-to-r from-blue-500 to-purple-600 text-white font-semibold py-3 px-6 rounded-lg shadow-lg hover:shadow-xl hover-scale transition-all duration-300"
        >
          Sign In
        </button>
      </div>
    </form>

    <!-- Optional: Message Area (untuk Flasher) -->
    <div class="mt-6 text-center">
      <?php
      // Flasher::Message();
      ?>
    </div>
  </div>

  <!-- JavaScript untuk Toggle Password (tetap sama) -->
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script>
    $(document).on("click", ".toggle-password", function() {
      $(this).toggleClass("fa-eye fa-eye-slash");
      var input = $($(this).attr("toggle"));
      if (input.attr("type") == "password") {
        input.attr("type", "text");
      } else {
        input.attr("type", "password");
      }
    });
  </script>
</body>
</html>
