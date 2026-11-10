@props(['id' => '', 'title' => '', 'path' => ''])

<x-partials.display.base-modal id="{{ $id }}" title="{{ $title }}" maxWidth='modal-xl'>
    <div class="text-center">
        <div role="group" class="btn-group" style="width: 100%; margin-bottom: 1rem;">
            <a href="{{ asset($path) }}" target="_blank" type="button" class="btn btn-outline-primary">Buka di
                Tab Baru</a>
            <a href="{{ asset($path) }}" download class="btn btn-outline-success">Download File</a>
        </div>
        <iframe src="{{ asset($path) }}" width="100%" height="650px" style="border: none;"></iframe>
    </div>
</x-partials.display.base-modal>
