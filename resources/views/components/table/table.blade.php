<table class="w-full text-sm text-left rtl:text-right text-body mb-4">
    <thead class="text-sm bg-neutral-secondary-medium border-b border-default-medium">
       {!! $tbhead !!}
    </thead>
    <tbody>
        {!! str_replace('<td>', '<td class="px-4 py-2">', str_replace('<tr>', '<tr class="border-b border-default-medium hover:bg-default-light">', $tbbody)) !!}
    </tbody>
</table>