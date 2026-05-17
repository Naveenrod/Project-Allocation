<button {{ $attributes->merge(['type' => 'submit', 'class' => 'inline-flex items-center gap-2 px-5 py-2.5 bg-gu-navy text-white text-sm font-semibold rounded-lg hover:bg-gu-navy/90 focus:outline-none focus:ring-2 focus:ring-gu-navy focus:ring-offset-2 transition-all duration-150']) }}>
    {{ $slot }}
</button>
