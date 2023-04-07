<div>
    @section('style')
        <style>

        </style>
    @endsection

    <div class="shadow card">
        <div class="py-3 card-header">
            <ol class="m-0 breadcrumb float-sm-left font-weight-bold text-primary">
                <li class="breadcrumb-item"><a href="{{ route('admin.index') }}">Dashboard</a></li>
                <li class="breadcrumb-item active">Les Clients</li>
            </ol>
            <div class="mt-2 d-flex justify-content-end">
                <div class="ml-3 dropdown">
                    <button class="btn btn-primary dropdown-toggle" type="button" id="dropdownMenuButton2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Services
                    </button>
                    <div class="bg-gray-100 dropdown-menu animated--fade-in" aria-labelledby="dropdownMenuButton2" style="">
                        <a class="dropdown-item" wire:click.prevent="exportExcel" href="#">Exporter vers Excel</a>
                        <a class="dropdown-item" wire:click.prevent="importExcelForm" href="#">Importer depuis Excel</a>
                        {{-- <a class="dropdown-item" wire:click.prevent="exportPDF" href="#">Export to PDF</a> --}}
                    </div>
                </div>
                <button wire:click.prevent='addNewCustomer' class="ml-1 btn btn-sm btn-primary">
                    <i class="mr-2 fa fa-plus-circle"
                        aria-hidden="true">
                        <span>Ajouter un Client</span>
                    </i>
                </button>
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
                                {{ $customersCount }}
                            </span>
                            <span class="text">Tous</span>
                        </button>
                        {{-- <button wire:click="filterUsersByRoles('user')" class="btn btn-sm btn-info btn-icon-split">
                            <span class="icon text-white-20">
                                {{ $roleUserCount }}
                            </span>
                            <span class="text">User</span>
                        </button>
                        <button wire:click="filterUsersByRoles('admin')" class="btn btn-sm btn-primary btn-icon-split">
                            <span class="icon text-white-20">
                                {{ $roleAdminCount }}
                            </span>
                            <span class="text">Admin</span>
                        </button>
                        <button wire:click="filterUsersByRoles('superadmin')" class="btn btn-sm btn-success btn-icon-split">
                            <span class="icon text-white-20">
                                {{ $roleSuperadminCount }}
                            </span>
                            <span class="text">SuperAdmin</span>
                        </button> --}}
                    </div>
                </div>
            </div>
        </div>


        <div class="p-3 card-body">
            @if ($selectedRows)
                <div class="mb-3 d-flex">
                    <span class="pt-1 text-success">
                        <i class="fa fa-user" aria-hidden="true"></i>
                       
                         <span class="text-gray-900 font-weight-bold">{{ count($selectedRows) }}</span> {{ Str::plural('Clients', count($selectedRows)) }} Sélectionné
                    </span>

                    <div class="ml-3 dropdown">
                        <button class="btn btn-secondary dropdown-toggle btn-sm" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Actions
                        </button>
                        <div class="bg-gray-100 dropdown-menu animated--fade-in" aria-labelledby="dropdownMenuButton" style="">
                            <a class="dropdown-item" wire:click.prevent="setAllAsActive" href="#">Définir comme actif</a>
                            <a class="dropdown-item" wire:click.prevent="setAllAsInActive" href="#">Définir comme inactif</a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item text-danger delete-confirm" wire:click.prevent="deleteSelectedRows" href="#">Supprimer les clients sélectionnée</a>
                        </div>
                    </div>
                </div>
            @endif
            <div class="table-responsive">
                <table class="table">
                    <thead class="text-white bg-gradient-secondary">
                        <tr class="text-center">
                            <th class="align-middle" scope="col">
                                <div class="custom-control custom-checkbox small">
                                    <input type="checkbox" wire:model="selectPageRows" value="" class="custom-control-input" id="customCheck">
                                    <label class="custom-control-label" for="customCheck"></label>
                                </div>
                            </th>
                            <th class="align-middle" scope="col">#</th>
                            <th class="align-middle">Nom </th>
                            <th class="align-middle"> Prénom </th>
                            <th class="align-middle"> Téléphone 1 </th>
                            <th class="align-middle"> Téléphone 2 </th>
                            <th class="align-middle"> Email </th>
                            <th class="align-middle"> Adresse </th>
                            <th class="align-middle"> Wilaya </th>
                            <th class="align-middle"> Commune </th>
                            <th class="align-middle"> Actif </th>
                            <th class="align-middle"> Commentaires </th>
                            <th class="align-middle" style="width: 10%" colspan="2">Actions
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($customers as $index => $customer)
                        {{-- @forelse($customers as $customer) --}}
                            <tr class="text-center">
                                {{-- <td class="align-middle" scope="row">{{ $loop->iteration }}</td> --}}
                                <td class="align-middle" scope="col">
                                    <div class="custom-control custom-checkbox small">
                                        <input type="checkbox" wire:model="selectedRows" value="{{ $customer->id }}" class="custom-control-input" id="{{ $customer->id }}">
                                        <label class="custom-control-label" for="{{ $customer->id }}"></label>
                                    </div>
                                </td>
                                <td class="align-middle" scope="row">{{ $customer->id }}</td>
                                <td class="align-middle">{{ $customer->firstname }}</td>
                                <td class="align-middle">{{ $customer->lastname }}</td>
                                <td class="align-middle">{{ $customer->phone1 }}</td>
                                <td class="align-middle">{{ $customer->phone2 }}</td>
                                <td class="align-middle">{{ $customer->email }}</td>
                                <td class="align-middle">{{ $customer->address }}</td>
                                <td class="align-middle">{{ $customer->state }}</td>
                                <td class="align-middle">{{ $customer->city }}</td>
                                <td class="align-middle"> 
                                    @if ($customer->active ==1)
                                    <span class="font-weight-bold badge text-white bg-success">Oui</span>
                                    @else
                                    <span class="font-weight-bold badge text-white bg-secondary">Non</span>
                                    @endif 
                            </td>
                                <td class="align-middle">{{ $customer->notes }}</td>
                                <td class="align-middle">
                                    <div class="btn-group btn-group-sm">
                                        <a href="#" wire:click.prevent="edit({{ $customer }})" class="btn btn-primary">
                                        <i class="fa fa-edit"></i>
                                    </a>  

                                      <a class="btn btn-danger" href="#" wire:click.prevent="confirmCustomerRemoval({{ $customer->id }})">
                                        <i class="fa fa-trash bg-danger"></i>
                                    </a>

                                    </div>
                                      <form action="" method="post" id="delete-customer-{{ $customer->id }}" class="d-none">
                                    @csrf
                                    @method('DELETE')
                                </form>  
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center">No customer found</td>
                            </tr>
                        @endforelse
                    </tbody>
                    <tfoot>
                        <tr class="bg-light">
                            <td colspan="14">
                                {!! $customers->appends(request()->all())->links() !!}  
                            </td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>

    <!-- Modal Create or Update customer -->

    <div class="modal fade" id="form" tabindex="-1" customer="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog" customer="document">
            <form autocomplete="off" wire:submit.prevent="{{ $showEditModal ? 'updateCustomer' : 'createCustomer' }}">
                <div class="modal-content">
                    <div class="modal-header bg-light">
                        <h5 class="modal-title" id="exampleModalLabel">
                            @if ($showEditModal)
                                <span>Modifier le client</span>
                            @else
                                <span>Ajouter un nouveau client</span>
                            @endif
                        </h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row h-100 justify-content-center align-items-center">
                            <div class="col-6">

                                <!-- Modal customer lastname -->
                                <div class="form-group">
                                    <label for="lastname">Le Nom</label>
                                    <input type="text" tabindex="1" wire:model.defer="data.lastname"
                                        class="form-control @error('lastname') is-invalid @enderror" id="lastname"
                                        aria-describedby="nameHelp" placeholder="Enter customer lastname">
                                    @error('lastname')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                {{-- ---------------------------------------------------- --}}

                            </div>
                            <div class="col-6">
                                <!-- Modal customer firstname -->
                                <div class="form-group">
                                    <label for="firstname">Le Prénom</label>
                                    <input type="text" tabindex="1" wire:model.defer="data.firstname"
                                        class="form-control @error('firstname') is-invalid @enderror" id="firstname"
                                        aria-describedby="nameHelp" placeholder="Enter customer firstname">
                                    @error('firstname')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                {{-- ---------------------------------------------------- --}}
                            </div>
                            <div class="row h-100 justify-content-center align-items-center">
                                <div class="col-6">
                                    <!-- Modal customer phone1 -->
                                    <div class="form-group">
                                        <label for="phone1">Téléphone 1</label>
                                        <input type="text" tabindex="1" wire:model.defer="data.phone1"
                                            class="form-control @error('phone1') is-invalid @enderror" id="phone1"
                                            aria-describedby="nameHelp" placeholder="Enter customer phone1">
                                        @error('phone1')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                    {{-- ---------------------------------------------------- --}}

                                </div>
                                <div class="col-6">
                                    <!-- Modal customer phone2 -->
                                    <div class="form-group">
                                        <label for="phone2">Téléphone 2</label>
                                        <input type="text" tabindex="1" wire:model.defer="data.phone2"
                                            class="form-control @error('phone2') is-invalid @enderror" id="phone2"
                                            aria-describedby="nameHelp" placeholder="Enter customer phone2">
                                        @error('phone2')
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
                                    <!-- Modal customer email -->
                                    <div class="form-group">
                                        <label for="email">Email</label>
                                        <input type="text" tabindex="1" wire:model.defer="data.email"
                                            class="form-control @error('email') is-invalid @enderror" id="email"
                                            aria-describedby="nameHelp" placeholder="Enter customer email">
                                        @error('email')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                    {{-- ---------------------------------------------------- --}}

                                </div>
                                <div class="col-6">
                                    <!-- Modal customer address -->
                                    <div class="form-group">
                                        <label for="address">Adresse</label>
                                        <textarea tabindex="1" wire:model.defer="data.address" class="form-control @error('address') is-invalid @enderror"
                                            id="address" aria-describedby="nameHelp" placeholder="Enter customer address">
                                    </textarea>
                                        @error('address')
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
                                    <!-- Modal customer state -->
                                    <div class="form-group">
                                        <label for="state">Wilaya</label>
                                        <input type="text" tabindex="1" wire:model.defer="data.state"
                                            class="form-control @error('state') is-invalid @enderror" id="state"
                                            aria-describedby="nameHelp" placeholder="Enter customer state">
                                        @error('state')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                    {{-- ---------------------------------------------------- --}}

                                </div>
                                <div class="col-6">
                                    <!-- Modal customer notes -->
                                    <div class="form-group"> 
                                        <label for="customSwitch1">Rendre le client actif</label>
                                        <div class="custom-control custom-switch">
                                            <input type="checkbox" class="custom-control-input" id="customSwitch1" checked="" wire:model.defer="data.active">
                                            <label class="custom-control-label" for="customSwitch1"></label>
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
                            <div class="row h-100 justify-content-center align-items-center" style="width:300%">

                                <div class="col-12">
                                    <!-- Modal customer notes -->
                                    <div class="form-group">
                                        <label for="notes">Remarques</label>
                                        <textarea type="textarea" tabindex="1" wire:model.defer="data.notes"
                                            class="form-control @error('notes') is-invalid @enderror" id="notes" aria-describedby="nameHelp"
                                            placeholder="Enter customer notes">
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
                            <div class="row h-100 justify-content-center align-items-center"  >

                                
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

    <!-- Modal Delete customer -->
    <div class="modal fade" id="confirmationModal" tabindex="-1" customer="dialog"
        aria-labelledby="exampleModalLabel" aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog" customer="document">
            <div class="modal-content">
                <div class="modal-header bg-light">
                    <h5>Supprimer le client</h5>
                </div>

                <div class="modal-body">
                    <h4>Voulez-vous vraiment supprimer ce client ?</h4>
                </div>

                <div class="modal-footer bg-light">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal"><i
                            class="mr-1 fa fa-times"></i> Annuler</button>
                    <button type="button" wire:click.prevent="deleteCustomer" class="btn btn-danger"><i
                            class="mr-1 fa fa-trash"></i>Supprimer le client</button>
                </div>
            </div>
        </div>
    </div>

    {{-- JS Code --}}

    @section('script')
        <script src="{{ asset('backend/js/backend.js') }}"></script>

        {{-- show or hide customers section on Modal --}}



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
