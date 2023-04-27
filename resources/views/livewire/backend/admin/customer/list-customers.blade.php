<div>
    @section('style')
        <style>

        </style>
    @endsection

    <div class="shadow card">
        <div class="py-3 card-header">
            <ol class="m-0 breadcrumb float-sm-left font-weight-bold text-primary">
                <li class="breadcrumb-item"><a href="{{ route('admin.index') }}">Page Principale</a></li>
                <li class="breadcrumb-item active">Les Clients</li>
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
                @if(Auth::user()->hasPermission('customers-create'))

                <button wire:click.prevent='addNewCustomer' class="ml-1 btn btn-sm btn-primary">
                    <i class="mr-2 fa fa-plus-circle"
                        aria-hidden="true">
                        <span>Ajouter un Client</span>
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
                                {{ $customersCount }}
                            </span>
                            <span class="text">Tous</span>
                        </button>

                        @if(0==1)
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
                        @endif
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
                                @if(Auth::user()->hasPermission('customers-update'))
                                    <a class="dropdown-item" wire:click.prevent="setAllAsActive" href="#">Définir comme actif</a>
                                    <a class="dropdown-item" wire:click.prevent="setAllAsInActive" href="#">Définir comme inactif</a>
                                @endif
                                <div class="dropdown-divider"></div>
                                @if(Auth::user()->hasPermission('customers-delete'))
                                    <a class="dropdown-item text-danger delete-confirm" wire:click.prevent="deleteSelectedRows" href="#">Supprimer les clients sélectionnée</a>
                                @endif
                            </div>
                        </div>
                </div>
            @endif
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead class="text-white bg-dark">
                        <tr class="text-center">

                            @if((Auth::user()->hasPermission('customers-update')) || (Auth::user()->hasPermission('customers-delete')))
                                <th class="align-middle" scope="col">
                                    <div class="custom-control custom-checkbox small">
                                        <input type="checkbox" wire:model="selectPageRows" value="" class="custom-control-input" id="customCheck">
                                        <label class="custom-control-label" for="customCheck"></label>
                                    </div>
                                </th>
                            @endif

                            <th class="align-middle" scope="col">#</th>

                            <th class="align-middle">Nom
                                <span wire:click="sortBy('customers.firstname')" class="text-sm float-sm-right" style="cursor: pointer;font-size:10px;">
                                    <i class="mr-1 fa fa-arrow-up" style="color:{{ $sortColumnName === 'customers.firstname' && $sortDirection === 'asc' ? '#90EE90' : '' }}"></i>
                                    <i class="fa fa-arrow-down" style="color : {{ $sortColumnName === 'customers.firstname' && $sortDirection === 'desc' ? '#90EE90' : '' }}"></i>
                                </span>
                            </th>
                            <th class="align-middle"> Prénom
                                <span wire:click="sortBy('customers.lastname')" class="text-sm float-sm-right" style="cursor: pointer;font-size:10px;">
                                    <i class="mr-1 fa fa-arrow-up" style="color:{{ $sortColumnName === 'customers.lastname' && $sortDirection === 'asc' ? '#90EE90' : '' }}"></i>
                                    <i class="fa fa-arrow-down" style="color : {{ $sortColumnName === 'customers.lastname' && $sortDirection === 'desc' ? '#90EE90' : '' }}"></i>
                                </span>
                            </th>
                            <th class="align-middle"> Téléphone 1
                                <span wire:click="sortBy('customers.phone1')" class="text-sm float-sm-right" style="cursor: pointer;font-size:10px;">
                                    <i class="mr-1 fa fa-arrow-up" style="color:{{ $sortColumnName === 'customers.phone1' && $sortDirection === 'asc' ? '#90EE90' : '' }}"></i>
                                    <i class="fa fa-arrow-down" style="color : {{ $sortColumnName === 'customers.phone1' && $sortDirection === 'desc' ? '#90EE90' : '' }}"></i>
                                </span>
                            </th>
                            <th class="align-middle"> Téléphone 2
                                <span wire:click="sortBy('customers.phone2')" class="text-sm float-sm-right" style="cursor: pointer;font-size:10px;">
                                    <i class="mr-1 fa fa-arrow-up" style="color:{{ $sortColumnName === 'customers.phone2' && $sortDirection === 'asc' ? '#90EE90' : '' }}"></i>
                                    <i class="fa fa-arrow-down" style="color : {{ $sortColumnName === 'customers.phone2' && $sortDirection === 'desc' ? '#90EE90' : '' }}"></i>
                                </span>
                            </th>
                            <th class="align-middle"> Email
                                <span wire:click="sortBy('customers.email')" class="text-sm float-sm-right" style="cursor: pointer;font-size:10px;">
                                    <i class="mr-1 fa fa-arrow-up" style="color:{{ $sortColumnName === 'customers.email' && $sortDirection === 'asc' ? '#90EE90' : '' }}"></i>
                                    <i class="fa fa-arrow-down" style="color : {{ $sortColumnName === 'customers.email' && $sortDirection === 'desc' ? '#90EE90' : '' }}"></i>
                                </span>
                            </th>
                            <th class="align-middle"> Adresse
                                <span wire:click="sortBy('customers.address')" class="text-sm float-sm-right" style="cursor: pointer;font-size:10px;">
                                    <i class="mr-1 fa fa-arrow-up" style="color:{{ $sortColumnName === 'customers.address' && $sortDirection === 'asc' ? '#90EE90' : '' }}"></i>
                                    <i class="fa fa-arrow-down" style="color : {{ $sortColumnName === 'customers.address' && $sortDirection === 'desc' ? '#90EE90' : '' }}"></i>
                                </span>
                            </th>
                            <th class="align-middle"> Wilaya
                                <span wire:click="sortBy('customers.state')" class="text-sm float-sm-right" style="cursor: pointer;font-size:10px;">
                                    <i class="mr-1 fa fa-arrow-up" style="color:{{ $sortColumnName === 'customers.state' && $sortDirection === 'asc' ? '#90EE90' : '' }}"></i>
                                    <i class="fa fa-arrow-down" style="color : {{ $sortColumnName === 'customers.state' && $sortDirection === 'desc' ? '#90EE90' : '' }}"></i>
                                </span>
                            </th>
                            <th class="align-middle"> Commune
                                <span wire:click="sortBy('customers.city')" class="text-sm float-sm-right" style="cursor: pointer;font-size:10px;">
                                <i class="mr-1 fa fa-arrow-up" style="color:{{ $sortColumnName === 'customers.city' && $sortDirection === 'asc' ? '#90EE90' : '' }}"></i>
                                <i class="fa fa-arrow-down" style="color : {{ $sortColumnName === 'customers.city' && $sortDirection === 'desc' ? '#90EE90' : '' }}"></i>
                            </span>
                            </th>
                            <th class="align-middle"> Revendeur
                                <span wire:click="sortBy('customers.is_reseller')" class="text-sm float-sm-right" style="cursor: pointer;font-size:10px;">
                                    <i class="mr-1 fa fa-arrow-up" style="color:{{ $sortColumnName === 'customers.is_reseller' && $sortDirection === 'asc' ? '#90EE90' : '' }}"></i>
                                    <i class="fa fa-arrow-down" style="color : {{ $sortColumnName === 'customers.is_reseller' && $sortDirection === 'desc' ? '#90EE90' : '' }}"></i>
                                </span>
                        </th>
                            <th class="align-middle"> Actif
                                <span wire:click="sortBy('customers.active')" class="text-sm float-sm-right" style="cursor: pointer;font-size:10px;">
                                <i class="mr-1 fa fa-arrow-up" style="color:{{ $sortColumnName === 'customers.active' && $sortDirection === 'asc' ? '#90EE90' : '' }}"></i>
                                <i class="fa fa-arrow-down" style="color : {{ $sortColumnName === 'customers.active' && $sortDirection === 'desc' ? '#90EE90' : '' }}"></i>
                            </span>
                            </th>
                             <th class="align-middle"> Remarques </th>
                            @if((Auth::user()->hasPermission('customers-update')) || (Auth::user()->hasPermission('customers-delete')))
                                <th class="align-middle" style="width: 10%" colspan="2">Actions
                                </th>
                            @endif
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($customers as $index => $customer)
                        {{-- @forelse($customers as $customer) --}}
                            <tr class="text-center">
                                {{-- <td class="align-middle" scope="row">{{ $loop->iteration }}</td> --}}

                                @if((Auth::user()->hasPermission('customers-update')) || (Auth::user()->hasPermission('customers-delete')))
                                    <td class="align-middle" scope="col">
                                        <div class="custom-control custom-checkbox small">
                                            <input type="checkbox" wire:model="selectedRows" value="{{ $customer->id_customer }}" class="custom-control-input" id="{{ $customer->id_customer }}">
                                            <label class="custom-control-label" for="{{ $customer->id_customer }}"></label>
                                        </div>
                                    </td>
                                @endif
                                <td class="align-middle" scope="row"><a  class="text-primary" href="{{route("admin.customer-details",$customer->id_customer)}}">#{{ $customer->id_customer }}</a></td>
                                <td class="align-middle text-left">{{ $customer->firstname }}</td>
                                <td class="align-middle text-left">{{ $customer->lastname }}</td>
                                <td class="align-middle">{{ $customer->phone1 }}</td>
                                <td class="align-middle d-none d-md-table-cell">{{ $customer->phone2 }}</td>
                                <td class="align-middle">{{ $customer->email }}</td>
                                <td class="align-middle text-left d-none d-md-table-cell">{{ $customer->address }}</td>
                                <td class="align-middle text-left d-none d-md-table-cell">{{ $customer->state }}</td>
                                <td class="align-middle text-left d-none d-md-table-cell">{{ $customer->city }}</td>
                                <td class="align-middle">

                                    @if ($customer->is_reseller ==1)
                                    <span class="font-weight-bold badge text-white bg-success">Oui</span>
                                    @else
                                    <span class="font-weight-bold badge text-white bg-secondary">Non</span>
                                    @endif
                            </td>
                                <td class="align-middle">

                                    @if ($customer->active ==1)
                                    <span class="font-weight-bold badge text-white bg-success">Oui</span>
                                    @else
                                    <span class="font-weight-bold badge text-white bg-secondary">Non</span>
                                    @endif
                            </td>
                                <td class="align-middle text-left d-none d-md-table-cell">{{ $customer->notes }}</td>

                            @if((Auth::user()->hasPermission('customers-update')) || (Auth::user()->hasPermission('customers-delete')))
                                    <td class="align-middle">
                                        <div class="btn-group btn-group-sm">
                                            @if(Auth::user()->hasPermission('customers-update'))
                                            <a href="#" wire:click.prevent="edit({{ $customer }})" class="btn btn-primary">
                                                <i class="fa fa-edit"></i>
                                            </a>
                                            @endif
                                            @if(Auth::user()->hasPermission('customers-delete'))
                                        <a class="btn btn-danger" href="#" wire:click.prevent="confirmCustomerRemoval({{ $customer->id_customer }})">
                                            <i class="fa fa-trash bg-danger"></i>
                                        </a>
                                        @endif

                                        </div>
                                    </td>
                                @endif
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center">Aucun client trouvé</td>
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
                                    <label for="firstname">Nom</label>
                                    <input type="text" tabindex="1" wire:model.defer="data.firstname"
                                        class="form-control @error('firstname') is-invalid @enderror" id="firstname"
                                        aria-describedby="nameHelp" placeholder="Nom">
                                    @error('firstname')
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
                                    <label for="lastname">Prénom</label>
                                    <input type="text" tabindex="1" wire:model.defer="data.lastname"
                                        class="form-control @error('lastname') is-invalid @enderror" id="lastname"
                                        aria-describedby="nameHelp" placeholder="Prénom">
                                    @error('lastname')
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
                                    <!-- Modal customer phone1 -->
                                    <div class="form-group">
                                        <label for="phone1">Téléphone 1</label>
                                        <input  type="tel" tabindex="1" placeholder="0655112233" required wire:model.defer="data.phone1"
                                            class="form-control @error('phone1') is-invalid @enderror" id="phone1"
                                            aria-describedby="nameHelp" >
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
                                        <input  type="tel" tabindex="1" placeholder="0655112233" wire:model.defer="data.phone2"
                                            class="form-control @error('phone2') is-invalid @enderror" id="phone2"
                                            aria-describedby="nameHelp" >
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
                                            aria-describedby="nameHelp" placeholder="Email">
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
                                        <input type="text" tabindex="1" wire:model.defer="data.address" class="form-control @error('address') is-invalid @enderror"
                                            id="address" aria-describedby="nameHelp" placeholder="Adresse">

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
                                        {{-- <input type="text" tabindex="1" wire:model.defer="data.state"
                                            class="form-control @error('state') is-invalid @enderror" id="state"
                                            aria-describedby="nameHelp" placeholder="Enter customer state"> --}}
                                            <select  wire:model.defer="data.state" class="form-control @error('state') is-invalid @enderror" id="state"
                                                aria-describedby="nameHelp">
                                                <option value="Adrar">Adrar</option>
                                                <option value="Chlef">Chlef</option>
                                                <option value="Laghouat">Laghouat</option>
                                                <option value="Oum El Bouaghi">Oum El Bouaghi</option>
                                                <option value="Batna">Batna</option>
                                                <option value="Béjaïa">Béjaïa</option>
                                                <option value="Biskra">Biskra</option>
                                                <option value="Béchar">Béchar</option>
                                                <option value="Blida">Blida</option>
                                                <option value="Bouira">Bouira</option>
                                                <option value="Tamanrasset">Tamanrasset</option>
                                                <option value="Tébessa">Tébessa</option>
                                                <option value="Tlemcen">Tlemcen</option>
                                                <option value="Tiaret">Tiaret</option>
                                                <option value="Tizi Ouzou">Tizi Ouzou</option>
                                                <option value="Alger">Alger</option>
                                                <option value="Djelfa">Djelfa</option>
                                                <option value="Jijel">Jijel</option>
                                                <option value="Sétif">Sétif</option>
                                                <option value="Saïda">Saïda</option>
                                                <option value="Skikda">Skikda</option>
                                                <option value="Sidi Bel Abbès">Sidi Bel Abbès</option>
                                                <option value="Annaba">Annaba</option>
                                                <option value="Guelma">Guelma</option>
                                                <option value="Constantine">Constantine</option>
                                                <option value="Médéa">Médéa</option>
                                                <option value="Mostaganem">Mostaganem</option>
                                                <option value="M'Sila">M'Sila</option>
                                                <option value="Mascara">Mascara</option>
                                                <option value="Ouargla">Ouargla</option>
                                                <option value="Oran">Oran</option>
                                                <option value="El Bayadh">El Bayadh</option>
                                                <option value="Illizi">Illizi</option>
                                                <option value="Bordj Bou Arreridj">Bordj Bou Arreridj</option>
                                                <option value="Boumerdès">Boumerdès</option>
                                                <option value="El Tarf">El Tarf</option>
                                                <option value="Tindouf">Tindouf</option>
                                                <option value="Tissemsilt">Tissemsilt</option>
                                                <option value="El Oued">El Oued</option>
                                                <option value="Khenchela">Khenchela</option>
                                                <option value="Souk Ahras">Souk Ahras</option>
                                                <option value="Tipaza">Tipaza</option>
                                                <option value="Mila">Mila</option>
                                                <option value="ain-defla">Aïn Defla</option>
                                                <option value="naama">Naâma</option>
                                                <option value="Aïn Témouchent">Aïn Témouchent</option>
                                                <option value="ghardaia">Ghardaia</option>
                                                <option value="Relizane">Relizane</option>
                                                <option value="Timimoun">Timimoun </option>
                                                <option value="Bordj Badji Mokhtar">Bordj Badji Mokhtar</option>
                                                <option value="Ouled Djellal">Ouled Djellal</option>
                                                <option value="Béni Abbès">Béni Abbès</option>
                                                <option value="Ain Salah">Aïn Salah</option>
                                                <option value="Ain Guezzam">Aïn Guezzam</option>
                                                <option value="Touggourt">Touggourt</option>
                                                <option value="Djanet">Djanet </option>
                                                <option value="El M'Ghair">El M'Ghair</option>
                                                <option value="El Meniaa">El Meniaa</option>
                                            </select>
                                        @error('state')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                    {{-- ---------------------------------------------------- --}}

                                </div>
                                <div class="col-3">
                                    <!-- Modal customer notes -->
                                    <div class="form-group">
                                        <label for="customSwitch1">Revendeur</label>
                                        <div class="custom-control custom-switch" style="min-width: 180px;margin-right: 80px;">
                                            <input type="checkbox" class="custom-control-input" id="isReseller" checked="" wire:model.defer="data.is_reseller">
                                            <label class="custom-control-label" for="isReseller"></label>
                                          </div>
                                        @error('is_reseller')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                    {{-- ---------------------------------------------------- --}}

                                </div>
                                <div class="col-3">
                                    <!-- Modal customer notes -->
                                    <div class="form-group">
                                        <label for="customSwitch1">Actif</label>
                                        <div class="custom-control custom-switch" style="min-width: 180px;margin-right: 80px;">
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
                            <div class="row h-100 justify-content-center align-items-center">

                                <div class="col-12">
                                    <!-- Modal customer notes -->
                                    <div class="form-group">
                                        <label for="notes">Remarques</label>
                                        <textarea type="textarea" tabindex="1" wire:model.defer="data.notes"
                                            class="form-control @error('notes') is-invalid @enderror" id="notes" aria-describedby="nameHelp"
                                            placeholder="Remarques">
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
