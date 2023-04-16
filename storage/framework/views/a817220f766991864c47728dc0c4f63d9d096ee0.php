<div>
    <?php $__env->startSection('style'); ?>
    <style>

    </style>
    <?php $__env->stopSection(); ?>

    <div class="shadow card">
        <div class="py-3 card-header">
            <ol class="m-0 breadcrumb float-sm-left font-weight-bold text-primary">
                <li class="breadcrumb-item"><a href="<?php echo e(route('admin.index')); ?>">Dashboard</a></li>
                <li class="breadcrumb-item active">Roles</li>
            </ol>
            
            <?php if(Auth::user()->hasPermission('users-create')): ?>
            <div class="mt-2 d-flex justify-content-end">
                <button wire:click.prevent='addNewRole' class="ml-1 btn btn-sm btn-primary">
                    <i class="mr-2 fa fa-plus-circle"
                        aria-hidden="true">
                        <span>Ajouter un  Role</span>
                    </i>
                </button>
            </div>
            <?php endif; ?>
        </div>

        <div class="p-3 card-body">
            <div class="table-responsive">
                <table class="table">
                    <thead class="text-white bg-gradient-secondary">
                        <tr class="text-center">
                            <th class="align-middle" scope="col">#</th>
                            <th class="align-middle">
                                Nom
                            </th>
                            <th class="align-middle">
                                Dispaly Name
                            </th>
                            <th class="align-middle">
                                Description
                            </th>
                            <th class="align-middle">
                                Permissions
                            </th>
                            
                            <?php if((Auth::user()->hasPermission('users-update')) || (Auth::user()->hasPermission('users-delete'))): ?>
                                <th class="align-middle" style="width: 10px" colspan="2">Actions</th>
                            <?php endif; ?>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__empty_1 = true; $__currentLoopData = $roles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $role): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        
                        <?php if($role->id!=1): ?>
                        <tr class="text-center">
                            <td class="align-middle" scope="row"><?php echo e($loop->iteration); ?></td>
                            <td class="align-middle"><?php echo e($role->name); ?></td>
                            <td class="align-middle"><?php echo e($role->display_name); ?></td>
                            <td class="align-middle"><?php echo e($role->description); ?></td>
                            <td class="align-middle"><?php echo e($role->permissions()->count()); ?></td>
                            
                            <?php if((Auth::user()->hasPermission('users-update')) || (Auth::user()->hasPermission('users-delete'))): ?>
                            <td class="align-middle">
                                <div class="btn-group btn-group-sm">
                                    <?php if(Auth::user()->hasPermission('users-update')): ?>
                                        <a href="#" wire:click.prevent="edit(<?php echo e($role); ?>)" class="btn btn-primary">
                                            <i class="fa fa-edit"></i>
                                        </a>
                                    <?php endif; ?>
                                    <?php if(Auth::user()->hasPermission('users-delete')): ?>
                                        <a class="btn btn-danger" href="#" wire:click.prevent="confirmRoleRemoval(<?php echo e($role->id); ?>)">
                                            <i class="fa fa-trash bg-danger"></i>
                                        </a>
                                    <?php endif; ?>

                                </div>
                                <form action="" method="post" id="delete-role-<?php echo e($role->id); ?>" class="d-none">
                                    <?php echo csrf_field(); ?>
                                    <?php echo method_field('DELETE'); ?>
                                </form>
                            </td>
                            <?php endif; ?>
                        </tr>
                        <?php endif; ?>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <tr>
                            <td colspan="6" class="text-center">Aucun rôle trouvé</td>
                        </tr>
                        <?php endif; ?>
                    </tbody>
                    <tfoot>
                        <tr class="bg-light">
                            <td colspan="6">
                                <?php echo $roles->appends(request()->all())->links(); ?>

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
            <form autocomplete="off" wire:submit.prevent="<?php echo e($showEditModal ? 'updateRole' : 'createRole'); ?>">
                <div class="modal-content">
                    <div class="modal-header bg-light">
                        <h5 class="modal-title" id="exampleModalLabel">
                            <?php if($showEditModal): ?>
                                <span>Modifier le rôle</span>
                            <?php else: ?>
                            <span>Ajouter un nouveau rôle</span>
                            <?php endif; ?>
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
                                    <input type="text" tabindex="1" wire:model.defer="data.name" class="form-control <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" id="name" aria-describedby="nameHelp" placeholder="Enter role name">
                                    <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <div class="invalid-feedback">
                                        <?php echo e($message); ?>

                                    </div>
                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </div>

                                <!-- Modal Role Display Name -->

                                <div class="form-group">
                                    <label for="display_name">Nom d'affichage</label>
                                    <input type="text" tabindex="1" wire:model.defer="data.display_name" class="form-control <?php $__errorArgs = ['display_name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" id="display_name" aria-describedby="display_nameHelp" placeholder="Enter role displayname">
                                    <?php $__errorArgs = ['display_name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <div class="invalid-feedback">
                                        <?php echo e($message); ?>

                                    </div>
                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </div>

                                <!-- Modal Role description -->

                                <div class="form-group">
                                    <label for="description">Description</label>
                                    <input type="text" tabindex="1" wire:model.defer="data.description" class="form-control <?php $__errorArgs = ['description'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" id="description" aria-describedby="descriptionHelp" placeholder="Enter role description">
                                    <?php $__errorArgs = ['description'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <div class="invalid-feedback">
                                        <?php echo e($message); ?>

                                    </div>
                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
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
                                    
                                            
    
                                            <?php $__currentLoopData = $array_permissions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $permissions): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <div class="sce" style="margin:1 0;padding:2 0">
                                                
                                            <h6 class="m-0 font-weight-bold text-primary"><?php echo e($index); ?></h6> <br>
                                            <div class="cra" style="display:flex;"> 
                                                    
                                                    <?php $__currentLoopData = $permissions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $permission): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <div class="trs" style="margin">
                                                        <div class="form-group">
                                                            <div class="custom-control form-checkbox small">
                                                                <label class="items-center" :key="<?php echo e($permission->id); ?>">
                                                                    <input
                                                                        type="checkbox"
                                                                        name="role_permissions.<?php echo e($permission->id); ?>"
                                                                        wire:model.defer="role_permissions.<?php echo e($permission->id); ?>"
                                                                        value="<?php echo e($permission->id); ?>"
                                                                        class="form-checkbox"
                                                                    />
                                                                    <span class="mr-1"><?php echo e($permission->display_name); ?></span>
                                                                </label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?> 
                                            </div> 
                                            <hr> 
                                            </div>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?> 
                                </div>
                            </div>
                            
                        </div>
                    </div>

                    <div class="modal-footer bg-light">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="mr-1 fa fa-times"></i> Annuler</button>
                        <button type="submit" class="btn btn-primary"><i class="mr-1 fa fa-save"></i>
                            <?php if($showEditModal): ?>
                                <span>Sauvegarder les modifications</span>
                            <?php else: ?>
                            <span>Sauvegarder</span>
                            <?php endif; ?>
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

    

    <?php $__env->startSection('script'); ?>
        <script src="<?php echo e(asset('backend/js/backend.js')); ?>"></script>

        

        <script>
            $(document).ready( function() {
                //
            });
        </script>

        

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
    <?php $__env->stopSection(); ?>
</div>
<?php /**PATH C:\xampp\htdocs\tv-subscriptions-management\resources\views/livewire/backend/admin/users/list-roles.blade.php ENDPATH**/ ?>