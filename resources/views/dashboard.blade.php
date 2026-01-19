@extends('layouts.app')
@section('content')

<style>
  @keyframes gradient {
    0%, 100% { background-position: 0% 50%; }
    50% { background-position: 100% 50%; }
  }
  .animate-gradient {
    background-size: 200% 200%;
    animation: gradient 15s ease infinite;
  }
  @keyframes float {
    0%, 100% { transform: translateY(0); }
    50% { transform: translateY(-10px); }
  }
  .animate-float {
    animation: float 3s ease-in-out infinite;
  }
</style>

<!-- Page Header -->
<div class="glass-card sticky top-0 z-50 -mx-6 px-6 py-5 mb-8 border-b">
  <div class="flex justify-between items-center">
    <div>
      <h1 class="text-3xl font-extrabold bg-gradient-to-r from-indigo-600 to-purple-600 bg-clip-text text-transparent flex items-center gap-3">
        <span class="text-3xl">📚</span> Dashboard
      </h1>
      <p class="text-sm text-gray-500 mt-1">{{ \Carbon\Carbon::now()->format('l, F j, Y') }}</p>
    </div>
  </div>
</div>

<!-- Welcome Hero Section -->
<div class="mb-8 rounded-2xl bg-gradient-to-r from-indigo-600 via-purple-600 to-pink-600 animate-gradient p-8 shadow-xl">
  <div class="flex flex-col md:flex-row items-center justify-between gap-6">
    <div class="flex-1">
      <h1 class="text-4xl md:text-5xl font-extrabold text-white mb-4 flex items-center gap-3">
        <span>👋</span> Welcome Back!
      </h1>
      <p class="text-lg text-white/90 mb-6 max-w-2xl">
        Manage your personal library with style. Track books, organize by genres, rate your favorites, and discover insights about your reading collection.
      </p>
      <div class="flex flex-wrap gap-3">
        <button onclick="scrollToSection('add-book')" class="px-6 py-3 bg-white text-indigo-600 rounded-xl font-semibold hover:shadow-lg hover:scale-105 transform transition duration-200">
          ➕ Add New Book
        </button>
        <button onclick="scrollToSection('books')" class="px-6 py-3 bg-white/10 backdrop-blur-sm text-white rounded-xl font-semibold border border-white/20 hover:bg-white/20 transition duration-200">
          📖 View Collection
        </button>
      </div>
    </div>
    <div class="animate-float">
      <div class="w-32 h-32 bg-white/10 backdrop-blur-sm rounded-3xl flex items-center justify-center text-7xl shadow-2xl">
        📚
      </div>
    </div>
  </div>
</div>

