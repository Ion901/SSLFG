<section x-data="{ open: false }" class=" relative left-0 dark:bg-gray-800 border-b border-gray-100 dark:border-gray-700 max-w-[20%] min-h-screen transition-[left] duration-500 ease-in-out ">

    <!-- Primary Navigation Menu -->
    <div class="sticky top-0">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16 flex-col ">
            <div class="flex flex-col gap-4">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('home') }}">
                        <x-application-logo class="block h-9 w-auto fill-current text-gray-800 dark:text-gray-200" />
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->

      
        <div class="pt-2 pb-1 space-y-1">
            <x-responsive-nav-link :href="route('posts')" :active="request()->routeIs('posts')">
                {{ __('Postări') }}
            </x-responsive-nav-link>
        </div>
        <div class="pt-2 pb-1 space-y-1">
            <x-responsive-nav-link :href="route('competitions')" :active="request()->routeIs('competitions')">
                {{ __('Competiții') }}
            </x-responsive-nav-link>
        </div>
        <div class="pt-2 pb-1 space-y-1">
            <x-responsive-nav-link :href="route('premiants')" :active="request()->routeIs('premiants')">
                {{ __('Premianți') }}
            </x-responsive-nav-link>
        </div>
        <div class="pt-2 pb-1 space-y-1">
            <x-responsive-nav-link :href="route('athlets')" :active="request()->routeIs('athlets')">
                {{ __('Date sportivi') }}
            </x-responsive-nav-link>
        </div>
        <div class="pt-2 pb-1 space-y-1">
            <x-responsive-nav-link :href="route('gallery')" :active="request()->routeIs('gallery')">
                {{ __('Galerie foto') }}
            </x-responsive-nav-link>
        </div>

        <!-- Responsive Settings Options -->
        <div class="pt-4 pb-1 border-t border-gray-200 dark:border-gray-600">
            <div class="px-4 ">
                <div class="font-medium text-base text-gray-800 dark:text-gray-200">{{ Auth::user()->name}}</div>
                <div class="font-medium text-sm text-gray-500 break-all"">{{ Auth::user()->email}}</div>
            </div>

            <div class="mt-3 space-y-1">
                <x-responsive-nav-link :href="route('profile.edit')">
                    {{ __('Profile') }}
                </x-responsive-nav-link>

                <!-- Authentication -->
                <form method="POST" action="{{ route('logout') }}">
                    @csrf

                    <x-responsive-nav-link :href="route('logout')"
                            onclick="event.preventDefault();
                                        this.closest('form').submit();">
                        {{ __('Log Out') }}
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>

    <div class="absolute bottom-0 right-2 text-3xl">
        <button class="text-white" id="resize"><</button>
    </div>
</section>
