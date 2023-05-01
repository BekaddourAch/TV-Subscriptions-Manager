<div>
    @section('style')
        <style>

        </style>
    @endsection

    <div class="shadow card">
        <div class="py-3 card-header">
            <ol class="m-0 breadcrumb float-sm-left font-weight-bold text-primary">
                <li class="breadcrumb-item"><a href="{{ route('admin.index') }}">Page Principale</a></li>
                <li class="breadcrumb-item"><a href="{{ route('admin.services') }}">Les Services</a></li>
                <li class="breadcrumb-item active">{{$service->name}}</li>
            </ol>
        </div>
        <form autocomplete="off" wire:submit.prevent="{{'updateService'}}">
            <div>
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

    <div class="shadow card mt-4" >
        <div class="py-3 card-header">
            <ol class="m-0 breadcrumb float-sm-left font-weight-bold text-primary">
                <li class="breadcrumb-item"><a href="{{ route('admin.subscriptions') }}">Les Abonnés</a></li>
            </ol>
            <div class="mt-2 d-flex justify-content-end">

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
        </div>


        <div class="p-3 card-body">
            <div class="table-responsive" >
                <table class="table" >
                    <thead class="text-white bg-dark">
                    <tr class="text-center">

                        <th class="align-middle" scope="col">#</th>
                        <th class="text-left align-middle "> Client </th>
                        <th class="align-middle d-none d-md-table-cell"> Prix d'Achat </th>
                        <th class="align-middle d-none d-md-table-cell"> Quantité </th>
                        <th class="align-middle d-none d-md-table-cell"> Prix de Vente </th>
                        <th class="align-middle d-none d-md-table-cell"> Total </th>
                        <th class="align-middle d-none d-md-table-cell"> Date Début </th>
                        <th class="align-middle d-none d-md-table-cell"> Date Fin </th>
                        <th class="align-middle"> A Expirer dans (jours) </th>

                    </tr>
                    </thead>
                    <tbody >
                    @forelse($subscriptions as $index => $subscription)
                        <tr class="text-center">

                            <td class="align-middle" scope="row">#{{ $subscription["id_subscription"] }}</td>
                            <td class="align-middle text-left">
                                <a  class="text-primary" href="{{route("admin.customer-details",$subscription["id_customer"])}}">{{ $subscription["firstname"] . ' ' . $subscription["lastname"] }}</a>
                            </td>
                            <td class="align-middle d-none d-md-table-cell">{{ formatPrice($subscription["cost_price"]) }}</td>
                            <td class="align-middle d-none d-md-table-cell">{{ $subscription["quantity"] }}</td>
                            <td class="align-middle d-none d-md-table-cell">{{ formatPrice($subscription["selling_price"]) }}</td>
                            <td class="align-middle d-none d-md-table-cell">{{ formatPrice($subscription["total"]) }}</td>
                            <td class="align-middle d-none d-md-table-cell">{{ formatDate($subscription["begin_date"]) }}</td>
                            <td class="align-middle d-none d-md-table-cell">{{ formatDate($subscription["end_date"]) }}</td>
                            <td class="align-middle">
                                <div class="progress">
                                    <div class="progress-bar @if($subscription["nb_days"]>20) bg-info @elseif($subscription["nb_days"]>10) bg-warning @else bg-danger @endif " role="progressbar" style="width: {{ formatTwoDecimal(100-($subscription["nb_days"]*100/30)) }}%;" aria-valuenow="{{ formatTwoDecimal(100-($subscription["nb_days"]*100/30))  }}" aria-valuemin="0" aria-valuemax="100">{{ $subscription["nb_days"]  }}</div>
                                </div>
                            </td>

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
                            {{--                            {!! $subscriptions->appends(request()->all())->links() !!}--}}
                        </td>
                    </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
    {{-- JS Code --}}
    @section('script')

    @endsection
</div>
