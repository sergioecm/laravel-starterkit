<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Lista de recetas') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
                    @can('recipes-view')
                    @can('recipes-create')
                    <x-linkbutton href="{{ route('recipes.create') }}"
                                  class="m-4"
                    >{{__("Add new recipes")}}</x-linkbutton>
                    @endcan
                    <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                        <tr>
                            <th scope="col" class="px-6 py-3">
                                recipe name
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Acciones
                            </th>
                        </tr>
                        </thead>
                        <tbody>

                        @forelse ($recipes as $recipe)
                            <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                                <td class="px-6 py-4 font-medium text-gray-900 dark:text-white whitespace-nowrap">
                                    {{ $recipe->name }}
                                </td>
                                <td class="px-6 py-4">
                                    @can('recipes-edit')
                                <x-linkbutton href="{{ route('recipes.edit', $recipe) }}">Edit</x-linkbutton>
                                    @endcan
                                        @can('recipes-delete')
                                        <form method="POST" action="{{ route('recipes.destroy', $recipe) }}" class="inline-block">
                                            @csrf
                                            @method('DELETE')
                                            <x-danger-button
                                                type="submit"
                                                onclick="return confirm('Are you sure?')">Delete</x-danger-button>
                                        </form>
                                    @endcan

                                </td>
                            </tr>
                        @empty
                            <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                                <td colspan="2"
                                    class="px-6 py-4 font-medium text-gray-900 dark:text-white whitespace-nowrap">
                                    {{ __('No recipes found') }}
                                </td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                    @endcan
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
