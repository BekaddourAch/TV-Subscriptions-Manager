<?php

namespace App\Http\Livewire\Backend\Admin\Dashboard;

use App\Models\Customer;
use App\Models\Subscription;
use Carbon\Carbon;
use Livewire\Component;

class Dashboard extends Component
{
    public $begin;
    public $end;
    public $totalSales;
    public $totalProfits;
    public $totalSubscriptions;
    public $totalActiveSubscriptions;
    public $totalCustomers;
    public $topSubscriptionsPerRegions;
    public $subscriptionsTotalSalesPerMonth;
    public $subscriptionsTotalServices;

    public function mount()
    {
        $this->begin = now()->format('d/m/Y');
        $this->end = now()->format('d/m/Y');
        $this->totalSales = Subscription::getTotalSales();
        $this->totalProfits = Subscription::getTotalProfits();
        $this->totalSubscriptions = Subscription::countSubscriptions();
        $this->totalActiveSubscriptions = Subscription::countActiveSubscriptions();
        $this->topSubscriptionsPerRegions = Subscription::getTopSubscriptionsPerRegions();
        $this->subscriptionsTotalSalesPerMonth = Subscription::getSubscriptionsTotalSalesPerMonth();
        $this->subscriptionsTotalServices = Subscription::getSubscriptionsTotalServices();
        $this->totalCustomers = Customer::countCustomers();
    }

    public function submit()
    {
        $startDate = Carbon::createFromFormat('d/m/Y', $this->begin)->format('Y-m-d');
        $endDate = Carbon::createFromFormat('d/m/Y', $this->end)->format('Y-m-d');
        $this->totalSales = Subscription::getTotalSales($startDate,$endDate);
        $this->totalProfits = Subscription::getTotalProfits($startDate,$endDate);
        $this->totalSubscriptions = Subscription::countSubscriptions($startDate,$endDate);
        $this->topSubscriptionsPerRegions = Subscription::getTopSubscriptionsPerRegions($startDate,$endDate);
        $this->totalActiveSubscriptions = Subscription::countActiveSubscriptions();
        $this->subscriptionsTotalSalesPerMonth = Subscription::getSubscriptionsTotalSalesPerMonth($startDate,$endDate);
        $this->subscriptionsTotalServices = Subscription::getSubscriptionsTotalServices($startDate,$endDate);
        $this->totalCustomers = Customer::countCustomers($startDate,$endDate);
        $this->dispatchBrowserEvent('draw-dashboard-charts');
    }

    public function render()
    {
        return view('livewire.backend.admin.dashboard.dashboard',[
        ])->layout('layouts.admin');

    }
}
