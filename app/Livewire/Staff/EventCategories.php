<?php

namespace App\Livewire\Staff;

use App\Custom\GoogleUpload;
use App\Models\EventCategory;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

class EventCategories extends Component
{
    use WithPagination, LivewireAlert,WithFileUploads;

    public $showEditForm=false;
    public $showAddForm = false;

    public $name;
    public $description;
    public $status;
    public $photo;
    public $editingId;
    public $staff;
    public $show = 10;

    protected $listeners = [
        'submitted' => 'render',
    ];
    public function mount()
    {
        $this->staff = Auth::guard('staff')->user();
    }

    public function toggleAddService()
    {
        $this->showEditForm=false;
        $this->showAddForm=true;
    }

    public function toggleEditService($id)
    {
        $service = EventCategory::where('id',$id)->first();
        $this->name = $service->name;
        $this->description = $service->description;
        $this->status = $service->status;

        $this->showAddForm = false;
        $this->showEditForm=true;
        $this->editingId = $id;
    }
    public function toggleDeleteService($id)
    {
        $this->editingId = $id;
    }

    public function resetForm()
    {
        $this->reset(['name','description','status','photo','editingId']);
        $this->cancelAction();
    }

    public function cancelAction()
    {
        $this->showAddForm = false;
        $this->showEditForm = false;
    }

    public function submitNewServiceType()
    {
        $staff = Auth::guard('staff')->user();

        if (!$staff->can('create ServiceType')) {
            $this->alert('error', '', [
                'position' => 'top-end',
                'timer' => 5000,
                'toast' => true,
                'text' => 'You do not have permission to perform this action.',
                'width' => '400',
            ]);
            return;
        }
        $this->validate([
            'name'=>['required','string','max:255','unique:event_categories,name'],
            'description'=>['required','string'],
            'status'=>['required','numeric','in:1,2'],
            'photo'=>['required','image','max:1024']
        ]);

        try {
            $google = new GoogleUpload();
            //we will upload file
            if (!$this->photo){
                $this->alert('error', '', [
                    'position' => 'top-end',
                    'timer' => 5000,
                    'toast' => true,
                    'text' => 'Category photo is mandatory',
                    'width' => '400',
                ]);
                return;
            }
            $imageResultFront = $google->uploadGoogle($this->photo);
            $photo = $imageResultFront['link'];

            $serviceTypes = EventCategory::create([
                'name' => $this->name,'description' => $this->description,
                'status' => $this->status,'image' => $photo
            ]);
            if (!empty($serviceTypes)){
                $this->alert('success', '', [
                    'position' => 'top-end',
                    'timer' => 5000,
                    'toast' => true,
                    'text' => 'Event Category added successfully.',
                    'width' => '400',
                ]);
                $this->dispatch('submitted');
                $this->resetForm();
                return;
            }

        }catch (\Exception $exception){
            Log::info('An error occurred while adding event category: '.$exception->getMessage());
            $this->alert('error', '', [
                'position' => 'top-end',
                'timer' => 5000,
                'toast' => true,
                'text' => 'An error occurred.',
                'width' => '400',
            ]);
            return;
        }
    }

    public function submitUpdateServiceType()
    {
        $staff = Auth::guard('staff')->user();

        if (!$staff->can('update ServiceType')) {
            $this->alert('error', '', [
                'position' => 'top-end',
                'timer' => 5000,
                'toast' => true,
                'text' => 'You do not have permission to perform this action.',
                'width' => '400',
            ]);
            return;
        }
        $this->validate([
            'name'=>['required','string','max:255',Rule::unique('event_categories','name')->ignore($this->editingId)],
            'description'=>['required','string'],
            'status'=>['required','numeric','in:1,2'],
            'photo'=>['nullable','image','max:1024']
        ]);

        try {

            $service = EventCategory::where('id',$this->editingId)->first();

            $google = new GoogleUpload();
            //we will upload file
            if (!$this->photo){
                $photo = $service->image;
            }else{
                $imageResultFront = $google->uploadGoogle($this->photo);
                $photo = $imageResultFront['link'];
            }

            $updated = EventCategory::where('id',$service->id)->update([
                'name' => $this->name,'description' => $this->description,
                'status' => $this->status,'image' => $photo
            ]);
            if ($updated){
                $this->alert('success', '', [
                    'position' => 'top-end',
                    'timer' => 5000,
                    'toast' => true,
                    'text' => 'Event Category updated successfully.',
                    'width' => '400',
                ]);
                $this->dispatch('submitted');
                $this->resetForm();
                return;
            }

        }catch (\Exception $exception){
            Log::info('An error occurred while adding event category: '.$exception->getMessage());
            $this->alert('error', '', [
                'position' => 'top-end',
                'timer' => 5000,
                'toast' => true,
                'text' => 'An error occurred.',
                'width' => '400',
            ]);
            return;
        }
    }
    public function render()
    {
        return view('livewire.staff.event-categories',[
            'serviceTypes' => EventCategory::paginate($this->show)
        ]);
    }
}
