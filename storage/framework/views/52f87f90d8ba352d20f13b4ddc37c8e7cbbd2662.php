<div>
    <?php $__env->startSection('style'); ?>
        <style>

        </style>
    <?php $__env->stopSection(); ?>

    <div class="shadow card">
        <div class="py-3 card-header">
            <ol class="m-0 breadcrumb float-sm-left font-weight-bold text-primary">
                <li class="breadcrumb-item"><a href="<?php echo e(route('admin.index')); ?>">Dashboard</a></li>
                <li class="breadcrumb-item active">Les Services</li>
            </ol>
            <div class="mt-2 d-flex justify-content-end">
                
                <?php if(0==1): ?>
                
                <?php endif; ?>
                
                <?php if(Auth::user()->hasPermission('services-create')): ?>
                    <button wire:click.prevent='addNewService' class="ml-1 btn btn-sm btn-primary">
                        <i class="mr-2 fa fa-plus-circle"
                        aria-hidden="true">
                            <span>Ajouter un Service</span>
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
            <div class="m-3 mw-100 justify-content-end">
                <div class="btn-group">
                    <div data-toggle="buttons">
                        <button wire:click="" class="btn btn-sm btn-warning btn-icon-split">
                            <span class="icon text-white-20">
                                <?php echo e($servicesCount); ?>

                            </span>
                            <span class="text">Tous</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>


        <div class="p-3 card-body">
            <?php if($selectedRows): ?>
                <div class="mb-3 d-flex">
                    <span class="pt-1 text-success">
                        <i class="fa fa-user" aria-hidden="true"></i>

                         <span class="text-gray-900 font-weight-bold"><?php echo e(count($selectedRows)); ?></span> <?php echo e(Str::plural('Services', count($selectedRows))); ?> Sélectionné
                    </span>

                    <div class="ml-3 dropdown">
                        <button class="btn btn-secondary dropdown-toggle btn-sm" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Actions
                        </button>
                        <div class="bg-gray-100 dropdown-menu animated--fade-in" aria-labelledby="dropdownMenuButton" style="">
                            <?php if(Auth::user()->hasPermission('services-update')): ?>
                                <a class="dropdown-item" wire:click.prevent="setAllAsActive" href="#">Définir comme actif</a>
                                <a class="dropdown-item" wire:click.prevent="setAllAsInActive" href="#">Définir comme inactif</a>
                            <?php endif; ?>
                            <?php if(Auth::user()->hasPermission('services-delete')): ?>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item text-danger delete-confirm" wire:click.prevent="deleteSelectedRows" href="#">Supprimer les services sélectionnée</a>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
            <div class="table-responsive">
                <table class="table">
                    <thead class="text-white bg-gradient-secondary">
                    <tr class="text-center">
                        
                        <?php if((Auth::user()->hasPermission('services-update')) || (Auth::user()->hasPermission('services-delete'))): ?>
                            <th class="align-middle" scope="col">
                                <div class="custom-control custom-checkbox small">
                                    <input type="checkbox" wire:model="selectPageRows" value="" class="custom-control-input" id="customCheck">
                                    <label class="custom-control-label" for="customCheck"></label>
                                </div>
                            </th>
                        <?php endif; ?>
                        <th class="align-middle" scope="col">#</th>
                        <th class="align-middle"> Nom </th>
                        <th class="align-middle"> Description </th>
                        <th class="align-middle"> Prix d'Achat </th>
                        <th class="align-middle"> Prix de Vente </th>
                        <th class="align-middle"> Durée </th>
                        <th class="align-middle"> Actif </th>
                        <th class="align-middle"> Remarques </th>
                        
                        <?php if((Auth::user()->hasPermission('services-update')) || (Auth::user()->hasPermission('services-delete'))): ?>
                            <th class="align-middle" style="width: 10%" colspan="2">Actions  </th>
                        <?php endif; ?>
                    </tr>
                    </thead>
                    <tbody>
                    <?php $__empty_1 = true; $__currentLoopData = $services; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $service): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <tr class="text-center">
                            
                            <?php if((Auth::user()->hasPermission('services-update')) || (Auth::user()->hasPermission('services-delete'))): ?>
                                <td class="align-middle" scope="col">
                                    <div class="custom-control custom-checkbox small">
                                        <input type="checkbox" wire:model="selectedRows" value="<?php echo e($service->id); ?>" class="custom-control-input" id="<?php echo e($service->id); ?>">
                                        <label class="custom-control-label" for="<?php echo e($service->id); ?>"></label>
                                    </div>
                                </td>
                            <?php endif; ?>
                            <td class="align-middle" scope="row"><?php echo e($service->id); ?></td>
                            <td class="align-middle"><?php echo e($service->name); ?></td>
                            <td class="align-middle"><?php echo e($service->description); ?></td>
                            <td class="align-middle"><?php echo e($service->cost_price); ?></td>
                            <td class="align-middle"><?php echo e($service->selling_price); ?></td>
                            <td class="align-middle"><?php echo e($service->getDurationWithUnit()); ?></td>
                            <td class="align-middle">
                                <?php if($service->active ==1): ?>
                                    <span class="font-weight-bold badge text-white bg-success">Oui</span>
                                <?php else: ?>
                                    <span class="font-weight-bold badge text-white bg-secondary">Non</span>
                                <?php endif; ?>
                            </td>
                            <td class="align-middle"><?php echo e($service->notes); ?></td>
                            
                            <?php if((Auth::user()->hasPermission('services-update')) || (Auth::user()->hasPermission('services-delete'))): ?>
                                <td class="align-middle">
                                    <div class="btn-group btn-group-sm">
                                        
                                        <?php if(Auth::user()->hasPermission('services-update')): ?>
                                            <a href="#" wire:click.prevent="edit(<?php echo e($service); ?>)" class="btn btn-primary">
                                                <i class="fa fa-edit"></i>
                                            </a>
                                        <?php endif; ?>
                                        
                                        <?php if(Auth::user()->hasPermission('services-delete')): ?>
                                            <a class="btn btn-danger" href="#" wire:click.prevent="confirmServiceRemoval(<?php echo e($service->id); ?>)">
                                                <i class="fa fa-trash bg-danger"></i>
                                            </a>
                                        <?php endif; ?>
                                    </div>
                                    <form action="" method="post" id="delete-service-<?php echo e($service->id); ?>" class="d-none">
                                        <?php echo csrf_field(); ?>
                                        <?php echo method_field('DELETE'); ?>
                                    </form>
                                </td>
                            <?php endif; ?>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <tr>
                            <td colspan="6" class="text-center">No services found</td>
                        </tr>
                    <?php endif; ?>
                    </tbody>
                    <tfoot>
                    <tr class="bg-light">
                        <td colspan="14">
                            <?php echo $services->appends(request()->all())->links(); ?>

                        </td>
                    </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>

    <!-- Modal Create or Update service -->

    <div class="modal fade" id="form" tabindex="-1" service="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog" service="document">
            <form autocomplete="off" wire:submit.prevent="<?php echo e($showEditModal ? 'updateService' : 'createService'); ?>">
                <div class="modal-content">
                    <div class="modal-header bg-light">
                        <h5 class="modal-title" id="exampleModalLabel">
                            <?php if($showEditModal): ?>
                                <span>Modifier le service<span>
                            <?php else: ?>
                                <span>Ajouter un nouveau service</span>
                            <?php endif; ?>
                        </h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row h-100 justify-content-center align-items-center">
                            <div class="col-12">

                                <!-- Modal service name -->
                                <div class="form-group">
                                    <label for="name">Nom</label>
                                    <input type="text" tabindex="1" wire:model.defer="data.name"
                                           class="form-control <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" id="name"
                                           aria-describedby="nameHelp" placeholder="Nom du service">
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
                                

                            </div>
                            <div class="col-12">

                                <!-- Modal service description -->
                                <div class="form-group">
                                    <label for="name">Description</label>
                                    <textarea  tabindex="1" wire:model.defer="data.description"
                                           class="form-control <?php $__errorArgs = ['description'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" id="description"
                                           aria-describedby="nameHelp" placeholder="Description du service">
                                    </textarea>
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
                        <div class="row h-100 justify-content-center align-items-center">
                            <div class="col-6">
                                <!-- Modal service cost price -->
                                <div class="form-group">
                                    <label for="cost_price">Prix d'Achat</label>
                                    <input type="number" min="1" tabindex="1" wire:model.defer="data.cost_price"
                                           class="form-control <?php $__errorArgs = ['cost_price'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" id="cost_price"
                                           aria-describedby="nameHelp" >
                                    <?php $__errorArgs = ['cost_price'];
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
                                <!-- Modal service selling price -->
                                <div class="form-group">
                                    <label for="selling_price">Prix de Vente</label>
                                    <input type="number" min="1" tabindex="1" wire:model.defer="data.selling_price"
                                           class="form-control <?php $__errorArgs = ['selling_price'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" id="selling_price"
                                           aria-describedby="nameHelp" >
                                    <?php $__errorArgs = ['selling_price'];
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
                        <div class="row h-100 justify-content-center align-items-center">

                            <div class="col-6">
                                <!-- Modal service duration -->
                                <div class="form-group">
                                    <label for="duration">Durée</label>
                                    <input type="number" min="1" tabindex="1" wire:model.defer="data.duration"
                                           class="form-control <?php $__errorArgs = ['duration'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" id="duration"
                                           aria-describedby="nameHelp" >
                                    <?php $__errorArgs = ['duration'];
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
                                <!-- Modal service duration type -->
                                <div class="form-group">
                                    <label for="duration_unit">Par</label>
                                    <select  wire:model.defer="data.duration_unit" class="form-control <?php $__errorArgs = ['duration_unit'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" id="duration_unit"
                                             aria-describedby="nameHelp">
                                        <?php $__empty_1 = true; $__currentLoopData = $durationUnits; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $durationUnit): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                            <option value="<?php echo e($index); ?>"><?php echo e($durationUnit); ?></option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                            <option value="1">mois</option>
                                        <?php endif; ?>
                                    </select>
                                    <?php $__errorArgs = ['duration_unit'];
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
                        <div class="row h-100 justify-content-center align-items-center">
                            <div class="col-12">
                                <!-- Modal service notes -->
                                <div class="form-group">
                                    <div class="custom-control custom-switch" style="min-width: 180px;margin-right: 80px;">
                                        <input type="checkbox" class="custom-control-input" id="customSwitch1" checked="true" wire:model.defer="data.active">
                                        <label class="custom-control-label" for="customSwitch1">Actif</label>
                                    </div>
                                    <?php $__errorArgs = ['active'];
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
                        <div class="row h-100 justify-content-center align-items-center">

                            <div class="col-12">
                                <!-- Modal service notes -->
                                <div class="form-group">
                                    <label for="notes">Remarques</label>
                                    <textarea  tabindex="1" wire:model.defer="data.notes"
                                              class="form-control <?php $__errorArgs = ['notes'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" id="notes" aria-describedby="nameHelp"
                                              placeholder="">
                                    </textarea>
                                    <?php $__errorArgs = ['notes'];
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
                    </div>

                    <div class="modal-footer bg-light">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal"><i
                                class="mr-1 fa fa-times"></i> Cancel</button>
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

    <!-- Modal Delete service -->
    <div class="modal fade" id="confirmationModal" tabindex="-1" service="dialog"
         aria-labelledby="exampleModalLabel" aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog" service="document">
            <div class="modal-content">
                <div class="modal-header bg-light">
                    <h5>Supprimer le client</h5>
                </div>

                <div class="modal-body">
                    <h4>Voulez-vous vraiment supprimer ce service ?</h4>
                </div>

                <div class="modal-footer bg-light">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal"><i
                            class="mr-1 fa fa-times"></i> Annuler</button>
                    <button type="button" wire:click.prevent="deleteService" class="btn btn-danger"><i
                            class="mr-1 fa fa-trash"></i>Supprimer le service</button>
                </div>
            </div>
        </div>
    </div>

    <?php echo $__env->make("livewire.backend.admin.excel-import-modal", \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    

    <?php $__env->startSection('script'); ?>
        <script src="<?php echo e(asset('backend/js/backend.js')); ?>"></script>

        
            <script>
                $(document).ready(function(){
                    window.addEventListener('show-import-excel-modal', function (event) {
                        $('#importExcelModal').modal('show');
                    });

                    window.addEventListener('hide-import-excel-modal', function (event) {
                        $('#importExcelModal').modal('hide');
                    });
                });
            </script>


        

        <script>
            window.addEventListener('show-delete-alert-confirmation', event => {
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
    <?php $__env->stopSection(); ?>
</div>
<?php /**PATH C:\xampp\htdocs\tv-subscriptions-management\resources\views/livewire/backend/admin/services/list-services.blade.php ENDPATH**/ ?>