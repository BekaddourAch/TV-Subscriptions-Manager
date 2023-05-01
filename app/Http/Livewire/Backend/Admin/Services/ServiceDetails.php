<?php

namespace App\Http\Livewire\Backend\Admin\Services;

use App\Models\Customer;
use App\Models\Service;
use App\Models\Subscription;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Livewire\Component;
use Livewire\WithPagination;

class ServiceDetails extends Component
{

    use WithPagination;

    public $sortColumnName = 'id_service';

    public $selectPageRows = false;



    public $selectedRows = [];
    public $sortDirection = 'asc';
    protected $paginationTheme = 'bootstrap';

    public $data = [];

    public $service;

    public $showEditModal = false;

    public $serviceIdBeingRemoved = null;

    protected $listeners = ['deleteConfirmed' => 'deleteServices'];
    public $serviceId;

    protected $ServiceCount = Null;
    protected $roleServiceCount = Null;
    protected $roleAdminCount = Null;
    protected $roleSuperadminCount = Null;


    public $searchTerm = null;
    protected $queryString = ['searchTerm' => ['except' => '']];

    public function updatedSelectPageRows($value)
    {
        if (Auth::user()->hasPermission('services-update')) {
            if ($value) {
                $this->selectedRows = $this->services->pluck('id_service')->map(function ($id) {
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
        if (Auth::user()->hasPermission('services-update')) {
            Service::whereIn('id_service', $this->selectedRows)->update(['active' => 1]);

            $this->dispatchBrowserEvent('swal', [
                'title'             => 'Les services ont défini comme actif avec succès.',
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
        if (Auth::user()->hasPermission('services-update')) {
            Service::whereIn('id_service', $this->selectedRows)->update(['active' => 0]);

            $this->dispatchBrowserEvent('swal', [
                'title'             => 'Les services ont défini comme inactif avec succès.',
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
        if (Auth::user()->hasPermission('services-delete')) {
            $this->dispatchBrowserEvent('show-delete-alert-confirmation');
        }
    }
    public function deleteServices()
    {

        if (Auth::user()->hasPermission('services-delete')) {
            // delete selected users from database
            Service::whereIn('id_service', $this->selectedRows)->delete();

            $this->dispatchBrowserEvent('swal', [
                'title'             => 'All selected services got deleted.',
                'icon'              =>'success',
                'iconColor'         => 'green',
                'position'          => 'center',
                'timer'             => '1700',
            ]);

            $this->reset();
        }
    }


    public function edit(Service $service)
    {
        if (Auth::user()->hasPermission('services-update')) {
            $this->reset();

            $this->showEditModal = true;

            $this->data = $service->toArray();

            $this->service = $service;

            $this->dispatchBrowserEvent('show-form');
        }
    }
    public function updateService()
    {
        if (Auth::user()->hasPermission('services-update')) {
            try {
                $validatedData = Validator::make($this->data, [
                    'name' => 'required',
                    'description' => 'required',
                    'cost_price' => 'required',
                    'selling_price' => 'required',
                    'duration_unit' => 'required',
                    'duration' => 'required',
                    'active' => '',
                    'notes' => '',
                ])->validate();


                $this->service->update($validatedData);

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

    public function confirmServiceRemoval($serviceId)
    {
        if (Auth::user()->hasPermission('services-delete')) {
            $this->serviceIdBeingRemoved = $serviceId;

            $this->dispatchBrowserEvent('show-delete-modal');
        }
    }

    // Delete Service

    public function deleteService()
    {
        if (Auth::user()->hasPermission('services-delete')) {
            $service = Service::findOrFail($this->serviceIdBeingRemoved);

            $service->delete();

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
    public function getServicesProperty()
    {

        $services = Service::query()
            ->where('name', 'like', '%'.$this->searchTerm.'%')
            ->orWhere('description', 'like', '%'.$this->searchTerm.'%')
            ->orderBy($this->sortColumnName, $this->sortDirection)
            ->paginate(15);

        return $services;
    }
    public function mount($id){
        $this->serviceId = $id;
        $this->service= Service::findOrFail($this->serviceId);
        $this->data = $this->service->toArray();
    }
    public function render()
    {
        $servicesCount= Service::count();
        $services = $this->services;
        return view('livewire.backend.admin.services.service-details',[
            'services' => $services,
            'servicesCount' => $servicesCount,
            'durationUnits' => Service::getDurationUnits(),
            'subscriptions'=>$subscriptionsPerCustomer = Subscription::getSubscriptionsWithData(null,null,0,0,$this->serviceId)
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
