<?php

namespace App\Http\Livewire\Backend\Admin\Services;

use App\Exports\ServiceExport;
use App\Imports\ServiceImport;
use App\Models\Service;
use Illuminate\Support\Facades\Validator;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;
use Maatwebsite\Excel\Facades\Excel;
use PhpOffice\PhpSpreadsheet\Writer\Pdf;

class ListServices extends Component
{

    use WithFileUploads;

    use WithPagination;

    public $sortColumnName = 'id';

    public $selectPageRows = false;


    public $excelFile = Null;

    public $importTypevalue = 'addNew';
    public $selectedRows = [];
    public $sortDirection = 'asc';
    protected $paginationTheme = 'bootstrap';

    public $data = [];

    public $service;

    public $showEditModal = false;

    public $serviceIdBeingRemoved = null;

    protected $listeners = ['deleteConfirmed' => 'deleteServices'];


    protected $ServiceCount = Null;
    protected $roleServiceCount = Null;
    protected $roleAdminCount = Null;
    protected $roleSuperadminCount = Null;


    public $searchTerm = null;
    protected $queryString = ['searchTerm' => ['except' => '']];

    public function updatedSelectPageRows($value)
    {
        if ($value) {
            $this->selectedRows = $this->services->pluck('id')->map(function ($id) {
                return (string) $id;
            });
        } else {
            $this->reset(['selectedRows', 'selectPageRows']);
        }
    }


    // set All selected Service As Active

    public function setAllAsActive()
    {
        Service::whereIn('id', $this->selectedRows)->update(['active' => 1]);

        $this->dispatchBrowserEvent('swal', [
            'title'             => 'Les services ont défini comme actif avec succès.',
            'icon'              =>'success',
            'iconColor'         => 'green',
            'position'          => 'center',
            'timer'             => '1700',
        ]);

        $this->reset(['selectPageRows', 'selectedRows']);
    }

    // set All selected Service As InActive

    public function setAllAsInActive()
    {
        Service::whereIn('id', $this->selectedRows)->update(['active' => 0]);

        $this->dispatchBrowserEvent('swal', [
            'title'             => 'Les services ont défini comme inactif avec succès.',
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
    public function deleteServices()
    {

        // delete selected users from database
        Service::whereIn('id', $this->selectedRows)->delete();

        $this->dispatchBrowserEvent('swal', [
            'title'             => 'All selected services got deleted.',
            'icon'              =>'success',
            'iconColor'         => 'green',
            'position'          => 'center',
            'timer'             => '1700',
        ]);

        $this->reset();
    }

    public function addNewService()
    {
        $this->reset();
        $this->showEditModal = false;
        $this->dispatchBrowserEvent('show-form');
    }

    public function createService()
    {
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



        Service::create($validatedData);
        $this->dispatchBrowserEvent('hide-form');

        $this->dispatchBrowserEvent('swal', [
            'title' => 'Service Added Successfully.',
            'icon'=>'success',
            'iconColor' => 'green',
            'position' => 'center',
            'timer' => '1700',
        ]);
    }

    public function edit(Service $service)
    {
        $this->reset();

        $this->showEditModal = true;

        $this->data = $service->toArray();

        $this->service = $service;

        $this->dispatchBrowserEvent('show-form');
    }
    public function updateService()
    {
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


    // Show Modal Form to Confirm Service Removal

    public function confirmServiceRemoval($serviceId)
    {
        $this->serviceIdBeingRemoved = $serviceId;

        $this->dispatchBrowserEvent('show-delete-modal');
    }

    // Delete Service

    public function deleteService()
    {
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
    public function getServicesProperty()
    {

        $services = Service::query()
            ->where('name', 'like', '%'.$this->searchTerm.'%')
            ->orWhere('description', 'like', '%'.$this->searchTerm.'%')
            ->orderBy($this->sortColumnName, $this->sortDirection)
            ->paginate(15);

        return $services;
    }

    // Export Excel File

    public function exportExcel()
    {
        return Excel::download(new ServiceExport($this->searchTerm,$this->selectedRows), 'services.xlsx');
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
                Excel::import(new ServiceImport, $this->excelFile);
            } else {
                // for update data
                $this->importTypevalue = 'Update';
                $serviceData = Excel::toCollection(new ServiceImport(), $this->excelFile);
                foreach ($serviceData[0] as $service) {
                    Service::where('id', $service['id'])->update([
                        'name' => $service['name'],
                        'description' => $service['description'],
                        'cost_price' => $service['cost_price'],
                        'selling_price' => $service['selling_price'],
                        'duration' => $service['duration'],
                        'duration_unit' => $service['duration_unit'],
                        'active' => $service['active'],
                        'notes' => $service['notes'],
                    ]);
                }
            }


            $this->dispatchBrowserEvent('swal', [
                'title' => 'Services ajoutés avec succès.',
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
                $service = Service::whereIn('id', $this->selectedRows)->orderBy('id', 'asc')->get();
            } else {
                $service = $this->service;
            }

            $pdf = Pdf::loadView('livewire.backend.admin.service.pdf',['service' => $service]);
            return $pdf->stream('service');

        },'service.pdf');
    }
    public function render()
    {
        $servicesCount= Service::count();
        $services = $this->services;
        return view('livewire.backend.admin.services.list-services',[
            'services' => $services,
            'servicesCount' => $servicesCount,
            'durationUnits' => Service::getDurationUnits(),
        ])->layout('layouts.admin');
    }
}
