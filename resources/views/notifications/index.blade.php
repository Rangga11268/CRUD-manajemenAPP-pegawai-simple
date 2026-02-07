<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Notifikasi') }}
            </h2>
            <form action="{{ route('notifications.markAllAsRead') }}" method="POST">
                @csrf
                <button type="submit" class="text-sm text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300">
                    Tandai semua sudah dibaca
                </button>
            </form>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    @forelse ($notifications as $notification)
                        <div class="flex items-center justify-between p-4 mb-4 border rounded-lg {{ $notification->read_at ? 'bg-gray-50 dark:bg-gray-700' : 'bg-blue-50 dark:bg-blue-900 border-blue-200 dark:border-blue-700' }}">
                            <div>
                                <h4 class="font-semibold">{{ $notification->data['message'] ?? 'Notifikasi Baru' }}</h4>
                                <span class="text-sm text-gray-500 dark:text-gray-400">{{ $notification->created_at->diffForHumans() }}</span>
                            </div>
                            <div class="flex space-x-2">
                                @if(isset($notification->data['url']))
                                    <a href="{{ route('notifications.read', $notification->id) }}" class="px-3 py-1 text-sm text-white bg-blue-600 rounded hover:bg-blue-700">
                                        Lihat
                                    </a>
                                @endif
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-8 text-gray-500 dark:text-gray-400">
                            Tidak ada notifikasi.
                        </div>
                    @endforelse

                    <div class="mt-4">
                        {{ $notifications->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