<!-- Stats Cards -->
<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
  <!-- Total Books Card -->
  <div class="glass-card p-6 hover:shadow-xl hover:scale-105 transform transition-all duration-300">
    <div class="flex items-start justify-between mb-4">
      <div class="flex-1">
        <p class="text-sm font-medium text-gray-500 mb-1">Total Books</p>
        <p class="text-4xl font-extrabold bg-gradient-to-r from-indigo-600 to-purple-600 bg-clip-text text-transparent">
          {{ $totalBooks }}
        </p>
      </div>
      <div class="w-12 h-12 bg-gradient-to-r from-indigo-100 to-purple-100 rounded-xl flex items-center justify-center">
        <span class="text-3xl">📚</span>
      </div>
    </div>
    <p class="text-xs text-gray-500">Books in your collection</p>
    <div class="mt-3 h-1 bg-gradient-to-r from-indigo-600 to-purple-600 rounded-full"></div>
  </div>

  <!-- Total Genres Card -->
  <div class="glass-card p-6 hover:shadow-xl hover:scale-105 transform transition-all duration-300">
    <div class="flex items-start justify-between mb-4">
      <div class="flex-1">
        <p class="text-sm font-medium text-gray-500 mb-1">Total Genres</p>
        <p class="text-4xl font-extrabold bg-gradient-to-r from-purple-600 to-pink-600 bg-clip-text text-transparent">
          {{ $totalGenres }}
        </p>
      </div>
      <div class="w-12 h-12 bg-gradient-to-r from-purple-100 to-pink-100 rounded-xl flex items-center justify-center">
        <span class="text-3xl">🎭</span>
      </div>
    </div>
    <p class="text-xs text-gray-500">Different categories</p>
    <div class="mt-3 h-1 bg-gradient-to-r from-purple-600 to-pink-600 rounded-full"></div>
  </div>

  <!-- Top Rated Card -->
  <div class="glass-card p-6 hover:shadow-xl hover:scale-105 transform transition-all duration-300">
    <div class="flex items-start justify-between mb-4">
      <div class="flex-1">
        <p class="text-sm font-medium text-gray-500 mb-1">Top Rated</p>
        @if($topRated)
          <p class="text-4xl font-extrabold bg-gradient-to-r from-yellow-600 to-orange-600 bg-clip-text text-transparent">
            ⭐ {{ $topRated->rating }}
          </p>
        @else
          <p class="text-2xl font-bold text-gray-400">N/A</p>
        @endif
      </div>
      <div class="w-12 h-12 bg-gradient-to-r from-yellow-100 to-orange-100 rounded-xl flex items-center justify-center">
        <span class="text-3xl">🏆</span>
      </div>
    </div>
    @if($topRated)
      <p class="text-xs text-gray-600 truncate font-medium">{{ $topRated->title }}</p>
    @else
      <p class="text-xs text-gray-500">No ratings yet</p>
    @endif
    <div class="mt-3 h-1 bg-gradient-to-r from-yellow-600 to-orange-600 rounded-full"></div>
  </div>
