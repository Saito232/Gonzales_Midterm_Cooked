@extends('layouts.app')
@section('content')

<!-- Page Header -->
<div class="bg-white shadow-sm sticky top-0 z-50 -mx-6 px-6 py-4 mb-6">
  <div class="flex justify-between items-center">
    <h1 class="text-3xl font-bold text-gray-800 flex items-center gap-2">
      <span class="text-3xl">📚</span> Unilibrary Dashboard
    </h1>
    <div class="text-sm text-gray-600">
      {{ \Carbon\Carbon::now()->format('l, F j, Y') }}
    </div>
  </div>
</div>

<!-- Blockbuster Hero Section -->
<div class="blockbuster-bg rounded-xl shadow-lg mb-10 p-8 flex flex-col md:flex-row items-center justify-between gap-8 animate-fade-in">
  <div>
    <h1 class="text-4xl md:text-5xl font-extrabold text-yellow-400 drop-shadow-lg mb-4 font-['Figtree',sans-serif] tracking-wide flex items-center gap-3">
      <span>📚</span> Welcome to Unilibrary!
    </h1>
    <p class="text-lg text-white/90 mb-4 max-w-xl">Your personal book vault. Add, manage, and discover your favorite books with a modern, interactive dashboard. Enjoy dark mode, genre highlights, and more!</p>
    <div class="flex gap-4 mt-4">
      <a href="#add-book" class="blockbuster-btn px-6 py-3 text-lg" onclick="scrollToSection('add-book')">Add Book</a>
      <a href="#books" class="blockbuster-btn px-6 py-3 text-lg" onclick="scrollToSection('books')">View Collection</a>
    </div>
  </div>
  <div class="hidden md:block">
    <img src="https://img.icons8.com/color/96/books.png" alt="Books" class="rounded-xl shadow-xl animate-bounce" />
  </div>
