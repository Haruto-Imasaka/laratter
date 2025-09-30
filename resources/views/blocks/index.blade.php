<x-app-layout>
  <x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
      {{ __('ブロック一覧') }}
    </h2>
  </x-slot>

  <div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
      <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6 text-gray-900 dark:text-gray-100">
          @forelse ($blockedUsers as $blocked)
            <div class="mb-4 p-4 bg-gray-100 dark:bg-gray-700 rounded-lg">
              <a href="{{ route('profile.show', $blocked) }}" class="text-gray-800 dark:text-gray-300 font-medium hover:text-blue-500">
                {{ $blocked->name }}
              </a>
              <p class="text-gray-600 dark:text-gray-400 text-sm">ユーザー詳細を見る</p>
              <form action="{{ route('blocks.destroy', $blocked) }}" method="POST" class="mt-2">
                @csrf
                @method('DELETE')
                <button type="submit" class="text-red-500 hover:text-red-700">ブロック解除</button>
              </form>
            </div>
          @empty
            <div class="p-4 bg-gray-100 dark:bg-gray-700 rounded-lg">
              <p class="text-gray-600 dark:text-gray-400">ブロックしているユーザーはいません。</p>
            </div>
          @endforelse
        </div>
      </div>
    </div>
  </div>
</x-app-layout>
