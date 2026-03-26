@props([
    'statePath' => null,
])
<x-filament-tiptap-editor::button
    label="iFrame"
    active="iframe"
    action="editor().chain().focus().setIframe({ src: '' }).run()"
>
   <svg height="20" viewBox="0 0 24 24" width="20" xmlns="http://www.w3.org/2000/svg"><path d="m13 20h7v-16h-16v7h7c1.1045695 0 2 .8954305 2 2zm-2 0v-7h-7v7zm-7-18h16c1.1045695 0 2 .8954305 2 2v16c0 1.1045695-.8954305 2-2 2h-16c-1.1045695 0-2-.8954305-2-2v-16c0-1.1045695.8954305-2 2-2z"/></svg>
    <span class="sr-only">iFrame</span>
</x-filament-tiptap-editor::button>