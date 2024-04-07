<!-- pagination.blade.php -->

<div>
    @if ($page > 1)
        <button wire:click="$parent.gotoPage({{ $page - 1 }})">Previous</button>
    @endif

    @for ($i = 1; $i <= $totalPage; $i++)
        <button wire:click="$parent.gotoPage({{ $i }})">{{ $i }}</button>
    @endfor

    @if ($page < $totalPage)
        <button wire:click="$parent.gotoPage({{ $page + 1 }})">Next</button>
    @endif
</div>
