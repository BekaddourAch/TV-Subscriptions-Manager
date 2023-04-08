<?php

namespace App\Http\Livewire\Backend\Admin\Customer;

use App\Exports\CustomerExport;
use App\Imports\CustomerImport;
use App\Models\Customer;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Livewire\Component;
use Livewire\WithPagination;
use Maatwebsite\Excel\Facades\Excel;
use PhpOffice\PhpSpreadsheet\Writer\Pdf; 

class ListCustomers extends Component
{ 
    // public $customers, $name, $email, $phone_number, $customer_id; 

    use WithPagination;

    public $sortColumnName = 'id';
  
	public $selectPageRows = false;


    public $excelFile = Null;

    public $importTypevalue = 'addNew';
    public $selectedRows = [];
    public $sortDirection = 'asc';
    protected $paginationTheme = 'bootstrap'; 

    public $data = [];

    public $customer;

	public $showEditModal = false;

	public $customerIdBeingRemoved = null;

    protected $listeners = ['deleteConfirmed' => 'deleteCustomers'];

    
    protected $CustomerCount = Null;
    protected $roleCustomerCount = Null;
    protected $roleAdminCount = Null;
    protected $roleSuperadminCount = Null;

    
    public $searchTerm = null; 
    protected $queryString = ['searchTerm' => ['except' => '']];

    public function updatedSelectPageRows($value)
	{
		if ($value) {
			$this->selectedRows = $this->customers->pluck('id')->map(function ($id) {
				return (string) $id;
			});
		} else {
			$this->reset(['selectedRows', 'selectPageRows']);
		}
	}


    // set All selected User As Active

    public function setAllAsActive()
	{
		Customer::whereIn('id', $this->selectedRows)->update(['active' => 1]);

        $this->dispatchBrowserEvent('swal', [
            'title'             => 'Les utilisateurs ont défini comme actif avec succès.',
            'icon'              =>'success',
            'iconColor'         => 'green',
            'position'          => 'center',
            'timer'             => '1700',
        ]);

		$this->reset(['selectPageRows', 'selectedRows']);
	}

    // set All selected User As InActive

	public function setAllAsInActive()
	{
		Customer::whereIn('id', $this->selectedRows)->update(['active' => 0]);

		$this->dispatchBrowserEvent('swal', [
            'title'             => 'Les utilisateurs ont défini comme inactif avec succès.',
            'icon'              =>'success',
            'iconColor'         => 'green',
            'position'          => 'center',
            'timer'             => '1700',
        ]);

		$this->reset(['selectPageRows', 'selectedRows']);
	}

    // show Sweetalert Confirmation for Delete

	public function deleteSelectedRows()
	{
        $this->dispatchBrowserEvent('show-delete-alert-confirmation');
	}
    public function deleteCustomers()
    {
          
        // delete selected users from database
		Customer::whereIn('id', $this->selectedRows)->delete();

        $this->dispatchBrowserEvent('swal', [
            'title'             => 'All selected users got deleted.',
            'icon'              =>'success',
            'iconColor'         => 'green',
            'position'          => 'center',
            'timer'             => '1700',
        ]);

		$this->reset();
    }

    public function addNewCustomer()
    {
        $this->reset(); 
        $this->showEditModal = false; 
        $this->dispatchBrowserEvent('show-form');
    }

    public function createCustomer()
    { 
        $validatedData = Validator::make($this->data, [ 
			'firstname' => 'required',
			'lastname' => 'required',
			'phone1' => 'required|regex:/[0-9]{10}/',
            'phone2' => 'regex:/(01)[0-9]{9}/', 
            'email' => 'email', 
            'address' => '', 
            'state' => '', 
            'city' => '',
            'active' => '', 
            'notes' => '', 
		])->validate();

        

        Customer::create($validatedData);

        $this->dispatchBrowserEvent('hide-form');

        $this->dispatchBrowserEvent('swal', [
            'title' => 'Client Added Successfully.',
            'icon'=>'success',
            'iconColor' => 'green',
            'position' => 'center',
            'timer' => '1700',
        ]);
    }

    public function edit(Customer $customer)
    {
        $this->reset();

		$this->showEditModal = true;

        $this->data = $customer->toArray();

		$this->customer = $customer;

		$this->dispatchBrowserEvent('show-form');
    }
    public function updateCustomer()
	{
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
                'title'         => 'Permission updated Successfully.',
                'icon'          =>'success',
                'iconColor'     => 'green',
                'position'      => 'center',
                'timer'         => '1700',
            ]);

        } catch (\Throwable $th) {
            return $th->getMessage();
        }
	}


    // Show Modal Form to Confirm Permission Removal

    public function confirmCustomerRemoval($customerId)
    {
        $this->customerIdBeingRemoved = $customerId;

        $this->dispatchBrowserEvent('show-delete-modal');
    }

    // Delete Permission

    public function deleteCustomer()
    {
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
    public function getCustomersProperty()
	{
		 
            $customers = Customer::query()
            ->where('firstname', 'like', '%'.$this->searchTerm.'%')
            ->orWhere('lastname', 'like', '%'.$this->searchTerm.'%')
            ->orWhere('phone1', 'like', '%'.$this->searchTerm.'%')
            ->orWhere('email', 'like', '%'.$this->searchTerm.'%')
            ->orderBy($this->sortColumnName, $this->sortDirection)
            ->paginate(15);
        
        return $customers;
	}
    
    // Export Excel File

    public function exportExcel()
    {
        return Excel::download(new CustomerExport($this->searchTerm,$this->selectedRows), 'customers.xlsx');
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
                Excel::import(new CustomerImport, $this->excelFile);
            } else {
                // for update data
                $this->importTypevalue = 'Update';
                $customerData = Excel::toCollection(new CustomerImport(), $this->excelFile);
                foreach ($customerData[0] as $customer) {
                    Customer::where('id', $customer['id'])->update([
                        'firstname' => $customer['firstname'],
                        'lastname' => $customer['lastname'],
                        'phone1' => $customer['phone1'],
                        'phone2' => $customer['phone2'], 
                        'email' => $customer['email'],
                        'address' => $customer['address'],
                        'state' => $customer['state'],
                        'active' => $customer['active'], 
                        'notes' => $customer['notes'], 
                    ]);
                }
            }

            // // method for add Roles to nwe users added

            // $usersDoesntHaveRole = Customer::whereDoesntHave('roles')->get();

            // foreach ($usersDoesntHaveRole as $user) {
            //     DB::table('role_user')->insert([
            //         'role_id' => 3,
            //         'user_id' => $user->id,
            //         'user_type' => 'App\Models\User'
            //     ]);
            // }

            // end method

            $this->dispatchBrowserEvent('swal', [
                'title' => 'Utilisateurs ajoutés avec succès.',
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
                $customer = Customer::whereIn('id', $this->selectedRows)->orderBy('id', 'asc')->get();
            } else {
                $customer = $this->customer;
            }

            $pdf = Pdf::loadView('livewire.backend.admin.customer.pdf',['customer' => $customer]);
            return $pdf->stream('customer');

        },'customer.pdf');
    }

    public function render()
    { 
        $customersCount= Customer::count();
       //  $customers = Customer::paginate(15); 
        $customers = $this->customers;
        return view('livewire.backend.admin.customer.list-customers',[
            'customers' => $customers,
            'customersCount' => $customersCount,
            ])->layout('layouts.admin');
    } 
}
