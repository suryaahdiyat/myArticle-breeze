<x-app-layout>
    <div class="p-2 m-2 rounded">
        @if (session()->has('success'))
            <p class="px-2 py-3 mb-2 text-xl text-center border rounded border-emerald-500 bg-emerald-200">
                {{ session('success') }}
            </p>
        @endif
        @if (!isset($su))
            <a href="/myPost/add"
                class="block px-3 py-2 my-2 text-center text-white duration-100 bg-black border-2 border-transparent rounded hover:bg-white hover:text-black hover:border-black hover:scale-95">Add
                New Post</a>
        @endif
        <div class="">
            @if ($posts->isEmpty())
                <h1 class="py-2 text-center">Your post is empty</h1>
            @else
                <table class="min-w-full text-sm bg-white divide-y-2 divide-gray-200">
                    <thead class="ltr:text-left rtl:text-right">
                        <tr>
                            <th class="px-4 py-2 font-medium text-gray-900 whitespace-nowrap">No</th>
                            <th class="px-4 py-2 font-medium text-gray-900 whitespace-nowrap">Title</th>
                            <th class="px-4 py-2 font-medium text-gray-900 whitespace-nowrap">Desc</th>
                            <th class="px-4 py-2 font-medium text-gray-900 whitespace-nowrap">Action</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @php
                            $no = ($posts->currentPage() - 1) * $posts->perPage() + 1;
                        @endphp
                        @foreach ($posts as $post)
                            <tr>
                                <td class="px-4 py-2 text-center text-gray-700 whitespace-nowrap">{{ $no++ }}
                                </td>
                                <td
                                    class="max-w-xs px-4 py-2 font-medium text-center text-gray-900 truncate whitespace-nowrap">
                                    <p class="text-wrap line-clamp-2">{{ $post->title }}</p>
                                </td>
                                <td class="max-w-xs px-4 py-2 text-center text-gray-700 whitespace-nowrap">
                                    <p class="text-wrap line-clamp-2">{{ $post->content }}</p>
                                </td>
                                <td
                                    class="flex flex-col justify-center gap-2 px-4 py-2 text-center md:flex-row whitespace-nowrap">
                                    @if (!isset($su))
                                        <a href="/myPost/edit/{{ $post->slug }}"
                                            class="inline-block px-4 py-2 text-xs font-medium text-white rounded bg-cyan-600 hover:bg-cyan-700">
                                            Edit
                                        </a>
                                    @endif
                                    <form action="/myPost/{{ $post->slug }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" onclick="return handleDelete()"
                                            class="inline-block px-4 py-2 text-xs font-medium text-white rounded bg-rose-600 hover:bg-rose-700">
                                            delete
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="p-2">
                    {{ $posts->links() }}
                </div>
            @endif
        </div>
    </div>
    <script>
        // console.log($posts)
        const handleDelete = () => {
            return confirm('Are you want to delete this post?')
        }
    </script>
</x-app-layout>
