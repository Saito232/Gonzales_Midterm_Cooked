@extends('layouts.app')
@section('content')

<!-- Page Header -->
<div class="glass-card sticky top-0 z-50 -mx-6 px-6 py-5 mb-8 border-b">
  <div class="flex justify-between items-center">
    <div>
      <h1 class="text-3xl font-extrabold bg-gradient-to-r from-red-600 to-orange-600 bg-clip-text text-transparent flex items-center gap-3">
        <span class="text-3xl">🗑️</span> Trash
      </h1>
      <p class="text-sm text-gray-500 mt-1">Restore or permanently delete items</p>
    </div>
  </div>
</div>

<!-- Success Messages -->
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

<!-- Deleted Books Section -->
<div class="glass-card overflow-hidden mb-8">
  <div class="px-8 py-6 border-b border-gray-200 bg-gradient-to-r from-gray-50 to-gray-100">
    <h2 class="text-2xl font-bold text-gray-800 flex items-center gap-3">
      <span class="w-10 h-10 bg-gradient-to-r from-red-600 to-orange-600 rounded-lg flex items-center justify-center text-white">📚</span>
      <span>Deleted Books</span>
    </h2>
  </div>

  <div class="overflow-x-auto">
    <table class="w-full">
      <thead class="bg-gradient-to-r from-gray-50 to-gray-100">
        <tr>
          <th class="px-6 py-4 text-left text-sm font-bold text-gray-700">Title</th>
          <th class="px-6 py-4 text-left text-sm font-bold text-gray-700">Author</th>
          <th class="px-6 py-4 text-left text-sm font-bold text-gray-700">Genre</th>
          <th class="px-6 py-4 text-left text-sm font-bold text-gray-700">Deleted At</th>
          <th class="px-6 py-4 text-left text-sm font-bold text-gray-700">Actions</th>
        </tr>
      </thead>
      <tbody class="divide-y divide-gray-100">
        @forelse($books as $book)
        <tr class="hover:bg-gray-50/50 transition-colors duration-150">
          <td class="px-6 py-4 text-sm text-gray-900 font-semibold">{{ $book->title }}</td>
          <td class="px-6 py-4 text-sm text-gray-600">{{ $book->author }}</td>
          <td class="px-6 py-4 text-sm">
            @if($book->genre)
              <span class="inline-flex items-center px-3 py-1.5 rounded-lg text-xs font-semibold bg-gradient-to-r from-indigo-100 to-purple-100 text-indigo-700">
                {{ $book->genre->name }}
              </span>
            @else
              <span class="text-gray-400">N/A</span>
            @endif
          </td>
          <td class="px-6 py-4 text-sm text-gray-600">{{ $book->deleted_at->format('M d, Y H:i') }}</td>
          <td class="px-6 py-4 text-sm">
            <div class="flex gap-2">
              <!-- Restore Button -->
              <form method="POST" action="{{ route('trash.books.restore', $book->id) }}">
                @csrf
                <button type="submit" class="px-4 py-2 bg-gradient-to-r from-green-600 to-green-700 hover:from-green-700 hover:to-green-800 text-white text-xs font-semibold rounded-lg transition-all duration-200 hover:shadow-md">
                  ↩️ Restore
                </button>
              </form>
              
              <!-- Permanent Delete Button -->
              <form method="POST" action="{{ route('trash.books.forceDelete', $book->id) }}" onsubmit="return confirm('Are you sure? This action cannot be undone!');">
                @csrf
                @method('DELETE')
                <button type="submit" class="px-4 py-2 bg-gradient-to-r from-red-600 to-red-700 hover:from-red-700 hover:to-red-800 text-white text-xs font-semibold rounded-lg transition-all duration-200 hover:shadow-md">
                  ❌ Delete Forever
                </button>
              </form>
            </div>
          </td>
        </tr>
        @empty
        <tr>
          <td colspan="5" class="px-6 py-12 text-center">
            <div class="flex flex-col items-center justify-center space-y-3">
              <div class="w-20 h-20 bg-gray-100 rounded-full flex items-center justify-center">
                <span class="text-5xl">📚</span>
              </div>
              <p class="text-gray-600 font-medium">No deleted books</p>
              <p class="text-gray-500 text-sm">Trash is empty</p>
            </div>
          </td>
        </tr>
        @endforelse
      </tbody>
    </table>
  </div>
</div>

<!-- Deleted Genres Section -->
<div class="glass-card overflow-hidden">
  <div class="px-8 py-6 border-b border-gray-200 bg-gradient-to-r from-gray-50 to-gray-100">
    <h2 class="text-2xl font-bold text-gray-800 flex items-center gap-3">
      <span class="w-10 h-10 bg-gradient-to-r from-purple-600 to-pink-600 rounded-lg flex items-center justify-center text-white">🎭</span>
      <span>Deleted Genres</span>
    </h2>
  </div>

  <div class="overflow-x-auto">
    <table class="w-full">
      <thead class="bg-gradient-to-r from-gray-50 to-gray-100">
        <tr>
          <th class="px-6 py-4 text-left text-sm font-bold text-gray-700">Name</th>
          <th class="px-6 py-4 text-left text-sm font-bold text-gray-700">Description</th>
          <th class="px-6 py-4 text-left text-sm font-bold text-gray-700">Deleted At</th>
          <th class="px-6 py-4 text-left text-sm font-bold text-gray-700">Actions</th>
        </tr>
      </thead>
      <tbody class="divide-y divide-gray-100">
        @forelse($genres as $genre)
        <tr class="hover:bg-gray-50/50 transition-colors duration-150">
          <td class="px-6 py-4 text-sm font-semibold text-gray-900">{{ $genre->name }}</td>
          <td class="px-6 py-4 text-sm text-gray-600">{{ $genre->description ?? 'N/A' }}</td>
          <td class="px-6 py-4 text-sm text-gray-600">{{ $genre->deleted_at->format('M d, Y H:i') }}</td>
          <td class="px-6 py-4 text-sm">
            <div class="flex gap-2">
              <!-- Restore Button -->
              <form method="POST" action="{{ route('trash.genres.restore', $genre->id) }}">
                @csrf
                <button type="submit" class="px-4 py-2 bg-gradient-to-r from-green-600 to-green-700 hover:from-green-700 hover:to-green-800 text-white text-xs font-semibold rounded-lg transition-all duration-200 hover:shadow-md">
                  ↩️ Restore
                </button>
              </form>
              
              <!-- Permanent Delete Button -->
              <form method="POST" action="{{ route('trash.genres.forceDelete', $genre->id) }}" onsubmit="return confirm('Are you sure? This action cannot be undone!');">
                @csrf
                @method('DELETE')
                <button type="submit" class="px-4 py-2 bg-gradient-to-r from-red-600 to-red-700 hover:from-red-700 hover:to-red-800 text-white text-xs font-semibold rounded-lg transition-all duration-200 hover:shadow-md">
                  ❌ Delete Forever
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
              <p class="text-gray-600 font-medium">No deleted genres</p>
              <p class="text-gray-500 text-sm">Trash is empty</p>
            </div>
          </td>
        </tr>
        @endforelse
      </tbody>
    </table>
  </div>
</div>

@endsection
