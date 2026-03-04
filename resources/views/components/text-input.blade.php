@props(['disabled' => false])

<input @disabled($disabled) {{ $attributes->merge(['class' => 'border-[#E8E0D5] focus:border-[#B07833] focus:ring-[#F7EDDA] rounded-md shadow-sm']) }}>