</div>

  <!-- Stats Cards -->
  <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
    <!-- Total Books Card -->
    <div class="blockbuster-card hover:scale-105 transition-transform duration-300">
      <div class="flex items-center justify-between">
        <div>
          <p class="text-gray-100 text-sm font-medium">Total Books</p>
          <p class="text-3xl font-extrabold text-yellow-400 mt-2">{{ $totalBooks }}</p>
        </div>
        <div class="text-5xl opacity-40">📚</div>
      </div>
      <p class="text-xs text-yellow-200 mt-4">Books in your collection</p>
    </div>

    <!-- Total Genres Card -->
    <div class="blockbuster-card hover:scale-105 transition-transform duration-300">
      <div class="flex items-center justify-between">
        <div>
          <p class="text-gray-100 text-sm font-medium">Total Genres</p>
          <p class="text-3xl font-extrabold text-yellow-400 mt-2">{{ $totalGenres }}</p>
        </div>
        <div class="text-5xl opacity-40">🏷️</div>
      </div>
      <p class="text-xs text-yellow-200 mt-4">Genres available</p>
    </div>

    <!-- Top Rated Card -->
    <div class="blockbuster-card hover:scale-105 transition-transform duration-300">
      <div class="flex items-center justify-between">
        <div>
          <p class="text-gray-100 text-sm font-medium">Top Rated</p>
          <p class="text-2xl font-extrabold text-yellow-400 mt-2">
            @if($topRated)
              <span class="text-yellow-300">⭐</span> {{ $topRated->rating }}
            @else
              N/A
            @endif
          </p>
          @if($topRated)
            <p class="text-xs text-yellow-200 mt-2 truncate">{{ $topRated->title }}</p>
          @endif
        </div>
        <div class="text-5xl opacity-40">🏆</div>
      </div>
    </div>
  </div>

  <!-- Success Message -->
  @if(session('deleted'))
    <div id="deletedMessage" class="mb-4 px-4 py-2 bg-red-100 text-red-800 rounded-lg shadow animate-fade-in">
      {{ session('deleted') }}
    </div>
    <script>
      setTimeout(function() {
        const msg = document.getElementById('deletedMessage');
        if (msg) msg.style.display = 'none';
      }, 500);
    </script>
  @endif
  @if(session('success'))
    <div id="successMessage" class="mb-4 px-4 py-2 bg-green-100 text-green-800 rounded-lg shadow animate-fade-in">
      {{ session('success') }}
    </div>
    <script>
      setTimeout(function() {
        const msg = document.getElementById('successMessage');
        if (msg) msg.style.display = 'none';
      }, 500);
    </script>
  @endif
  <!-- Add New Book Form -->
  <div id="add-book" class="bg-white rounded-lg shadow-md p-6 mb-8">
    <h2 class="text-xl font-bold text-gray-800 mb-6 flex items-center gap-2">
      <span class="text-2xl">➕</span> Add New Book
    </h2>
    <form method="POST" action="{{ route('books.store') }}" class="space-y-4">
      @csrf
      
      <!-- First Row -->
      <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
        <div>
          <label class="block text-sm font-medium text-gray-700 mb-2">Title <span class="text-red-500">*</span></label>
          <input 
            name="title" 
            value="{{ old('title') }}" 
            placeholder="Book title"
            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none transition"
            required
          />
        </div>
        <div>
          <label class="block text-sm font-medium text-gray-700 mb-2">Author <span class="text-red-500">*</span></label>
          <input 
            name="author" 
            value="{{ old('author') }}" 
            placeholder="Author name"
            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none transition"
            required
          />
        </div>
        <div>
          <label class="block text-sm font-medium text-gray-700 mb-2">Published Year <span class="text-red-500">*</span></label>
          <input 
            name="published_year" 
            value="{{ old('published_year') }}" 
            placeholder="2024"
            type="number"
            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none transition"
            required
          />
        </div>
      </div>

      <!-- Second Row -->
      <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <div>
          <label class="block text-sm font-medium text-gray-700 mb-2">Genre</label>
          <select 
            name="genre_id" 
            required
            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none transition"
          >
            <option value="">Select a genre</option>
            @foreach($genres as $g)
              <option value="{{ $g->id }}">{{ $g->name }}</option>
            @endforeach
          </select>
        </div>
        <div>
          <label class="block text-sm font-medium text-gray-700 mb-2">Rating</label>
          <input 
            name="rating" 
            value="{{ old('rating') }}" 
            placeholder="e.g., 8.5 or 8/10"
            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none transition"
            required
          />
        </div>
      </div>


      <!-- Description -->
      <div>
        <label class="block text-sm font-medium text-gray-700 mb-2">Description</label>
        <textarea 
          name="description" 
          placeholder="Book description..."
          rows="3"
          class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none transition"
        >{{ old('description') }}</textarea>
      </div>

      <!-- Submit Button -->
      <div class="flex justify-end pt-4">
        <button 
          type="submit" 
          class="px-6 py-2 bg-gradient-to-r from-blue-600 to-blue-700 text-white rounded-lg hover:from-blue-700 hover:to-blue-800 font-medium transition-all duration-200 flex items-center gap-2"
        >
          <span>✨</span> Add Book
        </button>
      </div>
    </form>
  </div>

  <!-- Books Table -->
  <div id="books" class="bg-white rounded-lg shadow-md overflow-hidden">
    <div class="p-6 border-b border-gray-200">
      <h2 class="text-xl font-bold text-gray-800 flex items-center gap-2">
        <span class="text-2xl">📚</span> Books Collection
      </h2>
    </div>

    <div class="overflow-x-auto">
      <table class="w-full">
        <thead class="bg-gray-50 border-b border-gray-200">
          <tr>
            <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Title</th>
            <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Genre</th>
            <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Author</th>
            <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Year</th>
            <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Rating</th>
            <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Description</th>
            <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Actions</th>
          </tr>
        </thead>
        <tbody class="divide-y divide-gray-200">
          @forelse($books as $b)
          <tr class="hover:bg-gray-50 transition-colors duration-150">
            <td class="px-6 py-4 text-sm text-gray-900 font-medium">{{ $b->title }}</td>
            <td class="px-6 py-4 text-sm text-gray-600">
              @if($b->genre)
                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-blue-100 text-blue-800">
                  {{ $b->genre->name }}
                </span>
              @else
                <span class="text-gray-400">N/A</span>
              @endif
            </td>
            <td class="px-6 py-4 text-sm text-gray-600">{{ $b->author }}</td>
            <td class="px-6 py-4 text-sm text-gray-600">{{ $b->published_year }}</td>
            <td class="px-6 py-4 text-sm text-gray-600">
              @if($b->rating)
                <span class="text-yellow-500">⭐ {{ $b->rating }}</span>
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
                  onclick="openEditModal({{ $b->id }}, '{{ addslashes($b->title) }}', '{{ $b->genre_id }}', '{{ $b->rating }}', '{{ addslashes($b->author) }}', '{{ $b->published_year }}', '{{ addslashes($b->description ?? '') }}')"
                  class="px-3 py-1 bg-blue-500 hover:bg-blue-600 text-white text-xs font-medium rounded-lg transition-colors duration-200"
                >
                  ✏️ Edit
                </button>

                <!-- Delete Button -->
                <form method="POST" action="{{ route('books.destroy',$b) }}" onsubmit="return confirm('Are you sure you want to delete this book?');" class="inline">
                  @csrf 
                  @method('DELETE')
                  <button 
                    type="submit" 
                    class="px-3 py-1 bg-red-500 hover:bg-red-600 text-white text-xs font-medium rounded-lg transition-colors duration-200"
                  >
                    🗑️ Delete
                  </button>
                </form>
              </div>
            </td>
          </tr>
          @empty
          <tr>
            <td colspan="7" class="px-6 py-8 text-center text-gray-500">
              <div class="flex flex-col items-center justify-center">
                <span class="text-4xl mb-2">📚</span>
                <p>No books found. Start by adding your first book!</p>
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
<div id="editModal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex justify-center items-center z-50 p-4">
    <div class="bg-white rounded-lg w-full max-w-2xl max-h-screen overflow-y-auto shadow-xl">
        <div class="sticky top-0 bg-gradient-to-r from-blue-600 to-blue-700 px-6 py-4 border-b border-gray-200">
            <h2 class="text-xl font-bold text-white">✏️ Edit Book</h2>
        </div>

        <form id="editForm" method="POST" class="p-6 space-y-4">
            @csrf
            @method('PUT')
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Title</label>
                    <input 
                      type="text" 
                      name="title" 
                      id="editTitle" 
                      class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none transition"
                    />
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Author</label>
                    <input 
                      type="text" 
                      name="author" 
                      id="editAuthor" 
                      class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none transition"
                    />
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Published Year</label>
                    <input 
                      type="number" 
                      name="published_year" 
                      id="editYear" 
                      class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none transition"
                    />
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Genre</label>
                    <select 
                      name="genre_id" 
                      id="editGenre" 
                      class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none transition"
                    >
                        <option value="">Select Genre</option>
                        @foreach($genres as $genre)
                            <option value="{{ $genre->id }}">{{ $genre->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Rating</label>
                <input 
                  type="text" 
                  name="rating" 
                  id="editRating" 
                  class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none transition"
                />
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Description</label>
                <textarea 
                  name="description" 
                  id="editDescription" 
                  rows="4"
                  class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none transition"
                ></textarea>
            </div>

            <div class="flex justify-end gap-3 pt-4 border-t border-gray-200">
                <button 
                  type="button" 
                  onclick="closeEditModal()" 
                  class="px-4 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 font-medium transition-colors duration-200"
                >
                  Cancel
                </button>
                <button 
                  type="submit" 
                  class="px-4 py-2 bg-gradient-to-r from-blue-600 to-blue-700 text-white rounded-lg hover:from-blue-700 hover:to-blue-800 font-medium transition-all duration-200"
                >
                  Update Book
                </button>
            </div>
        </form>
    </div>
</div>

<script>
function openEditModal(id, title, genre_id, rating, author, published_year, description) {
    document.getElementById('editModal').classList.remove('hidden');
    document.getElementById('editTitle').value = decodeURIComponent(title);
    document.getElementById('editGenre').value = genre_id;
    document.getElementById('editRating').value = rating;
    document.getElementById('editAuthor').value = decodeURIComponent(author);
    document.getElementById('editYear').value = published_year;
    document.getElementById('editDescription').value = decodeURIComponent(description);

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