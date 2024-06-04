<?php

namespace App\Livewire;

use App\Models\Practice;
use Carbon\Carbon;
use Livewire\Component;
use Livewire\WithPagination;

class PracticeTable extends Component
{
    use WithPagination;

    public $roster;
    public $search = '';
    public $sortField = 'start_time';
    public $sortAsc = true;
    public $showFinishedPractice = false;
    public $selectedNames = [];
    public $isDropdownOpen = false;

    public function mount($roster)
    {
        $this->roster = $roster;
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updateSelectedNames()
    {
        $this->resetPage();
    }

    public function sortBy($field)
    {
        if ($this->sortField === $field) {
            $this->sortAsc = !$this->sortAsc;
        } else {
            $this->sortAsc = true;
        }

        $this->sortField = $field;
    }

    public function toggleShowFinishedPractice()
    {
        $this->showFinishedPractice = !$this->showFinishedPractice;
    }

    public function toggleDropdown()
    {
        $this->isDropdownOpen = !$this->isDropdownOpen;
    }

    public function render()
    {
        $practiceQuery = Practice::where('roster_id', $this->roster->id)
            ->orderBy($this->sortField, $this->sortAsc ? 'asc' : 'desc');


        if (!$this->showFinishedPractice) {
            $practiceQuery->whereDate('end_time', '>=', Carbon::now());
        }

        $practices = $practiceQuery->paginate(10);

        return view('livewire.practice-table',[
            'practices' => $practices,
        ]);
    }
}
