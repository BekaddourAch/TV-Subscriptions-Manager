<div>
    <?php $__env->startSection('style'); ?>
    <style>

    </style>
    <?php $__env->stopSection(); ?>

    <div class="shadow card">
        <div class="py-3 card-header">
            <ol class="m-0 breadcrumb float-sm-left font-weight-bold text-primary">
                <li class="breadcrumb-item"><a href="<?php echo e(route('admin.index')); ?>">Dashboard</a></li>
                <li class="breadcrumb-item active">Utilisateurs</li>
            </ol>
            <div class="mt-2 d-flex justify-content-end">
                <?php if(1==0): ?>
                
                
                <?php endif; ?>
                
                <?php if(Auth::user()->hasPermission('users-create')): ?>
                    <button wire:click.prevent='addNewUser' class="ml-1 btn btn-sm btn-primary">
                        <i class="mr-2 fa fa-plus-circle"
                            aria-hidden="true">
                            <span>Ajouter un Utilisateur</span>
                        </i>
                    </button>
                <?php endif; ?>
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
            <?php if(1==0): ?>
            
            <?php endif; ?>
        </div>

        <div class="p-3 card-body">
            <?php if($selectedRows): ?>
                <div class="mb-3 d-flex">
                    <span class="pt-1 text-success">
                         <span class="text-gray-900 font-weight-bold"><?php echo e(count($selectedRows)); ?></span> <?php echo e(Str::plural('Utilisateure', count($selectedRows))); ?>

                         
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
            <?php endif; ?>
            <div class="table-responsive">
                <table class="table">
                    <thead class="text-white bg-gradient-secondary">
                        <tr class="text-center">

                            <?php if((Auth::user()->hasPermission('users-update')) || (Auth::user()->hasPermission('users-delete'))): ?>
                                <th class="align-middle" scope="col">
                                    <div class="custom-control custom-checkbox small">
                                        <input type="checkbox" wire:model="selectPageRows" value="" class="custom-control-input" id="customCheck">
                                        <label class="custom-control-label" for="customCheck"></label>
                                    </div>
                                </th>
                            <?php endif; ?>              

                            <th class="align-middle" scope="col">#</th>
                            <th class="align-middle">
                                Nom
                                <span wire:click="sortBy('name')" class="text-sm float-sm-right" style="cursor: pointer;font-size:10px;">
                                    <i class="mr-1 fa fa-arrow-up" style="color:<?php echo e($sortColumnName === 'name' && $sortDirection === 'asc' ? '#90EE90' : ''); ?>"></i>
                                    <i class="fa fa-arrow-down" style="color : <?php echo e($sortColumnName === 'name' && $sortDirection === 'desc' ? '#90EE90' : ''); ?>"></i>
                                </span>
                            </th>
                            <th class="align-middle">
                                Pseudo
                                <span wire:click="sortBy('username')" class="text-sm float-sm-right" style="cursor: pointer;font-size:10px;">
                                    <i class="mr-1 fa fa-arrow-up" style="color:<?php echo e($sortColumnName === 'username' && $sortDirection === 'asc' ? '#90EE90' : ''); ?>"></i>
                                    <i class="fa fa-arrow-down" style="color : <?php echo e($sortColumnName === 'username' && $sortDirection === 'desc' ? '#90EE90' : ''); ?>"></i>
                                </span>
                            </th>
                            <th class="align-middle" scope="col">Photo</th>
                            <th class="align-middle">
                                Email
                                <span wire:click="sortBy('email')" class="text-sm float-sm-right" style="cursor: pointer;font-size:10px;">
                                    <i class="mr-1 fa fa-arrow-up" style="color:<?php echo e($sortColumnName === 'email' && $sortDirection === 'asc' ? '#90EE90' : ''); ?>"></i>
                                    <i class="fa fa-arrow-down" style="color : <?php echo e($sortColumnName === 'email' && $sortDirection === 'desc' ? '#90EE90' : ''); ?>"></i>
                                </span>
                            </th>
                            <th class="align-middle">
                                Tèlèphone
                            </th>
                            <th class="align-middle">
                                Status
                                <span wire:click="sortBy('status')" class="text-sm float-sm-right" style="cursor: pointer;font-size:10px;">
                                    <i class="mr-1 fa fa-arrow-up" style="color:<?php echo e($sortColumnName === 'status' && $sortDirection === 'asc' ? '#90EE90' : ''); ?>"></i>
                                    <i class="fa fa-arrow-down" style="color : <?php echo e($sortColumnName === 'status' && $sortDirection === 'desc' ? '#90EE90' : ''); ?>"></i>
                                </span>
                            </th>
                            <th class="pl-5 pr-5 align-middle">
                                Role
                            </th>
                            <th>
                                créé à
                                <span wire:click="sortBy('created_at')" class="text-sm float-sm-right" style="cursor: pointer;font-size:10px;">
                                    <i class="mr-1 fa fa-arrow-up" style="color:<?php echo e($sortColumnName === 'created_at' && $sortDirection === 'asc' ? '#90EE90' : ''); ?>"></i>
                                    <i class="fa fa-arrow-down" style="color : <?php echo e($sortColumnName === 'created_at' && $sortDirection === 'desc' ? '#90EE90' : ''); ?>"></i>
                                </span>
                            </th>
                            
                            <?php if((Auth::user()->hasPermission('users-update')) || (Auth::user()->hasPermission('users-delete'))): ?>
                                <th class="align-middle" style="width: 10px" colspan="2">Actions</th>
                            <?php endif; ?>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__empty_1 = true; $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <?php if($user->id!=1): ?>
                            <tr class="text-center">
                                <?php if((Auth::user()->hasPermission('users-update')) || (Auth::user()->hasPermission('users-delete'))): ?>
                                    <td class="align-middle" scope="col">
                                        <div class="custom-control custom-checkbox small">
                                            <input type="checkbox" wire:model="selectedRows" value="<?php echo e($user->id); ?>" class="custom-control-input" id="<?php echo e($user->id); ?>">
                                            <label class="custom-control-label" for="<?php echo e($user->id); ?>"></label>
                                        </div>
                                    </td>
                                <?php endif; ?>
                                <td class="align-middle" scope="row"><?php echo e($users->firstItem() + $index); ?></td>
                                <td class="align-middle"><?php echo e($user->name); ?></td>
                                <td class="align-middle"><?php echo e($user->username); ?></td>
                                <td class="align-middle">
                                    <img src="<?php echo e($user->profile_photo_path ? $user->profile_url : $user->profile_photo_url); ?>" style="width: 50px;" class="img img-circle" alt="">
                                </td>
                                <td class="align-middle"><?php echo e($user->email); ?></td>
                                <td class="align-middle"><?php echo e($user->mobile); ?></td>
                                <td class="align-middle">
                                    <span
                                        class="font-weight-bold badge text-white <?php echo e($user->status == 1 ? 'bg-success' : 'bg-secondary'); ?>"><?php echo e($user->status()); ?>

                                    </span>
                                </td>
                                <td class="align-middle">
                                    <select class="form-control form-control-sm" wire:change='updateUserRole(<?php echo e($user); ?>, $event.target.value)'>
                                        <option hidden><?php echo app('translator')->get('message.roles'); ?></option>
                                        <?php $__currentLoopData = $roles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $role): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?> 
                                            <?php if($role->id!=1): ?>
                                            <option class="bg-red" value="<?php echo e($role->id); ?>" <?php echo e($user->roles[0]->name == $role->name ? 'selected' : ''); ?>><?php echo e($role->name); ?></option>
                                            <?php endif; ?>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                </td>
                                <td><?php echo e($user->created_at->format('d-m-Y')); ?></td>
                                
                                <?php if((Auth::user()->hasPermission('users-update')) || (Auth::user()->hasPermission('users-delete'))): ?>
                                    <td class="align-middle">
                                        <div class="btn-group btn-group-sm">
                                            
                                            <?php if(Auth::user()->hasPermission('users-update')): ?>
                                                <a href="#" wire:click.prevent="edit(<?php echo e($user); ?>)" class="btn btn-primary">
                                                    <i class="fa fa-edit"></i>
                                                </a>
                                            <?php endif; ?>
                                            <?php if(Auth::user()->hasPermission('users-delete')): ?>
                                                <a class="btn btn-danger" href="#" wire:click.prevent="confirmUserRemoval(<?php echo e($user->id); ?>)">
                                                    <i class="fa fa-trash bg-danger"></i>
                                                </a>
                                            <?php endif; ?>

                                        </div>
                                        <form action="" method="post" id="delete-user-<?php echo e($user->id); ?>" class="d-none">
                                            <?php echo csrf_field(); ?>
                                            <?php echo method_field('DELETE'); ?>
                                        </form>
                                    </td>
                                <?php endif; ?>
                            </tr>
                            <?php endif; ?>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <tr>
                            <td colspan="10" class="text-center">Aucun Utilisateur trouvé</td>
                        </tr>
                        <?php endif; ?>
                    </tbody>
                    <tfoot>
                        <tr class="bg-light">
                            <td colspan="11">
                                <?php echo $users->appends(request()->all())->links(); ?>

                            </td>
                        </tr>
                    </tfoot>
                </table>
               
            </div>
        </div>
    </div>

    <!-- Modal Create or Update User -->

    <div class="modal fade" id="form" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog" role="document">
            <form autocomplete="off" wire:submit.prevent="<?php echo e($showEditModal ? 'updateUser' : 'createUser'); ?>">
                <div class="modal-content">
                    <div class="modal-header bg-light">
                        <h5 class="modal-title" id="exampleModalLabel">
                            <?php if($showEditModal): ?>
                                <span>Modifier l'utilisateur</span>
                            <?php else: ?>
                            <span>Ajouter un nouvel utilisateur</span>
                            <?php endif; ?>
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
                                    <label for="name">Nom</label>
                                    <input type="text" tabindex="1" wire:model.defer="state.name" class="form-control <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" id="name" aria-describedby="nameHelp" placeholder="Entrez le nom">
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

                                <!-- Modal User Email -->

                                <div class="form-group">
                                    <label for="email">Email</label>
                                    <input type="email" tabindex="3" wire:model.defer="state.email" class="form-control <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" id="email" aria-describedby="emailHelp" placeholder="Entrez L'email">
                                    <?php $__errorArgs = ['email'];
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

                                <!-- Modal User Password -->

                                <div class="form-group">
                                    <label for="password">Mot de passe</label>
                                    <input type="password" tabindex="5" wire:model.defer="state.password" class="form-control <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" id="password" placeholder="Entrez le Mot de passe">
                                    <?php $__errorArgs = ['password'];
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
                            <div class="col-6">

                                <!-- Modal User Username -->

                                <div class="form-group">
                                    <label for="username">Pseudo</label>
                                    <input type="text" tabindex="2" wire:model.defer="state.username" class="form-control <?php $__errorArgs = ['username'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" id="username" aria-describedby="nameHelp" placeholder="Entrez le Pseudo">
                                    <?php $__errorArgs = ['username'];
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

                                <!-- Modal User Mobile -->

                                <div class="form-group">
                                    <label for="mobile">Mobile</label>
                                    <input type="text" tabindex="4" wire:model.defer="state.mobile" class="form-control <?php $__errorArgs = ['mobile'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" id="mobile" aria-describedby="nameHelp" placeholder="Entrez Le Numéro de téléphone">
                                    <?php $__errorArgs = ['mobile'];
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

                                <!-- Modal User Password Confirmation -->

                                <div class="form-group">
                                    <label for="passwordConfirmation">Confirm Password</label>
                                    <input type="password" tabindex="6" wire:model.defer="state.password_confirmation" class="form-control" id="passwordConfirmation" placeholder="Confirmez le mot de passe">
                                </div>
                            </div>
                        </div>

                        <!-- Modal User Roles -->

                        <div id="roles" class="form-group">
                            <label for="role_id">Role</label>
                            <select id="roles" tabindex="7" class="form-control form-control <?php $__errorArgs = ['role_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" wire:model.defer="state.role_id" wire:change="permissions_form($event.target.value)">
                                <option hidden><?php echo app('translator')->get('Sélectionnez les rôles ..'); ?></option>
                                <?php $__currentLoopData = $roles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $role): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <?php if($role->id!=1): ?>
                                        <option class="bg-red" value="<?php echo e($role->id); ?>"><?php echo e($role->name); ?></option>
                                    <?php endif; ?>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                            <?php $__errorArgs = ['role_id'];
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

                        <!-- Modal User Photo -->

                        <div class="form-group">
                            <label for="custom-file">Photo d'utilisteur</label>
                            <?php if($photo): ?>
                                <img src="<?php echo e($photo->temporaryUrl()); ?>" class="mb-2 d-block img img-circle" width="100px" alt="">
                            <?php else: ?>
                                <img src="<?php echo e($state['profile_url'] ?? ''); ?>" class="mb-2 d-block img img-circle" width="100px" alt="">
                            <?php endif; ?>
                            <div class="mb-3 custom-file">
                                <div x-data="{ isUploading: false, progress: 5 }" x-on:livewire-upload-start="isUploading = true" x-on:livewire-upload-finish="isUploading = false; progress = 5" x-on:livewire-upload-error="isUploading = false" x-on:livewire-upload-progress="progress = $event.detail.progress">
                                    <input tabindex="8" wire:model="photo" type="file" class="custom-file-input <?php $__errorArgs = ['photo'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" id="validatedCustomFile">
                                    
                                    <div x-show.transition="isUploading" class="mt-2 rounded progress progress-sm">
                                        <div class="progress-bar bg-primary progress-bar-striped" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100" x-bind:style="`width: ${progress}%`">
                                            <span class="sr-only">40% Terminé (succès)</span>
                                        </div>
                                    </div>
                                </div>
                                <label class="custom-file-label" for="customFile">
                                    <?php if($photo): ?>
                                        <?php echo e($photo->getClientOriginalName()); ?>

                                        <img src="<?php echo e($photo); ?>" class="img-fluid ${3|rounded-top,rounded-right,rounded-bottom,rounded-left,rounded-circle,|}" alt="">
                                    <?php else: ?>
                                    Choisissez une image
                                    <?php endif; ?>
                                </label>
                            </div>
                        </div>

                        <!-- Modal User Permissions -->

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
                                    <input wire:model.defer="excelFile" type="file" class="custom-file-input <?php $__errorArgs = ['excelFile'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" id="validatedCustomFile" required>
                                    
                                    <div x-show.transition="isUploading" class="mt-2 rounded progress progress-sm">
                                        <div class="progress-bar bg-primary progress-bar-striped" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100" x-bind:style="`width: ${progress}%`"></div>
                                    </div>
                                </div>
                                <?php $__errorArgs = ['excelFile'];
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
                                <label class="custom-file-label" for="customFile">
                                    <?php if($excelFile): ?>
                                        <?php echo e($excelFile->getClientOriginalName()); ?>

                                    <?php else: ?>
                                    Choisissez le fichier Excel
                                    <?php endif; ?>
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

    

    <?php $__env->startSection('script'); ?>
        <script src="<?php echo e(asset('backend/js/backend.js')); ?>"></script>

        

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
<?php /**PATH C:\xampp\htdocs\tv-subscriptions-management\resources\views/livewire/backend/admin/users/list-users.blade.php ENDPATH**/ ?>