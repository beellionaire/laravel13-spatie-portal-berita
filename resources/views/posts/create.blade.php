<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Tulis Artikel Baru') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-8 text-gray-900">
                    <form action="{{ route('posts.store') }}" method="POST">
                        @csrf
                        <div class="space-y-6">
                            
                            <div>
                                <label for="title" class="block text-sm font-medium text-gray-700">Judul Artikel</label>
                                <input type="text" name="title" id="title" value="{{ old('title') }}" placeholder="Masukkan judul menarik..." class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-lg font-medium py-3" required autofocus>
                                @error('title') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                            </div>

                            <div>
                                <label for="content" class="block text-sm font-medium text-gray-700 mb-1">Isi Konten</label>
                                <textarea name="content" id="content" rows="12" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" placeholder="Tuliskan isi berita atau artikel Anda di sini..." required>{{ old('content') }}</textarea>
                                @error('content') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                            </div>

                        </div>

                        <div class="mt-8 flex justify-end gap-x-4 pt-4 border-t border-gray-100">
                            <a href="{{ route('posts.index') }}" class="bg-white py-2 px-4 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                Batal
                            </a>
                            <button type="submit" class="bg-indigo-600 border border-transparent rounded-md shadow-sm py-2 px-6 inline-flex justify-center text-sm font-medium text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-900 transition-colors">
                                Terbitkan Artikel
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>