</div>

  <!-- Success Message -->
  @if(session('deleted'))
    <div id="deletedMessage" class="mb-4 px-6 py-4 bg-red-50 border border-red-200 text-red-800 rounded-xl shadow-sm flex items-center gap-3">
      <span class="text-2xl">✓</span>
      <span class="font-medium">{{ session('deleted') }}</span>
    </div>
    <script>
      setTimeout(function() {
        const msg = document.getElementById('deletedMessage');
        if (msg) {
          msg.style.opacity = '0';
          msg.style.transform = 'translateY(-10px)';
          msg.style.transition = 'all 0.3s ease';
          setTimeout(() => msg.style.display = 'none', 300);
        }
      }, 3000);
    </script>
  @endif
  @if(session('success'))
    <div id="successMessage" class="mb-4 px-6 py-4 bg-green-50 border border-green-200 text-green-800 rounded-xl shadow-sm flex items-center gap-3">
      <span class="text-2xl">✓</span>
      <span class="font-medium">{{ session('success') }}</span>
    </div>
    <script>
      setTimeout(function() {
        const msg = document.getElementById('successMessage');
        if (msg) {
          msg.style.opacity = '0';
          msg.style.transform = 'translateY(-10px)';
          msg.style.transition = 'all 0.3s ease';
          setTimeout(() => msg.style.display = 'none', 300);
        }
      }, 3000);
    </script>
  @endif
  
  <!-- Add New Book Form -->
  <div id="add-book" class="glass-card p-8 mb-8 scroll-mt-20">
    <h2 class="text-2xl font-bold text-gray-800 mb-6 flex items-center gap-3">
      <span class="w-10 h-10 bg-gradient-to-r from-indigo-600 to-purple-600 rounded-lg flex items-center justify-center text-white">➕</span>
      <span>Add New Book</span>
    </h2>
    <form method="POST" action="{{ route('books.store') }}" class="space-y-6" enctype="multipart/form-data">
      @csrf
      
      <!-- First Row -->
      <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
        <div>
          <label class="block text-sm font-semibold text-gray-700 mb-2">Title <span class="text-red-500">*</span></label>
          <input 
            name="title" 
            value="{{ old('title') }}" 
            placeholder="Enter book title"
            class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition"
            required
          />
        </div>
        <div>
          <label class="block text-sm font-semibold text-gray-700 mb-2">Author <span class="text-red-500">*</span></label>
          <input 
            name="author" 
            value="{{ old('author') }}" 
            placeholder="Enter author name"
            class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition"
            required
          />
        </div>
        <div>
          <label class="block text-sm font-semibold text-gray-700 mb-2">Published Year <span class="text-red-500">*</span></label>
          <input 
            name="published_year" 
            value="{{ old('published_year') }}" 
            placeholder="2024"
            type="number"
            class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition"
            required
          />
        </div>
      </div>

      <!-- Second Row -->
      <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
        <div>
          <label class="block text-sm font-semibold text-gray-700 mb-2">Genre <span class="text-red-500">*</span></label>
          <select 
            name="genre_id" 
            required
            class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition"
          >
            <option value="">Select a genre</option>
            @foreach($genres as $g)
              <option value="{{ $g->id }}">{{ $g->name }}</option>
            @endforeach
          </select>
        </div>
        <div>
          <label class="block text-sm font-semibold text-gray-700 mb-2">Rating</label>
          <input 
            name="rating" 
            value="{{ old('rating') }}" 
            placeholder="e.g., 8.5 or 8/10"
            class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition"
            required
          />
        </div>
        <div>
          <label class="block text-sm font-semibold text-gray-700 mb-2">Photo (JPG/PNG, max 2MB)</label>
          <input 
            name="photo" 
            type="file"
            id="photoInput"
            accept=".jpg,.jpeg,.png"
            onchange="previewAddPhoto(this)"
            class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100"
          />
          <div id="photoPreview" class="hidden mt-3">
            <p class="text-xs text-gray-600 mb-2">Preview:</p>
            <img id="photoPreviewImg" src="" alt="Preview" class="w-24 h-24 rounded-lg object-cover border-2 border-indigo-200 shadow-sm">
          </div>
        </div>
      </div>

      <!-- Description -->
      <div>
        <label class="block text-sm font-semibold text-gray-700 mb-2">Description</label>
        <textarea 
          name="description" 
          placeholder="Enter book description..."
          rows="4"
          class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition resize-none"
        >{{ old('description') }}</textarea>
      </div>

      <!-- Submit Button -->
      <div class="flex justify-end pt-4">
        <button 
          type="submit" 
          class="px-8 py-3 bg-gradient-to-r from-indigo-600 to-purple-600 text-white rounded-xl hover:shadow-lg hover:scale-105 font-semibold transition-all duration-200 flex items-center gap-2"
        >
          <span>✨</span> Add Book
        </button>
      </div>
    </form>
  </div>

  <!-- Books Table -->
  <div id="books" class="glass-card overflow-hidden scroll-mt-20">
    <div class="px-8 py-6 border-b border-gray-200 bg-gradient-to-r from-gray-50 to-gray-100">
      <div class="flex flex-col lg:flex-row justify-between items-start lg:items-center gap-4">
        <h2 class="text-2xl font-bold text-gray-800 flex items-center gap-3">
          <span class="w-10 h-10 bg-gradient-to-r from-indigo-600 to-purple-600 rounded-lg flex items-center justify-center text-white">📚</span>
          <span>Books Collection</span>
        </h2>
        
        <!-- Export PDF Button -->
        <form method="GET" action="{{ route('books.exportPdf') }}" class="inline">
          @if(request('search'))
            <input type="hidden" name="search" value="{{ request('search') }}">
          @endif
          @if(request('genre_id'))
            <input type="hidden" name="genre_id" value="{{ request('genre_id') }}">
          @endif
          <button type="submit" class="px-5 py-2.5 bg-gradient-to-r from-red-600 to-red-700 hover:from-red-700 hover:to-red-800 text-white rounded-xl font-semibold transition-all duration-200 hover:shadow-lg flex items-center gap-2 text-sm">
            <span>📄</span> Export to PDF
          </button>
        </form>
      </div>

      <!-- Search & Filter Section -->
      <form method="GET" action="{{ route('books.index') }}#books" class="mt-6 grid grid-cols-1 md:grid-cols-4 gap-4">
        <div class="md:col-span-2">
          <input 
            type="text" 
            name="search" 
            value="{{ request('search') }}" 
            placeholder="🔍 Search by title, author, or description..."
            class="w-full px-4 py-3 border-2 border-gray-300 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition"
          />
        </div>
        <div>
          <select 
            name="genre_id" 
            class="w-full px-4 py-3 border-2 border-gray-300 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition"
          >
            <option value="">All Genres</option>
            @foreach($genres as $g)
              <option value="{{ $g->id }}" {{ request('genre_id') == $g->id ? 'selected' : '' }}>
                {{ $g->name }}
              </option>
            @endforeach
          </select>
        </div>
        <div class="flex gap-2">
          <button 
            type="submit" 
            class="flex-1 px-4 py-3 bg-gradient-to-r from-indigo-600 to-purple-600 text-white rounded-xl hover:shadow-lg font-semibold transition-all duration-200"
          >
            Search
          </button>
          <a 
            href="{{ route('books.index') }}#books" 
            class="px-4 py-3 bg-gray-200 hover:bg-gray-300 text-gray-700 rounded-xl font-semibold transition-all duration-200 flex items-center justify-center"
            title="Clear Filters"
          >
            ✕
          </a>
        </div>
      </form>
    </div>

    <div class="overflow-x-auto">
      <table class="w-full">
        <thead class="bg-gradient-to-r from-gray-50 to-gray-100">
          <tr>
            <th class="px-6 py-4 text-left text-sm font-bold text-gray-700">Photo</th>
            <th class="px-6 py-4 text-left text-sm font-bold text-gray-700">Title</th>
            <th class="px-6 py-4 text-left text-sm font-bold text-gray-700">Genre</th>
            <th class="px-6 py-4 text-left text-sm font-bold text-gray-700">Author</th>
            <th class="px-6 py-4 text-left text-sm font-bold text-gray-700">Year</th>
            <th class="px-6 py-4 text-left text-sm font-bold text-gray-700">Rating</th>
            <th class="px-6 py-4 text-left text-sm font-bold text-gray-700">Description</th>
            <th class="px-6 py-4 text-left text-sm font-bold text-gray-700">Actions</th>
          </tr>
        </thead>
        <tbody class="divide-y divide-gray-100">
          @forelse($books as $b)
          <tr class="hover:bg-gray-50/50 transition-colors duration-150">
            <td class="px-6 py-4">
              @if($b->photo)
                <img src="{{ asset('storage/' . $b->photo) }}" alt="{{ $b->title }}" class="w-12 h-12 rounded-full object-cover border-2 border-indigo-200">
              @else
                <div class="w-12 h-12 rounded-full bg-gradient-to-r from-indigo-500 to-purple-500 flex items-center justify-center text-white font-bold text-sm">
                  {{ strtoupper(substr($b->title, 0, 2)) }}
                </div>
              @endif
            </td>
            <td class="px-6 py-4 text-sm text-gray-900 font-semibold">{{ $b->title }}</td>
            <td class="px-6 py-4 text-sm text-gray-600">
              @if($b->genre)
                <span class="inline-flex items-center px-3 py-1.5 rounded-lg text-xs font-semibold bg-gradient-to-r from-indigo-100 to-purple-100 text-indigo-700">
                  🎭 {{ $b->genre->name }}
                </span>
              @else
                <span class="text-gray-400">N/A</span>
              @endif
            </td>
            <td class="px-6 py-4 text-sm text-gray-600">{{ $b->author }}</td>
            <td class="px-6 py-4 text-sm text-gray-600">{{ $b->published_year }}</td>
            <td class="px-6 py-4 text-sm">
              @if($b->rating)
                <span class="inline-flex items-center px-3 py-1.5 rounded-lg text-xs font-semibold bg-gradient-to-r from-yellow-100 to-orange-100 text-orange-700">
                  ⭐ {{ $b->rating }}
                </span>
              @else
                <span class="text-gray-400">N/A</span>
              @endif
            </td>
            <td class="px-6 py-4 text-sm text-gray-600 max-w-xs truncate">{{ $b->description ?? 'N/A' }}</td>
            <td class="px-6 py-4 text-sm">
              <div class="flex gap-2">
                <!-- Edit Button -->
                <button 
                  type="button" 
                  onclick="openEditModal({{ $b->id }}, '{{ addslashes($b->title) }}', '{{ $b->genre_id }}', '{{ $b->rating }}', '{{ addslashes($b->author) }}', '{{ $b->published_year }}', '{{ addslashes($b->description ?? '') }}', '{{ $b->photo }}')"
                  class="px-4 py-2 bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-700 hover:to-purple-700 text-white text-xs font-semibold rounded-lg transition-all duration-200 hover:shadow-md"
                >
                  ✏️ Edit
                </button>

                <!-- Delete Button -->
                <form method="POST" action="{{ route('books.destroy',$b) }}" onsubmit="return confirm('Are you sure you want to delete this book?');" class="inline">
                  @csrf 
                  @method('DELETE')
                  <button 
                    type="submit" 
                    class="px-4 py-2 bg-gradient-to-r from-red-500 to-red-600 hover:from-red-600 hover:to-red-700 text-white text-xs font-semibold rounded-lg transition-all duration-200 hover:shadow-md"
                  >
                    🗑️ Delete
                  </button>
                </form>
              </div>
            </td>
          </tr>
          @empty
          <tr>
            <td colspan="8" class="px-6 py-12 text-center">
              <div class="flex flex-col items-center justify-center space-y-3">
                <div class="w-20 h-20 bg-gray-100 rounded-full flex items-center justify-center">
                  <span class="text-5xl">📚</span>
                </div>
                <p class="text-gray-600 font-medium">No books found</p>
                <p class="text-gray-500 text-sm">
                  @if(request('search') || request('genre_id'))
                    Try adjusting your search filters
                  @else
                    Start by adding your first book!
                  @endif
                </p>
              </div>
            </td>
          </tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </div>
