@extends('layouts.login')

@section('content')
<login-form inline-template old-email="{{ old('email') }}">
    <div class="tw-font-muli tw-relative">
        <div class="tw-flex tw-h-screen tw-items-center">
            <div class="tw-flex-1 tw-p-16 tw-h-full tw-flex tw-items-center tw-relative">
                <img src="{{ asset('/images/meals-on-wheels.png') }}" alt="Meals on Wheels" class="tw-absolute tw-mt-16 tw-ml-16 tw-top-0 tw-left-0"/>
                <div>
                    <h1 class="tw-text-4xl tw-text-indigo-base tw-font-extrabold">
                        Welcome to <span class="tw-text-4xl tw-text-orange-base text-normal">Meals on Wheels</span>
                    </h1>
                    <div class="tw-mt-5 tw-text-gray-dark">
                        Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aliquam non ipsum aliquam, pretium lectus vel, mollis nisl. Suspendisse iaculis erat in massa mollis, ut pulvinar erat consequat. Aliquam nec gravida massa.
                    </div>
                </div>
            </div>
            <img src="{{ asset('/images/eclipse.png') }}" class="login__eclipse" />
        </div>
        <div class="tw-absolute tw-right-0 tw-top-0 tw-bottom-0 tw-bg-indigo-lightest login__form-panel tw-flex tw-flex-col tw-px-10 tw-py-16">
            <form method="POST" action="{{ route('login') }}" class="tw-flex-1 tw-flex tw-flex-col tw-justify-center">
                @csrf
                <div class="tw-text-2xl tw-text-black tw-font-bold tw-mb-10 tw-text-center">Enter your credentials to login</div>
                <label for="email" class="tw-text-xs tw-text-gray-darkest tw-font-bold tw-mb-1">
                    USERNAME
                </label>
                <base-input
                    id="email"
                    v-model="email"
                    type="email"
                    class="tw-w-full tw-text-sm {{ $errors->has('email') ? ' is-invalid' : '' }}"
                    name="email"
                    value="{{ old('email') }}"
                    autocomplete="off"
                    required
                    autofocus
                ></base-input>
                <label for="password" class="tw-text-xs tw-text-gray-darkest tw-font-bold tw-mb-1 tw-mt-5">
                    PASSWORD
                </label>
                <base-input
                    id="password"
                    v-model="password"
                    type="password"
                    class="tw-w-full tw-text-sm {{ $errors->has('password') ? ' is-invalid' : '' }}"
                    name="password"
                    value="{{ old('password') }}"
                    required
                    show-password
                ></base-input>
                <div class="tw-mt-6 tw-flex tw-justify-between tw-items-center">
                    <base-checkbox
                        name="remember"
                        id="remember"
                        {{ old('remember') ? 'checked' : '' }}
                        class="tw-text-sm tw-text-black tw-font-normal"
                    >
                        Remember me
                    </base-checkbox>
                    <base-link href="javascript:;">Forgotten password</base-link>
                </div>
                <base-button type="submit" class="tw-mt-6" >Login</base-button>
                @if ($errors->has('email'))
                    <div class="tw-mt-3 tw-text-center tw-text-red-base tw-text-xs">This username and password combination is not recognised.</div>
                @endif
            </form>
            <div class="tw-flex tw-items-end">
                <img src="{{ asset('/images/meals-on-wheels.png') }}" alt="Meals on Wheels" class="tw-w-20">
                <div class="tw-ml-5 tw-text-xs tw-text-indigo-base">
                    Powered by <b class="tw-text-xs">Meals on Wheels</b>
                </div>
            </div>
        </div>
    </div>
</login-form>
@endsection

@section('scripts')
    <script src="{{ asset('js/app.js') }}"></script>
@endsection
