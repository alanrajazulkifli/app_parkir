<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login & Welcome Page</title>
  <!-- Tailwind CSS CDN -->
  <script src="https://cdn.tailwindcss.com"></script>
  <!-- Lucide Icons -->
  <script src="https://unpkg.com/lucide@latest"></script>
  <style>
    /* Gradient Mesh Background untuk Sisi Kanan */
    .hero-gradient {
      background: radial-gradient(at 0% 0%, #203562 0px, transparent 50%),
                  radial-gradient(at 50% 100%, #172a51 0px, transparent 50%),
                  radial-gradient(at 30% 20%, #fbd5ab 0px, transparent 40%),
                  radial-gradient(at 100% 40%, #fce3c7 0px, transparent 40%),
                  radial-gradient(at 80% 90%, #68a3cc 0px, transparent 50%);
      background-color: #1e3a6d;
    }
  </style>
</head>
<body class="bg-[#1b254b] min-h-screen flex items-center justify-center p-4 font-sans">

  <!-- Main Container -->
  <div class="w-full max-w-5xl bg-white rounded-3xl shadow-2xl overflow-hidden flex flex-col md:flex-row min-h-[580px]">
    
    <!-- Left Side (Form Login) -->
    <div class="w-full md:w-5/12 p-8 md:p-10 flex flex-col justify-between bg-white relative">
      
      <!-- Brand Logo -->
      <div class="flex items-center gap-2">
        <div class="w-7 h-7 bg-[#233876] rounded-lg flex items-center justify-center text-white font-bold text-xs">
          <i data-lucide="layers" class="w-4 h-4"></i>
        </div>
        <span class="font-bold text-[#233876] leading-tight text-sm">
          Template<br><span class="font-normal">Design</span>
        </span>
      </div>

      <!-- Form Content -->
      <div class="my-auto py-6 max-w-xs mx-auto w-full">
        <!-- Avatar Icon -->
        <div class="flex justify-center mb-6">
          <div class="w-16 h-16 border-2 border-[#233876] rounded-full flex items-center justify-center text-[#233876]">
            <i data-lucide="user" class="w-8 h-8"></i>
          </div>
        </div>

        <!-- Form Mengirim Data via POST ke Halaman Ini Sendiri -->
        <form action="" method="POST" class="space-y-4">
          <!-- Input Username -->
          <div class="relative">
            <span class="absolute inset-y-0 left-0 flex items-center pl-4 text-gray-400">
              <i data-lucide="user" class="w-4 h-4"></i>
            </span>
            <input 
              type="text" 
              name="nm_user" 
              placeholder="USERNAME" 
              required
              class="w-full py-2.5 pl-11 pr-4 border-2 border-gray-800 rounded-full text-xs font-semibold placeholder-gray-400 focus:outline-none focus:border-[#233876]"
            />
          </div>

          <!-- Input Password -->
          <div class="relative">
            <span class="absolute inset-y-0 left-0 flex items-center pl-4 text-gray-400">
              <i data-lucide="lock" class="w-4 h-4"></i>
            </span>
            <input 
              type="password" 
              name="pass" 
              placeholder="••••••••" 
              required
              class="w-full py-2.5 pl-11 pr-4 border-2 border-gray-800 rounded-full text-xs font-semibold placeholder-gray-400 focus:outline-none focus:border-[#233876]"
            />
          </div>

          <!-- Submit Button -->
          <button 
            type="submit" 
            name="btn"
            class="w-full bg-[#233876] hover:bg-[#1a2b5c] text-white font-bold py-3 rounded-full text-xs tracking-wider transition-all shadow-md">
            LOGIN
          </button>

          <!-- Checkbox & Forgot Password -->
          <div class="flex items-center justify-between text-[10px] text-gray-600 pt-1">
            <label class="flex items-center gap-1.5 cursor-pointer">
              <input type="checkbox" class="rounded accent-[#233876]">
              <span>Remember me</span>
            </label>
            <a href="#" class="hover:underline text-gray-500">Forgot your password?</a>
          </div>
        </form>
      </div>

      <!-- Pagination Dots -->
      <div class="flex justify-center gap-1.5">
        <span class="w-2 h-2 rounded-full bg-gray-800"></span>
        <span class="w-2 h-2 rounded-full bg-gray-800"></span>
        <span class="w-2 h-2 rounded-full bg-gray-800"></span>
      </div>

    </div>

    <!-- Right Side (Welcome Section with Gradient) -->
    <div class="w-full md:w-7/12 hero-gradient p-8 md:p-10 text-white flex flex-col justify-between relative">
      
    

      <!-- Main Heading Text -->
      <div class="my-auto pt-16 md:pt-24 max-w-md ml-auto text-right md:text-left">
        <h1 class="text-5xl md:text-6xl font-extrabold tracking-tight mb-4">
          Welcome.
        </h1>
        <p class="text-xs leading-relaxed text-gray-200 opacity-80 max-w-xs mb-6">
          Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore.
        </p>
        <p class="text-xs">
          Not a member? <a href="#" class="font-bold underline hover:text-gray-200">Sign up now</a>
        </p>
      </div>

    </div>

  </div>

  <!-- Initialize Lucide Icons -->
  <script>
    lucide.createIcons();
  </script>
</body>
</html>
<?php
    if (isset($_POST['btn'])) {
        $user = $_POST['uname'];
        $pass = $_POST['pass'];
        $sqlLogin = $conn->query("SELECT*FROM tb_user WHERE username='$user' AND password='$pass'");
        $result = $sqlLogin->fetch_array();
        $row = $sqlLogin->num_rows;
        if ($row > 0) {
            $_SESSION['user']=$result['id_user'];
            header('location:index.php');
        }else{
            echo"<script>
                alert('Login Gagal, pastikan username dan password benar!');
                window.location='login.php';";
        }
    }
?>