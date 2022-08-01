<div>
    @section('style')
    <style>

    </style>
    @endsection

    <div class="shadow card">
        <div class="py-3 card-header">
            <ol class="m-0 breadcrumb float-sm-left font-weight-bold text-primary">
                <li class="breadcrumb-item"><a href="{{ route('admin.index') }}">Dashboard</a></li>
                <li class="breadcrumb-item active">Users</li>
            </ol>
            <div class="m-2 d-flex justify-content-end">
                <button wire:click.prevent='addNewUser' class="mr-1 btn btn-primary">
                    <i class="mr-1 fa fa-plus-circle"
                        aria-hidden="true">
                        <span>Add New User</span>
                    </i>
                </button>
            </div>
        </div>

        <div class="flex-wrap d-flex justify-content-between">
            <div class="pt-3 my-2 ml-3 ml-md-3 my-md-0 mw-80 navbar-search">
                <div class="input-group">
                    <input wire:model="searchTerm" type="text" class="border-0 form-control bg-light small" placeholder="Search for..." aria-label="Search" aria-describedby="basic-addon2" spellcheck="false" data-ms-editor="true">
                    <div class="input-group-append">
                        <button class="btn btn-primary btn-sm" type="button">
                            <i class="fas fa-search fa-sm"></i>
                        </button>
                    </div>
                    @if ($selectedRows)
                        <div class="ml-3 dropdown">
                            <button class="btn btn-primary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                Action
                            </button>
                            <div class="dropdown-menu animated--fade-in bg-gray-100" aria-labelledby="dropdownMenuButton" style="">
                                <a class="dropdown-item" wire:click.prevent="setAllAsActive" href="#">Set as Acive</a>
                                <a class="dropdown-item" wire:click.prevent="setAllAsInActive" href="#">Set as InActive</a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" wire:click.prevent="export" href="#">Export</a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item text-danger delete-confirm" wire:click.prevent="deleteSelectedRows" href="#">Delete Selected</a>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
            <div class="m-3 mw-100 justify-content-end">
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
            </div>
        </div>

        <div class="card-body p-3">
            @if ($selectedRows)
                <span class="text-success">selected <span class="text-gray-900 font-weight-bold">{{ count($selectedRows) }}</span> {{ Str::plural('user', count($selectedRows)) }}</span>
            @endif
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead class="text-white bg-gradient-secondary">
                        <tr class="text-center">
                            <th class="align-middle" scope="col">
                                <div class="custom-control custom-checkbox small">
                                    <input type="checkbox" wire:model="selectPageRows" value="" class="custom-control-input" id="customCheck">
                                    <label class="custom-control-label" for="customCheck"></label>
                                </div>
                            </th>
                            <th class="align-middle" scope="col">#</th>
                            <th class="align-middle" style="width: 10%">
                                {{ trans('user.name') }}
                                <span wire:click="sortBy('name')" class="text-sm float-sm-right" style="cursor: pointer;font-size:10px;">
                                    <i class="mr-1 fa fa-arrow-up" style="color:{{ $sortColumnName === 'name' && $sortDirection === 'asc' ? '#90EE90' : '' }}"></i>
                                    <i class="fa fa-arrow-down" style="color : {{ $sortColumnName === 'name' && $sortDirection === 'desc' ? '#90EE90' : '' }}"></i>
                                </span>
                            </th>
                            <th class="align-middle" style="width: 15px">
                                {{ trans('user.username') }}
                                <span wire:click="sortBy('username')" class="text-sm float-sm-right" style="cursor: pointer;font-size:10px;">
                                    <i class="mr-1 fa fa-arrow-up" style="color:{{ $sortColumnName === 'username' && $sortDirection === 'asc' ? '#90EE90' : '' }}"></i>
                                    <i class="fa fa-arrow-down" style="color : {{ $sortColumnName === 'username' && $sortDirection === 'desc' ? '#90EE90' : '' }}"></i>
                                </span>
                            </th>
                            <th class="align-middle" scope="col">{{ trans('messages.photo') }}</th>
                            <th class="align-middle" style="width: 10%;">
                                {{ trans('user.email') }}
                                <span wire:click="sortBy('email')" class="text-sm float-sm-right" style="cursor: pointer;font-size:10px;">
                                    <i class="mr-1 fa fa-arrow-up" style="color:{{ $sortColumnName === 'email' && $sortDirection === 'asc' ? '#90EE90' : '' }}"></i>
                                    <i class="fa fa-arrow-down" style="color : {{ $sortColumnName === 'email' && $sortDirection === 'desc' ? '#90EE90' : '' }}"></i>
                                </span>
                            </th>
                            <th class="align-middle" style="width: 10px">
                                {{ trans('user.mobile') }}
                            </th>
                            <th class="align-middle">
                                {{ trans('messages.status') }}
                                <span wire:click="sortBy('status')" class="text-sm float-sm-right" style="cursor: pointer;font-size:10px;">
                                    <i class="mr-1 fa fa-arrow-up" style="color:{{ $sortColumnName === 'status' && $sortDirection === 'asc' ? '#90EE90' : '' }}"></i>
                                    <i class="fa fa-arrow-down" style="color : {{ $sortColumnName === 'status' && $sortDirection === 'desc' ? '#90EE90' : '' }}"></i>
                                </span>
                            </th>
                            <th class="pl-5 pr-5 align-middle">
                                {{ trans('Role') }}
                            </th>
                            {{-- <th>
                                {{ trans('messages.created_at') }}
                                <span wire:click="sortBy('created_at')" class="text-sm float-sm-right" style="cursor: pointer;font-size:10px;">
                                    <i class="mr-1 fa fa-arrow-up" style="color:{{ $sortColumnName === 'created_at' && $sortDirection === 'asc' ? '#90EE90' : '' }}"></i>
                                    <i class="fa fa-arrow-down" style="color : {{ $sortColumnName === 'created_at' && $sortDirection === 'desc' ? '#90EE90' : '' }}"></i>
                                </span>
                            </th> --}}
                            <th colspan="2">{{ trans('messages.actions') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($users as $index => $user)
                        <tr class="text-center">
                            <td class="align-middle" scope="col">
                                <div class="custom-control custom-checkbox small">
                                    <input type="checkbox" wire:model="selectedRows" value="{{ $user->id }}" class="custom-control-input" id="{{ $user->id }}">
                                    <label class="custom-control-label" for="{{ $user->id }}"></label>
                                </div>
                            </td>
                            <td class="align-middle" scope="row">{{ $users->firstItem() + $index }}</td>
                            <td class="align-middle">{{ $user->name }}</td>
                            <td class="align-middle">{{ $user->username }}</td>
                            <td class="align-middle">
                                <img src="{{ $user->profile_photo_path ? $user->profile_url : $user->profile_photo_url }}" style="width: 50px;" class="img img-circle" alt="">
                            </td>
                            <td class="align-middle">{{ $user->email }}</td>
                            <td class="align-middle">{{ $user->mobile }}</td>
                            <td class="align-middle">
                                <span
                                    class="font-weight-bold badge text-white {{ $user->status == 1 ? 'bg-success' : 'bg-secondary' }}">{{
                                    $user->status() }}
                                </span>
                            </td>
                            <td class="align-middle">
                                <select class="form-control form-control-sm" wire:change='updateUserRole({{ $user }}, $event.target.value)'>
                                    <option hidden>@lang('message.roles')</option>
                                    @foreach ($roles as $role)
                                        <option class="bg-red" value="{{ $role->id }}" {{ $user->roles[0]->name == $role->name ? 'selected' : '' }}>{{ $role->name }}</option>
                                    @endforeach
                                </select>
                            </td>
                            {{-- <td>{{ $user->created_at->format('d-m-Y') }}</td> --}}
                            <td class="align-middle">
                                <div class="btn-group btn-group-sm">
                                    <a href="#" wire:click.prevent="edit({{ $user }})" class="btn btn-primary">
                                        <i class="fa fa-edit"></i>
                                    </a>

                                    <a class="btn btn-danger" href="#" wire:click.prevent="confirmUserRemoval({{ $user->id }})">
                                        <i class="fa fa-trash bg-danger"></i>
                                    </a>

                                </div>
                                <form action="" method="post" id="delete-user-{{ $user->id }}" class="d-none">
                                    @csrf
                                    @method('DELETE')
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="10" class="text-center">No Users found</td>
                        </tr>
                        @endforelse
                    </tbody>
                    <tfoot>
                        <tr class="bg-light">
                            <td colspan="10">
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
                                <span>Edit User</span>
                            @else
                            <span>Add New User</span>
                            @endif
                        </h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row h-100 justify-content-center align-items-center">
                            <div class="col-6">

                                <!-- Modal User Full Name -->

                                <div class="form-group">
                                    <label for="name">Full Name</label>
                                    <input type="text" tabindex="1" wire:model.defer="state.name" class="form-control @error('name') is-invalid @enderror" id="name" aria-describedby="nameHelp" placeholder="Enter full name">
                                    @error('name')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>

                                <!-- Modal User Email -->

                                <div class="form-group">
                                    <label for="email">Email address</label>
                                    <input type="email" tabindex="3" wire:model.defer="state.email" class="form-control @error('email') is-invalid @enderror" id="email" aria-describedby="emailHelp" placeholder="Enter email">
                                    @error('email')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>

                                <!-- Modal User Password -->

                                <div class="form-group">
                                    <label for="password">Password</label>
                                    <input type="password" tabindex="5" wire:model.defer="state.password" class="form-control @error('password') is-invalid @enderror" id="password" placeholder="Password">
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
                                    <label for="username">UserName</label>
                                    <input type="text" tabindex="2" wire:model.defer="state.username" class="form-control @error('username') is-invalid @enderror" id="username" aria-describedby="nameHelp" placeholder="Enter username">
                                    @error('username')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>

                                <!-- Modal User Mobile -->

                                <div class="form-group">
                                    <label for="mobile">Mobile</label>
                                    <input type="text" tabindex="4" wire:model.defer="state.mobile" class="form-control @error('mobile') is-invalid @enderror" id="mobile" aria-describedby="nameHelp" placeholder="Enter Mobile">
                                    @error('mobile')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>

                                <!-- Modal User Password Confirmation -->

                                <div class="form-group">
                                    <label for="passwordConfirmation">Confirm Password</label>
                                    <input type="password" tabindex="6" wire:model.defer="state.password_confirmation" class="form-control" id="passwordConfirmation" placeholder="Confirm Password">
                                </div>
                            </div>
                        </div>

                        <!-- Modal User Roles -->

                        <div id="roles" class="form-group">
                            <label for="role_id">@lang('roles')</label>
                            <select id="roles" tabindex="7" class="form-control form-control @error('role_id') is-invalid @enderror" wire:model.defer="state.role_id" wire:change="permissions_form($event.target.value)">
                                <option hidden>@lang('roles')</option>
                                @foreach ($roles as $role)
                                    <option class="bg-red" value="{{ $role->id }}">{{ $role->name }}</option>
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
                            <label for="custom-file">User Photo</label>
                            @if ($photo)
                                <img src="{{ $photo->temporaryUrl() }}" class="mb-2 d-block img img-circle" width="100px" alt="">
                            @else
                                <img src="{{ $state['profile_url'] ?? '' }}" class="mb-2 d-block img img-circle" width="100px" alt="">
                            @endif
                            <div class="mb-3 custom-file">
                                <div x-data="{ isUploading: false, progress: 5 }" x-on:livewire-upload-start="isUploading = true" x-on:livewire-upload-finish="isUploading = false; progress = 5" x-on:livewire-upload-error="isUploading = false" x-on:livewire-upload-progress="progress = $event.detail.progress">
                                    <input tabindex="8" wire:model="photo" type="file" class="custom-file-input" id="validatedCustomFile">
                                    {{-- progres bar --}}
                                    <div x-show.transition="isUploading" class="mt-2 rounded progress progress-sm">
                                        <div class="progress-bar bg-primary progress-bar-striped" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100" x-bind:style="`width: ${progress}%`">
                                            <span class="sr-only">40% Complete (success)</span>
                                        </div>
                                    </div>
                                </div>
                                <label class="custom-file-label" for="customFile">
                                    @if ($photo)
                                        {{ $photo->getClientOriginalName() }}
                                        <img src="{{ $photo }}" class="img-fluid ${3|rounded-top,rounded-right,rounded-bottom,rounded-left,rounded-circle,|}" alt="">
                                    @else
                                        Choose Image
                                    @endif
                                </label>
                            </div>
                        </div>

                        <!-- Modal User Permissions -->

                        @if ($showPermissions)
                            <div id="permissions" class="form-group">
                                <label class="text-center text-white bg-secondary form-control" for="permissions">Permissions</label>

                                @php
                                    $PermissionName = array_keys(config('laratrust_seeder.roles_structure.superadmin'));
                                @endphp

                                @foreach ( $permissions->chunk(4) as $index => $chunk )

                                    <div class="mb-2 card d-flex justify-content-center">
                                        <div class="card-header">
                                            {{ ucfirst($PermissionName[$index] . ' Permissions') }}
                                        </div>
                                        <div class="card-body">
                                            <p class="card-text">
                                                <div class="row">
                                                    @foreach ($chunk as $permission)
                                                        <div class="col-6">
                                                            <div class="form-group">
                                                                <div class="custom-control form-checkbox small">
                                                                    <label class="items-center" :key="{{ $permission->id }}">
                                                                        <input
                                                                            type="checkbox"
                                                                            name="user_permissions.{{ $permission->id }}"
                                                                            wire:model.defer="user_permissions.{{ $permission->id }}"
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
                                            </p>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>

                    <div class="modal-footer bg-light">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="mr-1 fa fa-times"></i> Cancel</button>
                        <button type="submit" class="btn btn-primary"><i class="mr-1 fa fa-save"></i>
                            @if ($showEditModal)
                                <span>Save Changes</span>
                            @else
                            <span>Save</span>
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
                    <h5>Delete User</h5>
                </div>

                <div class="modal-body">
                    <h4>Are you sure you want to delete this user?</h4>
                </div>

                <div class="modal-footer bg-light">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="mr-1 fa fa-times"></i> Cancel</button>
                    <button type="button" wire:click.prevent="deleteUser" class="btn btn-danger"><i class="mr-1 fa fa-trash"></i>Delete User</button>
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
                $('#roles select').change(function(){
                    if($('#roles select').find("option:selected").text() == 'user'){ //'.val()'
                        $('#permissions').hide();
                        return true;
                    }

                    $('#permissions').show();
                });
            });
        </script>

        {{-- show-delete-alert-confirmation --}}

        <script>
            window.addEventListener('show-delete-alert-confirmation', event =>{
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
