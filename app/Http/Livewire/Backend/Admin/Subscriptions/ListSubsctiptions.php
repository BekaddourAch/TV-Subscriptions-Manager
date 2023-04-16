<?php

namespace App\Http\Livewire\Backend\Admin\Subscriptions;
use App\Models\Customer;
use App\Models\Service;
use App\Models\Subscription;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator; 
use Livewire\WithFileUploads;
use Livewire\WithPagination;
use Maatwebsite\Excel\Facades\Excel;
use PhpOffice\PhpSpreadsheet\Writer\Pdf;
use Livewire\Component;

class ListSubsctiptions extends Component
{
    use WithFileUploads;

    use WithPagination;
    
    public $sortColumnName = 'id_subscription';

    public $selectPageRows = false;


    public $excelFile = Null;

    public $importTypevalue = 'addNew';
    public $selectedRows = [];
    public $sortDirection = 'asc';
    protected $paginationTheme = 'bootstrap';

    public $data = [];

    public $subscription;

    public $showEditModal = false;

    public $subscriptionIdBeingRemoved = null;

    protected $listeners = ['deleteConfirmed' => 'deleteSubscriptions'];


    protected $subscriptionCount = Null;
    protected $roleSubscriptionCount = Null;
    protected $roleAdminCount = Null;
    protected $roleSuperadminCount = Null;


    public $searchTerm = null;
    protected $queryString = ['searchTerm' => ['except' => '']];

    public function updatedSelectPageRows($value)
    {
        if (Auth::user()->hasPermission('subscription-update')) {
        if ($value) {
            $this->selectedRows = $this->subscriptions->pluck('id_subscription')->map(function ($id) {
                return (string) $id;
            });
        } else {
            $this->reset(['selectedRows', 'selectPageRows']);
        }
    }
    }


    // set All selected Service As Active

    public function setAllAsActive()
    {
        if (Auth::user()->hasPermission('subscription-update')) {
        Subscription::whereIn('id_subscription', $this->selectedRows)->update(['active' => 1]);

        $this->dispatchBrowserEvent('swal', [
            'title'             => 'Les Subscriptions ont défini comme actif avec succès.',
            'icon'              =>'success',
            'iconColor'         => 'green',
            'position'          => 'center',
            'timer'             => '1700',
        ]);

        $this->reset(['selectPageRows', 'selectedRows']);
    }
    }

    // set All selected Service As InActive

    public function setAllAsInActive()
    {
        if (Auth::user()->hasPermission('subscription-update')) {
        Subscription::whereIn('id_subscription', $this->selectedRows)->update(['active' => 0]);

        $this->dispatchBrowserEvent('swal', [
            'title'             => 'Les Subscriptions ont défini comme inactif avec succès.',
            'icon'              =>'success',
            'iconColor'         => 'green',
            'position'          => 'center',
            'timer'             => '1700',
        ]);

        $this->reset(['selectPageRows', 'selectedRows']);
    }
    }

    // show Sweetalert Confirmation for Delete

    public function deleteSelectedRows()
    {
        if (Auth::user()->hasPermission('subscription-delete')) {
        $this->dispatchBrowserEvent('show-delete-alert-confirmation');
        }
    }
    public function deleteSubscriptions()
    {

        if (Auth::user()->hasPermission('subscription-delete')) {
        // delete selected users from database
        Subscription::whereIn('id_subscription', $this->selectedRows)->delete();

        $this->dispatchBrowserEvent('swal', [
            'title'             => 'All selected Subscriptions got deleted.',
            'icon'              =>'success',
            'iconColor'         => 'green',
            'position'          => 'center',
            'timer'             => '1700',
        ]);

        $this->reset();
    }
    }

    public function addNewSubscription()
    {
        if (Auth::user()->hasPermission('subscription-create')) {
        $this->reset();
        $this->showEditModal = false;
         $this->dispatchBrowserEvent('post-show-form');
        $this->dispatchBrowserEvent('show-form');
        }
    }

    public function createSubscription()
    {
        if (Auth::user()->hasPermission('subscription-create')) {
       
        $validatedData = Validator::make($this->data, [
            'id_customer' => 'required',
            'id_service' => 'required',
            'cost_price' => 'required',
            'quantity' => 'required',
            'selling_price' => 'required',
            'begin_date' => 'required',
            'end_date' => 'required',
            'total' => '',
            'notes' => '',
        ])->validate();


        $validatedData['id_user']=auth()->id();
        
        $validatedData['total']=$validatedData['selling_price']*$validatedData['quantity'];

        Subscription::create($validatedData);
        $this->dispatchBrowserEvent('hide-form');

        $this->dispatchBrowserEvent('swal', [
            'title' => 'Service Added Successfully.',
            'icon'=>'success',
            'iconColor' => 'green',
            'position' => 'center',
            'timer' => '1700',
        ]);
        $this->dispatchBrowserEvent('post-show-form');
    }
    }

