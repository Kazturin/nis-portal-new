<div x-data="worldMap({{ json_encode($countries) }})" x-init="init()" class="relative">
    @include('components.svg-world-map')
    <div x-show="showModal" x-transition.opacity class="fixed inset-0 bg-black/50 z-40" @click="showModal = false">
    </div>
    <div x-cloak x-show="showModal" x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0 scale-90" x-transition:enter-end="opacity-100 scale-100"
        x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100 scale-100"
        x-transition:leave-end="opacity-0 scale-90"
        class="fixed inset-0 flex items-center justify-center z-50 pointer-events-none">
        <div class="bg-white p-6 rounded shadow-lg max-w-xl w-full pointer-events-auto">
            <h2 class="text-xl font-bold border-b pb-2 mb-2" x-text="selectedCountry.name"></h2>
            <div class="mb-2">
                <p class="font-semibold">{{ __('Popular Universities') }}:</p>
                <p class="mt-2" x-text="selectedCountry.university"></p>
            </div>
            <div class="mb-2">
                <p class="font-semibold">{{ __('Popular places to work') }}:</p>
                <p class="mt-2" x-text="selectedCountry.work"></p>
            </div>
            <div class="mb-2">
                <p class="font-semibold">{{ __('Total number of graduates') }}:</p>
                <p class="mt-2" x-text="selectedCountry.graduates"></p>
            </div>
            <div class="text-center">
                <button @click="showModal = false"
                    class="mt-4 px-4 py-2 bg-blue-500 text-white rounded">{{ __("Close") }}</button>
            </div>

        </div>
    </div>
</div>
<script>
    function worldMap(countries) {
        console.log('www')
        console.log(countries)
        return {
            showModal: false,
            countries,
            selectedCountry: {},
            init() {
                const availableCodes = countries.map(c => c.code);

                document.querySelectorAll('svg [id]').forEach(el => {
                    // console.log(el.attributes.id.value);
                    if (availableCodes.includes(el.attributes.id.value)) {
                        el.addEventListener('click', () => {
                            const code = el.attributes.id.value;
                            this.selectCountry(code);
                            // this.fetchCountry(code)
                        })
                        console.log(el);
                        el.style.cursor = "pointer";
                        el.classList.add('hover:fill-blue-500');
                        el.classList.add('fill-primary');

                    }
                })
            },
            selectCountry(code) {
                const found = this.countries.find(c => c.code === code)
                if (found) {
                    this.selectedCountry = found
                    this.showModal = true
                }
            }
        }
    }
</script>