</div>

<!-- Edit Modal -->
<div id="editModal" class="hidden fixed inset-0 bg-black/60 backdrop-blur-sm flex justify-center items-center z-50 p-4">
    <div class="bg-white rounded-2xl w-full max-w-3xl max-h-[90vh] overflow-y-auto shadow-2xl">
        <div class="sticky top-0 bg-gradient-to-r from-indigo-600 to-purple-600 px-8 py-5 rounded-t-2xl">
            <div class="flex items-center justify-between">
                <h2 class="text-2xl font-bold text-white flex items-center gap-2">
                    <span>✏️</span> Edit Book
                </h2>
                <button onclick="closeEditModal()" class="text-white hover:bg-white/20 rounded-lg p-2 transition">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
        </div>

        <form id="editForm" method="POST" class="p-8 space-y-6" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Title</label>
                    <input 
                      type="text" 
                      name="title" 
                      id="editTitle" 
                      class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition"
                    />
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Author</label>
                    <input 
                      type="text" 
                      name="author" 
                      id="editAuthor" 
                      class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition"
                    />
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Published Year</label>
                    <input 
                      type="number" 
                      name="published_year" 
                      id="editYear" 
                      class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition"
                    />
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Genre</label>
                    <select 
                      name="genre_id" 
                      id="editGenre" 
                      class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition"
                    >
                        <option value="">Select Genre</option>
                        @foreach($genres as $genre)
                            <option value="{{ $genre->id }}">{{ $genre->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Rating</label>
                    <input 
                      type="text" 
                      name="rating" 
                      id="editRating" 
                      class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition"
                    />
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Photo (JPG/PNG, max 2MB)</label>
                    <input 
                      type="file" 
                      name="photo" 
                      id="editPhoto"
                      accept=".jpg,.jpeg,.png"
                      onchange="previewEditPhoto(this)"
                      class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100"
                    />
                    <p class="text-xs text-gray-500 mt-1">Leave empty to keep current photo</p>
                    <div id="editPhotoPreview" class="hidden mt-3">
                      <p class="text-xs text-gray-600 mb-2">New Preview:</p>
                      <img id="editPhotoPreviewImg" src="" alt="Preview" class="w-24 h-24 rounded-lg object-cover border-2 border-indigo-200 shadow-sm">
                    </div>
                </div>
            </div>

            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">Description</label>
                <textarea 
                  name="description" 
                  id="editDescription" 
                  rows="4"
                  class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition resize-none"
                ></textarea>
            </div>

            <div id="currentPhotoPreview" class="hidden">
                <label class="block text-sm font-semibold text-gray-700 mb-2">Current Photo</label>
                <img id="currentPhotoImg" src="" alt="Current photo" class="w-20 h-20 rounded-lg object-cover border-2 border-gray-200">
            </div>

            <div class="flex justify-end gap-3 pt-4 border-t-2 border-gray-100">
                <button 
                  type="button" 
                  onclick="closeEditModal()" 
                  class="px-6 py-3 border-2 border-gray-300 text-gray-700 rounded-xl hover:bg-gray-50 font-semibold transition-all duration-200"
                >
                  Cancel
                </button>
                <button 
                  type="submit" 
                  class="px-8 py-3 bg-gradient-to-r from-indigo-600 to-purple-600 text-white rounded-xl hover:shadow-lg hover:scale-105 font-semibold transition-all duration-200"
                >
                  Update Book
                </button>
            </div>
        </form>
    </div>
</div>

<script>
function previewAddPhoto(input) {
  const preview = document.getElementById('photoPreview');
  const previewImg = document.getElementById('photoPreviewImg');
  
  if (input.files && input.files[0]) {
    const reader = new FileReader();
    reader.onload = function(e) {
      previewImg.src = e.target.result;
      preview.classList.remove('hidden');
    };
    reader.readAsDataURL(input.files[0]);
  } else {
    preview.classList.add('hidden');
  }
}

function previewEditPhoto(input) {
  const preview = document.getElementById('editPhotoPreview');
  const previewImg = document.getElementById('editPhotoPreviewImg');
  
  if (input.files && input.files[0]) {
    const reader = new FileReader();
    reader.onload = function(e) {
      previewImg.src = e.target.result;
      preview.classList.remove('hidden');
    };
    reader.readAsDataURL(input.files[0]);
  } else {
    preview.classList.add('hidden');
  }
}

function openEditModal(id, title, genre_id, rating, author, published_year, description, photo) {
    document.getElementById('editModal').classList.remove('hidden');
    document.getElementById('editTitle').value = decodeURIComponent(title);
    document.getElementById('editGenre').value = genre_id;
    document.getElementById('editRating').value = rating;
    document.getElementById('editAuthor').value = decodeURIComponent(author);
    document.getElementById('editYear').value = published_year;
    document.getElementById('editDescription').value = decodeURIComponent(description);

    // Reset edit photo preview
    document.getElementById('editPhotoPreview').classList.add('hidden');
    document.getElementById('editPhoto').value = '';

    // Show current photo if exists
    if (photo && photo !== 'null' && photo !== '') {
        document.getElementById('currentPhotoPreview').classList.remove('hidden');
        document.getElementById('currentPhotoImg').src = '/storage/' + photo;
    } else {
        document.getElementById('currentPhotoPreview').classList.add('hidden');
    }

    // Set the form action dynamically
    document.getElementById('editForm').action = `/books/${id}`;
}

function closeEditModal() {
    document.getElementById('editModal').classList.add('hidden');
}

// Close modal when clicking outside
document.getElementById('editModal')?.addEventListener('click', function(e) {
    if (e.target === this) {
        closeEditModal();
    }
});

function scrollToSection(sectionId) {
  const el = document.getElementById(sectionId);
  if (el) {
    el.scrollIntoView({ behavior: 'smooth', block: 'start' });
  }
}
</script>

@endsection