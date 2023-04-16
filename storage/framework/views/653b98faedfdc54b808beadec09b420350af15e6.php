<div>
    <?php $__env->startSection('style'); ?>
        <style>

        </style>
    <?php $__env->stopSection(); ?>

    <div class="shadow card">
        <div class="py-3 card-header">
            <ol class="m-0 breadcrumb float-sm-left font-weight-bold text-primary">
                <li class="breadcrumb-item"><a href="<?php echo e(route('admin.index')); ?>">Dashboard</a></li>
                <li class="breadcrumb-item active">Les Abonnements</li>
            </ol>
            <div class="mt-2 d-flex justify-content-end">

                <?php if(0 == 1): ?>
                    
                <?php endif; ?>

                <?php if(Auth::user()->hasPermission('subscription-create')): ?>
                    <button wire:click.prevent='addNewSubscription' class="ml-1 btn btn-sm btn-primary">
                        <i class="mr-2 fa fa-plus-circle" aria-hidden="true">
                            <span>Ajouter un Abonnement</span>
                        </i>
                    </button>
                <?php endif; ?>
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
            <div class="m-3 mw-100 justify-content-end">
                <div class="btn-group">
                    <div data-toggle="buttons">
                        <button wire:click="" class="btn btn-sm btn-warning btn-icon-split">
                            <span class="icon text-white-20">
                                <?php echo e($subscriptionsCount); ?>

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

                        <span class="text-gray-900 font-weight-bold"><?php echo e(count($selectedRows)); ?></span>
                        <?php echo e(Str::plural('subscriptions', count($selectedRows))); ?> Sélectionné
                    </span>

                    <div class="ml-3 dropdown">
                        <button class="btn btn-secondary dropdown-toggle btn-sm" type="button" id="dropdownMenuButton"
                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Actions
                        </button>
                        <div class="bg-gray-100 dropdown-menu animated--fade-in" aria-labelledby="dropdownMenuButton"
                            style="">
                            
                            <?php if(Auth::user()->hasPermission('subscription-delete')): ?>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item text-danger delete-confirm"
                                    wire:click.prevent="deleteSelectedRows" href="#">Supprimer les Abonnements
                                    sélectionnée</a>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
            <div class="table-responsive">
                <table class="table">
                    <thead class="text-white bg-gradient-secondary">
                        <tr class="text-center">

                            <?php if(Auth::user()->hasPermission('subscription-update') || Auth::user()->hasPermission('subscription-delete')): ?>
                                <th class="align-middle" scope="col">
                                    <div class="custom-control custom-checkbox small">
                                        <input type="checkbox" wire:model="selectPageRows" value=""
                                            class="custom-control-input" id="customCheck">
                                        <label class="custom-control-label" for="customCheck"></label>
                                    </div>
                                </th>
                            <?php endif; ?>
                            <th class="align-middle" scope="col">#</th>
                            <th class="align-middle"> Service </th>
                            <th class="align-middle"> Client </th>
                            <th class="align-middle"> Créer par </th>
                            <th class="align-middle"> Prix d'Achat </th>
                            <th class="align-middle"> Quantité </th>
                            <th class="align-middle"> Prix de Vente </th>
                            <th class="align-middle"> Date Début </th>
                            <th class="align-middle"> Date Fin </th>
                            <th class="align-middle"> Total </th>
                            <th class="align-middle"> Remarques </th>

                            <?php if(Auth::user()->hasPermission('subscription-update') || Auth::user()->hasPermission('subscription-delete')): ?>
                                <th class="align-middle" style="width: 10%" colspan="2">Actions </th>
                            <?php endif; ?>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__empty_1 = true; $__currentLoopData = $subscriptions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $subscription): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <tr class="text-center">

                                <?php if(Auth::user()->hasPermission('subscription-update') || Auth::user()->hasPermission('subscription-delete')): ?>
                                    <td class="align-middle" scope="col">
                                        <div class="custom-control custom-checkbox small">
                                            <input type="checkbox" wire:model="selectedRows"
                                                value="<?php echo e($subscription->id_subscription); ?>"
                                                class="custom-control-input" id="<?php echo e($subscription->id_subscription); ?>">
                                            <label class="custom-control-label"
                                                for="<?php echo e($subscription->id_subscription); ?>"></label>
                                        </div>
                                    </td>
                                <?php endif; ?>
                                <td class="align-middle" scope="row"><?php echo e($subscription->id_subscription); ?></td>
                                <td class="align-middle"><?php echo e($subscription->Service->name); ?></td>
                                <td class="align-middle">
                                    <?php echo e($subscription->Customer->firstname . ' ' . $subscription->Customer->lastname); ?>

                                </td>
                                <td class="align-middle"><?php echo e($subscription->User->username); ?></td>
                                <td class="align-middle"><?php echo e($subscription->cost_price); ?></td>
                                <td class="align-middle"><?php echo e($subscription->quantity); ?></td>
                                <td class="align-middle"><?php echo e($subscription->selling_price); ?></td>
                                <td class="align-middle"><?php echo e($subscription->begin_date); ?></td>
                                <td class="align-middle"><?php echo e($subscription->end_date); ?></td>
                                <td class="align-middle"><?php echo e($subscription->total); ?></td>
                                <td class="align-middle"><?php echo e($subscription->notes); ?></td>

                                <?php if(Auth::user()->hasPermission('subscription-update') || Auth::user()->hasPermission('subscription-delete')): ?>
                                    <td class="align-middle">
                                        <div class="btn-group btn-group-sm">

                                            <?php if(Auth::user()->hasPermission('subscription-update')): ?>
                                                <a href="#"
                                                    wire:click.prevent="edit(<?php echo e($subscription->id_subscription); ?>)"
                                                    class="btn btn-primary">
                                                    <i class="fa fa-edit"></i>
                                                </a>
                                            <?php endif; ?>

                                            <?php if(Auth::user()->hasPermission('subscription-delete')): ?>
                                                <a class="btn btn-danger" href="#"
                                                    wire:click.prevent="confirmSubscriptionRemoval(<?php echo e($subscription->id_subscription); ?>)">
                                                    <i class="fa fa-trash bg-danger"></i>
                                                </a>
                                            <?php endif; ?>
                                        </div>
                                        <form action="" method="post"
                                            id="delete-subscription-<?php echo e($subscription->id_subscription); ?>"
                                            class="d-none">
                                            <?php echo csrf_field(); ?>
                                            <?php echo method_field('DELETE'); ?>
                                        </form>
                                    </td>
                                <?php endif; ?>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <tr>
                                <td colspan="6" class="text-center">Aucun abonnement trouvé</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                    <tfoot>
                        <tr class="bg-light">
                            <td colspan="14">
                                <?php echo $subscriptions->appends(request()->all())->links(); ?>

                            </td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>

    <!-- Modal Create or Update subscription -->

    <div class="modal fade" id="form" tabindex="-1" subscription="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog" subscription="document">
            <form autocomplete="off"
                wire:submit.prevent="<?php echo e($showEditModal ? 'updateSubscription' : 'createSubscription'); ?>">
                <div class="modal-content">
                    <div class="modal-header bg-light">
                        <h5 class="modal-title" id="exampleModalLabel">
                            <?php if($showEditModal): ?>
                                <span>Modifier l'Abonnement<span>
                                    <?php else: ?>
                                        <span>Ajouter un nouveau Abonnement</span>
                            <?php endif; ?>
                        </h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row h-100 justify-content-center align-items-center">
                            <div class="col-12">
                                <!-- Modal subscription name -->
                                <div class="form-group">
                                    <select class=" form-control  show-tick" wire:model.defer="data.id_customer"
                                        data-live-search="true" title="Selectionnez un client" id="customer_select">
                                        <?php $__currentLoopData = $customers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $customer): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($customer->id_customer); ?>"
                                                wire:key="<?php echo e($customer->id_customer); ?>">
                                                <?php echo e($customer->firstname . ' ' . $customer->lastname); ?></option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-12">
                                <!-- Modal subscription description -->
                                <div class="form-group">
                                    <div class="form-group">
                                        <select class=" form-control  show-tick" wire:model.defer="data.id_service"
                                            data-live-search="true" onchange="onServicesChange(this)"
                                            title="Selectionez un service" id="service_select">
                                            <?php $__currentLoopData = $services; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $service): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <option value="<?php echo e($service->id_service); ?>"
                                                    wire:key="<?php echo e($service->id_service); ?>"
                                                    data-object="<?php echo e(base64_encode(json_encode(['cost_price' => $service->cost_price, 'selling_price' => $service->selling_price, 'duration_unit' => $service->duration_unit, 'duration' => $service->duration]))); ?>">
                                                    <?php echo e($service->name); ?></option>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </select>




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

                        </div>
                        <div class="row h-100 justify-content-center align-items-center">
                            <div class="col-6">
                                <!-- Modal subscription cost price -->
                                <div class="form-group">
                                    <label for="cost_price">Prix d'Achat</label>
                                    <input type="number" min="1" tabindex="1"
                                        wire:model.defer="data.cost_price" value="" readonly
                                        class="form-control <?php $__errorArgs = ['cost_price'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" id="cost_price"
                                        aria-describedby="nameHelp">
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
                                <!-- Modal subscription selling price -->
                                <div class="form-group">
                                    <label for="selling_price">Prix de Vente</label>
                                    <input type="number" min="1" tabindex="1"
                                        wire:model.defer="data.selling_price"
                                        class="form-control <?php $__errorArgs = ['selling_price'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                        id="selling_price" aria-describedby="nameHelp">
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

                            <div class="col-12">
                                <!-- Modal subscription quantity -->
                                <div class="form-group">
                                    <label for="quantity">Quantité</label>
                                    <input type="number" min="1" tabindex="1"
                                        wire:model.defer="data.quantity"
                                        class="form-control <?php $__errorArgs = ['quantity'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" id="quantity"
                                        aria-describedby="nameHelp">
                                    <?php $__errorArgs = ['quantity'];
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
                                <!-- Modal subscription begin_date type -->
                                <div class="form-group">
                                    <label for="begin_date">Date début</label>
                                    <input type="date" min="1" tabindex="1"
                                        wire:model.defer="data.begin_date"
                                        class="form-control <?php $__errorArgs = ['begin_date'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" id="begin_date"
                                        aria-describedby="nameHelp">
                                    <?php $__errorArgs = ['begin_date'];
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

                                <div class="form-group">
                                    <label for="end_date">Date fin</label>
                                    <input type="date" min="1" tabindex="1"
                                        wire:model.defer="data.end_date"
                                        class="form-control <?php $__errorArgs = ['end_date'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" id="end_date"
                                        aria-describedby="nameHelp">

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
                                    <textarea tabindex="1" wire:model.defer="data.notes" class="form-control <?php $__errorArgs = ['notes'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                        id="notes" aria-describedby="nameHelp" placeholder="">
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
                </div>
            </form>
        </div>
    </div>

    <!-- Modal Delete subscription -->
    <div class="modal fade" id="confirmationModal" tabindex="-1" subscription="dialog"
        aria-labelledby="exampleModalLabel" aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog" subscription="document">
            <div class="modal-content">
                <div class="modal-header bg-light">
                    <h5>Supprimer l'Abonnement</h5>
                </div>

                <div class="modal-body">
                    <h4>Voulez-vous vraiment supprimer l'Abonnement ?</h4>
                </div>

                <div class="modal-footer bg-light">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal"><i
                            class="mr-1 fa fa-times"></i> Annuler</button>
                    <button type="button" wire:click.prevent="deleteSubscription" class="btn btn-danger"><i
                            class="mr-1 fa fa-trash"></i>Supprimer l'Abonnement</button>
                </div>
            </div>
        </div>
    </div>

    

    <?php $__env->startSection('script'); ?>
        
        <script src="<?php echo e(asset('backend/js/backend.js')); ?>"></script>

        
        <script>
            $(document).ready(function() {
                window.addEventListener('show-import-excel-modal', function(event) {
                    $('#importExcelModal').modal('show');
                });

                window.addEventListener('hide-import-excel-modal', function(event) {
                    $('#importExcelModal').modal('hide');
                });
            });
        </script>


        

        <script>
            // To style all selects 
            window.addEventListener('show-delete-alert-confirmation', event => {
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
        <script>
            window.addEventListener('post-show-form', event => {
                // $('#service_select').css( { "display", "block !important" } );

                // $('#customer_select').css( { "display", "block !important" } ); 

                $('#customer_select').selectpicker();

                $('#service_select').selectpicker();
                // $('.selectpicker').selectpicker();

            });
        </script>
        <script>
            const dateToInput = date =>
                `${date.getFullYear() }-${('0' + (date.getMonth() + 1)).slice(-2) }-${('0' + date.getDate()).slice(-2) }`;

            // str is expected in yyyy-mm-dd format (e.g., "2017-03-14")
            const inputToDate = str => new Date(str.split('-'));


            function onServicesChange(thing) {
                //var service=btoa($(thing).data('object'));
                var service = $('option:selected', thing).data('object')
                var serv_object = atob(service)
                var servc_json = JSON.parse(serv_object)
                $('#form #cost_price').val(servc_json.cost_price);
                window.livewire.find('<?php echo e($_instance->id); ?>').set('data.cost_price', servc_json.cost_price, true);

                $('#form #selling_price').val(servc_json.selling_price);
                window.livewire.find('<?php echo e($_instance->id); ?>').set('data.selling_price', servc_json.selling_price, true);


                console.log(increment_date('jour', 10));

                $('#form .row #begin_date').val(dateToInput(new Date()));
                window.livewire.find('<?php echo e($_instance->id); ?>').set('data.begin_date', dateToInput(new Date()), true);

                $('#form .row #end_date').val(increment_date(servc_json.duration_unit, servc_json.duration));
                window.livewire.find('<?php echo e($_instance->id); ?>').set('data.end_date', increment_date(servc_json.duration_unit, servc_json.duration), true);
            }



            function increment_date(unit, duree) {
                var answer = ""

                var date = new Date();
                switch (unit) {
                    case 1:
                        //date.getDate() + 1
                        date.setDate(date.getDate() + duree);
                        break;
                    case 2:
                        date.setDate(date.getDate() + duree * 7);
                        break;
                    case 3:
                        // increase the date by 6 months
                        date.setMonth(date.getMonth() + duree);
                        break;
                    case 4:
                        // increase the date by 2 years
                        date.setFullYear(date.getFullYear() + duree);
                        break;
                }
                answer = dateToInput(date);
                return answer;
            }

            //  theTest(servc_json.cost_price);
        </script>
        
    <?php $__env->stopSection(); ?>
</div>
<?php /**PATH C:\xampp\htdocs\tv-subscriptions-management\resources\views/livewire/backend/admin/subscriptions/list-subsctiptions.blade.php ENDPATH**/ ?>