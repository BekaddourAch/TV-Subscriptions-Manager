<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Subscription extends Model
{
    use HasFactory;

    protected $primaryKey = 'id_subscription';

    protected $fillable = [
        'id_service',
        'id_customer',
        'id_user',
        'cost_price',
        'quantity',
        'selling_price',
        'begin_date',
        'end_date',
        'total',
        'paid_amount',
        'notes'
    ];

    public function Service(){
        return $this->belongsTo(Service::class,'id_service');
    }

    public function Customer(){
        return $this->belongsTo(Customer::class,'id_customer');
    }
    public function User(){
        return $this->belongsTo(User::class,'id_user');
    }

    public static function getSubscriptionsWithData($beginDate = null, $endDate = null, $idUser = 0,$idCustomer= 0,$idService= 0)
    {
        $query = $regions = DB::table('subscriptions')
            ->join('customers', 'customers.id_customer', '=', 'subscriptions.id_customer')
            ->join('services', 'services.id_service', '=', 'subscriptions.id_service')
            ->select(['subscriptions.*',DB::raw('DATEDIFF(end_date, NOW()) nb_days') ,'services.name as service_name','customers.firstname','customers.lastname','customers.phone1','customers.phone2','customers.email']);

        if ($beginDate && $endDate) {
            $beginDate = Carbon::parse($beginDate)->startOfDay();
            $endDate = Carbon::parse($endDate)->endOfDay();
            $query->whereRaw ("subscriptions.end_date >= '".$beginDate."'");
            $query->whereRaw ("subscriptions.end_date <= '".$endDate."'");
        }
        if($idCustomer>0){
            $query->where("subscriptions.id_customer","=",$idCustomer);
        }
        if($idService>0){
            $query->where("subscriptions.id_service","=",$idService);
        }
        if($idCustomer==0 && $idService==0){
            $query->whereRaw ("DATEDIFF(end_date, NOW()) < 30 && DATEDIFF(end_date, NOW())>0");
        }
        $result= $query->orderByRaw('DATEDIFF(end_date, NOW()) ASC')->get();
        $subs = $result->map(function ($item) {
            return (array) $item;
        })->toArray();

        return $subs;
    }

    public static function getTotalSales($beginDate = null, $endDate = null)
    {
        $query = self::query();

        if ($beginDate && $endDate) {
            $beginDate = Carbon::parse($beginDate)->startOfDay();
            $endDate = Carbon::parse($endDate)->endOfDay();
            $query->whereRaw ("created_at >= '".$beginDate."'");
            $query->whereRaw ("created_at <= '".$endDate."'");
        }

        return $query->sum('total');
    }

    public static function getTotalProfits($beginDate = null, $endDate = null)
    {
        $query = self::query();

        if ($beginDate && $endDate) {
            $beginDate = Carbon::parse($beginDate)->startOfDay();
            $endDate = Carbon::parse($endDate)->endOfDay();
            $query->whereRaw ("created_at >= '".$beginDate."'");
            $query->whereRaw ("created_at <= '".$endDate."'");
        }

        $totalCost = $query->sum(DB::raw('quantity * cost_price'));

        return self::getTotalSales($beginDate,$endDate) - $totalCost;
    }

    public static function countSubscriptions($beginDate = null, $endDate = null)
    {
        $query = self::query();

        if ($beginDate && $endDate) {
            $beginDate = Carbon::parse($beginDate)->startOfDay();
            $endDate = Carbon::parse($endDate)->endOfDay();
            $query->whereRaw ("created_at >= '".$beginDate."'");
            $query->whereRaw ("created_at <= '".$endDate."'");
        }

        return $query->count();
    }

    public static function countActiveSubscriptions()
    {
        $query = self::query();
        $today = now()->format('Y-m-d');
        $query->whereRaw ("begin_date <= '".$today."'");
        $query->whereRaw ("end_date >= '".$today."'");

        return $query->count();
    }

    public static function getTopSubscriptionsPerRegions($beginDate = null, $endDate = null)
    {
        $query = $regions = DB::table('customers')
            ->join('subscriptions', 'customers.id_customer', '=', 'subscriptions.id_customer');


        if ($beginDate && $endDate) {
            $beginDate = Carbon::parse($beginDate)->startOfDay();
            $endDate = Carbon::parse($endDate)->endOfDay();
            $query->whereRaw ("subscriptions.created_at >= '".$beginDate."'");
            $query->whereRaw ("subscriptions.created_at <= '".$endDate."'");
        }
        $result = $query->select('customers.state', DB::raw('SUM(subscriptions.total) as total_spent'))
            ->groupBy('customers.state')
            ->orderBy('total_spent', 'desc')
            ->limit(10)
            ->get();

        $regions = $result->map(function ($item) {
            return (array) $item;
        })->toArray();

        return $regions;
    }

    public static function getSubscriptionsTotalSalesPerMonth($beginDate = null, $endDate = null){
        $query =  DB::table('subscriptions')
                ->select(DB::raw('MONTH(created_at) as month, YEAR(created_at) as year, SUM(subscriptions.total) as total_spent'));

        if ($beginDate && $endDate) {
            $beginDate = Carbon::parse($beginDate)->startOfDay();
            $endDate = Carbon::parse($endDate)->endOfDay();
            $query->whereRaw ("subscriptions.created_at >= '".$beginDate."'");
            $query->whereRaw ("subscriptions.created_at <= '".$endDate."'");
        }
        $result= $query->groupBy('year', 'month')
            ->orderBy('year', 'asc')
            ->orderBy('month', 'asc')
            ->get()
            ->groupBy(function($item) {
                return $item->year . '-' . str_pad($item->month, 2, '0', STR_PAD_LEFT);
            });

        $totalSales = $result->map(function ($item,$key) {
            return  $item->sum('total_spent');
        })->toArray();

        return $totalSales;
    }

    public static function getSubscriptionsTotalServices($beginDate = null, $endDate = null){

        $query =  DB::table('subscriptions')
                ->join('services', 'services.id_service', '=', 'subscriptions.id_service')
                ->select(DB::raw('services.name as service_name, COUNT(*) as total'));

        if ($beginDate && $endDate) {
            $beginDate = Carbon::parse($beginDate)->startOfDay();
            $endDate = Carbon::parse($endDate)->endOfDay();
            $query->whereRaw ("subscriptions.created_at >= '".$beginDate."'");
            $query->whereRaw ("subscriptions.created_at <= '".$endDate."'");
        }
        $result= $query->groupBy('service_name')
            ->orderBy('total', 'desc')
            ->get()
            ->groupBy(function($item) {
                return $item->service_name;
            });

        $totalServices = $result->map(function ($item,$key) {
            return  $item->sum('total');
        })->toArray();

        return $totalServices;
    }


}
