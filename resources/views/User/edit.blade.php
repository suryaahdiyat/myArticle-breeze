<x-app-layout>
    <div class="p-2 m-2 bg-white rounded">
        <form action="{{ route('users.update', $user->email) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="grid grid-cols-2 p-2 my-2 border">
                <label for="name">Name</label>
                <input type="text" id="name" name="name"
                    class="p-2 border @error('name') border-rose-600 @enderror" value="{{ old('name') ?? $user->name }}">
                @error('name')
                    <p class="mt-1 text-xs text-rose-500">{{ $message }}</p>
                @enderror
            </div>
            <div class="grid grid-cols-2 p-2 my-2 border">
                <label for="email">Email</label>
                <input type="email" id="email" name="email"
                    class="p-2 border @error('email') border-rose-600 @enderror" value="{{ old('email')  ?? $user->email }}">
                @error('email')
                    <p class="mt-1 text-xs text-rose-500">{{ $message }}</p>
                @enderror
            </div>
            <div class="grid grid-cols-2 p-2 my-2 border">
                <label for="role">Role</label>
                <select id="role" name="role" class="p-2 border @error('role') border-rose-600 @enderror"
                    value="{{ old('role') }}">
                    <option value="user" {{$user->roles[0]->name == 'user' ? 'selected' : ''}}>User</option>
                    <option value="admin" {{$user->roles[0]->name == 'admin' ? 'selected' : ''}}>Admin</option>
                </select>
                @error('role')
                    <p class="mt-1 text-xs text-rose-500">{{ $message }}</p>
                @enderror
            </div>
            <div class="flex items-center gap-2 p-2 my-2 border">
                <label for="cPass">change password?</label>
                <input type="checkbox" name="cPass" id="cPass">
            </div>
            <div class="hidden" id="dPass">
                <div class="grid grid-cols-2 p-2 my-2 border">
                    <label for="password">Password</label>
                    <input type="password" id="password" name="password"
                        class="p-2 border @error('password') border-rose-600 @enderror" value="{{ old('password') }}">
                    @error('password')
                        <p class="mt-1 text-xs text-rose-500">{{ $message }}</p>
                    @enderror
                </div>
                <div class="grid grid-cols-2 p-2 my-2 border">
                    <label for="password_confirmation">Password Confirmation</label>
                    <input type="password" id="password_confirmation" name="password_confirmation"
                        class="p-2 border @error('password_confirmation') border-rose-600 @enderror" value="{{ old('password_confirmation') }}">
                    @error('password_confirmation')
                        <p class="mt-1 text-xs text-rose-500">{{ $message }}</p>
                    @enderror
                </div>
            </div>
            <div class="grid grid-cols-2 gap-3 text-center">
                <a href="{{ route('users.index') }}"
                    class="block px-3 py-2 duration-100 rounded bg-rose-600 text-slate-200 hover:bg-rose-700 hover:text-slate-300 hover:scale-95">Back</a>
                <button type="submit" onclick="handleClick()"
                    class="px-3 py-2 duration-100 rounded bg-cyan-600 text-slate-200 hover:bg-cyan-700 hover:text-slate-300 hover:scale-95">Save</button>
            </div>
        </form>
    </div>
    <script>
        document.getElementById('cPass').addEventListener('change', (e) => {
            if(e.target.checked){
                document.getElementById('dPass').classList.remove('hidden')
            }else {
                document.getElementById('dPass').classList.add('hidden')
            }
        })
    </script>
</x-app-layout>
