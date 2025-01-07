<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Admin Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h1 class="text-xl font-bold mb-4">All Posts</h1>

                    <!-- Check if there are any posts -->
                    @if ($posts->isEmpty())
                        <p>No posts available.</p>
                    @else
                        <table class="min-w-full table-auto border-collapse">
                            <thead>
                            <tr>
                                <th class="border px-4 py-2 text-left">Post Title</th>
                                <th class="border px-4 py-2 text-left">Content</th>
                                <th class="border px-4 py-2 text-left">Category</th>
                                <th class="border px-4 py-2 text-left">Actions</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($posts as $post)
                                <tr>
                                    <td class="border px-4 py-2">{{ $post->post_title }}</td>
                                    <td class="border px-4 py-2">{{ $post->content }}</td>
                                    <td class="border px-4 py-2">{{ $post->category->name ?? 'Uncategorized' }}</td>
                                    <td class="border px-4 py-2">
                                        <!-- Toggle Visibility Button -->
                                        <form action="{{ route('posts.toggleVisibility', $post->id) }}" method="POST" style="display:inline;">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" class="px-2 py-1 bg-blue-500 text-white rounded-md hover:bg-blue-600">
                                                {{ $post->visible ? 'Hide' : 'Show' }}
                                            </button>
                                        </form>

                                        <!-- Edit Button -->
                                        <a href="{{ route('posts.edit', $post->id) }}" class="px-2 py-1 bg-yellow-500 text-white rounded-md hover:bg-yellow-600 ml-2">
                                            Edit
                                        </a>

                                        <!-- Delete Button -->
                                        <form action="{{ route('posts.destroy', $post->id) }}" method="POST" style="display:inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="px-2 py-1 bg-red-500 text-white rounded-md hover:bg-red-600 ml-2" onclick="return confirm('Are you sure you want to delete this post?')">
                                                Delete
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
