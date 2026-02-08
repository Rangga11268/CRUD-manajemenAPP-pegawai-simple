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

    <div class="p-4 bg-white block sm:flex items-center justify-between border-b border-gray-200 lg:mt-1.5 dark:bg-gray-800 dark:border-gray-700 rounded-t-lg">
        <div class="w-full mb-1">
            <div class="mb-4">
                <h1 class="text-xl font-semibold text-gray-900 sm:text-2xl dark:text-white">Pusat Notifikasi</h1>
            </div>
            <div class="sm:flex">
                <div class="flex items-center ms-auto space-x-2 sm:space-x-3">
                    <form action="{{ route('notifications.markAllAsRead') }}" method="POST">
                        @csrf
                        <button type="submit" class="inline-flex items-center justify-center px-4 py-2 text-sm font-medium text-center text-white rounded-lg bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                            Tandai semua sudah dibaca
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="flex flex-col">
        <div class="p-4 bg-white dark:bg-gray-800 shadow-sm rounded-b-lg overflow-hidden">
            <div class="space-y-4">
                @forelse ($notifications as $notification)
                <div class="flex items-center justify-between p-4 border rounded-lg {{ $notification->read_at ? 'bg-gray-50 border-gray-200 dark:bg-gray-700 dark:border-gray-600' : 'bg-blue-50 border-blue-200 dark:bg-blue-900/30 dark:border-blue-800' }}">
                    <div class="flex items-center space-x-4">
                        <div class="flex-shrink-0">
                            <i class="fas fa-bell {{ $notification->read_at ? 'text-gray-400' : 'text-blue-500' }}"></i>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-900 dark:text-white {{ $notification->read_at ? 'opacity-70' : '' }}">
                                {{ $notification->data['message'] ?? 'Notifikasi Baru' }}
                            </p>
                            <p class="text-xs text-gray-500 dark:text-gray-400">
                                {{ $notification->created_at->diffForHumans() }}
                            </p>
                        </div>
                    </div>
                    <div>
                        @if(isset($notification->data['url']))
                        <a href="{{ route('notifications.read', $notification->id) }}" class="inline-flex items-center px-3 py-1.5 text-xs font-medium text-center text-white bg-blue-700 rounded-lg hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                            Lihat
                        </a>
                        @endif
                    </div>
                </div>
                @empty
                <div class="py-12 text-center text-gray-500 dark:text-gray-400">
                    <div class="mb-4">
                        <i class="fas fa-bell-slash text-4xl opacity-20"></i>
                    </div>
                    <p class="text-lg font-medium">Tidak ada notifikasi baru.</p>
                </div>
                @endforelse
            </div>
            
            <div class="mt-6">
                {{ $notifications->links() }}
            </div>
        </div>
    </div>
</x-app-layout>
