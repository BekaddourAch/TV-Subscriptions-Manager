<?php

namespace App\Http\Livewire\Backend\Admin\Settings;

use Livewire\Component;

class Settings extends Component
{
    public $settings;
    public $frLang = [];
    public $settingKeyBeingRemoved = null;
    public function mount(){
        $this->settings= settings()->all();
        $this->frLang ["dashboard_nb_subscriptions_days"]= "Statistiques : nombre des jours a expirer (par défault : 30)";
    }


    public function updateField($key, $value)
    {
        settings()->set($key, $value);
    }

    public function forgetField()
    {
        settings()->forget($this->settingKeyBeingRemoved);
        $this->settings= settings()->all();
        $this->dispatchBrowserEvent('hide-delete-modal');

    }

    public function confirmSettingRemoval($key)
    {
            $this->settingKeyBeingRemoved = $key;
            $this->dispatchBrowserEvent('show-delete-modal');
    }


    public function render()
    {

        return view('livewire.backend.admin.settings.settings')->layout('layouts.admin');


    }
}
