<div>
    @section('style')
    <style>

    </style>
    @endsection

    <div class="shadow card">
        <div class="py-3 card-header">
            <ol class="m-0 breadcrumb float-sm-left font-weight-bold text-primary">
                <li class="breadcrumb-item"><a href="{{ route('admin.index') }}">Page Principale</a></li>
                <li class="breadcrumb-item active">Utilisateurs</li>
            </ol>
            <div class="mt-2 d-flex justify-content-end">
                @if(1==0)
                {{-- <div class="ml-3 dropdown">
                    <button class="btn btn-primary dropdown-toggle" type="button" id="dropdownMenuButton2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Services
                    </button>
                    <div class="bg-gray-100 dropdown-menu animated--fade-in" aria-labelledby="dropdownMenuButton2" style="">
                        <a class="dropdown-item" wire:click.prevent="exportExcel" href="#">Exporter vers Excel</a>
                        <a class="dropdown-item" wire:click.prevent="importExcelForm" href="#">Importer depuis Excel</a>
                    </div>
                </div> --}}

                @endif

                @if(Auth::user()->hasPermission('users-create'))
                    <button wire:click.prevent='addNewUser' class="ml-1 btn btn-sm btn-primary">
                        <i class="mr-2 fa fa-plus-circle"
                            aria-hidden="true">
                            <span>Ajouter un Utilisateur</span>
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
            @if(1==0)
            {{-- <div class="m-3 mw-100 justify-content-end">
                <div class="btn-group">
                    <div data-toggle="buttons">
                        <button wire:click="filterUsersByRoles" class="btn btn-sm btn-warning btn-icon-split">
                            <span class="icon text-white-20">
                                {{ $userCount }}
                            </span>
                            <span class="text">All</span>
                        </button>
                        <button wire:click="filterUsersByRoles('user')" class="btn btn-sm btn-info btn-icon-split">
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
                        </button>
                    </div>
                </div>
            </div> --}}
            @endif
        </div>

        <div class="p-3 card-body">
            @if ($selectedRows)
                <div class="mb-3 d-flex">
                    <span class="pt-1 text-success">
                         <span class="text-gray-900 font-weight-bold">{{ count($selectedRows) }}</span> {{ Str::plural('Utilisateure', count($selectedRows)) }}

                        sélectionné
                        <i class="fa fa-user" aria-hidden="true"></i>
                    </span>

                    <div class="ml-3 dropdown">
                        <button class="btn btn-secondary dropdown-toggle btn-sm" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Actions
                        </button>
                        <div class="bg-gray-100 dropdown-menu animated--fade-in" aria-labelledby="dropdownMenuButton" style="">
                            <a class="dropdown-item" wire:click.prevent="setAllAsActive" href="#">Définir comme actif</a>
                            <a class="dropdown-item" wire:click.prevent="setAllAsInActive" href="#">Définir comme inactif</a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item text-danger delete-confirm" wire:click.prevent="deleteSelectedRows" href="#">Supprimer les Utilisateurs sélectionnée</a>
                        </div>
                    </div>
                </div>
            @endif
            <div class="table-responsive">
                <table class="table">
                    <thead class="text-white  bg-primary">
                        <tr class="text-center">

                            @if((Auth::user()->hasPermission('users-update')) || (Auth::user()->hasPermission('users-delete')))
                                <th class="align-middle" scope="col">
                                    <div class="custom-control custom-checkbox small">
                                        <input type="checkbox" wire:model="selectPageRows" value="" class="custom-control-input" id="customCheck">
                                        <label class="custom-control-label" for="customCheck"></label>
                                    </div>
                                </th>
                            @endif

                            <th class="align-middle" scope="col">#</th>
                            <th class="text-left">
                                Nom
                                <span wire:click="sortBy('name')" class="text-sm float-sm-right" style="cursor: pointer;font-size:10px;">
                                    <i class="mr-1 fa fa-arrow-up" style="color:{{ $sortColumnName === 'name' && $sortDirection === 'asc' ? '#90EE90' : '' }}"></i>
                                    <i class="fa fa-arrow-down" style="color : {{ $sortColumnName === 'name' && $sortDirection === 'desc' ? '#90EE90' : '' }}"></i>
                                </span>
                            </th>
                            <th class="text-left">
                                Pseudo
                                <span wire:click="sortBy('username')" class="text-sm float-sm-right" style="cursor: pointer;font-size:10px;">
                                    <i class="mr-1 fa fa-arrow-up" style="color:{{ $sortColumnName === 'username' && $sortDirection === 'asc' ? '#90EE90' : '' }}"></i>
                                    <i class="fa fa-arrow-down" style="color : {{ $sortColumnName === 'username' && $sortDirection === 'desc' ? '#90EE90' : '' }}"></i>
                                </span>
                            </th>
                            <th class="align-middle d-none d-md-table-cell" scope="col">Photo</th>
                            <th class="text-left d-none d-md-table-cell">
                                Email
                                <span wire:click="sortBy('email')" class="text-sm float-sm-right" style="cursor: pointer;font-size:10px;">
                                    <i class="mr-1 fa fa-arrow-up" style="color:{{ $sortColumnName === 'email' && $sortDirection === 'asc' ? '#90EE90' : '' }}"></i>
                                    <i class="fa fa-arrow-down" style="color : {{ $sortColumnName === 'email' && $sortDirection === 'desc' ? '#90EE90' : '' }}"></i>
                                </span>
                            </th>
                            <th class="text-left d-none d-md-table-cell">
                                Tèlèphone
                            </th>
                            <th class="align-middle d-none d-md-table-cell">
                                Status
                                <span wire:click="sortBy('status')" class="text-sm float-sm-right" style="cursor: pointer;font-size:10px;">
                                    <i class="mr-1 fa fa-arrow-up" style="color:{{ $sortColumnName === 'status' && $sortDirection === 'asc' ? '#90EE90' : '' }}"></i>
                                    <i class="fa fa-arrow-down" style="color : {{ $sortColumnName === 'status' && $sortDirection === 'desc' ? '#90EE90' : '' }}"></i>
                                </span>
                            </th>
                            <th class="pl-5 pr-5 text-left">
                                Role
                            </th>
                            <th class=" d-none d-md-table-cell">
                                créé à
                                <span wire:click="sortBy('created_at')" class="text-sm float-sm-right" style="cursor: pointer;font-size:10px;">
                                    <i class="mr-1 fa fa-arrow-up" style="color:{{ $sortColumnName === 'created_at' && $sortDirection === 'asc' ? '#90EE90' : '' }}"></i>
                                    <i class="fa fa-arrow-down" style="color : {{ $sortColumnName === 'created_at' && $sortDirection === 'desc' ? '#90EE90' : '' }}"></i>
                                </span>
                            </th>

                            @if((Auth::user()->hasPermission('users-update')) || (Auth::user()->hasPermission('users-delete')))
                                <th class="align-middle" style="width: 10px" colspan="2">Actions</th>
                            @endif
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($users as $index => $user)
                            @if($user->id!=1)
                            <tr class="text-center">
                                @if((Auth::user()->hasPermission('users-update')) || (Auth::user()->hasPermission('users-delete')))
                                    <td class="align-middle" scope="col">
                                        <div class="custom-control custom-checkbox small">
                                            <input type="checkbox" wire:model="selectedRows" value="{{ $user->id }}" class="custom-control-input" id="{{ $user->id }}">
                                            <label class="custom-control-label" for="{{ $user->id }}"></label>
                                        </div>
                                    </td>
                                @endif
                                <td class="align-middle" scope="row">{{ $users->firstItem() + $index }}</td>
                                <td class="align-middle text-left">{{ $user->name }}</td>
                                <td class="align-middle text-left">{{ $user->username }}</td>
                                <td class="align-middle d-none d-md-table-cell">
                                    <img src="{{ $user->profile_photo_path ? $user->profile_url : $user->profile_photo_url }}" style="width: 50px;" class="img img-circle" alt="">
                                </td>
                                <td class="align-middle text-left d-none d-md-table-cell">{{ $user->email }}</td>
                                <td class="align-middle text-left d-none d-md-table-cell">{{ $user->mobile }}</td>
                                <td class="align-middle d-none d-md-table-cell">
                                    <span
                                        class="font-weight-bold badge text-white {{ $user->status == 1 ? 'bg-success' : 'bg-secondary' }}">{{
                                        $user->status() }}
                                    </span>
                                </td>
                                <td class="align-middle text-left">
                                    <select class="form-control form-control-sm" wire:change='updateUserRole({{ $user }}, $event.target.value)'>
                                        <option hidden>@lang('message.roles')</option>
                                        @foreach ($roles as $role)
                                            @if($role->id!=1)
                                            <option class="bg-red" value="{{ $role->id }}" {{ $user->roles[0]->name == $role->name ? 'selected' : '' }}>{{ $role->name }}</option>
                                            @endif
                                        @endforeach
                                    </select>
                                </td>
                                <td class="align-middle d-none d-md-table-cell">{{ $user->created_at->format('d-m-Y') }}</td>

                                @if((Auth::user()->hasPermission('users-update')) || (Auth::user()->hasPermission('users-delete')))
                                    <td class="align-middle">
                                        <div class="btn-group btn-group-sm">

                                            @if(Auth::user()->hasPermission('users-update'))
                                                <a href="#" wire:click.prevent="edit({{ $user }})" class="btn btn-primary">
                                                    <i class="fa fa-edit"></i>
                                                </a>
                                            @endif
                                            @if(Auth::user()->hasPermission('users-delete'))
                                                <a class="btn btn-danger" href="#" wire:click.prevent="confirmUserRemoval({{ $user->id }})">
                                                    <i class="fa fa-trash bg-danger"></i>
                                                </a>
                                            @endif

                                        </div>
                                        <form action="" method="post" id="delete-user-{{ $user->id }}" class="d-none">
                                            @csrf
                                            @method('DELETE')
                                        </form>
                                    </td>
                                @endif
                            </tr>
                            @endif
                        @empty
                        <tr>
                            <td colspan="10" class="text-center">Aucun Utilisateur trouvé</td>
                        </tr>
                        @endforelse
                    </tbody>
                    <tfoot>
                        <tr class="bg-light">
                            <td colspan="11">
                                {!! $users->appends(request()->all())->links() !!}
                            </td>
                        </tr>
                    </tfoot>
                </table>
               {{-- @dump($selectedRows) --}}
            </div>
        </div>
    </div>

    <!-- Modal Create or Update User -->

    <div class="modal fade" id="form" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog" role="document">
            <form autocomplete="off" wire:submit.prevent="{{ $showEditModal ? 'updateUser' : 'createUser' }}">
                <div class="modal-content">
                    <div class="modal-header bg-light">
                        <h5 class="modal-title" id="exampleModalLabel">
                            @if ($showEditModal)
                                <span>Modifier l'utilisateur</span>
                            @else
                            <span>Ajouter un nouvel utilisateur</span>
                            @endif
                        </h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        {{-- @if ($errors->hasAny(['image', 'image.*']))
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif --}}
                        <div class="row h-100 justify-content-center align-items-center">
                            <div class="col-6">

                                <!-- Modal User Full Name -->

                                <div class="form-group">
                                    <label for="name">Nom</label>
                                    <input type="text" tabindex="1" wire:model.defer="state.name" class="form-control @error('name') is-invalid @enderror" id="name" aria-describedby="nameHelp" placeholder="Nom">
                                    @error('name')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>

                                <!-- Modal User Email -->

                                <div class="form-group">
                                    <label for="email">Email</label>
                                    <input type="email" tabindex="3" wire:model.defer="state.email" class="form-control @error('email') is-invalid @enderror" id="email" aria-describedby="emailHelp" placeholder="Email">
                                    @error('email')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>

                                <!-- Modal User Password -->

                                <div class="form-group">
                                    <label for="password">Mot de passe</label>
                                    <input type="password" tabindex="5" wire:model.defer="state.password" class="form-control @error('password') is-invalid @enderror" id="password" placeholder="Mot de passe">
                                    @error('password')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-6">

                                <!-- Modal User Username -->

                                <div class="form-group">
                                    <label for="username">Pseudo</label>
                                    <input type="text" tabindex="2" wire:model.defer="state.username" class="form-control @error('username') is-invalid @enderror" id="username" aria-describedby="nameHelp" placeholder="Pseudo">
                                    @error('username')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>

                                <!-- Modal User Mobile -->

                                <div class="form-group">
                                    <label for="mobile">Mobile</label>
                                    <input type="text" tabindex="4" wire:model.defer="state.mobile" class="form-control @error('mobile') is-invalid @enderror" id="mobile" aria-describedby="nameHelp" placeholder="Numéro de téléphone">
                                    @error('mobile')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>

                                <!-- Modal User Password Confirmation -->

                                <div class="form-group">
                                    <label for="passwordConfirmation">Confirm Password</label>
                                    <input type="password" tabindex="6" wire:model.defer="state.password_confirmation" class="form-control" id="passwordConfirmation" placeholder="Confirmer le mot de passe">
                                </div>
                            </div>
                        </div>

                        <!-- Modal User Roles -->

                        <div id="roles" class="form-group">
                            <label for="role_id">Role</label>
                            <select id="roles" tabindex="7" class="form-control form-control @error('role_id') is-invalid @enderror" wire:model.defer="state.role_id" wire:change="permissions_form($event.target.value)">
                                <option hidden>@lang('Sélectionnez les rôles ..')</option>
                                @foreach ($roles as $role)
                                    @if($role->id!=1)
                                        <option class="bg-red" value="{{ $role->id }}">{{ $role->name }}</option>
                                    @endif
                                @endforeach
                            </select>
                            @error('role_id')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>

                        <!-- Modal User Photo -->

                        <div class="form-group">
                            <label for="custom-file">Photo d'utilisteur</label>
                            @if ($photo)
                                <img src="{{ $photo->temporaryUrl() }}" class="mb-2 d-block img img-circle" width="100px" alt="">
                            @else
                                <img src="{{ $state['profile_url'] ?? '' }}" class="mb-2 d-block img img-circle" width="100px" alt="">
                            @endif
                            <div class="mb-3 custom-file">
                                <div x-data="{ isUploading: false, progress: 5 }" x-on:livewire-upload-start="isUploading = true" x-on:livewire-upload-finish="isUploading = false; progress = 5" x-on:livewire-upload-error="isUploading = false" x-on:livewire-upload-progress="progress = $event.detail.progress">
                                    <input tabindex="8" wire:model="photo" type="file" class="custom-file-input @error('photo') is-invalid @enderror" id="validatedCustomFile">
                                    {{-- progres bar --}}
                                    <div x-show.transition="isUploading" class="mt-2 rounded progress progress-sm">
                                        <div class="progress-bar bg-primary progress-bar-striped" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100" x-bind:style="`width: ${progress}%`">
                                            <span class="sr-only">40% Terminé (succès)</span>
                                        </div>
                                    </div>
                                </div>
                                <label class="custom-file-label" for="customFile">
                                    @if ($photo)
                                        {{ $photo->getClientOriginalName() }}
                                        <img src="{{ $photo }}" class="img-fluid ${3|rounded-top,rounded-right,rounded-bottom,rounded-left,rounded-circle,|}" alt="">
                                    @else
                                    Choisissez une image
                                    @endif
                                </label>
                            </div>
                        </div>

                        <!-- Modal User Permissions -->

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

    <!-- Modal Delete User -->
    <div class="modal fade" id="confirmationModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header bg-light">
                    <h5>Supprimer l'utilisateur</h5>
                </div>

                <div class="modal-body">
                    <h4>Voulez-vous vraiment supprimer cet utilisateur ?</h4>
                </div>

                <div class="modal-footer bg-light">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="mr-1 fa fa-times"></i> Annuler</button>
                    <button type="button" wire:click.prevent="deleteUser" class="btn btn-danger"><i class="mr-1 fa fa-trash"></i>Supprimer </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Import Excel File -->
    <div class="modal fade" id="importExcelModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog" role="document">
            <form autocomplete="off" wire:submit.prevent="importExcel">
                <div class="modal-content">
                    <div class="modal-header bg-light">
                        <h5 class="modal-title" id="exampleModalLabel">
                            Importer un fichier Excel
                        </h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">

                        <!-- Modal Excel File -->

                        <div class="form-group">
                            <label for="custom-file">Choisissez le fichier Excel</label>
                            <div class="mb-3 custom-file">
                                <div x-data="{ isUploading: false, progress: 5 }" x-on:livewire-upload-start="isUploading = true" x-on:livewire-upload-finish="isUploading = false; progress = 5" x-on:livewire-upload-error="isUploading = false" x-on:livewire-upload-progress="progress = $event.detail.progress">
                                    <input wire:model.defer="excelFile" type="file" class="custom-file-input @error('excelFile') is-invalid @enderror" id="validatedCustomFile" required>
                                    {{-- progres bar --}}
                                    <div x-show.transition="isUploading" class="mt-2 rounded progress progress-sm">
                                        <div class="progress-bar bg-primary progress-bar-striped" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100" x-bind:style="`width: ${progress}%`"></div>
                                    </div>
                                </div>
                                @error('excelFile')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                                <label class="custom-file-label" for="customFile">
                                    @if ($excelFile)
                                        {{ $excelFile->getClientOriginalName() }}
                                    @else
                                    Choisissez le fichier Excel
                                    @endif
                                </label>
                            </div>
                        </div>
                        <div class="mb-0 form-group">
                            <label>Importer sous :</label>
                            <label class="ml-3 radio-inline">
                                <input type="radio" wire:click="importType('addNew')" name="optionsRadiosInline" id="optionsRadiosInline1" value="addNew" checked="checked">Ajouter nouveau
                            </label>
                            <label class="ml-3 radio-inline">
                                <input type="radio" wire:click="importType('Update')" name="optionsRadiosInline" id="optionsRadiosInline2" value="Update">Mise à jour
                            </label>
                        </div>
                    </div>

                    <div class="modal-footer bg-light">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="mr-1 fa fa-times"></i> Annuler</button>
                        <button type="submit" class="btn btn-primary"><i class="mr-1 fa fa-open"></i> Ouvrir</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    {{-- JS Code --}}

    @section('script')
        <script src="{{ asset('backend/js/backend.js') }}"></script>

        {{-- show or hide Permissions section on Modal --}}

        <script>
            $(document).ready( function() {
                // $('#roles select').change(function(){
                //     if($('#roles select').find("option:selected").text() == 'user'){ //'.val()'
                //         $('#permissions').hide();
                //         return true;
                //     }

                //     $('#permissions').show();
                // });

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
