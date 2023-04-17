<div>
    @section('style')
        <style>

        </style>
    @endsection

    <div class="shadow card">
        <div class="py-3 card-header">
            <ol class="m-0 breadcrumb float-sm-left font-weight-bold text-primary">
                <li class="breadcrumb-item"><a href="{{ route('admin.index') }}">Page Principale</a></li>
                <li class="breadcrumb-item"><a href="{{ route('admin.customers') }}">Les Clients</a></li>
                <li class="breadcrumb-item active">{{$customer->firstname.' ' .$customer->lastname}}</li>
            </ol>
        </div>
        <form autocomplete="off" wire:submit.prevent="{{ 'updateCustomer' }}">
                    <div >
                        <div class="modal-body">
                            <div class="row h-100">
                                <div class="col-sm-12 col-lg-4 col-xl-3">
                                    <!-- Modal customer lastname -->
                                    <div class="form-group">
                                        <label for="firstname">Nom</label>
                                        <input type="text" tabindex="1" wire:model.defer="data.firstname"
                                               class="form-control @error('firstname') is-invalid @enderror" id="firstname"
                                               aria-describedby="nameHelp" placeholder="Saisissez le nom du client">
                                        @error('firstname')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                    {{-- ---------------------------------------------------- --}}

                                </div>
                                <div class="col-sm-12 col-lg-4 col-xl-3">
                                    <!-- Modal customer firstname -->
                                    <div class="form-group">
                                        <label for="lastname">Prénom</label>
                                        <input type="text" tabindex="1" wire:model.defer="data.lastname"
                                               class="form-control @error('lastname') is-invalid @enderror" id="lastname"
                                               aria-describedby="nameHelp" placeholder="Saisissez le prénom du client">
                                        @error('lastname')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                    {{-- ---------------------------------------------------- --}}
                                </div>

                                <div class="col-sm-12 col-lg-4 col-xl-3">
                                    <!-- Modal customer phone1 -->
                                    <div class="form-group">
                                        <label for="phone1">Téléphone 1</label>
                                        <input  type="tel" tabindex="1" placeholder="ex:0655112233" required wire:model.defer="data.phone1"
                                                class="form-control @error('phone1') is-invalid @enderror" id="phone1"
                                                aria-describedby="nameHelp" placeholder="Entrez le 1er téléphone  du client">
                                        @error('phone1')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                    {{-- ---------------------------------------------------- --}}

                                </div>
                                <div class="col-sm-12 col-lg-4 col-xl-3">
                                    <!-- Modal customer phone2 -->
                                    <div class="form-group">
                                        <label for="phone2">Téléphone 2</label>
                                        <input  type="tel" tabindex="1" placeholder="ex:0655112233"  wire:model.defer="data.phone2"
                                                class="form-control @error('phone2') is-invalid @enderror" id="phone2"
                                                aria-describedby="nameHelp" placeholder="Entrez le 2ème téléphone  du client">
                                        @error('phone2')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                    {{-- ---------------------------------------------------- --}}
                                </div>
                                <div class="col-sm-12 col-lg-4 col-xl-3">
                                    <!-- Modal customer email -->
                                    <div class="form-group">
                                        <label for="email">Email</label>
                                        <input type="text" tabindex="1" wire:model.defer="data.email"
                                               class="form-control @error('email') is-invalid @enderror" id="email"
                                               aria-describedby="nameHelp" placeholder="Entrez l'e-mail du client">
                                        @error('email')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                    {{-- ---------------------------------------------------- --}}

                                </div>
                                <div class="col-sm-12 col-lg-4 col-xl-3">
                                    <!-- Modal customer address -->
                                    <div class="form-group">
                                        <label for="address">Adresse</label>
                                        <input type="text" tabindex="1" wire:model.defer="data.address" class="form-control @error('address') is-invalid @enderror"
                                               id="address" aria-describedby="nameHelp" placeholder="Entrez l'adresse du client">

                                        @error('address')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                    {{-- ---------------------------------------------------- --}}
                                </div>
                                <div class="col-sm-12 col-lg-4 col-xl-3">
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
                                <div class="col-sm-12 col-lg-4 col-xl-3">
                                    <!-- Modal customer notes -->
                                    <div class="form-group">
                                        <label for="customSwitch1">Rendre le client Actif</label>
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
                                                  placeholder="Saisir les Remarques des clients">
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
                                    <span>Sauvegarder</span>
                            </button>
                        </div>
                    </div>
                </form>
    </div>

        <div class="shadow card mt-4" >
            <div class="py-3 card-header">
                <ol class="m-0 breadcrumb float-sm-left font-weight-bold text-primary">
                    <li class="breadcrumb-item"><a href="{{ route('admin.subscriptions') }}">Les Abonnements</a></li>
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
                        <thead class="text-white bg-primary">
                        <tr class="text-center">

                            <th class="align-middle" scope="col">#</th>
                            <th class="text-left align-middle "> Service </th>
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
                                <td class="align-middle text-left">{{ $subscription["service_name"] }}</td>
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
