<el-header class="main-nav">
    <div class="tw-w-1/2">
        <global-search></global-search>
    </div>
    <div></div>
    <div class="user-nav">
        <base-menu mode="horizontal">
            <a class="tw-mr-2 tw-font-bold">
                {{ Auth::user()->name }}
            </a>
            <el-dropdown class="main-nav-dropdown" trigger="click" placement="bottom-end">
                <span>
                    <profile-picture></profile-picture>
                </span>
                <el-dropdown-menu slot="dropdown">
                    <el-dropdown-item>
                        <a href="/preferences">Preferences</a>
                    </el-dropdown-item>
                    <el-dropdown-item>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="tw-hidden">
                            @csrf
                        </form>
                        <a
                            href="{{ route('logout') }}"
                            onclick="event.preventDefault();
                                         document.getElementById('logout-form').submit();">
                            {{ __('Logout') }}
                        </a>
                    </el-dropdown-item>
                </el-dropdown-menu>
            </el-dropdown>
        </base-menu>
    </div>
</el-header>
