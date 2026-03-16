<x-app-layout>
    <div class="w-full h-full bg-gray-100">
        <div class="w-full h-full px-4 py-8">
            <div class="bg-white shadow-md rounded-lg overflow-hidden">
                <div class="p-6">
                    <h3 class="text-lg font-semibold mb-4">@lang('labels.usuariosEdit')</h3>
                    <form action="{{ route('admin.user.update', $user->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
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
                                <tbody>
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $user->id }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <input type="text" name="name" value="{{ $user->name }}" class="border border-gray-300 px-2 py-1 w-full rounded-md">
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <input type="email" name="email" value="{{ $user->email }}" class="border border-gray-300 px-2 py-1 w-full rounded-md">
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            <button type="submit" class="text-blue-500 hover:text-blue-700">
                                                <i class="fas fa-floppy-disk fa-lg"></i>
                                            </button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>