<div>
    @section('style')
    <style>

    </style>
    @endsection

    <div class="shadow card">
        <div class="py-3 card-header">
            <ol class="m-0 breadcrumb float-sm-left font-weight-bold text-primary">
                <li class="breadcrumb-item"><a href="{{ route('admin.index') }}">Dashboard</a></li>
                <li class="breadcrumb-item active">Permissions</li>
            </ol>
            <div class="mt-2 d-flex justify-content-end">
                <button wire:click.prevent='addNewPermission' class="ml-1 btn btn-sm btn-primary">
                    <i class="mr-2 fa fa-plus-circle"
                        aria-hidden="true">
                        <span>Add Permission</span>
                    </i>
                </button>
            </div>
        </div>

        <div class="p-3 card-body">
            <div class="table-responsive">
                <table class="table">
                    <thead class="text-white bg-gradient-secondary">
                        <tr class="text-center">
                            <th class="align-middle" scope="col">#</th>
                            <th class="align-middle">
                                {{ trans('permission.name') }}
                            </th>
                            <th class="align-middle">
                                {{ trans('permission.display_name') }}
                            </th>
                            <th class="align-middle">
                                {{ trans('permission.description') }}
                            </th>
                            <th class="align-middle" style="width: 10%" colspan="2">{{ trans('messages.actions') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($permissions as $permission)
                        <tr class="text-center">
                            <td class="align-middle" scope="row">{{ $loop->iteration }}</td>
                            <td class="align-middle">{{ $permission->name }}</td>
                            <td class="align-middle">{{ $permission->display_name }}</td>
                            <td class="align-middle">{{ $permission->description }}</td>
                            <td class="align-middle">
                                <div class="btn-group btn-group-sm">
                                    <a href="#" wire:click.prevent="edit({{ $permission }})" class="btn btn-primary">
                                        <i class="fa fa-edit"></i>
                                    </a>

                                    <a class="btn btn-danger" href="#" wire:click.prevent="confirmPermissionRemoval({{ $permission->id }})">
                                        <i class="fa fa-trash bg-danger"></i>
                                    </a>

                                </div>
                                <form action="" method="post" id="delete-permission-{{ $permission->id }}" class="d-none">
                                    @csrf
                                    @method('DELETE')
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center">No Permission found</td>
                        </tr>
                        @endforelse
                    </tbody>
                    <tfoot>
                        <tr class="bg-light">
                            <td colspan="6">
                                {!! $permissions->appends(request()->all())->links() !!}
                            </td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>

    <!-- Modal Create or Update Permission -->

    <div class="modal fade" id="form" tabindex="-1" permission="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog" permission="document">
            <form autocomplete="off" wire:submit.prevent="{{ $showEditModal ? 'updatePermission' : 'createPermission' }}">
                <div class="modal-content">
                    <div class="modal-header bg-light">
                        <h5 class="modal-title" id="exampleModalLabel">
                            @if ($showEditModal)
                                <span>Edit Permission</span>
                            @else
                            <span>Add New Permission</span>
                            @endif
                        </h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row h-100 justify-content-center align-items-center">
                            <div class="col-12">

                                <!-- Modal Permission Name -->

                                <div class="form-group">
                                    <label for="name">Name</label>
                                    <input type="text" tabindex="1" wire:model.defer="data.name" class="form-control @error('name') is-invalid @enderror" id="name" aria-describedby="nameHelp" placeholder="Enter permission name" readonly>
                                    @error('name')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>


                                <!-- Modal Permission Display Name -->

                                <div class="form-group">
                                    <label for="display_name">Display Name</label>
                                    <input type="text" tabindex="1" wire:model.defer="data.display_name" class="form-control @error('display_name') is-invalid @enderror" id="display_name" aria-describedby="display_nameHelp" placeholder="Enter permission display name, E.g : Create Users">
                                    @error('display_name')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>

                                <!-- Modal Permission description -->

                                <div class="form-group">
                                    <label for="description">Description</label>
                                    <input type="text" tabindex="1" wire:model.defer="data.description" class="form-control @error('description') is-invalid @enderror" id="description" aria-describedby="descriptionHelp" placeholder="Enter permission description">
                                    @error('description')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                            </div>
                        </div>
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

    <!-- Modal Delete Permission -->
    <div class="modal fade" id="confirmationModal" tabindex="-1" permission="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog" permission="document">
            <div class="modal-content">
                <div class="modal-header bg-light">
                    <h5>Delete Permission</h5>
                </div>

                <div class="modal-body">
                    <h4>Are you sure you want to delete this permission?</h4>
                </div>

                <div class="modal-footer bg-light">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="mr-1 fa fa-times"></i> Cancel</button>
                    <button type="button" wire:click.prevent="deletePermission" class="btn btn-danger"><i class="mr-1 fa fa-trash"></i>Delete Permission</button>
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
                $('#display_name').keyup(function() {
                    let name = this.value.toLowerCase();
                    name = name.split(" ");
                    name = name[1] + '-' + name[0];
                    //change txtInterest% value
                    $('#name').val(name);
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
