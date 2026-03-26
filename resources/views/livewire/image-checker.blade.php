<div class="container mx-auto px-4 border rounded-xl shadow-md p-4"
x-data="{
        cooldown: @json($initialCooldown),
        timer: null,
        startTimer() {
            if (this.timer) {
                clearInterval(this.timer);
            }
            this.timer = setInterval(() => {
                this.cooldown--;
                if (this.cooldown <= 0) {
                    clearInterval(this.timer);
                    this.cooldown = 0;
                }
            }, 1000);
        }
    }"
    x-init="if (cooldown > 0) startTimer()"
    x-on:start-cooldown.window="cooldown = $event.detail.seconds; startTimer()">
    <form wire:submit="save">
        <div class="flex flex-col md:flex-row space-x-10">

            <div class="">
                <label for="imageInput">{{ __('site.check_image') }}:</label>

                <div class="my-4 flex items-center space-x-4">
                    <label for="imageInput" class="cursor-pointer inline-block px-4 py-2 rounded-md">
                        📁 {{ __('site.select_image') }}
                    </label>
                    
                    <div wire:loading wire:target="image" class="text-sm text-gray-600">
                        Жүктеу ...
                    </div>
                </div>
                <input type="file" id="imageInput" wire:model="image" accept="image/*" class="hidden">
                @error('image') <span class="text-red-500 text-sm mt-1">{{ $message }}</span> @enderror
                <button type="submit"
                        class="flex items-center justify-center mt-5 border p-2 rounded bg-primary text-white text-lg px-4 font-semibold my-4 disabled:bg-gray-400 disabled:cursor-not-allowed"
                        wire:loading.attr="disabled"
                        wire:target="save"
                        :disabled="cooldown > 0 || !@this.get('image') || @json($errors->has('image')) || @this.get('imageSubmitted')">

                    <div wire:loading wire:target="save">
                        <div class="flex items-center">
                        <div class="w-full place-items-center rounded-lg mr-5 lg:overflow-visible">
                            <svg class="text-gray-300 animate-spin" viewBox="0 0 64 64" fill="none" xmlns="http://www.w3.org/2000/svg"
                                 width="24" height="24">
                                <path
                                    d="M32 3C35.8083 3 39.5794 3.75011 43.0978 5.20749C46.6163 6.66488 49.8132 8.80101 52.5061 11.4939C55.199 14.1868 57.3351 17.3837 58.7925 20.9022C60.2499 24.4206 61 28.1917 61 32C61 35.8083 60.2499 39.5794 58.7925 43.0978C57.3351 46.6163 55.199 49.8132 52.5061 52.5061C49.8132 55.199 46.6163 57.3351 43.0978 58.7925C39.5794 60.2499 35.8083 61 32 61C28.1917 61 24.4206 60.2499 20.9022 58.7925C17.3837 57.3351 14.1868 55.199 11.4939 52.5061C8.801 49.8132 6.66487 46.6163 5.20749 43.0978C3.7501 39.5794 3 35.8083 3 32C3 28.1917 3.75011 24.4206 5.2075 20.9022C6.66489 17.3837 8.80101 14.1868 11.4939 11.4939C14.1868 8.80099 17.3838 6.66487 20.9022 5.20749C24.4206 3.7501 28.1917 3 32 3L32 3Z"
                                    stroke="currentColor" stroke-width="5" stroke-linecap="round" stroke-linejoin="round"></path>
                                <path
                                    d="M32 3C36.5778 3 41.0906 4.08374 45.1692 6.16256C49.2477 8.24138 52.7762 11.2562 55.466 14.9605C58.1558 18.6647 59.9304 22.9531 60.6448 27.4748C61.3591 31.9965 60.9928 36.6232 59.5759 40.9762"
                                    stroke="currentColor" stroke-width="5" stroke-linecap="round" stroke-linejoin="round"
                                    class="text-green-500"></path>
                            </svg>
                        </div>
                        <span>{{ __('site.checking') }}...</span>
                        </div>
                        
                    </div>

                    <div wire:loading.remove wire:target="save">
                        <span x-show="cooldown <= 0">{{ __('site.check') }}</span>
                        <span x-show="cooldown > 0" class="flex items-center">
                            {{ __('site.repeat_after') }} &nbsp;<span x-text="cooldown"></span>&nbsp; сек.
                        </span>
                    </div>
                </button>



                @if ($image && !$errors->has('image'))
                    <div class="mt-4 animate-fade-in-left">
                        <p>{{ __('site.preview') }}:</p>
                        <img src="{{ $image->temporaryUrl() }}" class="max-w-xs mt-2 rounded shadow">
                    </div>
                @endif
            </div>

            <div class="flex-1 animate-fade-in-right" wire:loading.remove wire:target="save">
                @if ($apiErrors)
                @foreach ($apiErrors as $item)
                <div class="rounded text-red-800 bg-red-100 mb-2 p-3">
                    {{ $item }}
                </div>
                @endforeach
                @endif
                 @if ($message)
                <div @class([
    'rounded mb-2 p-3',
    'bg-green-100 text-green-800' => !$isError,
    'bg-red-100 text-red-800' => $isError,
])>
                    {{ $message }}
                </div>
                @endif
            </div>
        </div>
    </form>
</div>
