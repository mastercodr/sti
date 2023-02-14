<script setup>
import { Head, Link } from '@inertiajs/vue3';

defineProps({
    canLogin: Boolean,
    canRegister: Boolean
});
</script>

<template>
    <Head title="Task list management" />

    <div
        class="relative flex items-top justify-center min-h-screen bg-gray-100  sm:items-center sm:pt-0"
    >
        <div v-if="canLogin" class="hidden fixed top-0 right-0 px-6 py-4 sm:block">
            <Link
                v-if="$page.props.auth.user"
                :href="route('dashboard')"
                class="text-sm text-gray-700 underline">Dashboard</Link>

            <template v-else>
                <Link :href="route('login')" class="text-sm text-gray-700  underline">Log in</Link>

                <Link
                    v-if="canRegister"
                    :href="route('register')"
                    class="ml-4 text-sm text-gray-700  underline"
                    >Register</Link
                >
            </template>
        </div>

        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
            <div role="listitem" class="carousel-item active" data-v-1b151ea8="" aria-current="true" aria-posinset="1" aria-setsize="4" id="__BVID__125"><div class="carousel-img h-100 d-flex flex-column" data-v-47e48e5e="" data-v-1b151ea8=""><a href="/ez-path" class="text-center" data-v-47e48e5e=""><img src="https://assets.stifirestop.com/images/sti-site/home/slider/ezpath/ezpath-advantages/main.jpg" alt="EZ Path - The Gold Standard" class="main-img img-fluid" style="object-position:50%" data-v-47e48e5e="" srcset="https://assets.stifirestop.com/images/sti-site/home/slider/ezpath/ezpath-advantages/main@3x.jpg 3x,https://assets.stifirestop.com/images/sti-site/home/slider/ezpath/ezpath-advantages/main@2x.jpg 2x, https://assets.stifirestop.com/images/sti-site/home/slider/ezpath/ezpath-advantages/main.jpg 1x"></a> <div class="text-center my-auto" data-v-47e48e5e=""></div> <div class="bottom-row my-auto d-flex justify-content-between align-items-center" data-v-47e48e5e=""><!----> <img src="https://assets.stifirestop.com/images/sti-site/home/slider/ezpath/roi-calculator/ezPathLogoOrange.png" alt="EZ Path" class="mx-4 py-2 logo-img img-fluid" data-v-47e48e5e="" srcset="https://assets.stifirestop.com/images/sti-site/home/slider/ezpath/roi-calculator/ezPathLogoOrange@3x.png 3x,https://assets.stifirestop.com/images/sti-site/home/slider/ezpath/roi-calculator/ezPathLogoOrange@2x.png 2x, https://assets.stifirestop.com/images/sti-site/home/slider/ezpath/roi-calculator/ezPathLogoOrange.png 1x"> <div class="px-2" data-v-47e48e5e=""><p class="tagline font-italic" data-v-47e48e5e="">
      For more than twenty years industry-leading data centers, premier healthcare facilities, and countless others have relied on EZ Path.
    </p></div> <div class="font-italic mx-4 flex-shrink-0 text-center font-weight-bold" data-v-47e48e5e=""><a href="/ez-path" style="color:#e06f34" data-v-47e48e5e="" class="">
        find out more <svg aria-hidden="true" focusable="false" data-prefix="fas" data-icon="caret-right" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 192 512" class="ml-2 svg-inline--fa fa-caret-right fa-w-6 fa-lg" data-v-47e48e5e=""><path fill="currentColor" d="M0 384.662V127.338c0-17.818 21.543-26.741 34.142-14.142l128.662 128.662c7.81 7.81 7.81 20.474 0 28.284L34.142 398.804C21.543 411.404 0 402.48 0 384.662z" data-v-47e48e5e="" class=""></path></svg></a></div></div></div><!----></div>

        </div>
    </div>
</template>
