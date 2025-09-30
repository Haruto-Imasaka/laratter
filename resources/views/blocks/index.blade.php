<x-app-layout>
    <h1 class="text-xl font-bold mb-4">ブロック一覧</h1>
    <ul>
        @forelse ($blockedUsers as $blocked)
            <li>
                <a href="{{ route('profile.show', $blocked) }}">
                    {{ $blocked->name }}
                </a>
            </li>
        @empty
            <li>ブロックしているユーザーはいません。</li>
        @endforelse
    </ul>
</x-app-layout>

