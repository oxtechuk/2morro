@extends('shared.vertical', ['title' => 'Dashboard'])

@section('content')
    @include('shared.partials.page-title', ['subtitle' => 'Forms', 'title' => 'Input'])

    <div class="grid lg:grid-cols-2 gap-6">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Basic Usage</h4>
            </div>
            <div class="p-6">
                <div data-hs-file-upload='{
                                "url": "/upload",
                                "extensions": {
                                  "default": {
                                    "class": "shrink-0 size-5"
                                  },
                                  "xls": {
                                    "class": "shrink-0 size-5"
                                  },
                                  "zip": {
                                    "class": "shrink-0 size-5"
                                  },
                                  "csv": {
                                    "icon": "&lt;i class=\"iconify tabler--file-code\"&gt;&lt;/i&gt;",
                                    "class": "shrink-0 size-5"
                                  }
                                }
                              }'>
                    <template data-hs-file-upload-preview="">
                        <div class="p-3 bg-white border border-solid border-default-300 rounded-xl">
                            <div class="mb-1 flex justify-between items-center">
                                <div class="flex items-center gap-x-3">
<span class="size-10 flex justify-center items-center border border-default-200 text-default-500 rounded-lg"
      data-hs-file-upload-file-icon="">
<img class="rounded-lg hidden" data-dz-thumbnail=""/>
</span>
                                    <div>
                                        <p class="text-sm font-medium text-default-800">
                                            <span class="truncate inline-block max-w-[300px] align-bottom"
                                                  data-hs-file-upload-file-name=""></span>.<span
                                                data-hs-file-upload-file-ext=""></span>
                                        </p>
                                        <p class="text-xs text-default-500" data-hs-file-upload-file-size="">
                                        </p>
                                    </div>
                                </div>
                                <div class="flex items-center gap-x-2">
                                    <button
                                        class="text-default-500 hover:text-default-800 focus:outline-none focus:text-default-800"
                                        data-hs-file-upload-remove="" type="button">
                                        <i class="iconify tabler--trash size-4 shrink-0"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="flex items-center gap-x-3 whitespace-nowrap">
                                <div aria-valuemax="100" aria-valuemin="0" aria-valuenow="0"
                                     class="flex w-full h-2 bg-default-200 rounded-full overflow-hidden"
                                     data-hs-file-upload-progress-bar="" role="progressbar">
                                    <div
                                        class="flex flex-col justify-center rounded-full overflow-hidden bg-primary-600 text-xs text-white text-center whitespace-nowrap transition-all duration-500 hs-file-upload-complete:bg-green-500"
                                        data-hs-file-upload-progress-bar-pane="" style="width: 0"></div>
                                </div>
                                <div class="w-10 text-end">
<span class="text-sm text-default-800">
<span data-hs-file-upload-progress-bar-value="">0</span>%
                                                </span>
                                </div>
                            </div>
                        </div>
                    </template>
                    <div
                        class="cursor-pointer p-12 flex justify-center bg-white border border-dashed border-default-300 rounded-xl"
                        data-hs-file-upload-trigger="">
                        <div class="text-center">
<span class="inline-flex justify-center items-center size-16 bg-default-100 text-default-800 rounded-full">
<i class="iconify tabler--upload size-6 shrink-0"></i>
</span>
                            <div class="mt-4 flex flex-wrap justify-center text-sm leading-6 text-default-600">
<span class="pe-1 font-medium text-default-800">
                                                Drop your file here or
                                            </span>
                                <span
                                    class="bg-white font-semibold text-primary hover:text-primary-700 rounded-lg decoration-2 hover:underline focus-within:outline-none focus-within:ring-2 focus-within:ring-primary-600 focus-within:ring-offset-2">browse</span>
                            </div>
                            <p class="mt-1 text-xs text-default-400">
                                Pick a file up to 2MB.
                            </p>
                        </div>
                    </div>
                    <div class="mt-4 space-y-2 empty:mt-0" data-hs-file-upload-previews=""></div>
                </div>
            </div>
        </div> <!-- end card -->
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Error</h4>
            </div>
            <div class="p-6">
                <div data-hs-file-upload='{
                                "url": "/upload",
                                "maxFilesize": 1,
                                "extensions": {
                                  "default": {
                                    "class": "shrink-0 size-5"
                                  },
                                  "xls": {
                                    "class": "shrink-0 size-5"
                                  },
                                  "zip": {
                                    "class": "shrink-0 size-5"
                                  },
                                  "csv": {
                                    "icon": "&lt;i class=\"iconify tabler--file-code\"&gt;&lt;/i&gt;",
                                    "class": "shrink-0 size-5"
                                  }
                                }
                              }' id="hs-file-upload-with-limited-file-size">
                    <template data-hs-file-upload-preview="">
                        <div class="p-3 bg-white border border-solid border-default-300 rounded-xl">
                            <div class="mb-1 flex justify-between items-center">
                                <div class="flex items-center gap-x-3">
