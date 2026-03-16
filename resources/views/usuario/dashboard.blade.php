<x-app-layout>
    <div class="w-full h-full bg-gray-100">
        <div class="w-full h-full px-4 py-8">
            <div class="bg-white shadow-md rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-semibold mb-4">@lang('labels.usuariosLista')</h3>
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead>
                                <tr>
                                    <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                                    <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">@lang('labels.nome')</th>
                                    <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">@lang('labels.email')</th>
                                    <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">@lang('labels.acoes')</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach ($users as $user)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $user->id }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $user->name }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $user->email }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        <div class="flex space-x-2">
                                            <form method="POST" action="{{ route('admin.user.delete', $user->id) }}">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-500 hover:text-red-700">
                                                    <i class="fas fa-trash fa-lg"></i>
                                                </button>
                                            </form>
                                            <form method="GET" action="{{ route('admin.user.edit', $user->id) }}">
                                                <button type="submit" class="text-blue-500 hover:text-blue-700">
                                                    <i class="fas fa-pen fa-lg"></i>
                                                </button>
                                            </form>
                                            @if ($isAdmin == 1)
                                            <form action="{{ route('admin.user.create') }}">
                                                <button type="submit" class="text-blue-500 hover:text-blue-700">
                                                    <i class="fa-solid fa-plus fa-lg"></i>
                                                </button>
                                            </form>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
