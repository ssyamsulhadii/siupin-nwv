<?php

use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;

new class extends Component {
    use WithPagination;
    public $search = '';
    public ?int $user_id = null;
    public $password = '';
    public array $form = [
        'username' => null,
        'nik' => null,
        'nama' => null,
    ];
    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function render()
    {
        $list_user = User::where('level', 'member')
            ->when($this->search, function ($query) {
                $query->where('username', 'like', '%' . $this->search . '%')->orWhere('nama', 'like', '%' . $this->search . '%');
            })
            ->latest()
            ->paginate(10);
        return view('pages.⚡manajemen-user', [
            'list_user' => $list_user,
        ]);
    }

    public function edit(User $user)
    {
        $this->user_id = $user->id;
        $this->form = [
            'username' => $user->username,
            'nik' => $user->nik,
            'nama' => $user->nama,
        ];
    }

    public function resetForm()
    {
        $this->reset(['form', 'password', 'user_id']);
        $this->resetValidation();
    }
};
?>

<div>
    <div class="container-fluid px-3 px-lg-4 py-4">
        <x-partials.display.page-title title="Jabatan Nominatif"></x-partials.display.page-title>
        <section class="row g-3">
            {{-- Tabel Data --}}
            <div class="col-12 col-xl-7">
                <section class="panel">
                    <div class="panel-header">
                        <h2 class="h5 mb-1 section-title"><i class="bi bi-table" aria-hidden="true"></i>
                            <span>Daftar Jabatan Nominatif</span>
                        </h2>
                        <x-partials.forms.input-search />
                    </div>
                    <x-partials.feedback.alert />
                    <div class="table-responsive">
                        <table class="table table-bordered align-middle mb-0" id="ordersTable" data-searchable-table="">
                            <thead>
                                <tr>
                                    <th class="text-center">No</th>
                                    <th class="text-center">USERNAME(NIP)</th>
                                    <th class="text-center">NIK</th>
                                    <th>Nama</th>
                                    <th class="text-center">Menu</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($list_user as $index => $user)
                                    <tr>
                                        <td class="text-center fw-semibold" style="min-width: 40px;">
                                            {{ $list_user->firstItem() + $index }}
                                        </td>
                                        <td class="text-center">{{ $user->username }}</td>
                                        <td class="text-center">{{ $user->nik }}</td>
                                        <td>{{ $user->nama }}</td>
                                        <td class="text-center">
                                            <div class="d-flex align-items-center justify-content-center gap-1"
                                                role="group" aria-label="Aksi Jenis Pensiun">
                                                <!-- Tombol Ubah / Edit -->
                                                <x-partials.forms.action-button icon="bi-pencil" label="Ubah"
                                                    color="warning" wireClick="edit({{ $user->id }})" />
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5">
                                            <h6 class="text-center text-danger">Data user tidak ditemukan....</h5>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Bagian Pagination -->
                    <div class="panel-footer px-3 py-3 border-top">
                        {{ $list_user->links('livewire::bootstrap') }}
                    </div>
                </section>
            </div>


            {{-- Form Input --}}
            <div class="col-12 col-xl-5">
                <form class="panel needs-validation" wire:submit="save" method="POST">
                    <div class="panel-header">
                        <div>
                            <h2 class="h5 mb-1 section-title"><i class="bi bi-ui-checks-grid"
                                    aria-hidden="true"></i><span>Form Information</span></h2>
                            <p class="text-muted mb-0">Isi Form Berikut.</p>
                        </div>

                    </div>
                    <div class="row g-3">
                        <x-partials.forms.input name="form.nama" label="Nama Lengkap" wire:model="form.nama"
                            disabled></x-partials.forms.input>
                        <x-partials.forms.input name="form.username" label="Username (NIP)" wire:model="form.username"
                            disabled></x-partials.forms.input>
                        <x-partials.forms.input name="form.nik" label="NIK" wire:model="form.nik"
                            disabled></x-partials.forms.input>
                    </div>
                    <div class="d-flex justify-content-end mt-4">
                        @if ($user_id)
                            <button type="button" wire:click="resetForm" class="btn btn-secondary me-2">Batal</button>
                            <x-partials.forms.submit target="save" :is-update="(bool) $user_id" />
                        @endif
                    </div>
                </form>
            </div>
        </section>
    </div>
</div>
