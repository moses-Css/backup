<button {{ $attributes->merge(['type' => 'submit', 'class' => '
relative px-6 py-3 min-w-[100px] border-2 border-primary/50 outline-none bg-primary
    shadow-[inset_-3px_-15px_20px_#005ED1,inset_-3px_-10px_10px_#005ED1,inset_-10px_0px_15px_#005ED1] 
    transition-all duration-300 ease-in-out will-change-transform transform-gpu 
     hover:shadow-[inset_-3px_-15px_20px_#005ED1,inset_-3px_-10px_10px_#005ED1,inset_-10px_0px_15px_#005ED1,5px_8px_10px_#005ED1] 
     active:shadow-none flex items-center justify-center gap-2 !text-secondary']) }}>
    {{ $slot }}
</button>
