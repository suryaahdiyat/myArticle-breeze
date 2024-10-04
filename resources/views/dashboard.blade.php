<x-app-layout>

    <div class="flex justify-center my-10">
		<div class="w-3/5">
			<div class="pb-5 text-center border-b-4 border-black">
				<h1 class="text-2xl font-bold md:text-4xl">Discover New Inspiration and Insights for Every Aspect of Your Life</h1>
				<p class="mt-5 text-xs">Our blog offers a range of inspiring and insightful content designed to enhance
					every area of your life. Explore
					articles that motivate and inform, helping you overcome challenges, make informed decisions, and
					achieve both personal
					and professional goals.</p>
			</div>
			<div>
				{{-- <div class="flex items-center justify-between">
					<h1 class="block mt-5 font-semibold text-center md:text-2xl">Newest Article</h1>
					<a href="/allPost"
						class="block mt-5 font-semibold text-center duration-100 border-b-2 border-black md:text-2xl hover:translate-x-2 w-fit">All
						Article</a>
				</div> --}}
				@if($posts->isEmpty())
				<h1 class="py-2 text-center">No Post Created yet</h1>
				@else
				<div class="grid grid-cols-1 gap-2 mt-3 md:gap-4 sm:grid-cols-2">
					@foreach ($posts as $p)
					<a href="/allPost/{{ $p->slug }}"
						class="flex flex-col items-center justify-center p-2 duration-100 border-b-2 border-r-2 hover:scale-105 hover:shadow-lg">
						<img src="{{ $p->image ? asset('/storage/' . $p->image) : 'https://placehold.co/200x200' }}" alt=""
							class="object-cover text-center w-52 h-52">
						<p class="pt-2 text-center line-clamp-3">{{ $p->title }}</p>
						<small class="w-full text-end font-extralight">{{ $p->created_at->diffForHumans() }}</small>
					</a>
					@endforeach
				</div>
				@endif
			</div>
		</div>
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
