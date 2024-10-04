<x-app-layout>

    <div class="px-5 mt-5 mb-10">
        <form action="/allPost" method="GET" class="relative overflow-hidden border rounded-md">
            <input type="text" name="search" placeholder="Search here...." value="{{ request('search') }}"
                class="w-full px-2 py-4 rounded-md focus:outline-none">
            <button type="submit"
                class="absolute top-0 right-0 z-20 p-4 duration-100 bg-none hover:scale-105">🔍</button>
        </form>
        @if($posts->isEmpty())
        @if($query)
        <h1 class="py-2 mb-40 text-center">No Post Found</h1>
        @else
        <h1 class="py-2 text-center">No Post Created yet</h1>
        @endif
        @else
        {{-- <div class="flex items-center justify-between">
            <h1 class="block mt-5 font-semibold text-center md:text-2xl">All Article</h1>
            <a href="/dashboard"
                class="block mt-5 font-semibold text-center duration-100 border-b-2 border-black md:text-2xl hover:translate-x-2 w-fit">Newest
                Article</a>
        </div> --}}
        <div class="grid grid-cols-1 gap-2 mt-3 md:gap-4 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4">
            @foreach ($posts as $p)
            <a href="/allPost/{{ $p->slug }}"
                class="flex flex-col items-center justify-center p-2 duration-100 border-b-2 border-r-2 hover:scale-105 hover:shadow-md">
                <img src="{{ $p->image ? asset('storage/' . $p->image) : 'https://placehold.co/200x200' }}" alt=""
                    class="object-cover text-center w-52 h-52">
                <p class="pt-2 text-center line-clamp-3">{{ $p->title }}</p>
                <small class="w-full text-end font-extralight">{{ $p->created_at->diffForHumans() }}</small>
            </a>
            @endforeach
        </div>
        <div class="p-2">
            {{ $posts->links() }}
        </div>
        @endif
    </div>

    <x-footer />

    {{-- <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    {{ __("You're logged in!") }}
                </div>
            </div>
        </div>
    </div> --}}
</x-app-layout>
