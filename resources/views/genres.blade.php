@extends('layouts.app')
@section('content')

<!-- Page Header -->
<div class="bg-white shadow-sm sticky top-0 z-50 -mx-6 px-6 py-4 mb-6">
  <div class="flex justify-between items-center">
    <h1 class="text-3xl font-bold text-gray-800 flex items-center gap-2">
      <span class="text-3xl">🎟️</span> Blockbuster Genres
    </h1>
    <div class="text-sm text-gray-600">
      {{ \Carbon\Carbon::now()->format('l, F j, Y') }}
    </div>
  </div>
</div>

<!-- Add New Genre Form -->
<div class="bg-white rounded-lg shadow-md p-6 mb-8">
  <h2 class="text-xl font-bold text-gray-800 mb-6 flex items-center gap-2">
    <span class="text-2xl">➕</span> Add New Genre
  </h2>
  
  <form method="POST" action="{{ route('genres.store') }}" class="space-y-4">
    @csrf
    
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
      <div>
        <label class="block text-sm font-medium text-gray-700 mb-2">Genre Name <span class="text-red-500">*</span></label>
        <input 
          name="name" 
          value="{{ old('name') }}"
          placeholder="Enter genre name"
          class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none transition"
          required
        />
        @error('name')
          <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
        @enderror
      </div>
    </div>

    <div>
      <label class="block text-sm font-medium text-gray-700 mb-2">Description</label>
      <textarea 
        name="description" 
        placeholder="Enter genre description..."
        rows="3"
        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none transition"
      >{{ old('description') }}</textarea>
    </div>

    <div class="flex justify-end pt-4">
      <button 
        type="submit" 
        class="px-6 py-2 bg-gradient-to-r from-blue-600 to-blue-700 text-white rounded-lg hover:from-blue-700 hover:to-blue-800 font-medium transition-all duration-200 flex items-center gap-2"
      >
        <span>✨</span> Add Genre
      </button>
    </div>
  </form>
</div>

<!-- All Genres Table -->
<div class="bg-white rounded-lg shadow-md overflow-hidden">
  <div class="p-6 border-b border-gray-200">
    <h2 class="text-xl font-bold text-gray-800 flex items-center gap-2">
      <span class="text-2xl">📚</span> All Genres
    </h2>
  </div>

  <div class="overflow-x-auto">
    <table class="w-full">
      <thead class="bg-gray-50 border-b border-gray-200">
        <tr>
          <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Genre Name</th>
          <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Description</th>
          <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Movies Count</th>
          <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Actions</th>
        </tr>
      </thead>
      <tbody class="divide-y divide-gray-200">
        @forelse($genres as $g)
        <tr class="hover:bg-gray-50 transition-colors duration-150">
          <td class="px-6 py-4 text-sm text-gray-900 font-medium">
            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-purple-100 text-purple-800">
              {{ $g->name }}
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
            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-blue-100 text-blue-800">
              🎥 {{ $g->movies_count }} 
              <span class="ml-1">{{ $g->movies_count === 1 ? 'movie' : 'movies' }}</span>
            </span>
          </td>
          <td class="px-6 py-4 text-sm">
            <div class="flex gap-2">
              <!-- Edit Button -->
              <button 
                type="button"
                onclick="openEditGenreModal({{ $g->id }}, '{{ addslashes($g->name) }}', '{{ addslashes($g->description ?? '') }}')"
                class="px-3 py-1 bg-blue-500 hover:bg-blue-600 text-white text-xs font-medium rounded-lg transition-colors duration-200 flex items-center gap-1"
              >
                ✏️ Edit
              </button>

              <!-- Delete Button -->
              <form method="POST" action="{{ route('genres.destroy', $g) }}" onsubmit="return confirm('Are you sure you want to delete this genre? This action cannot be undone.');" class="inline">
                @csrf
                @method('DELETE')
                <button 
                  type="submit" 
                  class="px-3 py-1 bg-red-500 hover:bg-red-600 text-white text-xs font-medium rounded-lg transition-colors duration-200 flex items-center gap-1"
                >
                  🗑️ Delete
                </button>
              </form>
            </div>
          </td>
        </tr>
        @empty
        <tr>
          <td colspan="4" class="px-6 py-8 text-center text-gray-500">
            <div class="flex flex-col items-center justify-center">
              <span class="text-4xl mb-2">🎭</span>
              <p class="font-medium">No genres found yet</p>
              <p class="text-sm text-gray-400">Create your first genre to get started!</p>
            </div>
          </td>
        </tr>
        @endforelse
      </tbody>
    </table>
  </div>
</div>

<!-- Edit Genre Modal -->
<div id="editGenreModal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex justify-center items-center z-50 p-4">
  <div class="bg-white rounded-lg w-full max-w-md shadow-xl">
    <!-- Modal Header -->
    <div class="bg-gradient-to-r from-purple-600 to-purple-700 px-6 py-4 border-b border-gray-200">
      <h2 class="text-xl font-bold text-white">✏️ Edit Genre</h2>
    </div>

    <!-- Modal Body -->
    <form id="editGenreForm" method="POST" class="p-6 space-y-4">
      @csrf
      @method('PUT')
      
      <div>
        <label class="block text-sm font-medium text-gray-700 mb-2">Genre Name</label>
        <input 
          type="text" 
          name="name" 
          id="editGenreName" 
          class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent outline-none transition"
          required
        />
      </div>

      <div>
        <label class="block text-sm font-medium text-gray-700 mb-2">Description</label>
        <textarea 
          name="description" 
          id="editGenreDescription" 
          rows="4"
          class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent outline-none transition"
        ></textarea>
      </div>

      <!-- Modal Footer -->
      <div class="flex justify-end gap-3 pt-4 border-t border-gray-200">
        <button 
          type="button" 
          onclick="closeEditGenreModal()" 
          class="px-4 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 font-medium transition-colors duration-200"
        >
          Cancel
        </button>
        <button 
          type="submit" 
          class="px-4 py-2 bg-gradient-to-r from-purple-600 to-purple-700 text-white rounded-lg hover:from-purple-700 hover:to-purple-800 font-medium transition-all duration-200"
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