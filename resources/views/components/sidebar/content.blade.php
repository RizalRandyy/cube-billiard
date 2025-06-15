
<x-perfect-scrollbar as="nav" aria-label="main" class="flex flex-col flex-1 gap-4 px-3">

    <x-sidebar.link title="Dashboard" href="{{ route('admin.dashboard') }}" :isActive="request()->routeIs('admin.dashboard')">
        <x-slot name="icon">
            <x-icons.dashboard class="flex-shrink-0 w-6 h-6" aria-hidden="true" />
        </x-slot>
    </x-sidebar.link>


    <div x-transition x-show="isSidebarOpen || isSidebarHovered" class="text-sm text-gray-500">
        Menu
    </div>

    @if (auth()->user()->hasRole('Admin'))
    <x-sidebar.link title="Pengguna" href="{{ route('admin.users.index') }}" :isActive="request()->routeIs('admin.users*')" >
        <x-slot name="icon">
            <x-icons.users class="flex-shrink-0 w-6 h-6" aria-hidden="true" />
        </x-slot>
    </x-sidebar.link>
    @endif

    <x-sidebar.link title="Meja Biliar" href="{{ route('admin.pool_tables.index') }}" :isActive="request()->routeIs('admin.pool_tables*')" >
        <x-slot name="icon">
            <x-icons.billiards class="flex-shrink-0 w-6 h-6" aria-hidden="true" />
        </x-slot>
    </x-sidebar.link>

    <x-sidebar.link title="Pembayaran" href="{{ route('admin.transactions.index') }}" :isActive="request()->routeIs('admin.transactions*')" >
        <x-slot name="icon">
            <x-icons.money class="flex-shrink-0 w-6 h-6" aria-hidden="true" />
        </x-slot>
    </x-sidebar.link>

    

</x-perfect-scrollbar>