<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title> @yield('title') </title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <script src="https://cdn.tiny.cloud/1/j5anuhxqurgaumnivs1fcdlovfp89kfcfdipxxe8zrh6q7sa/tinymce/7/tinymce.min.js" referrerpolicy="origin"></script>
        <link rel="stylesheet" href="{{ asset('css/loader.css') }}">
    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen bg-gray-100">
            @include('layouts.navigation')

            <!-- Page Heading -->
            @isset($header)
                <header class="bg-white shadow">

                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endisset

            <x-auth-session-status :status="$status ?? ''">

            </x-auth-session-status>
            <!-- Page Content -->
            <main>
                <div id="loader" style="display:none;">
                <div class="spinner"></div>
            </div>
                {{ $slot }}
            </main>
        </div>


        <script src="{{ asset('js/loader.js') }}"></script>

{{--        <script src="/js/functions.js"></script>--}}
        <script src="/js/jquery-3.3.1.min.js"></script>
        <script>
            tinymce.init({
                selector: 'textarea',
                plugins: [
                    // Core editing features
                    'anchor', 'autolink', 'charmap', 'codesample', 'emoticons', 'lists', 'searchreplace', 'visualblocks', 'wordcount',
                    // Your account includes a free trial of TinyMCE premium features
                    // Try the most popular premium features until Dec 26, 2024:
                    // 'checklist', 'mediaembed', 'casechange', 'a11ychecker', 'tinymcespellchecker', 'permanentpen', 'powerpaste', 'advtable', 'advcode', 'editimage', 'advtemplate', 'ai', 'mentions', 'tinycomments', 'tableofcontents', 'footnotes', 'mergetags', 'autocorrect', 'typography', 'inlinecss', 'markdown','importword', 'exportword', 'exportpdf'
                ],
                toolbar: 'undo redo | blocks fontfamily fontsize | bold italic underline strikethrough | link image media table mergetags | addcomment showcomments | spellcheckdialog a11ycheck typography | checklist numlist bullist indent outdent | charmap | removeformat',
                tinycomments_mode: 'embedded',
                // tinycomments_author: 'Author name',
                mergetags_list: [
                    { value: 'First.Name', title: 'First Name' },
                    { value: 'Email', title: 'Email' },
                ],
                ai_request: (request, respondWith) => respondWith.string(() => Promise.reject('See docs to implement AI Assistant')),
            });
        </script>
    </body>
</html>
