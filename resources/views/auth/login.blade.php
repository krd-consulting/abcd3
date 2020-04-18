@extends('layouts.login')

@section('content')

<div class="tw-bg-gray-100 tw-flex tw-justify-around tw-items-stretch tw-h-screen">
    <login-form inline-template old-email="{{ old('email') }}">
        <div class="lg:tw-w-1/2 md:tw-w-3/4 tw-w-full xl:tw-px-12 tw-px-4 tw-flex tw-items-center">
            <div class="tw-w-full lg:tw-pt-16 tw-pt-12 tw-pb-8 xl:tw-px-12 lg:tw-px-8 tw-px-4 tw-bg-white tw-rounded-lg tw-shadow tw-border-t-8 tw-border-orange-500">
                <form method="POST" action="{{ route('login') }}">
                    @csrf
                    @if ($errors->has('email'))
                        <div 
                            class="tw-rounded tw-py-2 tw-mb-4 tw-text-center tw-bg-red-200 
                            tw-border tw-border-red-700">
                            <span role="alert" class="tw-text-red-700 tw-text-sm">
                            {{ $errors->first('email') }}
                            </span>
                        </div>
                    @endif            
                    <div>
                        <div class="tw-flex tw-flex-wrap tw-items-center tw-w-full">
                            <label class="md:tw-w-1/4 md:tw-block tw-hidden">
                                Login 
                            </label>
                            <div class="md:tw-w-3/4 tw-w-full">
                                <base-input
                                        id="email"
                                        v-model="email"
                                        type="email"
                                        class="
                                            {{ $errors->has('email') ? ' is-invalid' : '' }}
                                            tw-mb-2 tw-w-full tw-text-base
                                            tw-placeholder-transparent
                                            "
                                        name="email" 
                                        value="{{ old('email') }}"
                                        placeholder="Login"
                                        autocomplete="off"
                                        required autofocus
                                ></base-input>
                            </div>
                        </div>
                    </div>
                    <div class="tw-mb-1">
                        <div class="tw-flex tw-flex-wrap tw-items-center tw-w-full">
                            <label class="md:tw-w-1/4 md:tw-block tw-hidden">
                                Password 
                            </label>
                            <div class="md:tw-w-3/4 tw-w-full">
                                <base-input
                                        id="password"
                                        v-model="password"
                                        type="password"
                                        class="
                                                {{ $errors->has('password') ? ' is-invalid' : '' }}
                                                tw-mb-2 tw-w-full tw-text-base
                                            "
                                        name="password"
                                        placeholder="Password"
                                        required
                                        show-password
                                ></base-input>
                            </div>
                        </div>
                    </div>
                    <base-button type="submit" class="tw-py-4 tw-w-full tm-mx-auto tw-mb-5 tw-center tw-text-base tw-text-white tw-font-semibold tw-bg-orange-400">
                        {{ __('Log in') }}
                    </base-button>
                        
                    <div class="tw-flex tw-justify-around tw-items-center tw-mb-4">
                        <span>
                            <base-checkbox
                                name="remember"
                                id="remember"
                                {{ old('remember') ? 'checked' : '' }}
                            >{{ __('Remember Me') }}</base-checkbox>
                        </span>
                    </div>
                </form>
            </div>
        </div>
    </login-form>
    <div class="tw-hidden lg:tw-w-1/2 lg:tw-flex lg:tw-items-center tw-bg-white">
        <img src="/images/splash.jpg"></img>
    </div>
</div>

@endsection

@section('scripts')
    <script src="{{ asset('js/app.js') }}"></script>
@endsection
