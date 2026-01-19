@extends('layouts.app')
@section('content')

<!-- Page Header -->
<div class="glass-card sticky top-0 z-50 -mx-6 px-6 py-5 mb-8 border-b">
  <div class="flex justify-between items-center">
    <div>
      <h1 class="text-3xl font-extrabold bg-gradient-to-r from-purple-600 to-pink-600 bg-clip-text text-transparent flex items-center gap-3">
        <span class="text-3xl">🎭</span> Genres
      </h1>
      <p class="text-sm text-gray-500 mt-1">{{ \Carbon\Carbon::now()->format('l, F j, Y') }}</p>
    </div>
  </div>
</div>

<!-- Add New Genre Form -->
<div class="glass-card p-8 mb-8">
  <h2 class="text-2xl font-bold text-gray-800 mb-6 flex items-center gap-3">
    <span class="w-10 h-10 bg-gradient-to-r from-purple-600 to-pink-600 rounded-lg flex items-center justify-center text-white">➕</span>
    <span>Add New Genre</span>
  </h2>
  
  <form method="POST" action="{{ route('genres.store') }}" class="space-y-6">
    @csrf
    
    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
      <div>
        <label class="block text-sm font-semibold text-gray-700 mb-2">Genre Name <span class="text-red-500">*</span></label>
        <input 
          name="name" 
          value="{{ old('name') }}"
          placeholder="Enter genre name"
          class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-purple-500 focus:border-purple-500 outline-none transition"
          required
        />
        @error('name')
          <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
        @enderror
      </div>
    </div>

    <div>
      <label class="block text-sm font-semibold text-gray-700 mb-2">Description</label>
      <textarea 
        name="description" 
        placeholder="Enter genre description..."
        rows="4"
        class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-purple-500 focus:border-purple-500 outline-none transition resize-none"
      >{{ old('description') }}</textarea>
    </div>

    <div class="flex justify-end pt-4">
      <button 
        type="submit" 
        class="px-8 py-3 bg-gradient-to-r from-purple-600 to-pink-600 text-white rounded-xl hover:shadow-lg hover:scale-105 font-semibold transition-all duration-200 flex items-center gap-2"
      >
        <span>✨</span> Add Genre
      </button>
    </div>
  </form>
</div>

<!-- All Genres Table -->
<div class="glass-card overflow-hidden">
  <div class="px-8 py-6 border-b border-gray-200 bg-gradient-to-r from-gray-50 to-gray-100">
    <h2 class="text-2xl font-bold text-gray-800 flex items-center gap-3 mb-6">
      <span class="w-10 h-10 bg-gradient-to-r from-purple-600 to-pink-600 rounded-lg flex items-center justify-center text-white">🎭</span>
      <span>All Genres</span>
    </h2>

    <!-- Search Section -->
    <form method="GET" action="{{ route('genres.index') }}" class="flex gap-3">
      <input 
        type="text" 
        name="search" 
        value="{{ request('search') }}" 
        placeholder="🔍 Search genres by name or description..."
        class="flex-1 px-4 py-3 border-2 border-gray-300 rounded-xl focus:ring-2 focus:ring-purple-500 focus:border-purple-500 outline-none transition"
      />
      <button 
        type="submit" 
        class="px-6 py-3 bg-gradient-to-r from-purple-600 to-pink-600 text-white rounded-xl hover:shadow-lg font-semibold transition-all duration-200"
      >
        Search
      </button>
      <a 
        href="{{ route('genres.index') }}" 
        class="px-4 py-3 bg-gray-200 hover:bg-gray-300 text-gray-700 rounded-xl font-semibold transition-all duration-200 flex items-center justify-center"
        title="Clear Search"
      >
        ✕
      </a>
    </form>
  </div>

  <div class="overflow-x-auto">
    <table class="w-full">
      <thead class="bg-gradient-to-r from-gray-50 to-gray-100">
        <tr>
          <th class="px-6 py-4 text-left text-sm font-bold text-gray-700">Genre Name</th>
          <th class="px-6 py-4 text-left text-sm font-bold text-gray-700">Description</th>
          <th class="px-6 py-4 text-left text-sm font-bold text-gray-700">Books Count</th>
          <th class="px-6 py-4 text-left text-sm font-bold text-gray-700">Actions</th>
        </tr>
      </thead>
      <tbody class="divide-y divide-gray-100">
        @forelse($genres as $g)
        <tr class="hover:bg-gray-50/50 transition-colors duration-150">
          <td class="px-6 py-4 text-sm">
            <span class="inline-flex items-center px-4 py-2 rounded-xl text-sm font-semibold bg-gradient-to-r from-purple-100 to-pink-100 text-purple-700">
              🎭 {{ $g->name }}
            </span>
          </td>
          <td class="px-6 py-4 text-sm text-gray-600">
            @if($g->description)
              <span class="line-clamp-2">{{ $g->description }}</span>
            @else
              <span class="text-gray-400 italic">No description</span>
            @endif
          </td>
          <td class="px-6 py-4 text-sm">
            <span class="inline-flex items-center px-4 py-2 rounded-xl text-sm font-semibold bg-gradient-to-r from-indigo-100 to-blue-100 text-indigo-700">
              📚 {{ $g->books_count }} 
              <span class="ml-1">{{ $g->books_count === 1 ? 'book' : 'books' }}</span>
            </span>
          </td>
          <td class="px-6 py-4 text-sm">
            <div class="flex gap-2">
              <!-- Edit Button -->
              <button 
                type="button"
                onclick="openEditGenreModal({{ $g->id }}, '{{ addslashes($g->name) }}', '{{ addslashes($g->description ?? '') }}')"
                class="px-4 py-2 bg-gradient-to-r from-purple-600 to-pink-600 hover:from-purple-700 hover:to-pink-700 text-white text-xs font-semibold rounded-lg transition-all duration-200 hover:shadow-md flex items-center gap-1"
              >
                ✏️ Edit
              </button>

              <!-- Delete Button -->
              <form method="POST" action="{{ route('genres.destroy', $g) }}" onsubmit="return confirm('Are you sure you want to delete this genre? This action cannot be undone.');" class="inline">
                @csrf
                @method('DELETE')
                <button 
                  type="submit" 
                  class="px-4 py-2 bg-gradient-to-r from-red-500 to-red-600 hover:from-red-600 hover:to-red-700 text-white text-xs font-semibold rounded-lg transition-all duration-200 hover:shadow-md flex items-center gap-1"
                >
                  🗑️ Delete
                </button>
              </form>
            </div>
          </td>
        </tr>
        @empty
        <tr>
          <td colspan="4" class="px-6 py-12 text-center">
            <div class="flex flex-col items-center justify-center space-y-3">
              <div class="w-20 h-20 bg-gray-100 rounded-full flex items-center justify-center">
                <span class="text-5xl">🎭</span>
              </div>
              <p class="text-gray-600 font-medium">No genres found</p>
              <p class="text-gray-500 text-sm">Create your first genre to get started!</p>
            </div>
          </td>
        </tr>
        @endforelse
      </tbody>
    </table>
  </div>
