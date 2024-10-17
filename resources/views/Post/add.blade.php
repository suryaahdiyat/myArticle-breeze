<x-app-layout>
    <div class="p-2 m-2 bg-white rounded">
        <h1>Add new post here</h1>
        <form action="/myPost" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="grid grid-cols-2 p-2 my-2 border">
                <label for="title">Title</label>
                <input type="text" id="title" name="title"
                    class="p-2 border @error('title') border-rose-600 @enderror" value="{{ old('title') }}">
                @error('title')
                    <p class="mt-1 text-xs text-rose-500">{{ $message }}</p>
                @enderror
            </div>
            <div class="grid grid-cols-2 p-2 my-2 border">
                <label for="image">Image</label>
                <input type="file" onchange="handlePreview()" id="image" name="image"
                    class="p-2 border @error('image') border-rose-600 @enderror">
                @error('image')
                    <p class="mt-1 text-xs text-rose-500">{{ $message }}</p>
                @enderror
                <img alt="" class="my-2 img-preview max-h-52" />
            </div>
            <div class="p-2 my-2 border">
                <label for="contet">Content</label>
                <div id="editor-container" name='content'>
                </div>
                <input type="hidden" name="content" id="editor-content">
            </div>
            <div class="grid grid-cols-2 gap-3 text-center">
                <a href="/myPost"
                    class="block px-3 py-2 duration-100 rounded bg-rose-600 text-slate-200 hover:bg-rose-700 hover:text-slate-300 hover:scale-95">Back</a>
                <button type="submit" onclick="handleClick()"
                    class="px-3 py-2 duration-100 rounded bg-cyan-600 text-slate-200 hover:bg-cyan-700 hover:text-slate-300 hover:scale-95">Save</button>
            </div>
        </form>

    </div>
    <script>
        const quill = new Quill('#editor-container', {
            theme: 'snow',
            modules: {
                toolbar: [
                    [{
                        'header': '1'
                    }, {
                        'header': '2'
                    }],
                    [{
                        'list': 'ordered'
                    }, {
                        'list': 'bullet'
                    }],
                    ['bold', 'italic', 'underline'],
                    ['link']
                ]
            }
        })
        quill.root.innerHTML = `{!! old('content') ?? '<p>start your content here </p>' !!}`
        // document.querySelector('form').addEventListener('submit', function(event) {
        // 	// Set the hidden input value to the editor content
        // 	console.log(quill.root.innerHTML)
        // 	document.querySelector('#editor-content').value = quill.root.innerHTML
        // })

        // document.querySelector('form').addEventListener('submit', (e) => {
        // 	e.preventDefault()
        // 	document.querySelector('#editor-content').value = quill.root.innerHTML
        // 	e.target.submit()
        // })

        const handlePreview = () => {
            const image = document.querySelector('#image')
            const imagePreview = document.querySelector('.img-preview')

            imagePreview.style.display = 'block';
            const oFReader = new FileReader()
            oFReader.readAsDataURL(image.files[0])

            oFReader.onload = function(oFREvent) {
                imagePreview.src = oFREvent.target.result
            }
        }

        const handleClick = () => {
            document.querySelector('#editor-content').value = quill.root.innerHTML
            console.log(document.querySelector('#editor-content').value)
            // console.log(quill.root.innerHTML)
            // console.log(document.querySelector('#editor-content').value)
            // console.log(quill.root.innerHTML)
        }
    </script>
</x-app-layout>
