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
                                <th class="border px-4 py-2">Post Title</th>
                                <th class="border px-4 py-2">Category</th>
                                <th class="border px-4 py-2">Actions</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($posts as $post)
                                <div class="post">
                                    <td><h3>{{ $post->post_title }}</h3></td>
                                    <td><p>{{ $post->content }}</p></td>

                                    <!-- Toggle Visibility Button -->
                                    <td><form action="{{ route('posts.toggleVisibility', $post->id) }}" method="POST">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="btn btn-toggle">
                                            {{ $post->visible ? 'Hide' : 'Show' }} Post
                                        </button>
                                        </form></td>

                                    <!-- Edit and Delete buttons -->
                                    <td><a href="{{ route('posts.edit', $post->id) }}">Edit</a></td>
                                    <td><form action="{{ route('posts.destroy', $post->id) }}" method="POST" style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit">Delete</button>
                                        </form></td>
                                </div>
                            @endforeach
                            </tbody>
                        </table>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
