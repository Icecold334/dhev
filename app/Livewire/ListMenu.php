<?php

namespace App\Livewire;

use App\Models\Menu;
use Livewire\Component;
use Illuminate\Support\Str;
use Livewire\WithPagination;
use Livewire\WithoutUrlPagination;

class ListMenu extends Component
{
    use WithPagination, WithoutUrlPagination;

    public $selectedMenu;
    public $showModal = false;
    public $search = '';
    public $perPage = 5;
    public $isEditing = false;
    public $form = [
        'id' => null,
        'nama' => '',
        'tipe' => '',
        'harga' => '',
        'deskripsi' => '',
        'bahanList' => [], // array of ['bahan_id' => ..., 'jumlah' => ...]
    ];

    public $allBahans;
    public $showFormModal = false;

    public $deleteId = null;
    public $showDeleteConfirm = false;

    // protected $queryString = ['search', 'perPage'];
    protected $paginationTheme = 'tailwind';
    public function openCreateForm()
    {
        $this->resetForm();
        $this->allBahans = \App\Models\Bahan::with('satuanKecil')->get();
        $this->showFormModal = true;
        $this->isEditing = false;
    }

    public function confirmDelete($id)
    {
        $this->deleteId = $id;
        $this->showDeleteConfirm = true;
    }

    public function delete()
    {
        $menu = Menu::findOrFail($this->deleteId);
        $menu->listMenus()->delete(); // hapus relasi bahan
        $menu->delete(); // hapus menu utama

        $this->showDeleteConfirm = false;
        $this->deleteId = null;

        session()->flash('message', 'Menu berhasil dihapus.');
    }

    public function openEditForm($menuId)
    {
        $menu = Menu::with('listMenus')->findOrFail($menuId);
        $this->form = [
            'id' => $menu->id,
            'nama' => $menu->nama,
            'tipe' => $menu->tipe,
            'harga' => $menu->harga,
            'deskripsi' => $menu->deskripsi,
            'bahanList' => $menu->listMenus->map(fn($item) => [
                'bahan_id' => $item->bahan_id,
                'jumlah' => $item->jumlah,
            ])->toArray()
        ];

        $this->allBahans = \App\Models\Bahan::with('satuanKecil')->get();
        $this->showFormModal = true;
        $this->isEditing = true;
    }


    public function resetForm()
    {
        $this->form = [
            'id' => null,
            'nama' => '',
            'tipe' => '',
            'harga' => '',
            'deskripsi' => '',
            'bahanList' => [],
        ];
    }

    public function showDetail($menuId)
    {
        $this->selectedMenu = Menu::with(['listMenus.bahan.satuanKecil'])->find($menuId);
        $this->showModal = true;
    }

    public function updatingSearch()
    {
        $this->resetPage(); // reset ke halaman 1 saat filter berubah
    }
    public function save()
    {
        $this->validate([
            'form.nama' => 'required|string',
            'form.tipe' => 'required|string',
            'form.harga' => 'required|integer',
            'form.deskripsi' => 'nullable|string',
            'form.bahanList.*.bahan_id' => 'required|exists:bahans,id',
            'form.bahanList.*.jumlah' => 'required|integer|min:1',
        ]);

        $menu = Menu::updateOrCreate(
            ['id' => $this->form['id']],
            [
                'nama' => $this->form['nama'],
                'slug' => Str::slug($this->form['nama']),
                'tipe' => $this->form['tipe'],
                'harga' => $this->form['harga'],
                'deskripsi' => $this->form['deskripsi'],
            ]
        );

        // Hapus dan insert ulang listMenus
        $menu->listMenus()->delete();
        foreach ($this->form['bahanList'] as $bahan) {
            $menu->listMenus()->create([
                'bahan_id' => $bahan['bahan_id'],
                'jumlah' => $bahan['jumlah'],
            ]);
        }

        $this->showFormModal = false;
        $this->resetForm();
        $this->render();
    }
    public function addBahan()
    {
        $this->form['bahanList'][] = ['bahan_id' => '', 'jumlah' => 1];
    }

    public function removeBahan($index)
    {
        unset($this->form['bahanList'][$index]);
        $this->form['bahanList'] = array_values($this->form['bahanList']); // reindex
    }

    public function render()
    {
        $menus = Menu::where('nama', 'like', '%' . $this->search . '%')
            ->orderBy('nama')
            ->paginate($this->perPage);

        return view('livewire.list-menu', compact('menus'));
    }
}
