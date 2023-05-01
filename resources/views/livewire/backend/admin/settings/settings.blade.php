<div>
    @section('style')
    @endsection

    <div class="shadow card">
        <div class="py-3 card-header">
            <ol class="m-0 breadcrumb float-sm-left font-weight-bold text-primary">
                <li class="breadcrumb-item"><a href="{{ route('admin.index') }}">Page Principale</a></li>
                <li class="breadcrumb-item active">Configuration</li>
            </ol>
        </div>
        <div class="p-3 card-body">
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead class="text-white bg-dark">
                        <tr>
                            <th>Nom</th>
                            <th>Valeur</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($settings as $key => $value)
                            <tr>
                                <td>{{ isset($frLang[$key]) ? $frLang[$key] :  $key }}</td>
                                <td>
                                    <input type="text" wire:model="settings.{{ $key }}"  wire:change="updateField('{{ $key }}', $event.target.value)" >
                                </td>
                                <td>
                                    <a class="btn btn-danger" href="#"  wire:click.prevent="confirmSettingRemoval('{{ $key }}')">
                                        <i class="fa fa-trash bg-danger"></i>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Modal Delete subscription -->
    <div class="modal fade" id="confirmationModal" tabindex="-1" subscription="dialog"
         aria-labelledby="exampleModalLabel" aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog" setting="document">
            <div class="modal-content">
                <div class="modal-header bg-light">
                    <h5>Supprimer la config</h5>
                </div>

                <div class="modal-body">
                    <h4>Voulez-vous vraiment supprimer la config ?</h4>
                </div>

                <div class="modal-footer bg-light">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal"><i
                            class="mr-1 fa fa-times"></i> Annuler</button>
                    <button type="button" wire:click.prevent="forgetField" class="btn btn-danger"><i
                            class="mr-1 fa fa-trash"></i>Supprimer la config</button>
                </div>
            </div>
        </div>
    </div>

    @section('script')

            <script src="{{ asset('backend/js/backend.js') }}"></script>

    @endsection
</div>
