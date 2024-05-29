<?php

namespace App\Livewire;

use Carbon\Carbon;
use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Game;

class GamesTable extends Component
{
    use WithPagination;

    public $roster;
    public $search = '';
    public $sortField = 'start_date';
    public $sortAsc = true;
    public $showFinishedGames = false;
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

    public function toggleShowFinishedGames()
    {
        $this->showFinishedGames = !$this->showFinishedGames;
    }

    public function toggleDropdown()
    {
        $this->isDropdownOpen = !$this->isDropdownOpen;
    }

    public function render()
    {
        $gamesQuery = Game::where('roster_id', $this->roster->id)
            ->orderBy($this->sortField, $this->sortAsc ? 'asc' : 'desc');

        if (!$this->showFinishedGames) {
            $gamesQuery->whereDate('end_date', '>=', Carbon::now());
        }

        if (!empty($this->selectedNames)) {
            $gamesQuery->whereIn('comp_name', $this->selectedNames);
        }

        $games = $gamesQuery->paginate(10);

        // Get distinct competition names
        $competitions = Game::distinct()
            ->where('roster_id', $this->roster->id)
            ->pluck('comp_name');

        return view('livewire.games-table', [
            'games' => $games,
            'competitions' => $competitions,
        ]);
    }
}
