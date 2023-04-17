<div>
    @section('style')
        <style>

        </style>
    @endsection

    <div class="shadow card">
        <div class="py-3 card-header">
            <ol class="m-0 breadcrumb float-sm-left font-weight-bold text-primary">
                <li class="breadcrumb-item"><a href="{{ route('admin.index') }}">Page Principale</a></li>
                <li class="breadcrumb-item active">Les Abonnements</li>
            </ol>
            <div class="mt-2 d-flex justify-content-end">

                @if (0 == 1)
                    {{-- <div class="ml-3 dropdown">
                    <button class="btn btn-primary dropdown-toggle" type="button" id="dropdownMenuButton2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        subscriptions
                    </button>
                    <div class="bg-gray-100 dropdown-menu animated--fade-in" aria-labelledby="dropdownMenuButton2" style="">
                        <a class="dropdown-item" wire:click.prevent="exportExcel" href="#">Exporter vers Excel</a>
                        <a class="dropdown-item" wire:click.prevent="importExcelForm" href="#">Importer depuis Excel</a>
                        <a class="dropdown-item" wire:click.prevent="exportPDF" href="#">Export to PDF</a>
                    </div>
                </div> --}}
                @endif

                @if (Auth::user()->hasPermission('subscription-create'))
                    <button wire:click.prevent='addNewSubscription' class="ml-1 btn btn-sm btn-primary">
                        <i class="mr-2 fa fa-plus-circle" aria-hidden="true">
                            <span>Ajouter un Abonnement</span>
                        </i>
                    </button>
                @endif
            </div>
        </div>
        <div class="flex-wrap d-flex justify-content-between">
            <div class="pt-3 my-2 ml-3 ml-md-3 my-md-0 mw-80 navbar-search">
                <div class="input-group">
                    <input wire:model="searchTerm" type="text" class="border-0 form-control bg-light small"
                        placeholder="Rechercher..." aria-label="Search" aria-describedby="basic-addon2"
                        spellcheck="false" data-ms-editor="true">
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
                                {{ $subscriptionsCount }}
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

                        <span class="text-gray-900 font-weight-bold">{{ count($selectedRows) }}</span>
                        {{ Str::plural('subscriptions', count($selectedRows)) }} Sélectionné
                    </span>

                    <div class="ml-3 dropdown">
                        <button class="btn btn-secondary dropdown-toggle btn-sm" type="button" id="dropdownMenuButton"
                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Actions
                        </button>
                        <div class="bg-gray-100 dropdown-menu animated--fade-in" aria-labelledby="dropdownMenuButton"
                            style="">

                            @if (Auth::user()->hasPermission('subscription-delete'))
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item text-danger delete-confirm"
                                    wire:click.prevent="deleteSelectedRows" href="#">Supprimer les Abonnements
                                    sélectionnée</a>
                            @endif
                        </div>
                    </div>
                </div>
            @endif
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead class="text-white bg-primary">
                        <tr class="text-center">

                            @if (Auth::user()->hasPermission('subscription-update') || Auth::user()->hasPermission('subscription-delete'))
                                <th class="align-middle" scope="col">
                                    <div class="custom-control custom-checkbox small">
                                        <input type="checkbox" wire:model="selectPageRows" value=""
                                            class="custom-control-input" id="customCheck">
                                        <label class="custom-control-label" for="customCheck"></label>
                                    </div>
                                </th>
                            @endif
                            <th class="align-middle" scope="col">#</th>

                            <th class="align-middle"> Service
                                <span wire:click="sortBy('services.name')" class="text-sm float-sm-right" style="cursor: pointer;font-size:10px;">
                                    <i class="mr-1 fa fa-arrow-up" style="color:{{ $sortColumnName === 'services.name' && $sortDirection === 'asc' ? '#90EE90' : '' }}"></i>
                                    <i class="fa fa-arrow-down" style="color : {{ $sortColumnName === 'services.name' && $sortDirection === 'desc' ? '#90EE90' : '' }}"></i>
                                </span>
                            </th>
                            <th class="align-middle"> Client
                                <span wire:click="sortBy('concat(customers.firstname ,\' \', customers.lastname)')" class="text-sm float-sm-right" style="cursor: pointer;font-size:10px;">
                                    <i class="mr-1 fa fa-arrow-up" style="color:{{ $sortColumnName === "concat(customers.firstname ,' ', customers.lastname)" && $sortDirection === 'asc' ? '#90EE90' : '' }}"></i>
                                    <i class="fa fa-arrow-down" style="color : {{ $sortColumnName === "concat(customers.firstname ,' ', customers.lastname)" && $sortDirection === 'desc' ? '#90EE90' : '' }}"></i>
                                </span>
                            </th>
                            <th class="align-middle"> Créer par
                                <span wire:click="sortBy('users.name')" class="text-sm float-sm-right" style="cursor: pointer;font-size:10px;">
                                    <i class="mr-1 fa fa-arrow-up" style="color:{{ $sortColumnName === 'users.name' && $sortDirection === 'asc' ? '#90EE90' : '' }}"></i>
                                    <i class="fa fa-arrow-down" style="color : {{ $sortColumnName === 'users.name' && $sortDirection === 'desc' ? '#90EE90' : '' }}"></i>
                                </span>
                            </th>
                                <th class="align-middle"> Total
                                    <span wire:click="sortBy('subscriptions.total')" class="text-sm float-sm-right" style="cursor: pointer;font-size:10px;">
                                    <i class="mr-1 fa fa-arrow-up" style="color:{{ $sortColumnName === 'subscriptions.total' && $sortDirection === 'asc' ? '#90EE90' : '' }}"></i>
                                    <i class="fa fa-arrow-down" style="color : {{ $sortColumnName === 'subscriptions.total' && $sortDirection === 'desc' ? '#90EE90' : '' }}"></i>
                                </span>
                                </th>
                            <th class="align-middle"> Date Début
                                <span wire:click="sortBy('subscriptions.begin_date')" class="text-sm float-sm-right" style="cursor: pointer;font-size:10px;">
                                    <i class="mr-1 fa fa-arrow-up" style="color:{{ $sortColumnName === 'subscriptions.begin_date' && $sortDirection === 'asc' ? '#90EE90' : '' }}"></i>
                                    <i class="fa fa-arrow-down" style="color : {{ $sortColumnName === 'subscriptions.begin_date' && $sortDirection === 'desc' ? '#90EE90' : '' }}"></i>
                                </span>
                            </th>
                            <th class="align-middle"> Date Fin
                                <span wire:click="sortBy('subscriptions.end_date')" class="text-sm float-sm-right" style="cursor: pointer;font-size:10px;">
                                    <i class="mr-1 fa fa-arrow-up" style="color:{{ $sortColumnName === 'subscriptions.end_date' && $sortDirection === 'asc' ? '#90EE90' : '' }}"></i>
                                    <i class="fa fa-arrow-down" style="color : {{ $sortColumnName === 'subscriptions.end_date' && $sortDirection === 'desc' ? '#90EE90' : '' }}"></i>
                                </span>
                            </th>
                            <th class="align-middle"> Remarques
                                <span wire:click="sortBy('subscriptions.notes')" class="text-sm float-sm-right" style="cursor: pointer;font-size:10px;">
                                    <i class="mr-1 fa fa-arrow-up" style="color:{{ $sortColumnName === 'subscriptions.notes' && $sortDirection === 'asc' ? '#90EE90' : '' }}"></i>
                                    <i class="fa fa-arrow-down" style="color : {{ $sortColumnName === 'subscriptions.notes' && $sortDirection === 'desc' ? '#90EE90' : '' }}"></i>
                                </span>
                            </th>

                            @if (Auth::user()->hasPermission('subscription-update') || Auth::user()->hasPermission('subscription-delete'))
                                <th class="align-middle" style="width: 10%" colspan="2">Actions </th>
                            @endif
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($subscriptions as $index => $subscription)
                            <tr class="text-center">

                                @if (Auth::user()->hasPermission('subscription-update') || Auth::user()->hasPermission('subscription-delete'))
                                    <td class="align-middle" scope="col" wire:ignore>
                                        <div class="custom-control custom-checkbox small">
                                            <input type="checkbox" wire:model="selectedRows"
                                                value="{{ $subscription->id_subscription }}"
                                                class="custom-control-input" id="{{ $subscription->id_subscription }}">
                                            <label class="custom-control-label"
                                                for="{{ $subscription->id_subscription }}"></label>
                                        </div>
                                    </td>
                                @endif
                                <td class="align-middle" scope="row">{{ $subscription->id_subscription }}</td>
                                <td class="align-middle text-left">{{ $subscription->Service->name }}</td>
                                <td class="align-middle text-left">
                                    {{ $subscription->Customer->firstname . ' ' . $subscription->Customer->lastname }}
                                </td>
                                <td class="align-middle d-none d-md-table-cell">{{ $subscription->User->name }}</td>
                                <td class="align-middle d-none d-md-table-cell">{{ formatPrice($subscription->total) }}</td>
                                <td class="align-middle d-none d-md-table-cell">{{ formatDate($subscription->begin_date) }}</td>
                                <td class="align-middle d-none d-md-table-cell">{{ formatDate($subscription->end_date) }}</td>
                                <td class="align-middle text-left d-none d--table-cell">{{ $subscription->notes }}</td>

                                @if (Auth::user()->hasPermission('subscription-update') || Auth::user()->hasPermission('subscription-delete'))
                                    <td class="align-middle">
                                        <div class="btn-group btn-group-sm">

                                            @if (Auth::user()->hasPermission('subscription-update'))
                                                <a href="#"
                                                    wire:click.prevent="edit({{ $subscription->id_subscription }})"
                                                    class="btn btn-primary">
                                                    <i class="fa fa-edit"></i>
                                                </a>
                                            @endif

                                            @if (Auth::user()->hasPermission('subscription-delete'))
                                                <a class="btn btn-danger" href="#"
                                                    wire:click.prevent="confirmSubscriptionRemoval({{ $subscription->id_subscription }})">
                                                    <i class="fa fa-trash bg-danger"></i>
                                                </a>
                                            @endif
                                        </div>
                                        <form action="" method="post"
                                            id="delete-subscription-{{ $subscription->id_subscription }}"
                                            class="d-none">
                                            @csrf
                                            @method('DELETE')
                                        </form>
                                    </td>
                                @endif
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center">Aucun abonnement trouvé</td>
                            </tr>
                        @endforelse
                    </tbody>
                    <tfoot>
                        <tr class="bg-light">
                            <td colspan="14">
                                {!! $subscriptions->appends(request()->all())->links() !!}
                            </td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>

    <!-- Modal Create or Update subscription -->

    <div class="modal fade" id="form" tabindex="-1" subscription="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog" subscription="document">
            <form autocomplete="off"
                wire:submit.prevent="{{ $showEditModal ? 'updateSubscription' : 'createSubscription' }}">
                <div class="modal-content">
                    <div class="modal-header bg-light">
                        <h5 class="modal-title" id="exampleModalLabel">
                            @if ($showEditModal)
                                <span>Modifier l'Abonnement<span>
                                    @else
                                        <span>Ajouter un nouveau Abonnement</span>
                            @endif
                        </h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row h-100 justify-content-center align-items-center">
                            <div class="col-12">
                                <!-- Modal subscription name -->
                                <div class="form-group">
                                    <select class=" form-control  show-tick" wire:model.defer="data.id_customer"
                                        data-live-search="true" title="Selectionnez un client" id="customer_select">
                                        @foreach ($customers as $customer)
                                            <option value="{{ $customer->id_customer }}"
                                                wire:key="{{ $customer->id_customer }}">
                                                {{ $customer->firstname . ' ' . $customer->lastname }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-12">
                                <!-- Modal subscription description -->
                                <div class="form-group">
                                    <div class="form-group">
                                        <select class=" form-control  show-tick" wire:model.defer="data.id_service"
                                            data-live-search="true" onchange="onServicesChange(this)"
                                            title="Selectionez un service" id="service_select">
                                            @foreach ($services as $service)
                                                <option value="{{ $service->id_service }}"
                                                    wire:key="{{ $service->id_service }}"
                                                    data-object="{{ base64_encode(json_encode(['cost_price' => $service->cost_price, 'selling_price' => $service->selling_price, 'duration_unit' => $service->duration_unit, 'duration' => $service->duration])) }}">
                                                    {{ $service->name }}</option>
                                            @endforeach
                                        </select>




                                        @error('description')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                    {{-- ---------------------------------------------------- --}}

                                </div>
                            </div>

                        </div>
                        <div class="row h-100 justify-content-center align-items-center">
                            <div class="col-6">
                                <!-- Modal subscription cost price -->
                                <div class="form-group">
                                    <label for="cost_price">Prix d'Achat</label>
                                    <input type="number" min="1" tabindex="1"
                                        wire:model.defer="data.cost_price" value="" readonly
                                        class="form-control @error('cost_price') is-invalid @enderror" id="cost_price"
                                        aria-describedby="nameHelp">
                                    @error('cost_price')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                {{-- ---------------------------------------------------- --}}

                            </div>
                            <div class="col-6">
                                <!-- Modal subscription selling price -->
                                <div class="form-group">
                                    <label for="selling_price">Prix de Vente</label>
                                    <input type="number" min="1" tabindex="1"
                                        wire:model.defer="data.selling_price"
                                        class="form-control @error('selling_price') is-invalid @enderror"
                                        id="selling_price" aria-describedby="nameHelp">
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

                            <div class="col-12">
                                <!-- Modal subscription quantity -->
                                <div class="form-group">
                                    <label for="quantity">Quantité</label>
                                    <input type="number" min="1" tabindex="1"
                                        wire:model.defer="data.quantity"
                                        class="form-control @error('quantity') is-invalid @enderror" id="quantity"
                                        aria-describedby="nameHelp">
                                    @error('quantity')
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
                                <!-- Modal subscription begin_date type -->
                                <div class="form-group">
                                    <label for="begin_date">Date début</label>
                                    <input type="date" min="1" tabindex="1"
                                        wire:model.defer="data.begin_date"
                                        class="form-control @error('begin_date') is-invalid @enderror" id="begin_date"
                                        aria-describedby="nameHelp">
                                    @error('begin_date')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                {{-- ---------------------------------------------------- --}}

                            </div>
                            <div class="col-6">

                                <div class="form-group">
                                    <label for="end_date">Date fin</label>
                                    <input type="date" min="1" tabindex="1"
                                        wire:model.defer="data.end_date"
                                        class="form-control @error('end_date') is-invalid @enderror" id="end_date"
                                        aria-describedby="nameHelp">

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
                                    <textarea tabindex="1" wire:model.defer="data.notes" class="form-control @error('notes') is-invalid @enderror"
                                        id="notes" aria-describedby="nameHelp" placeholder="">
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
                </div>
            </form>
        </div>
    </div>

    <!-- Modal Delete subscription -->
    <div class="modal fade" id="confirmationModal" tabindex="-1" subscription="dialog"
        aria-labelledby="exampleModalLabel" aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog" subscription="document">
            <div class="modal-content">
                <div class="modal-header bg-light">
                    <h5>Supprimer l'Abonnement</h5>
                </div>

                <div class="modal-body">
                    <h4>Voulez-vous vraiment supprimer l'Abonnement ?</h4>
                </div>

                <div class="modal-footer bg-light">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal"><i
                            class="mr-1 fa fa-times"></i> Annuler</button>
                    <button type="button" wire:click.prevent="deleteSubscription" class="btn btn-danger"><i
                            class="mr-1 fa fa-trash"></i>Supprimer l'Abonnement</button>
                </div>
            </div>
        </div>
    </div>

    {{-- JS Code --}}

    @section('script')

        <script src="{{ asset('backend/js/backend.js') }}"></script>

        {{-- show or hide subscriptions section on Modal --}}
        <script>
            $(document).ready(function() {
                window.addEventListener('show-import-excel-modal', function(event) {
                    $('#importExcelModal').modal('show');
                });

                window.addEventListener('hide-import-excel-modal', function(event) {
                    $('#importExcelModal').modal('hide');
                });
            });
        </script>


        {{-- show-delete-alert-confirmation --}}

        <script>
            // To style all selects
            window.addEventListener('show-delete-alert-confirmation', event => {
                Swal.fire({
                    title: 'Es-tu sûr?',
                    text: "Vous ne pourrez pas revenir en arrière !",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Oui, supprimez-le !'
                }).then((result) => {
                    if (result.isConfirmed) {
                        Livewire.emit('deleteConfirmed')
                    }
                })
            })
        </script>
        <script>
            window.addEventListener('post-show-form', event => {
                // $('#service_select').css( { "display", "block !important" } );

                // $('#customer_select').css( { "display", "block !important" } );

                $('#customer_select').selectpicker();

                $('#service_select').selectpicker();
                // $('.selectpicker').selectpicker();

            });
        </script>
        <script>
            const dateToInput = date =>
                `${date.getFullYear() }-${('0' + (date.getMonth() + 1)).slice(-2) }-${('0' + date.getDate()).slice(-2) }`;

            // str is expected in yyyy-mm-dd format (e.g., "2017-03-14")
            const inputToDate = str => new Date(str.split('-'));


            function onServicesChange(thing) {
                //var service=btoa($(thing).data('object'));
                var service = $('option:selected', thing).data('object')
                var serv_object = atob(service)
                var servc_json = JSON.parse(serv_object)
                $('#form #cost_price').val(servc_json.cost_price);
                @this.set('data.cost_price', servc_json.cost_price, true);

                $('#form #selling_price').val(servc_json.selling_price);
                @this.set('data.selling_price', servc_json.selling_price, true);


                console.log(increment_date('jour', 10));

                $('#form .row #begin_date').val(dateToInput(new Date()));
                @this.set('data.begin_date', dateToInput(new Date()), true);

                $('#form .row #end_date').val(increment_date(servc_json.duration_unit, servc_json.duration));
                @this.set('data.end_date', increment_date(servc_json.duration_unit, servc_json.duration), true);
            }



            function increment_date(unit, duree) {
                var answer = ""

                var date = new Date();
                switch (unit) {
                    case 1:
                        //date.getDate() + 1
                        date.setDate(date.getDate() + duree);
                        break;
                    case 2:
                        date.setDate(date.getDate() + duree * 7);
                        break;
                    case 3:
                        // increase the date by 6 months
                        date.setMonth(date.getMonth() + duree);
                        break;
                    case 4:
                        // increase the date by 2 years
                        date.setFullYear(date.getFullYear() + duree);
                        break;
                }
                answer = dateToInput(date);
                return answer;
            }

            //  theTest(servc_json.cost_price);
        </script>
        {{-- <script  src="{{ asset("") }}"></script> --}}
    @endsection
</div>
