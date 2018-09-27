<nav class="tw-fixed tw-w-full tw-border-b">
    <div class="tw-px-12 tw-flex tw-justify-between tw-items-center">
        <!-- Brand -->
        <a class="tw-py-4 tw-text-xl tw-font-semibold" href="{{ url('/') }}">
            {{ config('app.name') }}
        </a>
        <div>
            <!-- Right Side Of Navbar -->
            <ul class="tw-list-reset">
                <!-- Authentication Links -->
                @guest
                    <li>
                        <a href="{{ route('login') }}">{{ __('Login') }}</a>
                    </li>
                @else
                    <li>
                        <user-dropdown inline-template>
                            <div class="tw-text-sm">
                                <a @click="active = !active" role="button">
                                    {{ Auth::user()->name }}
                                    <base-icon>@{{ icon }}</base-icon>
                                </a>
                                <nav v-if="active" class="tw-mt-4 tw-absolute tw-bg-white tw-border">
                                    <ul class="tw-list-reset">
                                        <li class="tw-py-2 tw-pr-8 tw-pl-2">
                                            <a>
                                                Preferences
                                            </a>
                                        </li>
                                        <li class="tw-py-2 tw-pr-4 tw-pl-2">
                                            <a
                                                href="{{ route('logout') }}"
                                                onclick="event.preventDefault();
                                                             document.getElementById('logout-form').submit();">
                                                {{ __('Logout') }}
                                            </a>
                                        </li>
                                    </ul>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="tw-hidden">
                                        @csrf
                                    </form>
                                </nav>
                            </div>
                        </user-dropdown>
                    </li>
                @endguest
            </ul>
        </div>
    </div>
</nav>
