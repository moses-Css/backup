<button {{ $attributes->merge(['type' => 'submit', 'class' => '
inline-flex items-center
 px-4 py-2 bg-primary  border border-transparent rounded-md  text-sm text-white
   tracking-widest hover:bg-primary/90 focus:bg-primary  active:bg-primary/90
   focus:outline-none focus:ring-2 focus:ring-primary focus:ring-offset-2 
    transition ease-in-out duration-150']) }}>
    {{ $slot }}
</button>