    public function edit(Subscription $subscription)
    {
        if (Auth::user()->hasPermission('subscription-update')) {
        $this->reset();

        $this->showEditModal = true;

        $this->data = $subscription->toArray();

        $this->subscription = $subscription;

        $this->dispatchBrowserEvent('post-show-form');
        $this->dispatchBrowserEvent('show-form');
        }
    }
    public function updateSubscription()
    {
        if (Auth::user()->hasPermission('subscription-update')) {
        try {
            $validatedData = Validator::make($this->data, [
                'id_customer' => 'required',
                'id_service' => 'required',
                'cost_price' => 'required',
                'quantity' => 'required',
                'selling_price' => 'required',
                'begin_date' => 'required',
                'end_date' => 'required',
                'total' => '',
                'notes' => '',
            ])->validate();


            $validatedData['id_user']=auth()->id();
        
            $validatedData['total']=$validatedData['selling_price']*$validatedData['quantity'];
    
            $this->subscription->update($validatedData);

            $this->dispatchBrowserEvent('hide-form');

            $this->dispatchBrowserEvent('swal', [
                'title'         => 'Service updated Successfully.',
                'icon'          =>'success',
                'iconColor'     => 'green',
                'position'      => 'center',
                'timer'         => '1700',
            ]);

        } catch (\Throwable $th) {
            return $th->getMessage();
        }
    }
    }


    // Show Modal Form to Confirm Service Removal

    public function confirmSubscriptionRemoval($subscriptionId)
    {
        if (Auth::user()->hasPermission('subscription-delete')) {
        $this->subscriptionIdBeingRemoved = $subscriptionId;

        $this->dispatchBrowserEvent('show-delete-modal');
        }
    }

    // Delete Subscription

    public function deleteSubscription()
    {
        if (Auth::user()->hasPermission('subscription-delete')) {
        $subscription = Subscription::findOrFail($this->subscriptionIdBeingRemoved);

        $subscription->delete();

        $this->dispatchBrowserEvent('hide-delete-modal');

        $this->dispatchBrowserEvent('swal', [
            'title' => 'Service Deleted Successfully.',
            'icon'=>'success',
            'iconColor' => 'green',
            'position' => 'center',
            'timer' => '1700',
        ]);
    }
    }
    public function getSubscriptionsProperty()
    {

        $subscriptions = Subscription::query()
            // ->where('name', 'like', '%'.$this->searchTerm.'%')
            // ->orWhere('description', 'like', '%'.$this->searchTerm.'%')
            ->orderBy($this->sortColumnName, $this->sortDirection)
            ->paginate(15);

        return $subscriptions;
    }

    // Export Excel File

    public function exportExcel()
    {
        return Excel::download(new ServiceExport($this->searchTerm,$this->selectedRows), 'Subscriptions.xlsx');
    }

    // Show Import Excel Form

    public function importExcelForm()
    {
        $this->reset();
        $this->dispatchBrowserEvent('show-import-excel-modal');
    }

    public function importType($value)
    {
        $this->importTypevalue = $value;
    }

    public function importExcel()
    {
        try {

            $this->validate([
                'excelFile' => 'mimes:xls,xlsx'
            ]);

            if ($this->importTypevalue == 'addNew') {
                // for add new data
                Excel::import(new SubscriptionImport, $this->excelFile);
            } else {
                // for update data
                $this->importTypevalue = 'Update';
                $subscriptionData = Excel::toCollection(new SubscriptionImport(), $this->excelFile);
                foreach ($subscriptionData[0] as $subscription) {
                    Subscription::where('id_subscription', $subscription['id_subscription'])->update([
                        'name' => $subscription['name'],
                        'description' => $subscription['description'],
                        'cost_price' => $subscription['cost_price'],
                        'selling_price' => $subscription['selling_price'],
                        'duration' => $subscription['duration'],
                        'duration_unit' => $subscription['duration_unit'],
                        'active' => $subscription['active'],
                        'notes' => $subscription['notes'],
                    ]);
                }
            }


            $this->dispatchBrowserEvent('swal', [
                'title' => 'Subscriptions ajoutés avec succès.',
                'icon'=>'success',
                'iconColor' => 'green',
                'position' => 'center',
                'timer' => '1700',
            ]);

            $this->dispatchBrowserEvent('hide-import-excel-modal');


        } catch (\Exception $e) {
            //return $e->getMessage();
            $this->dispatchBrowserEvent('swal', [
                'title' =>  'ملف الإكسل غير مطابق !!',
                'icon'=>'error',
                'iconColor' => 'red',
                'position' => 'center',
                'timer' => '1700',
            ]);

            $this->reset();
            $this->dispatchBrowserEvent('hide-import-excel-modal');
        }
    }

    // Export PDF File

    public function exportPDF()
    {
        return response()->streamDownload(function(){
            if ($this->selectedRows) {
                $subscription = Subscription::whereIn('id_subscription', $this->selectedRows)->orderBy('id_subscription', 'asc')->get();
            } else {
                $subscription = $this->subscription;
            }

            $pdf = Pdf::loadView('livewire.backend.admin.service.pdf',['service' => $subscription]);
            return $pdf->stream('service');

        },'service.pdf');
    }
    public function render()
    {
        $subscriptionsCount= Subscription::count();
        $subscriptions = $this->subscriptions; 
        return view('livewire.backend.admin.subscriptions.list-subsctiptions',[
            'subscriptions' => $subscriptions,
            'subscriptionsCount' => $subscriptionsCount,
            'durationUnits' => Service::getDurationUnits(),
            'customers' => Customer::all(),
            'services' => Service::all(),
        ])->layout('layouts.admin');
    }
}