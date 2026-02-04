            <aside :class="{ 'w-full md:w-64': sidebarOpen, 'w-0 md:w-16 hidden md:block': !sidebarOpen }"
                class="bg-sidebar text-sidebar-foreground border-r border-gray-200 dark:border-gray-700 sidebar-transition overflow-hidden">
                <!-- Sidebar Content -->
                <div class="h-full flex flex-col">
                    <!-- Sidebar Menu -->
                    <nav class="flex-1 overflow-y-auto custom-scrollbar py-4">
                        <ul class="space-y-1 px-2">
                            <!-- Dashboard -->
                            <x-layouts.sidebar-link href="{{ route('dashboard') }}" icon='fas-house'
                                :active="request()->routeIs('dashboard*')">Dashboard</x-layouts.sidebar-link>
                            <!-- Example two level -->
                            <x-layouts.sidebar-two-level-link-parent title="Shipping" icon="fas-truck"
                                :active="request()->routeIs('fedex*')">
                                <x-layouts.sidebar-two-level-link href="{{ route('fedex.cutoff-time') }}" icon='fas-clock'
                                    :active="request()->routeIs('fedex.cutoff-time')">Cutoff Time</x-layouts.sidebar-two-level-link>
                                <x-layouts.sidebar-two-level-link href="{{ route('fedex.holidays') }}" icon='fas-calendar'
                                    :active="request()->routeIs('fedex.holidays')">Holidays</x-layouts.sidebar-two-level-link>
                            </x-layouts.sidebar-two-level-link-parent>
                            <x-layouts.sidebar-link href="{{ route('banner-settings.index') }}" icon='fas-image'
                                :active="request()->routeIs('banner-settings*')">Banner Settings</x-layouts.sidebar-link>
                            <x-layouts.sidebar-two-level-link-parent title="Coupons" icon="fas-tag"
                                :active="request()->routeIs('coupon*') || request()->routeIs('credentials*')">
                                <x-layouts.sidebar-two-level-link href="{{ route('coupon.index', [ 'site' => 'tb']) }}" icon='fas-tag' 
                                :active="request()->routeIs('coupon.*') && request()->route('site') === 'tb'">Tonerbuzz</x-layouts.sidebar-two-level-link>
                                <x-layouts.sidebar-two-level-link href="{{ route('coupon.index', [ 'site' => 'os']) }}" icon='fas-tag' 
                                :active="request()->routeIs('coupon.*') && request()->route('site') === 'os'">Original supplies</x-layouts.sidebar-two-level-link>
                                <x-layouts.sidebar-two-level-link href="{{ route('coupon.index', [ 'site' => 'gi']) }}" icon='fas-tag' 
                                :active="request()->routeIs('coupon.*') && request()->route('site') === 'gi'">Genuine ink</x-layouts.sidebar-two-level-link>
                                <x-layouts.sidebar-two-level-link href="{{ route('credentials.index') }}" icon='fas-key' 
                                :active="request()->routeIs('credentials*')">Credentials</x-layouts.sidebar-two-level-link>
                                <x-layouts.sidebar-two-level-link href="{{ route('coupon.index', [ 'site' => 'tbdev']) }}" icon='fas-tag' 
                                :active="request()->routeIs('coupon.*') && request()->route('site') === 'tbdev'">Tonerbee sandbox</x-layouts.sidebar-two-level-link>
                                <x-layouts.sidebar-two-level-link href="{{ route('coupon-cart-log.index') }}" icon='fas-shopping-cart' 
                                :active="request()->routeIs('coupon-cart-log*')">Coupon Cart Logs</x-layouts.sidebar-two-level-link>
                                <x-layouts.sidebar-two-level-link href="{{ route('couponspage.index', [ 'site' => 'tbdev']) }}" icon='fas-file-alt' 
                                :active="request()->routeIs('couponspage*')">Coupons Page content</x-layouts.sidebar-two-level-link>
                            </x-layouts.sidebar-two-level-link-parent>

                            <!-- Example three level -->
                            <x-layouts.sidebar-two-level-link-parent title="Example three level" icon="fas-house"
                                :active="request()->routeIs('three-level*')">
                                <x-layouts.sidebar-two-level-link href="#" icon='fas-house'
                                    :active="request()->routeIs('three-level*')">Single Link</x-layouts.sidebar-two-level-link>

                                <x-layouts.sidebar-three-level-parent title="Third Level" icon="fas-house"
                                    :active="request()->routeIs('three-level*')">
                                    <x-layouts.sidebar-three-level-link href="#" :active="request()->routeIs('three-level*')">
                                        Third Level Link
                                    </x-layouts.sidebar-three-level-link>
                                </x-layouts.sidebar-three-level-parent>
                            </x-layouts.sidebar-two-level-link-parent>
                        </ul>
                    </nav>
                </div>
            </aside>