<span class="size-10 flex justify-center items-center border border-default-200 text-default-500 rounded-lg"
      data-hs-file-upload-file-icon="">
<img class="rounded-lg hidden" data-dz-thumbnail=""/>
</span>
                                    <div>
                                        <p class="text-sm font-medium text-default-800">
                                            <span class="truncate inline-block max-w-[300px] align-bottom"
                                                  data-hs-file-upload-file-name=""></span>.<span
                                                data-hs-file-upload-file-ext=""></span>
                                        </p>
                                        <p class="text-xs text-default-500" data-hs-file-upload-file-size=""
                                           data-hs-file-upload-file-success=""></p>
                                        <p class="text-xs text-red-500" data-hs-file-upload-file-error=""
                                           style="display: none;">File exceeds size limit.</p>
                                    </div>
                                </div>
                                <div class="flex items-center gap-x-2">
<span class="hs-tooltip [--placement:top] inline-block" data-hs-file-upload-file-error="" style="display: none;">
<span class="hs-tooltip-toggle text-red-500 hover:text-red-800 focus:outline-none focus:text-red-800">
<i class="iconify tabler--alert-circle shrink-0 size-4"></i>
<span
    class="hs-tooltip-content max-w-[100px] hs-tooltip-shown:opacity-100 hs-tooltip-shown:visible opacity-0 transition-opacity inline-block absolute invisible z-10 py-1 px-2 bg-default-900 text-xs font-medium text-white rounded shadow-sm"
    role="tooltip">
                                                            Please try to upload a file smaller than 1MB.
                                                        </span>
</span>
</span>
                                    <button
                                        class="text-default-500 hover:text-default-800 focus:outline-none focus:text-default-800"
                                        data-hs-file-upload-reload="" type="button">
                                        <i class="iconify tabler--reload shrink-0 size-4"></i>
                                    </button>
                                    <button
                                        class="text-default-500 hover:text-default-800 focus:outline-none focus:text-default-800"
                                        data-hs-file-upload-remove="" type="button">
                                        <i class="iconify tabler--trash shrink-0 size-4"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="flex items-center gap-x-3 whitespace-nowrap">
                                <div aria-valuemax="100" aria-valuemin="0" aria-valuenow="0"
                                     class="flex w-full h-2 bg-default-200 rounded-full overflow-hidden"
                                     data-hs-file-upload-progress-bar="" role="progressbar">
                                    <div
                                        class="flex flex-col justify-center rounded-full overflow-hidden bg-primary-600 text-xs text-white text-center whitespace-nowrap transition-all duration-500 hs-file-upload-complete:bg-green-500"
                                        data-hs-file-upload-progress-bar-pane="" style="width: 0"></div>
                                </div>
                                <div class="w-10 text-end">
<span class="text-sm text-default-800">
<span data-hs-file-upload-progress-bar-value="">0</span>%
                                                </span>
                                </div>
                            </div>
                        </div>
                    </template>
                    <div
                        class="cursor-pointer p-12 flex justify-center bg-white border border-dashed border-default-300 rounded-xl"
                        data-hs-file-upload-trigger="">
                        <div class="text-center">
<span class="inline-flex justify-center items-center size-16 bg-default-100 text-default-800 rounded-full">
<i class="iconify tabler--upload size-6 shrink-0"></i>
</span>
                            <div class="mt-4 flex flex-wrap justify-center text-sm leading-6 text-default-600">
