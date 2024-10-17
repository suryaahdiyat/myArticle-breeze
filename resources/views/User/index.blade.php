<x-app-layout>
    <div class="p-2 m-2 rounded">
        @if (session()->has('success'))
            <p class="px-2 py-3 mb-2 text-xl text-center border rounded border-emerald-500 bg-emerald-200">
                {{ session('success') }}
            </p>
        @endif
        @if (!isset($su))
            <a href="{{ route('users.create') }}"
                class="block px-3 py-2 my-2 text-center text-white duration-100 bg-black border-2 border-transparent rounded hover:bg-white hover:text-black hover:border-black hover:scale-95">Add
                New user</a>
        @endif
        <div class="">
            @if ($users->isEmpty())
                <h1 class="py-2 text-center">There is no user</h1>
            @else
                <table class="min-w-full text-sm bg-white divide-y-2 divide-gray-200">
                    <thead class="ltr:text-left rtl:text-right">
                        <tr>
                            <th class="px-4 py-2 font-medium text-gray-900 whitespace-nowrap">No</th>
                            <th class="px-4 py-2 font-medium text-gray-900 whitespace-nowrap">Initial</th>
                            <th class="px-4 py-2 font-medium text-gray-900 whitespace-nowrap">Email</th>
                            <th class="px-4 py-2 font-medium text-gray-900 whitespace-nowrap">Role</th>
                            <th class="px-4 py-2 font-medium text-gray-900 whitespace-nowrap">Action</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @php
                            $no = ($users->currentPage() - 1) * $users->perPage() + 1;
                        @endphp
                        @foreach ($users as $user)
                            <tr>
                                <td class="px-4 py-2 text-center text-gray-700 whitespace-nowrap">{{ $no++ }}
                                </td>
                                <td
                                    class="max-w-xs px-4 py-2 font-medium text-center text-gray-900 truncate whitespace-nowrap">
                                    <p class="text-wrap line-clamp-2">{{ $user->initial }}</p>
                                </td>
                                <td class="max-w-xs px-4 py-2 text-center text-gray-700 whitespace-nowrap">
                                    <p class="text-wrap line-clamp-2">{{ $user->email }}</p>
                                </td>
                                <td class="max-w-xs px-4 py-2 text-center text-gray-700 whitespace-nowrap">
                                    <p class="text-wrap line-clamp-2">{{ $user->roles[0]->name }}</p>
                                </td>
                                <td
                                    class="flex flex-col justify-center gap-2 px-4 py-2 text-center md:flex-row whitespace-nowrap">
                                    <a href="{{ route('users.edit', $user->email) }}"
                                        class="inline-block px-4 py-2 text-xs font-medium text-white rounded bg-cyan-600 hover:bg-cyan-700">
                                        Edit
                                    </a>
                                    <form action="{{ route('users.destroy', $user->email) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            onclick="return confirm('are you sure want to delete this user?')"
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
                    {{ $users->links() }}
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
