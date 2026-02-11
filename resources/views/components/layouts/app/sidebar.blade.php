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
                                :active="request()->routeIs('coupon*') || request()->routeIs('credentials.index')">
                                <x-layouts.sidebar-two-level-link href="{{ route('coupon.index', [ 'site' => 'tb']) }}" icon='fas-tag' 
                                :active="request()->routeIs('coupon.*') && request()->route('site') === 'tb'">Tonerbuzz</x-layouts.sidebar-two-level-link>
                                <x-layouts.sidebar-two-level-link href="{{ route('coupon.index', [ 'site' => 'os']) }}" icon='fas-tag' 
                                :active="request()->routeIs('coupon.*') && request()->route('site') === 'os'">Original supplies</x-layouts.sidebar-two-level-link>
                                <x-layouts.sidebar-two-level-link href="{{ route('coupon.index', [ 'site' => 'gi']) }}" icon='fas-tag' 
                                :active="request()->routeIs('coupon.*') && request()->route('site') === 'gi'">Genuine ink</x-layouts.sidebar-two-level-link>
                                <x-layouts.sidebar-two-level-link href="{{ route('credentials.index') }}" icon='fas-key' 
                                :active="request()->routeIs('credentials.index')">Credentials</x-layouts.sidebar-two-level-link>
                                <x-layouts.sidebar-two-level-link href="{{ route('coupon.index', [ 'site' => 'tbdev']) }}" icon='fas-tag' 
                                :active="request()->routeIs('coupon.*') && request()->route('site') === 'tbdev'">Tonerbee sandbox</x-layouts.sidebar-two-level-link>
                                <x-layouts.sidebar-two-level-link href="{{ route('coupon-cart-log.index') }}" icon='fas-shopping-cart' 
                                :active="request()->routeIs('coupon-cart-log*')">Coupon Cart Logs</x-layouts.sidebar-two-level-link>
                                <x-layouts.sidebar-two-level-link href="{{ route('couponspage.index', [ 'site' => 'tbdev']) }}" icon='fas-file-alt' 
                                :active="request()->routeIs('couponspage*')">Coupons Page content</x-layouts.sidebar-two-level-link>
                            </x-layouts.sidebar-two-level-link-parent>
                            <x-layouts.sidebar-two-level-link-parent title="Set Product Info" icon="fas-cubes"
                                :active="request()->routeIs('set-info*') || request()->routeIs('credentials.plytix-index')">
                                <x-layouts.sidebar-two-level-link href="{{ route('set-info.list-single') }}" icon='fas-cubes'
                                :active="request()->routeIs('set-info.list-single')">List Single</x-layouts.sidebar-two-level-link>
                                <x-layouts.sidebar-two-level-link href="{{ route('set-info.list-set') }}" icon='fas-cubes'
                                :active="request()->routeIs('set-info.list-set')">List Set</x-layouts.sidebar-two-level-link>
                                <x-layouts.sidebar-two-level-link href="{{ route('credentials.plytix-index') }}" icon='fas-key'
                                :active="request()->routeIs('credentials.plytix-index')">Plytix Credentials</x-layouts.sidebar-two-level-link>

                            </x-layouts.sidebar-two-level-link-parent>
                            <x-layouts.sidebar-link href="{{ route('sso-login.logs') }}" icon="fas-user-lock" :active="request()->routeIs('sso-login.logs')">SSO Login logs</x-layouts.sidebar-link>
                            <x-layouts.sidebar-two-level-link-parent title="Metafields" icon="fas-database" :active="request()->routeIs('ordermeta.list')">
                                <x-layouts.sidebar-two-level-link href="{{ route('ordermeta.list',[ 'resource' => 'order']) }}" icon='fas-database'
                                :active="request()->routeIs('ordermeta.list') && request()->route('resource') === 'order'">Order</x-layouts.sidebar-two-level-link>
                                <x-layouts.sidebar-two-level-link href="{{ route('ordermeta.list',[ 'resource' => 'cart']) }}" icon='fas-database'
                                :active="request()->routeIs('ordermeta.list') && request()->route('resource') === 'cart'">Cart</x-layouts.sidebar-two-level-link>
                            </x-layouts.sidebar-two-level-link-parent>

                            <x-layouts.sidebar-link href="{{ route('plytix.settings') }}" icon="fas-cog" :active="request()->routeIs('plytix.settings')">Plytix</x-layouts.sidebar-link>
                            <x-layouts.sidebar-two-level-link-parent title="Tremendous" icon="fas-gift" :active="request()->routeIs('tremendous*')">
                                <x-layouts.sidebar-two-level-link href="{{ route('tremendous.orderslist') }}" icon='fas-list'
                                :active="request()->routeIs('tremendous.orderslist')">Tremendous reward List</x-layouts.sidebar-two-level-link>
                                <x-layouts.sidebar-two-level-link href="{{ route('tremendous.influenceAwards') }}" icon='fas-trophy'
                                :active="request()->routeIs('tremendous.influenceAwards')">Influence Awards</x-layouts.sidebar-two-level-link>
                                <x-layouts.sidebar-two-level-link href="{{ route('tremendous.settings') }}" icon='fas-cog'
                                :active="request()->routeIs('tremendous.settings')">Settings</x-layouts.sidebar-two-level-link>
                            </x-layouts.sidebar-two-level-link-parent>
                            <x-layouts.sidebar-two-level-link-parent  title="NR and SR Products" icon="fas-boxes" :active="request()->routeIs('nrandsrproducts*')">
                                 <x-layouts.sidebar-two-level-link  href="{{route('nrandsrproducts.sr_index')}}" icon='fas-flag' :active="request()->routeIs('nrandsrproducts.sr_index')">State Restricted Products</x-layouts.sidebar-two-level-link>
                                <x-layouts.sidebar-two-level-link  href="{{route('nrandsrproducts.nr_index')}}" icon='fas-times-circle' :active="request()->routeIs('nrandsrproducts.nr_index')">Non - Returnable Products</x-layouts.sidebar-two-level-link>
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
