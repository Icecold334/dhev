<?php

namespace App\Livewire;

use App\Models\Bahan;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithoutUrlPagination;

class ListBahan extends Component
{
    use WithPagination, WithoutUrlPagination;

    public $search = '';
    public $perPage = 5;
    public $showFormModal = false;
    public $isEditing = false;
    public $deleteId = null;
    public $showDeleteConfirm = false;

    public $allSatuan;
    public $form = [
        'id' => null,
        'nama' => '',
        'konversi' => '',
        'besar_id' => '',
        'kecil_id' => '',
    ];
    public $showOpnameModal = false;
    public $selectedBahan;
    public $stokOpnameInput;


    protected $paginationTheme = 'tailwind';
    public function openOpname($id)
    {
        $this->selectedBahan = Bahan::findOrFail($id);
        $this->stokOpnameInput = ''; // reset input
        $this->showOpnameModal = true;
    }
    public function saveOpname()
    {
        $this->validate([
            'stokOpnameInput' => 'required|numeric|min:0',
        ]);

        $bahan = $this->selectedBahan;
        $konversi = $bahan->konversi;

        $stokSekarangKecil = $bahan->getTotalStok()['kecil'];
        $stokInputKecil = round($this->stokOpnameInput * $konversi);
        $selisih = $stokInputKecil - $stokSekarangKecil;

        if ($selisih !== 0) {
            $bahan->logStoks()->create([
                'jenis' => 'ADJ',
                'kode' => 'ADJ-' . now()->format('YmdHis'),
                'jumlah' => $selisih,
                'harga' => 0,
                'keterangan' => 'Penyesuaian stok opname (' . $this->stokOpnameInput . ' ' . $bahan->satuanBesar->nama . ')',
            ]);
        }

        $this->showOpnameModal = false;
        $this->selectedBahan = null;
        $this->stokOpnameInput = null;

        $this->dispatch('toast', [
            ['type' => 'success', 'message' => 'Stok berhasil disesuaikan.']
        ]);
    }


    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function resetForm()
    {
        $this->form = [
            'id' => null,
            'nama' => '',
        ];
    }

    public function openCreateForm()
    {
        $this->resetForm();
        $this->allSatuan = \App\Models\Satuan::all();
        $this->isEditing = false;
        $this->showFormModal = true;
    }

    public function openEditForm($id)
    {
        $bahan = \App\Models\Bahan::findOrFail($id);
        $this->form = [
            'id' => $bahan->id,
            'nama' => $bahan->nama,
            'konversi' => $bahan->konversi,
            'besar_id' => $bahan->besar_id,
            'kecil_id' => $bahan->kecil_id,
        ];
        $this->allSatuan = \App\Models\Satuan::all();
        $this->isEditing = true;
        $this->showFormModal = true;
    }

    public function save()
    {
        $this->validate([
            'form.nama' => 'required|string|max:255',
            'form.konversi' => 'required|integer|min:1',
            'form.besar_id' => 'required|exists:satuan,id',
            'form.kecil_id' => 'required|exists:satuan,id',
        ]);

        \App\Models\Bahan::updateOrCreate(
            ['id' => $this->form['id']],
            [
                'nama' => $this->form['nama'],
                'konversi' => $this->form['konversi'],
                'besar_id' => $this->form['besar_id'],
                'kecil_id' => $this->form['kecil_id'],
            ]
        );

        $this->showFormModal = false;
        $this->resetForm();

        $this->dispatch('toast', [
            ['type' => 'success', 'message' => $this->isEditing ? 'Bahan berhasil diperbarui.' : 'Bahan berhasil ditambahkan.']
        ]);
    }


    public function confirmDelete($id)
    {
        $this->deleteId = $id;
        $this->showDeleteConfirm = true;
    }

    public function delete($id)
    {
        Bahan::findOrFail($id)->delete();

        $this->dispatch('toast', [
            ['type' => 'success', 'message' => 'Bahan berhasil dihapus.']
        ]);
    }

    public function render()
    {
        $bahans = Bahan::with('satuanBesar', 'satuanKecil')
            ->where('nama', 'like', '%' . $this->search . '%')
            ->orderBy('nama')
            ->paginate($this->perPage);

        foreach ($bahans as $bahan) {
            $bahan->total_stok = $bahan->getTotalStok();
        }

        return view('livewire.list-bahan', compact('bahans'));
    }
}
