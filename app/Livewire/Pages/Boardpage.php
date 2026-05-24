<?php

namespace App\Livewire\Pages;

use App\Models\Board;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Attributes\On;
use Livewire\Component;


#[Layout('layouts.app')]
class Boardpage extends Component
{
    public Board $board;
    public $user;

    // تعریف یک پراپرتی برای نگهداری اطلاعات ممبر لود شده
    protected $currentBoardMember;

    public function boot(){
        $user = Auth::user();

        if ($this->board && $this->board->owner_id !== $user->id) {
            // کوئری را اینجا می‌زنیم و نتیجه را در یک پراپرتی ذخیره می‌کنیم
            $this->currentBoardMember = $this->board->users()
                        ->where('user_id', $user->id)
                        ->first();

            if (!$this->currentBoardMember || $this->currentBoardMember->pivot->status !== 'accepted') {
                $this->redirect(route('index'));
            }
        }
    }

    public function mount(Board $board)
    {
        if ($board->is_archive){
            abort(404);
        }

        $this->board = $board;
    }

    public function render()
    {
        // تعیین نقش کاربر بدون اجرای کوئری مجدد
        $userRole = null;

        if ($this->board->owner_id === Auth::id()) {
            $userRole = 'owner'; // اگر صاحب بورد بود مستقیم ست شود
        } elseif ($this->currentBoardMember) {
            $userRole = $this->currentBoardMember->pivot->role; // استفاده از داده کش شده در متد boot
        }

        return view('livewire.pages.boardpage',[
            'board' => $this->board,
            'userRole'  => $userRole
        ])->title($this->board->title);
    }
}
