<div class="panel needs-validation">
    <div class="panel-header">
        <div>
            <h2 class="h5 mb-1 section-title"><i class="bi bi-ui-checks-grid" aria-hidden="true"></i>
                <span class="bg-warning-subtle p-1 rounded px-3">Form Identitas Anak</span>
            </h2>
        </div>
    </div>
    <div class="row g-3">
        {{-- form input --}}
    </div>
    <div class="d-flex justify-content-end mt-4">
        <button type="button" wire:click="$set('step', 2)" class="btn btn-secondary me-2">
            &larr; Sebelumnya
        </button>
        <button type="button" wire:click="saveIdentitasAnak" class="btn btn-warning">
            Berikutnya &rarr;
        </button>
    </div>
</div>
