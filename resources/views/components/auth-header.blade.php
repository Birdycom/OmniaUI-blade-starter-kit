@props([
    'title',
    'description',
])

<x-oc::heading :title="$title" :description="$description" :level="1" class="text-center" />
