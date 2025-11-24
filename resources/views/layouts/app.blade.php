<!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title>Unilibrary</title>
  @vite('resources/css/app.css')
</head>
<body class="light-mode min-h-screen">
  <div class="flex">
    <!-- Modern Sidebar -->
    <aside class="sidebar w-64 bg-gradient-to-b from-blue-600 to-blue-800 text-white shadow-lg fixed h-screen overflow-y-auto md:relative" id="sidebarMobile">
      <!-- Logo Section -->
      <div class="p-6 border-b border-blue-500">
        <div class="flex items-center gap-3">
          <div class="w-10 h-10 bg-white rounded-lg flex items-center justify-center">
              <span class="text-blue-600 font-bold text-lg">🎟️</span>
            </div>
            <h1 class="text-xl font-bold">Unilibrary</h1>
        </div>
      </div>

      <!-- Navigation Menu -->
      <nav class="p-4 space-y-2 relative">
        <a href="{{ route('dashboard') }}" 
           class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }} flex items-center gap-3 px-4 py-3 rounded-lg transition-all duration-200">
          <span class="text-xl">📚</span>
          <span>Books</span>
        </a>
        <a href="{{ route('genres.index') }}" 
           class="nav-link {{ request()->routeIs('genres.*') ? 'active' : '' }} flex items-center gap-3 px-4 py-3 rounded-lg transition-all duration-200">
          <span class="text-xl">🎭</span>
          <span>Genres</span>
        </a>
        <button type="button" class="nav-link flex items-center gap-3 px-4 py-3 rounded-lg transition-all duration-200" onclick="toggleSettingsMenu()" id="settingsBtn">
          <span class="text-xl">⚙️</span>
          <span>Settings</span>
        </button>
        <div id="settingsMenu" class="hidden mt-2 p-4 rounded-lg shadow-lg absolute z-50" style="left: 70px; min-width: 180px;">
          <div class="flex flex-col gap-2">
            <button class="mode-toggle w-full" id="modeToggleSidebar" onclick="toggleModeSidebar()">🌙 Dark Mode</button>
          </div>
        </div>
      </nav>

      <!-- Logout Button -->
      <div class="absolute bottom-0 left-0 right-0 p-4 border-t border-blue-500 bg-blue-700">
        <form method="POST" action="/logout">
          @csrf
          <button type="submit" class="w-full flex items-center justify-center gap-2 px-4 py-2 bg-red-500 hover:bg-red-600 rounded-lg text-sm font-medium transition-colors duration-200">
            <span>🚪</span>
            <span>Logout</span>
          </button>
        </form>
      </div>
    </aside>

    <!-- Main Content -->
    <main class="main-content ml-64 flex-1 p-6">
      @if(session('success'))
        <div id="successToast" class="mb-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded-lg">
          {{ session('success') }}
        </div>
        <script>
          setTimeout(function() {
            const toast = document.getElementById('successToast');
            if (toast) toast.style.display = 'none';
          }, 3000);
        </script>
      @endif

      @if(session('error'))
        <div id="errorToast" class="mb-4 p-4 bg-red-100 border border-red-400 text-red-700 rounded-lg">
          {{ session('error') }}
        </div>
        <script>
          setTimeout(function() {
            const toast = document.getElementById('errorToast');
            if (toast) toast.style.display = 'none';
          }, 3000);
        </script>
      @endif

      @yield('content')
    </main>
  </div>

  <style>
    .nav-link {
      color: rgba(255, 255, 255, 0.8);
    }

    .nav-link:hover {
      background-color: rgba(255, 255, 255, 0.1);
      color: white;
    }

    .nav-link.active {
      background-color: rgba(255, 255, 255, 0.2);
      color: white;
      font-weight: 600;
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
          btnSidebar.textContent = '☀️ Light Mode';
          btnSidebar.classList.add('dark-mode');
          btnSidebar.classList.remove('light-mode');
        } else {
          btnSidebar.textContent = '🌙 Dark Mode';
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
      if (!menu.contains(e.target) && e.target !== btn) {
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