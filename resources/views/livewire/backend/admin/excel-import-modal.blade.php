<!-- Modal Import Excel File -->
<div class="modal fade" id="importExcelModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" wire:ignore.self>
    <div class="modal-dialog" role="document">
        <form autocomplete="off" wire:submit.prevent="importExcel">
            <div class="modal-content">
                <div class="modal-header bg-light">
                    <h5 class="modal-title" id="exampleModalLabel">
                        Import Excel File
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">

                    <!-- Modal Excel File -->

                    <div class="form-group">
                        <label for="custom-file">Choose Excel File</label>
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
                                    Choose Excel file
                                @endif
                            </label>
                        </div>
                    </div>
                    <div class="mb-0 form-group">
                        <label>Import As :</label>
                        <label class="ml-3 radio-inline">
                            <input type="radio" wire:click="importType('addNew')" name="optionsRadiosInline" id="optionsRadiosInline1" value="addNew" checked="checked">Add New
                        </label>
                        <label class="ml-3 radio-inline">
                            <input type="radio" wire:click="importType('Update')" name="optionsRadiosInline" id="optionsRadiosInline2" value="Update">Update
                        </label>
                    </div>
                </div>

                <div class="modal-footer bg-light">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="mr-1 fa fa-times"></i> Annuler</button>
                    <button type="submit" class="btn btn-primary"><i class="mr-1 fa fa-open"></i> Open</button>
                </div>
            </div>
        </form>
    </div>
</div>
