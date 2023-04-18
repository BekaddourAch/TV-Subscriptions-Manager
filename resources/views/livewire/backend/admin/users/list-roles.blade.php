<div>
    @section('style')
    <style>

    </style>
    @endsection

    <div class="shadow card">
        <div class="py-3 card-header">
            <ol class="m-0 breadcrumb float-sm-left font-weight-bold text-primary">
                <li class="breadcrumb-item"><a href="{{ route('admin.index') }}">Page Principale</a></li>
                <li class="breadcrumb-item active">Roles</li>
            </ol>

            @if(Auth::user()->hasPermission('users-create'))
            <div class="mt-2 d-flex justify-content-end">
                <button wire:click.prevent='addNewRole' class="ml-1 btn btn-sm btn-primary">
                    <i class="mr-2 fa fa-plus-circle"
                        aria-hidden="true">
                        <span>Ajouter un  Role</span>
                    </i>
                </button>
            </div>
            @endif
        </div>

        <div class="p-3 card-body">
            <div class="table-responsive">
                <table class="table">
                    <thead class="text-white bg-dark">
                        <tr class="text-center">
                            <th class="align-middle" scope="col">#</th>
                            <th class="align-middle">
                                Nom
                            </th>
                            <th class="align-middle">
                                Dispaly Name
                            </th>
                            <th class="align-middle d-none d-md-table-cell">
                                Description
                            </th>
                            <th class="align-middle d-none d-md-table-cell">
                                Permissions
                            </th>

                            @if((Auth::user()->hasPermission('users-update')) || (Auth::user()->hasPermission('users-delete')))
                                <th class="align-middle" style="width: 10px" colspan="2">Actions</th>
                            @endif
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($roles as $role)

                        @if($role->id!=1)
                        <tr class="text-center">
                            <td class="align-middle" scope="row">{{ $loop->iteration }}</td>
                            <td class="align-middle">{{ $role->name }}</td>
                            <td class="align-middle">{{ $role->display_name }}</td>
                            <td class="align-middle d-none d-md-table-cell">{{ $role->description }}</td>
                            <td class="align-middle d-none d-md-table-cell">{{ $role->permissions()->count() }}</td>

                            @if((Auth::user()->hasPermission('users-update')) || (Auth::user()->hasPermission('users-delete')))
                            <td class="align-middle">
                                <div class="btn-group btn-group-sm">
                                    @if(Auth::user()->hasPermission('users-update'))
                                        <a href="#" wire:click.prevent="edit({{ $role }})" class="btn btn-primary">
                                            <i class="fa fa-edit"></i>
                                        </a>
                                    @endif
                                    @if(Auth::user()->hasPermission('users-delete'))
                                        <a class="btn btn-danger" href="#" wire:click.prevent="confirmRoleRemoval({{ $role->id }})">
                                            <i class="fa fa-trash bg-danger"></i>
                                        </a>
                                    @endif

                                </div>
                                <form action="" method="post" id="delete-role-{{ $role->id }}" class="d-none">
                                    @csrf
                                    @method('DELETE')
                                </form>
                            </td>
                            @endif
                        </tr>
                        @endif
                        @empty
                        <tr>
                            <td colspan="6" class="text-center">Aucun rôle trouvé</td>
                        </tr>
                        @endforelse
                    </tbody>
                    <tfoot>
                        <tr class="bg-light">
                            <td colspan="6">
                                {!! $roles->appends(request()->all())->links() !!}
                            </td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>

    <!-- Modal Create or Update Role -->

    <div class="modal fade" id="form" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog " role="document">
            <form autocomplete="off" wire:submit.prevent="{{ $showEditModal ? 'updateRole' : 'createRole' }}">
                <div class="modal-content">
                    <div class="modal-header bg-light">
                        <h5 class="modal-title" id="exampleModalLabel">
                            @if ($showEditModal)
                                <span>Modifier le rôle</span>
                            @else
                            <span>Ajouter un nouveau rôle</span>
                            @endif
                        </h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row h-100 justify-content-center align-items-center">
                            <div class="col-12">

                                <!-- Modal Role Name -->

                                <div class="form-group">
                                    <label for="name">Nom</label>
                                    <input type="text" tabindex="1" wire:model.defer="data.name" class="form-control @error('name') is-invalid @enderror" id="name" aria-describedby="nameHelp" placeholder="Enter role name">
                                    @error('name')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>

                                <!-- Modal Role Display Name -->

                                <div class="form-group">
                                    <label for="display_name">Nom d'affichage</label>
                                    <input type="text" tabindex="1" wire:model.defer="data.display_name" class="form-control @error('display_name') is-invalid @enderror" id="display_name" aria-describedby="display_nameHelp" placeholder="Enter role displayname">
                                    @error('display_name')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>

                                <!-- Modal Role description -->

                                <div class="form-group">
                                    <label for="description">Description</label>
                                    <input type="text" tabindex="1" wire:model.defer="data.description" class="form-control @error('description') is-invalid @enderror" id="description" aria-describedby="descriptionHelp" placeholder="Enter role description">
                                    @error('description')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Modal Role Permissions -->

                        <div id="permissions" class="form-group">
                            <div class="mb-2 card d-flex justify-content-center">
                                <div class="card-header">
                                    <h4 class="text-center">Permissions</h4>
                                </div>
                                <div class="card-body">


    {{-- // echo'<pre>';
        // var_dump($array_permissions);
        // echo'</pre>'; --}}
                                            @foreach ($array_permissions as $index => $permissions)
                                            <div class="sce" style="margin:1 0;padding:2 0">

                                            <h6 class="m-0 font-weight-bold text-primary">{{ $index }}</h6> <br>
                                            <div class="cra" style="display:flex;">

                                                    @foreach ($permissions as $permission)
                                                    <div class="trs" style="margin">
                                                        <div class="form-group">
                                                            <div class="custom-control form-checkbox small">
                                                                <label class="items-center" :key="{{ $permission->id }}">
                                                                    <input
                                                                        type="checkbox"
                                                                        name="role_permissions.{{ $permission->id }}"
                                                                        wire:model.defer="role_permissions.{{ $permission->id }}"
                                                                        value="{{ $permission->id }}"
                                                                        class="form-checkbox"
                                                                    />
                                                                    <span class="mr-1">{{ $permission->display_name }}</span>
                                                                </label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    @endforeach
                                            </div>
                                            <hr>
                                            </div>
                                            @endforeach
                                </div>
                            </div>
                            {{-- @endforeach --}}
                        </div>
                    </div>

                    <div class="modal-footer bg-light">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="mr-1 fa fa-times"></i> Annuler</button>
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

    <!-- Modal Delete Role -->
    <div class="modal fade" id="confirmationModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header bg-light">
                    <h5>Delete Role</h5>
                </div>

                <div class="modal-body">
                    <h4>Voulez-vous vraiment supprimer ce rôle ?</h4>
                </div>

                <div class="modal-footer bg-light">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="mr-1 fa fa-times"></i> Annuler</button>
                    <button type="button" wire:click.prevent="deleteRole" class="btn btn-danger"><i class="mr-1 fa fa-trash"></i>Supprimer le rôle</button>
                </div>
            </div>
        </div>
    </div>

    {{-- JS Code --}}

    @section('script')
        <script src="{{ asset('backend/js/backend.js') }}"></script>

        {{-- show or hide Permissions section on Modal --}}

        <script>
            $(document).ready( function() {
                //
            });
        </script>

        {{-- show-delete-alert-confirmation --}}

        <script>
            window.addEventListener('show-delete-alert-confirmation', event =>{
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
    @endsection
</div>
