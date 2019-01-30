<el-header class="main-nav">
    <div class="main-logo-container tw-py-4">
        <base-button class="tw-border-none tw-bg-transparent tw-align-middle" @click="collapseSidebar = !collapseSidebar">
            <base-icon>menu</base-icon>
        </base-button>
        <span class="tw-text-3xl tw-font-bold tw-align-middle tw-inline-block">
            ABCD
        </span>
    </div>
    <div class="tw-px-4 tw-flex tw-flex-1 tw-justify-between">
        <div class="tw-w-1/2">
            <global-search></global-search>
        </div>
        <div>
            <div class="tw-inline-block tw-align-middle tw-mr-2">
                <el-dropdown class="main-nav-dropdown" trigger="click" placement="bottom-end">
                    <base-icon class="tw-text-lg">notifications</base-icon>
                    <el-dropdown-menu slot="dropdown">
                    </el-dropdown-menu>
                </el-dropdown>
            </div>
            <div class="tw-inline-block tw-align-middle">
                <base-menu mode="horizontal">
                    <el-dropdown class="main-nav-dropdown" trigger="click" placement="bottom-end">
                        <span>
                            <profile-picture class="tw-w-8 tw-h-8 tw-bg-blue tw-text-white" username="{{ Auth::user()->name }}"></profile-picture>
                        </span>
                        <el-dropdown-menu slot="dropdown">
                            <a>
                                {{ Auth::user()->name }}
                            </a>
                            <el-dropdown-item>
                                <a href="/preferences">
                                    <base-icon class="tw-text-base tw-align-middle">settings</base-icon>
                                    <span class="tw-align-middle">Preferences</span>
                                </a>
                            </el-dropdown-item>
                            <el-dropdown-item>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="tw-hidden">
                                    @csrf
                                </form>
                                <a
                                    href="{{ route('logout') }}"
                                    onclick="event.preventDefault();
                                                 document.getElementById('logout-form').submit();">
                                    <base-icon class="tw-text-base tw-align-middle">exit_to_app</base-icon>
                                    <span class="tw-align-middle">{{ __('Logout') }}</span>
                                </a>
                            </el-dropdown-item>
                        </el-dropdown-menu>
                    </el-dropdown>
                </base-menu>
            </div>
        </div>
    </div>
</el-header>
