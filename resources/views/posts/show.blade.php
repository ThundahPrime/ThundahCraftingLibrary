<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Post Details') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <!-- Show Post Title -->
                    <h1 class="text-2xl font-bold">{{ $post->post_title }}</h1>

                    <!-- Show Post Content -->
                    <div class="mt-4">
                        <p>{{ $post->content }}</p>
                    </div>
                </div>
            </div>

            <!-- Comments Section -->
            <div class="mt-6 bg-white dark:bg-gray-800 p-6 shadow-sm sm:rounded-lg">
                <h2 class="text-xl font-semibold text-gray-800 dark:text-gray-200">Comments</h2>

                <!-- Display error/success messages -->
                @if(session('error'))
                    <div class="text-red-500">{{ session('error') }}</div>
                @endif
                @if(session('success'))
                    <div class="text-green-500">{{ session('success') }}</div>
                @endif

                <!-- Comment Form -->
                <div class="mt-6">
                    <form method="POST" action="{{ route('comments.store', $post->id) }}">
                        @csrf
                        <div>
                            <textarea name="content" rows="4" class="w-full p-2 border border-gray-300 rounded-md" placeholder="Leave a comment..." required></textarea>
                        </div>

                        <div class="mt-4">
                            <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600">
                                Post Comment
                            </button>
                        </div>
                    </form>
                </div>

                <!-- Show all Comments -->
                <div class="mt-6">
                    @foreach ($post->comments as $comment)
                        <div class="mt-4 p-4 bg-gray-100 rounded-lg">
                            <div class="flex justify-between items-center">
                                <div>
                                    <p class="font-semibold">{{ $comment->user->name }}</p>
                                    <p>{{ $comment->content }}</p>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

            </div>
        </div>
    </div>
</x-app-layout>
