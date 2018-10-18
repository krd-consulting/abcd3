<el-header class="tw-flex tw-justify-between tw-items-center">
    <div></div>
    <div>
        <base-menu mode="horizontal">
            <el-dropdown trigger="click" placement="top">
                <el-button class="tw-border-none">
                    {{ Auth::user()->name }}
                </el-button>
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