<span class="pe-1 font-medium text-default-800">
                                                Drop your file here or
                                            </span>
                                <span
                                    class="bg-white font-semibold text-primary hover:text-primary-700 rounded-lg decoration-2 hover:underline focus-within:outline-none focus-within:ring-2 focus-within:ring-primary-600 focus-within:ring-offset-2">browse</span>
                            </div>
                            <p class="mt-1 text-xs text-default-400">
                                Pick a file up to 2MB.
                            </p>
                        </div>
                    </div>
                    <div class="mt-4 space-y-2 empty:mt-0" data-hs-file-upload-previews=""></div>
                </div>
            </div>
        </div> <!-- end card -->
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Gallery</h4>
            </div>
            <div class="p-6">
                <div data-hs-file-upload='{
                                    "url": "/upload",
                                    "acceptedFiles": "image/*",
                                    "autoHideTrigger": false,
                                    "extensions": {
                                    "default": {
                                        "class": "shrink-0 size-5"
                                    },
                                    "xls": {
                                        "class": "shrink-0 size-5"
                                    },
                                    "zip": {
                                        "class": "shrink-0 size-5"
                                    },
                                    "csv": {
                                        "icon": "&lt;i class=\"iconify tabler--file-code\"&gt;&lt;/i&gt;",
                                        "class": "shrink-0 size-5"
                                    }
                                    }
                                }'>
                    <template data-hs-file-upload-preview="">
                        <div class="relative mt-2 p-2 bg-white border border-default-200 rounded-xl">
                            <img class="mb-2 w-full object-cover rounded-lg" data-dz-thumbnail=""/>
                            <div class="mb-1 flex justify-between items-center gap-x-3 whitespace-nowrap">
                                <div class="w-10">
<span class="text-sm text-default-800">
<span data-hs-file-upload-progress-bar-value="">0</span>%
                                                </span>
                                </div>
                                <div class="flex items-center gap-x-2">
                                    <button
                                        class="text-default-500 hover:text-default-800 focus:outline-none focus:text-default-800"
                                        data-hs-file-upload-remove="" type="button">
                                        <i class="iconify tabler--trash shrink-0 size-3.5"></i>
                                    </button>
                                </div>
                            </div>
                            <div aria-valuemax="100" aria-valuemin="0" aria-valuenow="0"
                                 class="flex w-full h-2 bg-default-200 rounded-full overflow-hidden"
                                 data-hs-file-upload-progress-bar="" role="progressbar">
                                <div
                                    class="flex flex-col justify-center rounded-full overflow-hidden bg-primary-600 text-xs text-white text-center whitespace-nowrap transition-all duration-500 hs-file-upload-complete:bg-green-500"
                                    data-hs-file-upload-progress-bar-pane="" style="width: 0"></div>
                            </div>
                        </div>
                    </template>
                    <div
                        class="cursor-pointer p-12 flex justify-center bg-white border border-dashed border-default-300 rounded-xl"
                        data-hs-file-upload-trigger="">
                        <div class="text-center">
<span class="inline-flex justify-center items-center size-16 bg-default-100 text-default-800 rounded-full">
<i class="iconify tabler--upload size-6 shrink-0"></i>
</span>
                            <div class="mt-4 flex flex-wrap justify-center text-sm leading-6 text-default-600">
<span class="pe-1 font-medium text-default-800">
                                                Drop your file here or
                                            </span>
                                <span
                                    class="bg-white font-semibold text-primary hover:text-primary-700 rounded-lg decoration-2 hover:underline focus-within:outline-none focus-within:ring-2 focus-within:ring-primary-600 focus-within:ring-offset-2">browse</span>
                            </div>
                            <p class="mt-1 text-xs text-default-400">
                                Pick a file up to 2MB.
                            </p>
                        </div>
                    </div>
                    <div class="grid grid-cols-4 gap-x-2 empty:gap-0" data-hs-file-upload-previews=""></div>
                </div>
            </div>
        </div> <!-- end card -->
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Single Image Upload</h4>
            </div>
            <div class="p-6">
                <div data-hs-file-upload='{
                                "url": "/upload",
                                "acceptedFiles": "image/*",
                                "maxFiles": 1,
                                "singleton": true
                              }'>
                    <template data-hs-file-upload-preview="">
                        <div class="size-20">
                            <img class="w-full object-contain rounded-full" data-dz-thumbnail=""/>
                        </div>
                    </template>
                    <div class="flex flex-wrap items-center gap-3 sm:gap-5">
                        <div class="group" data-hs-file-upload-previews="" data-hs-file-upload-pseudo-trigger="">
<span
    class="group-has-[div]:hidden flex shrink-0 justify-center items-center size-20 border-2 border-dotted border-default-300 text-default-400 cursor-pointer rounded-full hover:bg-default-50">
<i class="iconify tabler--user-circle size-7 shrink-0"></i>
</span>
                        </div>
                        <div class="grow">
                            <div class="flex items-center gap-x-2">
                                <button class="btn bg-primary text-white" data-hs-file-upload-trigger="" type="button">
                                    <i class="iconify tabler--upload size-4 shrink-0"></i>
                                    Upload photo
                                </button>
                                <button class="btn border-default-200 text-default-400" data-hs-file-upload-clear=""
                                        type="button">Delete
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div> <!-- end card -->
    </div>
@endsection

@section('scripts')
@endsection
