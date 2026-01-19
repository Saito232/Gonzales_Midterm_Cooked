<!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title>Unilibrary - Modern Book Management</title>
  @vite('resources/css/app.css')
</head>
<body class="light-mode min-h-screen">
  <div class="flex">
    <!-- Modern Sidebar -->
    <aside class="sidebar w-64 bg-gradient-to-b from-indigo-600 to-purple-700 text-white shadow-2xl fixed h-screen overflow-y-auto md:relative" id="sidebarMobile">
      <!-- Logo Section -->
      <div class="p-6 border-b border-white/10">
        <div class="flex items-center gap-3">
          <div class="w-12 h-12 bg-white rounded-xl flex items-center justify-center shadow-lg">
            <span class="text-indigo-600 font-bold text-2xl">📚</span>
          </div>
          <div>
            <h1 class="text-xl font-extrabold">Unilibrary</h1>
            <p class="text-xs text-white/70">Book Management</p>
          </div>
        </div>
      </div>

      <!-- Navigation Menu -->
      <nav class="p-4 space-y-2 relative">
        <a href="{{ route('dashboard') }}" 
           class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }} flex items-center gap-3 px-4 py-3.5 rounded-xl transition-all duration-200 group">
          <div class="w-10 h-10 bg-white/10 rounded-lg flex items-center justify-center group-hover:bg-white/20 transition">
            <span class="text-xl">📚</span>
          </div>
          <span class="font-semibold">Books</span>
        </a>
        <a href="{{ route('genres.index') }}" 
           class="nav-link {{ request()->routeIs('genres.*') ? 'active' : '' }} flex items-center gap-3 px-4 py-3.5 rounded-xl transition-all duration-200 group">
          <div class="w-10 h-10 bg-white/10 rounded-lg flex items-center justify-center group-hover:bg-white/20 transition">
            <span class="text-xl">🎭</span>
          </div>
          <span class="font-semibold">Genres</span>
        </a>
        <a href="{{ route('trash.index') }}" 
           class="nav-link {{ request()->routeIs('trash.*') ? 'active' : '' }} flex items-center gap-3 px-4 py-3.5 rounded-xl transition-all duration-200 group">
          <div class="w-10 h-10 bg-white/10 rounded-lg flex items-center justify-center group-hover:bg-white/20 transition">
            <span class="text-xl">🗑️</span>
          </div>
          <span class="font-semibold">Trash</span>
        </a>
        <button type="button" class="nav-link flex items-center gap-3 px-4 py-3.5 rounded-xl transition-all duration-200 w-full group" onclick="toggleSettingsMenu()" id="settingsBtn">
          <div class="w-10 h-10 bg-white/10 rounded-lg flex items-center justify-center group-hover:bg-white/20 transition">
            <span class="text-xl">⚙️</span>
          </div>
          <span class="font-semibold">Settings</span>
        </button>
        <div id="settingsMenu" class="hidden mt-2 p-4 rounded-xl shadow-2xl absolute z-50 left-4 right-4" style="min-width: 200px;">
          <div class="flex flex-col gap-2">
            <button class="mode-toggle w-full text-left" id="modeToggleSidebar" onclick="toggleModeSidebar()">
              <span class="flex items-center gap-2">
                <span class="text-xl">🌙</span>
                <span>Dark Mode</span>
              </span>
            </button>
          </div>
        </div>
      </nav>

      <!-- User Section & Logout Button -->
      <div class="absolute bottom-0 left-0 right-0 p-4 border-t border-white/10 bg-gradient-to-t from-black/20">
        <form method="POST" action="/logout">
          @csrf
          <button type="submit" class="w-full flex items-center justify-center gap-3 px-4 py-3 bg-white/10 hover:bg-white/20 backdrop-blur-sm rounded-xl text-sm font-semibold transition-all duration-200 hover:scale-105">
            <span class="text-xl">🚪</span>
            <span>Logout</span>
          </button>
        </form>
      </div>
    </aside>

    <!-- Main Content -->
    <main class="main-content ml-64 flex-1 p-8 min-h-screen">
      @if(session('success'))
        <div id="successToast" class="mb-6 p-5 bg-green-50 border-2 border-green-200 text-green-800 rounded-2xl shadow-lg flex items-center gap-4">
          <div class="w-10 h-10 bg-green-200 rounded-full flex items-center justify-center">
            <span class="text-xl">✓</span>
          </div>
          <span class="font-semibold">{{ session('success') }}</span>
        </div>
        <script>
          setTimeout(function() {
            const toast = document.getElementById('successToast');
            if (toast) {
              toast.style.opacity = '0';
              toast.style.transform = 'translateY(-10px)';
              toast.style.transition = 'all 0.3s ease';
              setTimeout(() => toast.style.display = 'none', 300);
            }
          }, 3000);
        </script>
      @endif

      @if(session('error'))
        <div id="errorToast" class="mb-6 p-5 bg-red-50 border-2 border-red-200 text-red-800 rounded-2xl shadow-lg flex items-center gap-4">
          <div class="w-10 h-10 bg-red-200 rounded-full flex items-center justify-center">
            <span class="text-xl">✕</span>
          </div>
          <span class="font-semibold">{{ session('error') }}</span>
        </div>
        <script>
          setTimeout(function() {
            const toast = document.getElementById('errorToast');
            if (toast) {
              toast.style.opacity = '0';
              toast.style.transform = 'translateY(-10px)';
              toast.style.transition = 'all 0.3s ease';
              setTimeout(() => toast.style.display = 'none', 300);
            }
          }, 3000);
        </script>
      @endif

      @yield('content')
    </main>
  </div>

  <style>
    /* Enhanced Navigation Styles */
    .nav-link {
      color: rgba(255, 255, 255, 0.9);
      position: relative;
    }

    .nav-link::before {
      content: '';
      position: absolute;
      left: 0;
      top: 50%;
      transform: translateY(-50%);
      width: 3px;
      height: 0;
      background: white;
      border-radius: 0 3px 3px 0;
      transition: height 0.3s ease;
    }

    .nav-link:hover::before {
      height: 60%;
    }

    .nav-link:hover {
      background: rgba(255, 255, 255, 0.15);
      color: white;
      transform: translateX(2px);
    }

    .nav-link.active {
      background: rgba(255, 255, 255, 0.25);
      color: white;
      font-weight: 700;
      box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    }

    .nav-link.active::before {
      height: 60%;
    }
  </style>

  @vite('resources/css/app.css')
  @vite('resources/js/app.js')

  <script>
    function setMode(mode) {
      document.body.classList.remove('light-mode', 'dark-mode');
      document.body.classList.add(mode + '-mode');
      document.querySelector('.sidebar').classList.remove('light-mode', 'dark-mode');
      document.querySelector('.sidebar').classList.add(mode + '-mode');
      document.querySelector('.main-content').classList.remove('light-mode', 'dark-mode');
      document.querySelector('.main-content').classList.add(mode + '-mode');
      document.getElementById('settingsMenu').classList.remove('light-mode', 'dark-mode');
      document.getElementById('settingsMenu').classList.add(mode + '-mode');
      
      const btnSidebar = document.getElementById('modeToggleSidebar');
      if (btnSidebar) {
        if (mode === 'dark') {
          btnSidebar.innerHTML = '<span class="flex items-center gap-2"><span class="text-xl">☀️</span><span>Light Mode</span></span>';
          btnSidebar.classList.add('dark-mode');
          btnSidebar.classList.remove('light-mode');
        } else {
          btnSidebar.innerHTML = '<span class="flex items-center gap-2"><span class="text-xl">🌙</span><span>Dark Mode</span></span>';
          btnSidebar.classList.add('light-mode');
          btnSidebar.classList.remove('dark-mode');
        }
      }
      localStorage.setItem('unilibraryMode', mode);
    }
    
    function toggleModeSidebar() {
      const current = document.body.classList.contains('dark-mode') ? 'dark' : 'light';
      setMode(current === 'dark' ? 'light' : 'dark');
    }
    
    function toggleSettingsMenu() {
      const menu = document.getElementById('settingsMenu');
      menu.classList.toggle('hidden');
    }
    
    document.addEventListener('click', function(e) {
      const menu = document.getElementById('settingsMenu');
      const btn = document.getElementById('settingsBtn');
      if (menu && btn && !menu.contains(e.target) && !btn.contains(e.target)) {
        menu.classList.add('hidden');
      }
    });
    
    // On load, set mode from localStorage or default to light
    document.addEventListener('DOMContentLoaded', function() {
      const saved = localStorage.getItem('unilibraryMode');
      setMode(saved === 'dark' ? 'dark' : 'light');
    });
  </script>
</body>
</html>
    });
  </script>
</body>
</html>