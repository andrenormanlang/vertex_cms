@props(['bgColor', 'title', 'count'])

<div class="bg-{{ $bgColor }} text-white p-6 rounded-lg shadow-md">
    <h3 class="text-lg font-semibold">{{ $title }}</h3>
    <p class="text-3xl">{{ $count }}</p>
</div>
