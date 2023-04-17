<?php

namespace App\Http\Livewire\Backend\Admin\Customer;

use App\Models\Customer;
use App\Models\Subscription;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Livewire\Component;
use Livewire\WithPagination;
use Maatwebsite\Excel\Facades\Excel;
use PhpOffice\PhpSpreadsheet\Writer\Pdf;

class CustomerDetails extends Component
{
    // public $customers, $name, $email, $phone_number, $customer_id;

    use WithPagination;

    public $sortColumnName = 'id_customer';

	public $selectPageRows = false;


    public $selectedRows = [];
    public $sortDirection = 'asc';
    protected $paginationTheme = 'bootstrap';

    public $data = [];

    public $customer;
    public $customerId;

    protected $listeners = ['deleteConfirmed' => 'deleteCustomers'];


    protected $subscriptionsCount = Null;


    public $searchTerm = null;
    protected $queryString = ['searchTerm' => ['except' => '']];

    public function updatedSelectPageRows($value)
	{
        if (Auth::user()->hasPermission('customers-update')) {
		if ($value) {
			$this->selectedRows = $this->customers->pluck('id_customer')->map(function ($id) {
				return (string) $id;
			});
		} else {
			$this->reset(['selectedRows', 'selectPageRows']);
		}
    }
	}

	public function deleteSelectedRows()
	{
        if (Auth::user()->hasPermission('customers-delete')) {
        $this->dispatchBrowserEvent('show-delete-alert-confirmation');
        }
	}
    public function deleteCustomers()
    {

        if (Auth::user()->hasPermission('customers-delete')) {
        // delete selected users from database
		Customer::whereIn('id_customer', $this->selectedRows)->delete();

        $this->dispatchBrowserEvent('swal', [
            'title'             => 'All selected users got deleted.',
            'icon'              =>'success',
            'iconColor'         => 'green',
            'position'          => 'center',
            'timer'             => '1700',
        ]);
		$this->reset();
        }
    }

    public function edit(Customer $customer)
    {
        if (Auth::user()->hasPermission('customers-update')) {
        $this->reset();

		$this->showEditModal = true;

        $this->data = $customer->toArray();

		$this->customer = $customer;

		$this->dispatchBrowserEvent('show-form');
        }
    }

    public function updateCustomer()
	{
        if (Auth::user()->hasPermission('customers-update')) {
        try {
            $validatedData = Validator::make($this->data, [
                'firstname' => 'required',
                'lastname' => 'required',
                'phone1' => 'required',
                'phone2' => '',
                'email' => '',
                'address' => '',
                'state' => '',
                'city' => '',
                'active' => '',
                'notes' => '',
            ])->validate();


            $this->customer->update($validatedData);

            $this->dispatchBrowserEvent('hide-form');

            $this->dispatchBrowserEvent('swal', [
                'title'         => 'Client Modifié avec succès.',
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


    public function confirmCustomerRemoval($customerId)
    {
        if (Auth::user()->hasPermission('customers-delete')) {
        $this->customerIdBeingRemoved = $customerId;

        $this->dispatchBrowserEvent('show-delete-modal');
        }
    }

    // Delete Permission

    public function deleteCustomer()
    {
        if (Auth::user()->hasPermission('customers-delete')) {
        $customer = Customer::findOrFail($this->customerIdBeingRemoved);

        $customer->delete();

        $this->dispatchBrowserEvent('hide-delete-modal');

        $this->dispatchBrowserEvent('swal', [
            'title' => 'Permission Deleted Successfully.',
            'icon'=>'success',
            'iconColor' => 'green',
            'position' => 'center',
            'timer' => '1700',
        ]);
    }
    }
    public function getCustomersProperty()
	{

            $customers = Customer::query()
            ->where('firstname', 'like', '%'.$this->searchTerm.'%')
            ->orWhere('lastname', 'like', '%'.$this->searchTerm.'%')
            ->orWhere('phone1', 'like', '%'.$this->searchTerm.'%')
            ->orWhere('email', 'like', '%'.$this->searchTerm.'%')
            ->orderBy($this->sortColumnName, $this->sortDirection)
            ->paginate(10)->onEachSide(0);

        return $customers;
	}

    public function mount($id){
        $this->customerId = $id;
        $this->customer= Customer::findOrFail($this->customerId);
        $this->data = $this->customer->toArray();
    }

    public function render()
    {

        $subscriptionsPerCustomer = Subscription::getSubscriptionsWithData(null,null,0,$this->customerId);
        return view('livewire.backend.admin.customer.customer-details',[
            'subscriptions' => $subscriptionsPerCustomer,
        ])->layout('layouts.admin');
    }


    // Sort By Column Name

    public function sortBy($columnName)
    {
        if ($this->sortColumnName === $columnName) {
            $this->sortDirection = $this->swapSortDirection();
        } else {
            $this->sortDirection = 'asc';
        }

        $this->sortColumnName = $columnName;

    }

    // Swap Sort Direction

    public function swapSortDirection()
    {
        return $this->sortDirection === 'asc' ? 'desc' : 'asc';
    }

}
