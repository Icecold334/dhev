<?php

namespace App\Livewire;

use App\Models\Menu;
use App\Models\Bahan;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithoutUrlPagination;
use Illuminate\Support\Str;

class ListMenu extends Component
{
    use WithPagination, WithoutUrlPagination;

    public $selectedMenu;
    public $showModal = false;
    public $showFormModal = false;
    public $search = '';
    public $perPage = 5;
    public $isEditing = false;
    public $deleteId = null;

    public $form = [
        'id' => null,
        'nama' => '',
        'tipe' => '',
        'harga' => '',
        'deskripsi' => '',
        'bahanList' => [],
    ];

    public $allBahans;

    protected $paginationTheme = 'tailwind';

    public function mount()
    {
        $this->allBahans = Bahan::with('satuanKecil')->get();
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function openCreateForm()
    {
        $this->resetForm();
        $this->isEditing = false;
        $this->showFormModal = true;
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

        $this->isEditing = true;
        $this->showFormModal = true;
    }

    public function showDetail($menuId)
    {
        $this->selectedMenu = Menu::with(['listMenus.bahan.satuanKecil'])->findOrFail($menuId);
        $this->showModal = true;
    }

    public function delete($id)
    {
        $menu = Menu::findOrFail($id);
        $menu->listMenus()->delete();
        $menu->delete();

        $this->dispatch('toast', [
            ['type' => 'success', 'message' => 'Menu berhasil dihapus.']
        ]);
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

        $menu->listMenus()->delete();
        foreach ($this->form['bahanList'] as $bahan) {
            $menu->listMenus()->create([
                'bahan_id' => $bahan['bahan_id'],
                'jumlah' => $bahan['jumlah'],
            ]);
        }

        $this->dispatch('toast', [
            ['type' => 'success', 'message' => 'Menu berhasil disimpan.']
        ]);

        $this->showFormModal = false;
        $this->resetForm();
    }

    public function addBahan()
    {
        $this->form['bahanList'][] = ['bahan_id' => '', 'jumlah' => 1];
    }

    public function removeBahan($index)
    {
        unset($this->form['bahanList'][$index]);
        $this->form['bahanList'] = array_values($this->form['bahanList']);
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

    public function render()
    {
        $menus = Menu::where('nama', 'like', '%' . $this->search . '%')
            ->orderBy('nama')
            ->paginate($this->perPage);

        return view('livewire.list-menu', compact('menus'));
    }
}
