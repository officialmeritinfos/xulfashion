<?php

namespace App\Livewire\Staff\Staffs;

use App\Models\GeneralSetting;
use App\Models\SystemStaff;
use App\Models\SystemStaffAction;
use App\Notifications\StaffWelcomeMail;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Attributes\Url;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;
use Spatie\Permission\Models\Role;

class StaffList extends Component
{
    use  LivewireAlert, WithPagination,WithFileUploads;

    public $mainStaff;
    public $web;
    #[Url]
    public $search='';
    #[Url]
    public $status = 'all';
    #[Url]
    public $role;
    #[Url]
    public $show = 10;
    public $showAddStaff;
    public $showEditStaff;

    public $showStaffDetails;

    public $name;
    public $email;
    public $staffRole;
    public $password;
    public $password_confirmation;
    public $staffStatus;
    public $editingId;

    public function mount()
    {
        $this->mainStaff = Auth::guard('staff')->user();
        $this->web = GeneralSetting::find(1);
    }

    public function toggleShowAddStaff()
    {
        $this->showAddStaff = true;
    }
    public function toggleShowEditStaff($id)
    {
        //check if the logged in staff can edit staff
        $staff = SystemStaff::where('id',$id)->first();
        if (empty($staff)){
            $this->alert('error', '', [
                'position' => 'top-end',
                'timer' => 5000,
                'toast' => true,
                'text' => 'Staff not found',
                'width' => '400'
            ]);
            return;
        }
        if (!$this->mainStaff->can('update SystemStaff')) {
            $this->alert('error', '', [
                'position' => 'top-end',
                'timer' => 5000,
                'toast' => true,
                'text' => 'You do not have permission to edit this staff.',
                'width' => '400',
            ]);
            return;
        }

        if ($staff->role=='superadmin' && !$this->mainStaff->can('update SuperAdmin')){
            $this->alert('error', '', [
                'position' => 'top-end',
                'timer' => 5000,
                'toast' => true,
                'text' => 'You do not have permission to edit this department level',
                'width' => '400',
            ]);
            return;
        }

        if ($staff->role=='admin' && !$this->mainStaff->can('update Admin')){
            $this->alert('error', '', [
                'position' => 'top-end',
                'timer' => 5000,
                'toast' => true,
                'text' => 'You do not have permission to edit this department level',
                'width' => '400',
            ]);
            return;
        }

        $this->name = $staff->name;
        $this->email = $staff->email;
        $this->staffRole = $staff->role;
        $this->staffStatus = $staff->status;
        $this->editingId = $staff->id;

        $this->showEditStaff = true;
    }
    public function toggleShowStaffDetail($id)
    {
        $this->showStaffDetails = true;
    }

    public function resetForm()
    {
        $this->showAddStaff =false;
        $this->showEditStaff = false;
        $this->showStaffDetails = false;

        $this->reset([
            'name','email','editingId','password','password_confirmation','staffRole','staffStatus'
        ]);
    }

