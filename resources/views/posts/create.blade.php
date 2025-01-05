<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>
<div class="container mx-auto p-8">
    <h1 class="text-2xl font-bold mb-4">Create a New Post</h1>

    @if(session('success'))
        <div class="bg-green-500 text-white p-3 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    <form action="{{ route('posts.store') }}" method="POST" class="bg-white p-6 rounded shadow">
        @csrf

        <!-- Post Title -->
        <div class="mb-4">
            <label for="title" class="block text-gray-700 font-bold">Post Title</label>
            <input type="text" id="title" name="title" class="w-full border-gray-300 rounded p-2" required>
            @error('title')
            <span class="text-red-500 text-sm">{{ $message }}</span>
            @enderror
        </div>

        <!-- Post Content -->
        <div class="mb-4">
            <label for="content" class="block text-gray-700 font-bold">Content</label>
            <textarea id="content" name="content" rows="4" class="w-full border-gray-300 rounded p-2" required></textarea>
            @error('content')
            <span class="text-red-500 text-sm">{{ $message }}</span>
            @enderror
        </div>

        <!-- Category Dropdown -->
        <div class="mb-4">
            <label for="category_id" class="block text-gray-700 font-bold">Category</label>
            <select id="category_id" name="category_id" class="w-full border-gray-300 rounded p-2" required>
                <option value="" disabled selected>Select a category</option>
                @foreach($categories as $category)
                    <option value="{{ $category->id }}">{{ $category->category_name }}</option>
                @endforeach
            </select>
            @error('category_id')
            <span class="text-red-500 text-sm">{{ $message }}</span>
            @enderror
        </div>

        <!-- Submit Button -->
        <div>
            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Create Post</button>
        </div>
    </form>
</div>
</x-app-layout>
