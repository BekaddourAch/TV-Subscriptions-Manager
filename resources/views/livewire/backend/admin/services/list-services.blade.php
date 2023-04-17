<div>
    @section('style')
        <style>

        </style>
    @endsection

    <div class="shadow card">
        <div class="py-3 card-header">
            <ol class="m-0 breadcrumb float-sm-left font-weight-bold text-primary">
                <li class="breadcrumb-item"><a href="{{ route('admin.index') }}">Page Principale</a></li>
                <li class="breadcrumb-item active">Les Services</li>
            </ol>
            <div class="mt-2 d-flex justify-content-end">

                @if(0==1)
                {{-- <div class="ml-3 dropdown">
                    <button class="btn btn-primary dropdown-toggle" type="button" id="dropdownMenuButton2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Services
                    </button>
                    <div class="bg-gray-100 dropdown-menu animated--fade-in" aria-labelledby="dropdownMenuButton2" style="">
                        <a class="dropdown-item" wire:click.prevent="exportExcel" href="#">Exporter vers Excel</a>
                        <a class="dropdown-item" wire:click.prevent="importExcelForm" href="#">Importer depuis Excel</a>
                        <a class="dropdown-item" wire:click.prevent="exportPDF" href="#">Export to PDF</a>
                    </div>
                </div> --}}
                @endif

                @if(Auth::user()->hasPermission('services-create'))
                    <button wire:click.prevent='addNewService' class="ml-1 btn btn-sm btn-primary">
                        <i class="mr-2 fa fa-plus-circle"
                        aria-hidden="true">
                            <span>Ajouter un Service</span>
                        </i>
                    </button>
                @endif
            </div>
        </div>
        <div class="flex-wrap d-flex justify-content-between">
            <div class="pt-3 my-2 ml-3 ml-md-3 my-md-0 mw-80 navbar-search">
                <div class="input-group">
                    <input wire:model="searchTerm" type="text" class="border-0 form-control bg-light small" placeholder="Rechercher..." aria-label="Search" aria-describedby="basic-addon2" spellcheck="false" data-ms-editor="true">
                    <div class="input-group-append">
                        <button class="btn btn-primary btn-sm" type="button">
                            <i class="fas fa-search fa-sm"></i>
                        </button>
                    </div>
                </div>
            </div>
            <div class="m-3 mw-100 justify-content-end">
                <div class="btn-group">
                    <div data-toggle="buttons">
                        <button wire:click="" class="btn btn-sm btn-warning btn-icon-split">
                            <span class="icon text-white-20">
                                {{ $servicesCount }}
                            </span>
                            <span class="text">Tous</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>


        <div class="p-3 card-body">
            @if ($selectedRows)
                <div class="mb-3 d-flex">
                    <span class="pt-1 text-success">
                        <i class="fa fa-user" aria-hidden="true"></i>

                         <span class="text-gray-900 font-weight-bold">{{ count($selectedRows) }}</span> {{ Str::plural('Services', count($selectedRows)) }} Sélectionné
                    </span>

                    <div class="ml-3 dropdown">
                        <button class="btn btn-secondary dropdown-toggle btn-sm" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Actions
                        </button>
                        <div class="bg-gray-100 dropdown-menu animated--fade-in" aria-labelledby="dropdownMenuButton" style="">
                            @if(Auth::user()->hasPermission('services-update'))
                                <a class="dropdown-item" wire:click.prevent="setAllAsActive" href="#">Définir comme actif</a>
                                <a class="dropdown-item" wire:click.prevent="setAllAsInActive" href="#">Définir comme inactif</a>
                            @endif
                            @if(Auth::user()->hasPermission('services-delete'))
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item text-danger delete-confirm" wire:click.prevent="deleteSelectedRows" href="#">Supprimer les services sélectionnée</a>
                            @endif
                        </div>
                    </div>
                </div>
            @endif
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead class="text-white bg-primary">
                    <tr class="text-center">

                        @if((Auth::user()->hasPermission('services-update')) || (Auth::user()->hasPermission('services-delete')))
                            <th class="align-middle" scope="col">
                                <div class="custom-control custom-checkbox small">
                                    <input type="checkbox" wire:model="selectPageRows" value="" class="custom-control-input" id="customCheck">
                                    <label class="custom-control-label" for="customCheck"></label>
                                </div>
                            </th>
                        @endif
                        <th class="align-middle" scope="col">#</th>
                        <th wire:click="sortBy('services.name')" style="cursor: pointer;" class="align-middle text-left whitespace-no-wrap"> Nom
                            <span  class="text-sm" style="cursor: pointer;font-size:10px;">
                                <i class="mr-1 fa fa-arrow-up" style="color:{{ $sortColumnName === 'services.name' && $sortDirection === 'asc' ? '#90EE90' : '' }}"></i>
                                <i class="fa fa-arrow-down" style="color : {{ $sortColumnName === 'services.name' && $sortDirection === 'desc' ? '#90EE90' : '' }}"></i>
                            </span>
                        </th>
                        <th  wire:click="sortBy('services.description')" style="cursor: pointer;" class="align-middle text-left d-none d-md-table-cell whitespace-no-wrap"> Description
                            <span class="text-sm" style="cursor: pointer;font-size:10px;">
                                <i class="mr-1 fa fa-arrow-up" style="color:{{ $sortColumnName === 'services.description' && $sortDirection === 'asc' ? '#90EE90' : '' }}"></i>
                                <i class="fa fa-arrow-down" style="color : {{ $sortColumnName === 'services.description' && $sortDirection === 'desc' ? '#90EE90' : '' }}"></i>
                            </span>
                        </th>
                        <th  wire:click="sortBy('services.cost_price')" style="cursor: pointer;" class="align-middle d-none d-md-table-cell whitespace-no-wrap"> Prix d'Achat
                            <span class="text-sm " style="cursor: pointer;font-size:10px;">
                                <i class="mr-1 fa fa-arrow-up" style="color:{{ $sortColumnName === 'services.cost_price' && $sortDirection === 'asc' ? '#90EE90' : '' }}"></i>
                                <i class="fa fa-arrow-down" style="color : {{ $sortColumnName === 'services.cost_price' && $sortDirection === 'desc' ? '#90EE90' : '' }}"></i>
                            </span>
                        </th>
                        <th  wire:click="sortBy('services.selling_price')" style="cursor: pointer;" class="align-middle d-none d-md-table-cell whitespace-no-wrap"> Prix de Vente
                            <span class="text-sm " style="cursor: pointer;font-size:10px;">
                                <i class="mr-1 fa fa-arrow-up" style="color:{{ $sortColumnName === 'services.selling_price' && $sortDirection === 'asc' ? '#90EE90' : '' }}"></i>
                                <i class="fa fa-arrow-down" style="color : {{ $sortColumnName === 'services.selling_price' && $sortDirection === 'desc' ? '#90EE90' : '' }}"></i>
                            </span>
                        </th>
                        <th  wire:click="sortBy('services.duration')" style="cursor: pointer;" class="align-middle text-left whitespace-no-wrap"> Durée
                            <span class="text-sm " style="cursor: pointer;font-size:10px;">
                                <i class="mr-1 fa fa-arrow-up" style="color:{{ $sortColumnName === 'services.duration' && $sortDirection === 'asc' ? '#90EE90' : '' }}"></i>
                                <i class="fa fa-arrow-down" style="color : {{ $sortColumnName === 'services.duration' && $sortDirection === 'desc' ? '#90EE90' : '' }}"></i>
                            </span>
                        </th>
                        <th  wire:click="sortBy('services.active')" style="cursor: pointer;" class="align-middle whitespace-no-wrap"> Actif
                            <span class="text-sm " style="cursor: pointer;font-size:10px;">
                                <i class="mr-1 fa fa-arrow-up" style="color:{{ $sortColumnName === 'services.active' && $sortDirection === 'asc' ? '#90EE90' : '' }}"></i>
                                <i class="fa fa-arrow-down" style="color : {{ $sortColumnName === 'services.active' && $sortDirection === 'desc' ? '#90EE90' : '' }}"></i>
                            </span>
                        </th>
                        <th  wire:click="sortBy('services.notes')" style="cursor: pointer;" class="align-middle whitespace-no-wrap text-left  d-none d-xl-table-cell"> Remarques
                            <span class="text-sm " style="cursor: pointer;font-size:10px;">
                                <i class="mr-1 fa fa-arrow-up" style="color:{{ $sortColumnName === 'services.notes' && $sortDirection === 'asc' ? '#90EE90' : '' }}"></i>
                                <i class="fa fa-arrow-down" style="color : {{ $sortColumnName === 'services.notes' && $sortDirection === 'desc' ? '#90EE90' : '' }}"></i>
                            </span>
                        </th>

                        @if((Auth::user()->hasPermission('services-update')) || (Auth::user()->hasPermission('services-delete')))
                            <th class="align-middle" style="width: 10%" colspan="2">Actions  </th>
                        @endif
                    </tr>
                    </thead>
                    <tbody>
                    @forelse($services as $index => $service)
                        <tr class="text-center">

                            @if((Auth::user()->hasPermission('services-update')) || (Auth::user()->hasPermission('services-delete')))
                                <td class="align-middle" scope="col">
                                    <div class="custom-control custom-checkbox small">
                                        <input type="checkbox" wire:model="selectedRows" value="{{ $service->id_service }}" class="custom-control-input" id="{{ $service->id_service }}">
                                        <label class="custom-control-label" for="{{ $service->id_service }}"></label>
                                    </div>
                                </td>
                            @endif
                            <td class="align-middle" scope="row">#{{ $service->id_service }}</td>
                            <td class="align-middle text-left">{{ $service->name }}</td>
                            <td class="align-middle text-left d-none d-md-table-cell">{{ $service->description }}</td>
                            <td class="align-middle d-none d-md-table-cell whitespace-no-wrap">{{ formatPrice($service->cost_price) }}</td>
                            <td class="align-middle d-none d-md-table-cell whitespace-no-wrap">{{ formatPrice($service->selling_price) }}</td>
                            <td class="align-middle text-left whitespace-no-wrap">{{ $service->getDurationWithUnit() }}</td>
                            <td class="align-middle">
                                @if ($service->active ==1)
                                    <span class="font-weight-bold badge text-white bg-success">Oui</span>
                                @else
                                    <span class="font-weight-bold badge text-white bg-secondary">Non</span>
                                @endif
                            </td>
                            <td class="align-middle text-left d-none d-xl-table-cell">{{ $service->notes }}</td>

                            @if((Auth::user()->hasPermission('services-update')) || (Auth::user()->hasPermission('services-delete')))
                                <td class="align-middle">
                                    <div class="btn-group btn-group-sm">

                                        @if(Auth::user()->hasPermission('services-update'))
                                            <a href="#" wire:click.prevent="edit({{ $service }})" class="btn btn-primary">
                                                <i class="fa fa-edit"></i>
                                            </a>
                                        @endif

                                        @if(Auth::user()->hasPermission('services-delete'))
                                            <a class="btn btn-danger" href="#" wire:click.prevent="confirmServiceRemoval({{ $service->id_service }})">
                                                <i class="fa fa-trash bg-danger"></i>
                                            </a>
                                        @endif
                                    </div>
                                    <form action="" method="post" id="delete-service-{{ $service->id_service }}" class="d-none">
                                        @csrf
                                        @method('DELETE')
                                    </form>
                                </td>
                            @endif
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center">No services found</td>
                        </tr>
                    @endforelse
                    </tbody>
                    <tfoot>
                    <tr class="bg-light">
                        <td colspan="14">
                            {!! $services->appends(request()->all())->links() !!}
                        </td>
                    </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>

    <!-- Modal Create or Update service -->

    <div class="modal fade" id="form" tabindex="-1" service="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog" service="document">
            <form autocomplete="off" wire:submit.prevent="{{ $showEditModal ? 'updateService' : 'createService' }}">
                <div class="modal-content">
                    <div class="modal-header bg-light">
                        <h5 class="modal-title" id="exampleModalLabel">
                            @if ($showEditModal)
                                <span>Modifier le service<span>
                            @else
                                <span>Ajouter un nouveau service</span>
                            @endif
                        </h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row h-100 justify-content-center align-items-center">
                            <div class="col-12">

                                <!-- Modal service name -->
                                <div class="form-group">
                                    <label for="name">Nom</label>
                                    <input type="text" tabindex="1" wire:model.defer="data.name"
                                           class="form-control @error('name') is-invalid @enderror" id="name"
                                           aria-describedby="nameHelp" placeholder="Nom du service">
                                    @error('name')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                                {{-- ---------------------------------------------------- --}}

                            </div>
                            <div class="col-12">

                                <!-- Modal service description -->
                                <div class="form-group">
                                    <label for="name">Description</label>
                                    <textarea  tabindex="1" wire:model.defer="data.description"
                                           class="form-control @error('description') is-invalid @enderror" id="description"
                                           aria-describedby="nameHelp" placeholder="Description du service">
                                    </textarea>
                                    @error('description')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                                {{-- ---------------------------------------------------- --}}

                            </div>
                        </div>
                        <div class="row h-100 justify-content-center align-items-center">
                            <div class="col-6">
                                <!-- Modal service cost price -->
                                <div class="form-group">
                                    <label for="cost_price">Prix d'Achat</label>
                                    <input type="number" min="1" tabindex="1" wire:model.defer="data.cost_price"
                                           class="form-control @error('cost_price') is-invalid @enderror" id="cost_price"
                                           aria-describedby="nameHelp" step="0.01">
                                    @error('cost_price')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                                {{-- ---------------------------------------------------- --}}

                            </div>
                            <div class="col-6">
                                <!-- Modal service selling price -->
                                <div class="form-group">
                                    <label for="selling_price">Prix de Vente</label>
                                    <input type="number" min="1" tabindex="1" wire:model.defer="data.selling_price"
                                           class="form-control @error('selling_price') is-invalid @enderror" id="selling_price"
                                           aria-describedby="nameHelp"  step="0.01">
                                    @error('selling_price')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                                {{-- ---------------------------------------------------- --}}
                            </div>
                        </div>
                        <div class="row h-100 justify-content-center align-items-center">

                            <div class="col-6">
                                <!-- Modal service duration -->
                                <div class="form-group">
                                    <label for="duration">Durée</label>
                                    <input type="number" min="1" tabindex="1" wire:model.defer="data.duration"
                                           class="form-control @error('duration') is-invalid @enderror" id="duration"
                                           aria-describedby="nameHelp" >
                                    @error('duration')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                                {{-- ---------------------------------------------------- --}}

                            </div>

                            <div class="col-6">
                                <!-- Modal service duration type -->
                                <div class="form-group">
                                    <label for="duration_unit">Par</label>
                                    <select  wire:model.defer="data.duration_unit" class="form-control @error('duration_unit') is-invalid @enderror" id="duration_unit"
                                             aria-describedby="nameHelp">
                                        @forelse($durationUnits as $index => $durationUnit)
                                            <option value="{{$index}}">{{$durationUnit}}</option>
                                        @empty
                                            <option value="1">mois</option>
                                        @endforelse
                                    </select>
                                    @error('duration_unit')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                                {{-- ---------------------------------------------------- --}}

                            </div>
                        </div>
                        <div class="row h-100 justify-content-center align-items-center">
                            <div class="col-12">
                                <!-- Modal service notes -->
                                <div class="form-group">
                                    <div class="custom-control custom-switch" style="min-width: 180px;margin-right: 80px;">
                                        <input type="checkbox" class="custom-control-input" id="customSwitch1" checked="true" wire:model.defer="data.active">
                                        <label class="custom-control-label" for="customSwitch1">Actif</label>
                                    </div>
                                    @error('active')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                                {{-- ---------------------------------------------------- --}}

                            </div>
                        </div>
                        <div class="row h-100 justify-content-center align-items-center">

                            <div class="col-12">
                                <!-- Modal service notes -->
                                <div class="form-group">
                                    <label for="notes">Remarques</label>
                                    <textarea  tabindex="1" wire:model.defer="data.notes"
                                              class="form-control @error('notes') is-invalid @enderror" id="notes" aria-describedby="nameHelp"
                                              placeholder="">
                                    </textarea>
                                    @error('notes')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                                {{-- ---------------------------------------------------- --}}

                            </div>
                        </div>
                    </div>

                    <div class="modal-footer bg-light">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal"><i
                                class="mr-1 fa fa-times"></i> Cancel</button>
                        <button type="submit" class="btn btn-primary"><i class="mr-1 fa fa-save"></i>
                            @if ($showEditModal)
                                <span>Sauvegarder les modifications</span>
                            @else
                                <span>Sauvegarder</span>
                            @endif
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal Delete service -->
    <div class="modal fade" id="confirmationModal" tabindex="-1" service="dialog"
         aria-labelledby="exampleModalLabel" aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog" service="document">
            <div class="modal-content">
                <div class="modal-header bg-light">
                    <h5>Supprimer le client</h5>
                </div>

                <div class="modal-body">
                    <h4>Voulez-vous vraiment supprimer ce service ?</h4>
                </div>

                <div class="modal-footer bg-light">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal"><i
                            class="mr-1 fa fa-times"></i> Annuler</button>
                    <button type="button" wire:click.prevent="deleteService" class="btn btn-danger"><i
                            class="mr-1 fa fa-trash"></i>Supprimer le service</button>
                </div>
            </div>
        </div>
    </div>

    @include("livewire.backend.admin.excel-import-modal")
    {{-- JS Code --}}

    @section('script')
        <script src="{{ asset('backend/js/backend.js') }}"></script>

        {{-- show or hide services section on Modal --}}
            <script>
                $(document).ready(function(){
                    window.addEventListener('show-import-excel-modal', function (event) {
                        $('#importExcelModal').modal('show');
                    });

                    window.addEventListener('hide-import-excel-modal', function (event) {
                        $('#importExcelModal').modal('hide');
                    });
                });
            </script>


        {{-- show-delete-alert-confirmation --}}

        <script>
            window.addEventListener('show-delete-alert-confirmation', event => {
                Swal.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        Livewire.emit('deleteConfirmed')
                    }
                })
            })
        </script>
    @endsection
</div>