</div>

<!-- Edit Genre Modal -->
<div id="editGenreModal" class="hidden fixed inset-0 bg-black/60 backdrop-blur-sm flex justify-center items-center z-50 p-4">
  <div class="bg-white rounded-2xl w-full max-w-lg shadow-2xl">
    <!-- Modal Header -->
    <div class="bg-gradient-to-r from-purple-600 to-pink-600 px-8 py-5 rounded-t-2xl">
      <div class="flex items-center justify-between">
        <h2 class="text-2xl font-bold text-white flex items-center gap-2">
          <span>✏️</span> Edit Genre
        </h2>
        <button onclick="closeEditGenreModal()" class="text-white hover:bg-white/20 rounded-lg p-2 transition">
          <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
          </svg>
        </button>
      </div>
    </div>

    <!-- Modal Body -->
    <form id="editGenreForm" method="POST" class="p-8 space-y-6">
      @csrf
      @method('PUT')
      
      <div>
        <label class="block text-sm font-semibold text-gray-700 mb-2">Genre Name</label>
        <input 
          type="text" 
          name="name" 
          id="editGenreName" 
          class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-purple-500 focus:border-purple-500 outline-none transition"
          required
        />
      </div>

      <div>
        <label class="block text-sm font-semibold text-gray-700 mb-2">Description</label>
        <textarea 
          name="description" 
          id="editGenreDescription" 
          rows="4"
          class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-purple-500 focus:border-purple-500 outline-none transition resize-none"
        ></textarea>
      </div>

      <!-- Modal Footer -->
      <div class="flex justify-end gap-3 pt-4 border-t-2 border-gray-100">
        <button 
          type="button" 
          onclick="closeEditGenreModal()" 
          class="px-6 py-3 border-2 border-gray-300 text-gray-700 rounded-xl hover:bg-gray-50 font-semibold transition-all duration-200"
        >
          Cancel
        </button>
        <button 
          type="submit" 
          class="px-8 py-3 bg-gradient-to-r from-purple-600 to-pink-600 text-white rounded-xl hover:shadow-lg hover:scale-105 font-semibold transition-all duration-200"
        >
          Update Genre
        </button>
      </div>
    </form>
  </div>
</div>

<script>
function openEditGenreModal(id, name, description) {
    document.getElementById('editGenreModal').classList.remove('hidden');
    document.getElementById('editGenreName').value = decodeURIComponent(name);
    document.getElementById('editGenreDescription').value = decodeURIComponent(description);
    document.getElementById('editGenreForm').action = `/genres/${id}`;
}

function closeEditGenreModal() {
    document.getElementById('editGenreModal').classList.add('hidden');
}

// Close modal when clicking outside
document.getElementById('editGenreModal')?.addEventListener('click', function(e) {
    if (e.target === this) {
        closeEditGenreModal();
    }
});
</script>

@endsection