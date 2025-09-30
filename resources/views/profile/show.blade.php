<x-app-layout>
  <x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
      {{ __('User詳細') }}
    </h2>
  </x-slot>

  <div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
      <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6 text-gray-900 dark:text-gray-100">

          {{-- 🔹 ブロックされている場合のプロフィール表示 --}}
          @if ($blockedMessage ?? false)
          <div class="text-red-600 font-bold">
            ＠{{ $user->name }}さんはあなたをブロックしました
          </div>
          <div class="text-gray-600">
            ＠{{ $user->name }}さんにブロックされているため、＠{{ $user->name }}さんの詳細画面を表示できません。
          </div>
          @else
          
          {{-- 🔹 通常のプロフィール表示 --}}
          <a href="{{ route('tweets.index') }}" class="text-blue-500 hover:text-blue-700 mr-2">一覧に戻る</a>
          <p class="text-gray-800 dark:text-gray-300 text-lg">{{ $user->name }}</p>
          <div class="text-gray-600 dark:text-gray-400 text-sm mb-4">
            <p>アカウント作成日時: {{ $user->created_at->format('Y-m-d H:i') }}</p>
          </div>

          {{-- 🔹 フォロー／ブロック操作 --}}
          @if ($user->id !== auth()->id())
          <div class="text-gray-900 dark:text-gray-100 mb-4">

            {{-- フォロー／アンフォローボタン --}}
            @if ($user->followers->contains(auth()->id()))
            <form action="{{ route('follow.destroy', $user) }}" method="POST" class="mb-2">
              @csrf
              @method('DELETE')
              <button type="submit" class="text-red-500 hover:text-red-700">unFollow</button>
            </form>
            @else
            <form action="{{ route('follow.store', $user) }}" method="POST" class="mb-2">
              @csrf
              <button type="submit" class="text-blue-500 hover:text-blue-700">follow</button>
            </form>
            @endif

            {{-- ブロック／ブロック解除ボタン --}}
            @if (auth()->user()->blocks->contains($user->id))
            <form action="{{ route('blocks.destroy', $user) }}" method="POST" class="mb-2">
              @csrf
              @method('DELETE')
              <button type="submit" class="text-yellow-500 hover:text-yellow-700">ブロック解除</button>
            </form>
            @else
            <form action="{{ route('blocks.store', $user) }}" method="POST" class="mb-2">
              @csrf
              <button type="submit" class="text-red-500 hover:text-red-700">ブロック</button>
            </form>
            @endif

          </div>
          @endif

          {{-- 🔹 フォロー／フォロワー数 --}}
          <p>following: {{$user->follows->count()}}</p>
          <p>followers: {{$user->followers->count()}}</p>

          {{-- 🔹 ユーザーのツイート一覧 --}}
          @if ($tweets->count())

          {{-- ページネーション --}}
          <div class="mb-4">
            {{ $tweets->appends(request()->input())->links() }}
          </div>

          @foreach ($tweets as $tweet)
          <div class="mb-4 p-4 bg-gray-100 dark:bg-gray-700 rounded-lg">
            <p class="text-gray-800 dark:text-gray-300">{{ $tweet->tweet }}</p>
            <a href="{{ route('profile.show', $tweet->user) }}">
              <p class="text-gray-600 dark:text-gray-400 text-sm">投稿者: {{ $tweet->user->name }}</p>
            </a>
            <a href="{{ route('tweets.show', $tweet) }}" class="text-blue-500 hover:text-blue-700">詳細を見る</a>
            <div class="flex mt-2">
              @if ($tweet->liked->contains(auth()->id()))
              <form action="{{ route('tweets.dislike', $tweet) }}" method="POST" class="mr-2">
                @csrf
                @method('DELETE')
                <button type="submit" class="text-red-500 hover:text-red-700">dislike {{ $tweet->liked->count() }}</button>
              </form>
              @else
              <form action="{{ route('tweets.like', $tweet) }}" method="POST" class="mr-2">
                @csrf
                <button type="submit" class="text-blue-500 hover:text-blue-700">like {{ $tweet->liked->count() }}</button>
              </form>
              @endif
            </div>
          </div>
          @endforeach

          {{-- ページネーション --}}
          <div class="mt-4">
            {{ $tweets->appends(request()->input())->links() }}
          </div>

          @else
          <p>No tweets found.</p>
          @endif

          @endif {{-- $blockedMessage の else 終了 --}}
        </div>
      </div>
    </div>
  </div>
</x-app-layout>
