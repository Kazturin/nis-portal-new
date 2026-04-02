<button {{ $attributes->merge(['type' => 'submit', 'class' => 'font-inter-semibold inline-flex items-center px-5 py-1 bg-primary border border-transparent rounded-3xl text-white hover:bg-rich-primary focus:outline-none focus:ring-2 focus:ring-primary focus:ring-offset-2 transition ease-in-out duration-150 cursor-pointer']) }}>
    {{ $slot }}
</button>