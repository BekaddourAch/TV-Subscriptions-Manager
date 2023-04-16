<div>
    <?php $__env->startSection('style'); ?>
        <style>

        </style>
    <?php $__env->stopSection(); ?>

    <div class="shadow card">
        <div class="py-3 card-header">
            <ol class="m-0 breadcrumb float-sm-left font-weight-bold text-primary">
                <li class="breadcrumb-item"><a href="<?php echo e(route('admin.index')); ?>">Dashboard</a></li>
                <li class="breadcrumb-item active">Les Clients</li>
            </ol>
            <div class="mt-2 d-flex justify-content-end">
                <?php if(0==1): ?>
                    
                <?php endif; ?>
                <?php if(Auth::user()->hasPermission('customers-create')): ?>
                
                <button wire:click.prevent='addNewCustomer' class="ml-1 btn btn-sm btn-primary">
                    <i class="mr-2 fa fa-plus-circle"
                        aria-hidden="true">
                        <span>Ajouter un Client</span>
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
                                <?php echo e($customersCount); ?>

                            </span>
                            <span class="text">Tous</span>
                        </button>
                        
                        <?php if(0==1): ?>
                        
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>


        <div class="p-3 card-body">
            <?php if($selectedRows): ?>
                <div class="mb-3 d-flex">
                    <span class="pt-1 text-success">
                        <i class="fa fa-user" aria-hidden="true"></i>
                       
                         <span class="text-gray-900 font-weight-bold"><?php echo e(count($selectedRows)); ?></span> <?php echo e(Str::plural('Clients', count($selectedRows))); ?> Sélectionné
                    </span>
                   
                
                        <div class="ml-3 dropdown">
                            <button class="btn btn-secondary dropdown-toggle btn-sm" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                Actions
                            </button>
                            
                            <div class="bg-gray-100 dropdown-menu animated--fade-in" aria-labelledby="dropdownMenuButton" style="">
                                <?php if(Auth::user()->hasPermission('customers-update')): ?>
                                    <a class="dropdown-item" wire:click.prevent="setAllAsActive" href="#">Définir comme actif</a>
                                    <a class="dropdown-item" wire:click.prevent="setAllAsInActive" href="#">Définir comme inactif</a>
                                <?php endif; ?>
                                <div class="dropdown-divider"></div>
                                <?php if(Auth::user()->hasPermission('customers-delete')): ?>
                                    <a class="dropdown-item text-danger delete-confirm" wire:click.prevent="deleteSelectedRows" href="#">Supprimer les clients sélectionnée</a>
                                <?php endif; ?>
                            </div>
                        </div> 
                </div>
            <?php endif; ?>
            <div class="table-responsive">
                <table class="table">
                    <thead class="text-white bg-gradient-secondary">
                        <tr class="text-center">
                            
                            <?php if((Auth::user()->hasPermission('customers-update')) || (Auth::user()->hasPermission('customers-delete'))): ?>
                                <th class="align-middle" scope="col">
                                    <div class="custom-control custom-checkbox small">
                                        <input type="checkbox" wire:model="selectPageRows" value="" class="custom-control-input" id="customCheck">
                                        <label class="custom-control-label" for="customCheck"></label>
                                    </div>
                                </th> 
                            <?php endif; ?>              

                            <th class="align-middle" scope="col">#</th>
                            <th class="align-middle">Nom </th>
                            <th class="align-middle"> Prénom </th>
                            <th class="align-middle"> Téléphone 1 </th>
                            <th class="align-middle"> Téléphone 2 </th>
                            <th class="align-middle"> Email </th>
                            <th class="align-middle"> Adresse </th>
                            <th class="align-middle"> Wilaya </th>
                            <th class="align-middle"> Commune </th>
                            <th class="align-middle"> Actif </th>
                            <th class="align-middle"> Commentaires </th>
                            <?php if((Auth::user()->hasPermission('customers-update')) || (Auth::user()->hasPermission('customers-delete'))): ?>
                                <th class="align-middle" style="width: 10%" colspan="2">Actions
                                </th>
                            <?php endif; ?>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__empty_1 = true; $__currentLoopData = $customers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $customer): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        
                            <tr class="text-center">
                                
                                
                                <?php if((Auth::user()->hasPermission('customers-update')) || (Auth::user()->hasPermission('customers-delete'))): ?>
                                    <td class="align-middle" scope="col">
                                        <div class="custom-control custom-checkbox small">
                                            <input type="checkbox" wire:model="selectedRows" value="<?php echo e($customer->id); ?>" class="custom-control-input" id="<?php echo e($customer->id); ?>">
                                            <label class="custom-control-label" for="<?php echo e($customer->id); ?>"></label>
                                        </div>
                                    </td>
                                <?php endif; ?>
                                <td class="align-middle" scope="row"><?php echo e($customer->id); ?></td>
                                <td class="align-middle"><?php echo e($customer->firstname); ?></td>
                                <td class="align-middle"><?php echo e($customer->lastname); ?></td>
                                <td class="align-middle"><?php echo e($customer->phone1); ?></td>
                                <td class="align-middle"><?php echo e($customer->phone2); ?></td>
                                <td class="align-middle"><?php echo e($customer->email); ?></td>
                                <td class="align-middle"><?php echo e($customer->address); ?></td>
                                <td class="align-middle"><?php echo e($customer->state); ?></td>
                                <td class="align-middle"><?php echo e($customer->city); ?></td>
                                <td class="align-middle"> 
                                    <?php if($customer->active ==1): ?>
                                    <span class="font-weight-bold badge text-white bg-success">Oui</span>
                                    <?php else: ?>
                                    <span class="font-weight-bold badge text-white bg-secondary">Non</span>
                                    <?php endif; ?> 
                            </td>
                                <td class="align-middle"><?php echo e($customer->notes); ?></td>
                                
                            <?php if((Auth::user()->hasPermission('customers-update')) || (Auth::user()->hasPermission('customers-delete'))): ?>
                                    <td class="align-middle">
                                        <div class="btn-group btn-group-sm">
                                            <?php if(Auth::user()->hasPermission('customers-update')): ?>
                                            <a href="#" wire:click.prevent="edit(<?php echo e($customer); ?>)" class="btn btn-primary">
                                                <i class="fa fa-edit"></i>
                                            </a>  
                                            <?php endif; ?>
                                            <?php if(Auth::user()->hasPermission('customers-delete')): ?>
                                        <a class="btn btn-danger" href="#" wire:click.prevent="confirmCustomerRemoval(<?php echo e($customer->id); ?>)">
                                            <i class="fa fa-trash bg-danger"></i>
                                        </a>
                                        <?php endif; ?>

                                        </div>
                                        <form action="" method="post" id="delete-customer-<?php echo e($customer->id); ?>" class="d-none">
                                                <?php echo csrf_field(); ?>
                                            <?php echo method_field('DELETE'); ?>
                                        </form>  
                                    </td>
                                <?php endif; ?>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <tr>
                                <td colspan="6" class="text-center">Aucun client trouvé</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                    <tfoot>
                        <tr class="bg-light">
                            <td colspan="14">
                                <?php echo $customers->appends(request()->all())->links(); ?>  
                            </td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>

    <!-- Modal Create or Update customer -->

    <div class="modal fade" id="form" tabindex="-1" customer="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog" customer="document">
            <form autocomplete="off" wire:submit.prevent="<?php echo e($showEditModal ? 'updateCustomer' : 'createCustomer'); ?>">
                <div class="modal-content">
                    <div class="modal-header bg-light">
                        <h5 class="modal-title" id="exampleModalLabel">
                            <?php if($showEditModal): ?>
                                <span>Modifier le client</span>
                            <?php else: ?>
                                <span>Ajouter un nouveau client</span>
                            <?php endif; ?>
                        </h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row h-100 justify-content-center align-items-center">
                            <div class="col-6">

                                <!-- Modal customer lastname -->
                                <div class="form-group">
                                    <label for="firstname">Nom</label>
                                    <input type="text" tabindex="1" wire:model.defer="data.firstname"
                                        class="form-control <?php $__errorArgs = ['firstname'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" id="firstname"
                                        aria-describedby="nameHelp" placeholder="Saisissez le nom du client">
                                    <?php $__errorArgs = ['firstname'];
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
                                <!-- Modal customer firstname -->
                                <div class="form-group">
                                    <label for="lastname">Prénom</label>
                                    <input type="text" tabindex="1" wire:model.defer="data.lastname"
                                        class="form-control <?php $__errorArgs = ['lastname'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" id="lastname"
                                        aria-describedby="nameHelp" placeholder="Saisissez le prénom du client">
                                    <?php $__errorArgs = ['lastname'];
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
                                    <!-- Modal customer phone1 -->
                                    <div class="form-group">
                                        <label for="phone1">Téléphone 1</label>
                                        <input  type="tel" tabindex="1" placeholder="ex:0655112233" pattern="[0-9]{10}" required wire:model.defer="data.phone1"
                                            class="form-control <?php $__errorArgs = ['phone1'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" id="phone1"
                                            aria-describedby="nameHelp" placeholder="Entrez le 1er téléphone  du client">
                                        <?php $__errorArgs = ['phone1'];
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
                                    <!-- Modal customer phone2 -->
                                    <div class="form-group">
                                        <label for="phone2">Téléphone 2</label>
                                        <input  type="tel" tabindex="1" placeholder="ex:0655112233" pattern="[0-9]{10}"  wire:model.defer="data.phone2"
                                            class="form-control <?php $__errorArgs = ['phone2'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" id="phone2"
                                            aria-describedby="nameHelp" placeholder="Entrez le 2ème téléphone  du client">
                                        <?php $__errorArgs = ['phone2'];
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
                                    <!-- Modal customer email -->
                                    <div class="form-group">
                                        <label for="email">Email</label>
                                        <input type="text" tabindex="1" wire:model.defer="data.email"
                                            class="form-control <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" id="email"
                                            aria-describedby="nameHelp" placeholder="Entrez l'e-mail du client">
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
                                    

                                </div>
                                <div class="col-6">
                                    <!-- Modal customer address -->
                                    <div class="form-group">
                                        <label for="address">Adresse</label>
                                        <input type="text" tabindex="1" wire:model.defer="data.address" class="form-control <?php $__errorArgs = ['address'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                            id="address" aria-describedby="nameHelp" placeholder="Entrez l'adresse du client">
                                     
                                        <?php $__errorArgs = ['address'];
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
                                    <!-- Modal customer state -->
                                    <div class="form-group">
                                        <label for="state">Wilaya</label>
                                        
                                            <select  wire:model.defer="data.state" class="form-control <?php $__errorArgs = ['state'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" id="state"
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
                                        <?php $__errorArgs = ['state'];
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
                                    <!-- Modal customer notes -->
                                    <div class="form-group"> 
                                        <label for="customSwitch1">Rendre le client Actif</label>
                                        <div class="custom-control custom-switch" style="min-width: 180px;margin-right: 80px;">
                                            <input type="checkbox" class="custom-control-input" id="customSwitch1" checked="" wire:model.defer="data.active">
                                            <label class="custom-control-label" for="customSwitch1"></label>
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
                                    <!-- Modal customer notes -->
                                    <div class="form-group">
                                        <label for="notes">Remarques</label>
                                        <textarea type="textarea" tabindex="1" wire:model.defer="data.notes"
                                            class="form-control <?php $__errorArgs = ['notes'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" id="notes" aria-describedby="nameHelp"
                                            placeholder="Saisir les Remarques des clients">
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

    <!-- Modal Delete customer -->
    <div class="modal fade" id="confirmationModal" tabindex="-1" customer="dialog"
        aria-labelledby="exampleModalLabel" aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog" customer="document">
            <div class="modal-content">
                <div class="modal-header bg-light">
                    <h5>Supprimer le client</h5>
                </div>

                <div class="modal-body">
                    <h4>Voulez-vous vraiment supprimer ce client ?</h4>
                </div>

                <div class="modal-footer bg-light">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal"><i
                            class="mr-1 fa fa-times"></i> Annuler</button>
                    <button type="button" wire:click.prevent="deleteCustomer" class="btn btn-danger"><i
                            class="mr-1 fa fa-trash"></i>Supprimer le client</button>
                </div>
            </div>
        </div>
    </div>

    

    <?php $__env->startSection('script'); ?>
        <script src="<?php echo e(asset('backend/js/backend.js')); ?>"></script>

        



        

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
<?php /**PATH C:\xampp\htdocs\tv-subscriptions-management\resources\views/livewire/backend/admin/customer/list-customers.blade.php ENDPATH**/ ?>