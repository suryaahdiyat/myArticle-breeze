<x-app-layout>
    <div class="">
        <div class="flex justify-center my-10">
            <div class="flex flex-col justify-center w-2/3 text-center">
                {{-- <div class="flex items-center justify-between my-4">
                    <a href="/"
                        class="block mt-5 font-semibold text-center duration-100 border-b-2 border-black md:text-2xl hover:translate-x-2 w-fit">Newest
                        Article</a>
                    <a href="/allPosts"
                        class="block mt-5 font-semibold text-center duration-100 border-b-2 border-black md:text-2xl hover:translate-x-2 w-fit">All
                        Article</a>
                </div> --}}
                <h1 class="my-4 text-xl">{{ $post->title }}</h1>
                <img src="{{ $post->image ? asset('storage/' . $post->image) : 'https://placehold.co/700x400' }}"
                    alt="" class="pb-5 border-b-4 border-black">
                <div class="py-3 text-start">
                    <div class="flex gap-3">
                        @if ($post->user->pp)
                            <img src="{{ asset('storage/' . $post->user->pp) }}"
                                class="object-cover my-2 rounded-full img-preview max-h-10 max-w-10" alt="">
                        @else
                            @php
                                // Membatasi warna ke spektrum gelap dengan rentang nilai RGB yang lebih rendah
                                $randomColor = sprintf(
                                    '#%02X%02X%02X',
                                    mt_rand(0, 128),
                                    mt_rand(0, 128),
                                    mt_rand(0, 128),
                                );
                                // $randomColor = sprintf('#%06X', mt_rand(0, 0xFFFFFF));
                            @endphp
                            <div class="flex items-center justify-center w-10 h-10 text-white rounded-full"
                                style="background-color: {{ $randomColor }}">
                                {{ $post->user->initial }}
                            </div>
                        @endif
                        <div>
                            <h1 class="">Writter <a href="/postsBy/{{ $post->user->email }}"
                                    class="underline">{{ $post->user->name }}</a></h1>
                            <p class="text-xs font-light">{{ $post->created_at->diffForHumans() }}</p>
                        </div>
                    </div>
                    <div class="mt-3" id="editor-container">
                        {{-- {!! $post->content !!} --}}
                    </div>
                </div>
                <div class="flex items-center justify-start gap-2 mt-10">
                    <button onclick="handleLike()" class="flex items-center justify-center gap-1 p-1">
                        <span class="">
                            <svg id="like-icon" xmlns="http://www.w3.org/2000/svg"
                                fill="{{ $hasLiked ? '#be123c' : '#fff' }}" viewBox="0 0 24 24" stroke-width="1.5"
                                stroke="{{ $hasLiked ? 'none' : '#000' }}" class="size-6">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12Z" />
                            </svg>
                        </span>
                        <span id="likeC">{{ $likesCount }}</span>

                        {{-- {{ $likesCount >= 1 ? ($hasLiked ? 'Liked' : 'Like') : 'Likes' }} --}}
                    </button>
                    <button class="flex items-center justify-center gap-1 p-1" onclick="handleComment()">
                        <span>
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                stroke-width="1.5" stroke="currentColor" class="size-6">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M8.625 12a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm0 0H8.25m4.125 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm0 0H12m4.125 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm0 0h-.375M21 12c0 4.556-4.03 8.25-9 8.25a9.764 9.764 0 0 1-2.555-.337A5.972 5.972 0 0 1 5.41 20.97a5.969 5.969 0 0 1-.474-.065 4.48 4.48 0 0 0 .978-2.025c.09-.457-.133-.901-.467-1.226C3.93 16.178 3 14.189 3 12c0-4.556 4.03-8.25 9-8.25s9 3.694 9 8.25Z" />
                            </svg>
                        </span>
                        <span id="commentC">{{ $commentCount }}</span>
                    </button>
                </div>
                <div id="commentDisplay" class="hidden p-2 border">
                    @role('admin')
                        <form action="/comments" method="POST">
                            @csrf
                            <input type="hidden" name="post_id" value="{{ $post->id }}">
                            {{-- <div>

                            </div> --}}
                            <textarea name="content" type="text" class="block w-full p-2 border resize-none" placeholder="add comment...."
                                rows="3"></textarea>
                            @error('content')
                                <p class="mt-1 text-xs text-rose-500">{{ $message }}</p>
                            @enderror
                            <button
                                class="block w-full py-2 my-2 text-white duration-150 hover:scale-95 bg-cyan-500 hover:bg-cyan-700">Send</button>
                        </form>
                    @endrole
                    <div>
                        @if ($commentCount == 0)
                            <p>no any comment yet</p>
                        @else
                            @foreach ($comments as $comment)
                                {{-- item --}}
                                <div class="p-2 my-1 border">
                                    {{-- atas --}}
                                    <div class="flex items-center ">
                                        @if ($comment->user->pp)
                                            <img src="{{ asset('storage/' . $$comment->user->pp) }}"
                                                class="object-cover my-2 rounded-full img-preview max-h-7 max-w-7"
                                                alt="">
                                        @else
                                            @php
                                                $randomColor = sprintf(
                                                    '#%02X%02X%02X',
                                                    mt_rand(0, 128),
                                                    mt_rand(0, 128),
                                                    mt_rand(0, 128),
                                                );
                                            @endphp
                                            <div class="flex items-center justify-center text-xs text-white rounded-full w-7 h-7"
                                                style="background-color: {{ $randomColor }}">
                                                {{ $comment->user->initial }}
                                            </div>
                                        @endif
                                        <div class="ml-2 text-start">
                                            <h1 class=""><a href="/postsBy/{{ $comment->user->email }}"
                                                    class="text-sm underline">{{ $comment->user->name }}</a></h1>
                                            <p class="text-xs font-light">{{ $comment->created_at->diffForHumans() }}
                                            </p>
                                        </div>
                                    </div>
                                    {{--  bawah --}}
                                    <div class="text-start ">
                                        <p class="text-xs">{{ $comment->content }}</p>
                                    </div>
                                </div>
                            @endforeach
                            {{ $comments->links() }}
                        @endif
                    </div>
                </div>
            </div>
        </div>
        <x-footer />
    </div>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script>
        const handleComment = () => {
            document.getElementById('commentDisplay').classList.toggle('hidden')
        }

        const handleLike = () => {

            let likeCounter = parseInt(document.getElementById('likeC').innerHTML)
            const likeIcon = document.getElementById('like-icon')
            const postId = @json($post->id);
            const data = {
                'post_id': postId
            }
            axios.post('/post/toggle-like', data, {
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    }
                })
                .then(response => {
                    console.log('berhasil', response.data)
                    if (response.data.message == 'liked') {
                        likeCounter += 1

                        // Ubah atribut fill dan stroke
                        likeIcon.setAttribute('fill', '#be123c'); // Mengubah fill menjadi hijau
                        likeIcon.setAttribute('stroke', 'none'); // Mengubah stroke menjadi hitam

                        document.getElementById('likeC').innerHTML = likeCounter
                    } else {
                        likeCounter -= 1

                        // Ubah atribut fill dan stroke
                        likeIcon.setAttribute('fill', '#fff'); // Mengubah fill menjadi hijau
                        likeIcon.setAttribute('stroke', '#000'); // Mengubah stroke menjadi hitam

                        document.getElementById('likeC').innerHTML = likeCounter
                    }
                    // console.log(likeCounter.innerHTML)
                }).catch(error => {
                    console.error('ada masalah', error)
                })
        }
        const quill = new Quill('#editor-container', {
            theme: 'snow',
            readOnly: true,
            modules: {
                toolbar: false // Tidak menambahkan toolbar
            }
        })
        quill.root.innerHTML = `{!! $post->content !!}`
        if (@json(session()->has('success'))) {
            alert(@json(session('success')))
            // console.log();
        }
    </script>
</x-app-layout>