    public function submitNewStaff(Request $request)
    {
        $this->validate([
            'name'        =>['required','string','max:150'],
            'email'       =>['required','email','unique:system_staff,email'],
            'staffRole'   =>['required','string','max:100',Rule::exists('roles','name')->where('guard_name','staff')],
            'password'    =>['required','string','confirmed','min:8'],
            'password_confirmation'    =>['required','string','min:8'],
        ]);
        if (!$this->mainStaff->can('create SystemStaff')) {
            $this->alert('error', '', [
                'position' => 'top-end',
                'timer' => 5000,
                'toast' => true,
                'text' => 'You do not have permission to add this staff.',
                'width' => '400',
            ]);
            return;
        }
        DB::beginTransaction();
        try {
            $staff = SystemStaff::create([
                'name'=>$this->name,'email' => $this->email,'password' => bcrypt($this->password),
                'setPin' => 2,'twoFactor' => 1,'status' => 1,'hasUpdatedPassword' => 2,
                'role' => $this->staffRole
            ]);

            if (!empty($staff)){
                $staff->notify(new StaffWelcomeMail($staff,$this->web));
                //create staff action
                SystemStaffAction::create([
                    'staff'         =>$staff->id,
                    'action'        =>'Staff Onboarding',
                    'isSuper'       =>$staff->role=='superadmin'?1:2,
                    'model'         =>get_class($staff),
                    'model_id'      =>$staff->id
                ]);
                //send a welcome mail to the merchant
                $this->alert('success', '', [
                    'position' => 'top-end',
                    'timer' => 5000,
                    'toast' => true,
                    'text' => 'Staff created successfully.',
                    'width' => '400'
                ]);
                DB::commit();

                $this->resetForm();
                return;
            }

        }catch (\Exception $exception){
            DB::rollBack();
            $this->alert('error', '', [
                'position' => 'top-end',
                'timer' => 5000,
                'toast' => true,
                'text' => 'An error occurred while onboarding the staff.',
                'width' => '400',
            ]);
            Log::error('Error onboarding staff: ' . $exception->getMessage());
        }
    }
    public function render()
    {
        $staffs = SystemStaff::query()
            ->when($this->search, function($query) {
                $query->where('email', 'like', '%' . $this->search . '%')
                    ->orWhere('name', 'like', '%' . $this->search . '%');
            })
            ->when($this->status != 'all', function($query) {
                $query->where('status', $this->status);
            })
            ->when($this->role,function ($query){
                $query->where('role',$this->role);
            })->when($this->mainStaff->role!='superadmin', function ($query) {
                $query->whereNot('role','superadmin');
                $query->whereNot('role','admin');
        })->latest()->paginate($this->show);

        return view('livewire.staff.staffs.staff-list',[
            'staffs'       => $staffs,
            'roles'        =>Role::where('guard_name','staff')->get()
        ]);
    }

    public function submitUpdate()
    {
        $this->validate([
            'name'        =>['required','string','max:150'],
            'email'       =>['required','email',Rule::unique('system_staff','email')->ignore($this->editingId)],
            'staffRole'   =>['required','string','max:100',Rule::exists('roles','name')->where('guard_name','staff')],
            'staffStatus' =>['required','numeric','in:1,2']
        ]);

        $staff = SystemStaff::where('id',$this->editingId)->first();
        if (empty($staff)){
            $this->alert('error', '', [
                'position' => 'top-end',
                'timer' => 5000,
                'toast' => true,
                'text' => 'Staff not found',
                'width' => '400'
            ]);
            return;
        }
        if (!$this->mainStaff->can('update SystemStaff')) {
            $this->alert('error', '', [
                'position' => 'top-end',
                'timer' => 5000,
                'toast' => true,
                'text' => 'You do not have permission to edit this staff.',
                'width' => '400',
            ]);
            return;
        }

        if ($staff->role=='superadmin' && !$this->mainStaff->can('update SuperAdmin')){
            $this->alert('error', '', [
                'position' => 'top-end',
                'timer' => 5000,
                'toast' => true,
                'text' => 'You do not have permission to edit this department level',
                'width' => '400',
            ]);
            return;
        }

        if ($staff->role=='admin' && !$this->mainStaff->can('update Admin')){
            $this->alert('error', '', [
                'position' => 'top-end',
                'timer' => 5000,
                'toast' => true,
                'text' => 'You do not have permission to edit this department level',
                'width' => '400',
            ]);
            return;
        }
        DB::beginTransaction();
        try {
            $updated = SystemStaff::where('id',$this->editingId)->update([
                'name'=>$this->name,'email' => $this->email,'status' => $this->staffStatus,
                'role' => $this->staffRole
            ]);

            if ($updated){
                //create staff action
                SystemStaffAction::create([
                    'staff'         =>$staff->id,
                    'action'        =>'Staff Update',
                    'isSuper'       =>$staff->role=='superadmin'?1:2,
                    'model'         =>get_class($staff),
                    'model_id'      =>$staff->id
                ]);
                //send a welcome mail to the merchant
                $this->alert('success', '', [
                    'position' => 'top-end',
                    'timer' => 5000,
                    'toast' => true,
                    'text' => 'Staff updated successfully.',
                    'width' => '400'
                ]);
                DB::commit();
                $this->resetForm();
                return;
            }

        }catch (\Exception $exception){
            DB::rollBack();
            $this->alert('error', '', [
                'position' => 'top-end',
                'timer' => 5000,
                'toast' => true,
                'text' => 'An error occurred while updating the staff.',
                'width' => '400',
            ]);
            Log::error('Error updating staff: ' . $exception->getMessage());
        }
    }
}
