<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Barang;

class Barangs extends Component
{
    public $barangs, $name_brng, $merek, $stok, $barang_id;
    public $isModal = 0;


    public function render()
    {
        $this->barangs = Barang::orderBy('created_at', 'DESC')->get();
        return view('livewire.barangs');
    }

    public function create()
    {
        $this->resetFields();
        $this->openModal();
    }

    public function closeModal()
    {
        $this->isModal = false;
    }

    public function openModal()
    {
        $this->isModal = true;
    }

    public function resetFields()
    {
        $this->name_brng = '';
        $this->merek = '';
        $this->dtok = '';

        $this->barang_id = '';
    }

    public function store()
    {
        $this->validate([
            'name_brng' => 'required|string',
            'merek' => 'required|string',
            'stok' => 'required|string'
        ]);

        Barang::updateOrCreate(['id' => $this->barang_id], [
            'name_brng' => $this->name_brng,
            'merek' => $this->merek,
            'stok' => $this->stok,
        ]);

        session()->flash('message', $this->barang_id ? $this->name_brng . ' Diperbaharui' : $this->name_brng . ' Ditambahkan');
        $this->closeModal();
        $this->resetFields();
    }

    public function edit($id)
    {
        $barang = Barang::find($id);
        $this->barang_id = $id;
        $this->name_brng = $barang->name_brng;
        $this->merek = $barang->merek;
        $this->stok = $barang->stok;

        $this->openModal();
    }

    public function delete($id)
    {
        $barang = Barang::find($id);
        $barang->delete();
        session()->flash('message', $barang->name_brng . ' Dihapus');
    }
}
