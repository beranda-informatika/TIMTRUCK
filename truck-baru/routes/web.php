<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\DeliveryController;
use App\Http\Controllers\UtilityController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Auth::routes();

Route::get('/', [App\Http\Controllers\HomeController::class, 'root'])->name('root');
Route::get('/registrasi', [App\Http\Controllers\HomeController::class, 'registrasi'])->name('registrasi');


//Update User Details


Route::post('/update-profile/{id}', [App\Http\Controllers\HomeController::class, 'updateProfile'])->name('updateProfile');
Route::post('/update-password/{id}', [App\Http\Controllers\HomeController::class, 'updatePassword'])->name('updatePassword');
Route::get('restrictpage', [App\Http\Controllers\HomeController::class, 'restrictpage'])->name('restrictpage');
Route::group(['middleware' => ['web', 'auth', 'roles']], function () {
    Route::group(['roles' => ['admin','manajer','marketing']], function () {

    });


    Route::group(['roles' => ['admin','manajer','marketing','operational']], function () {
        Route::get('/root', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
        Route::get('utility/userlog', [App\Http\Controllers\UtilityController::class, 'userlog'])->name('utility.userlog');
        Route::get('utility/edituser/{id}', [App\Http\Controllers\UtilityController::class, 'edituser'])->name('utility.edituser');
        Route::post('utility/updateuser/{id}', [App\Http\Controllers\UtilityController::class, 'updateuser'])->name('utility.updateuser');

        Route::get('/utility/gantipassword', [App\Http\Controllers\UtilityController::class, 'gantipassword'])->name('utility.gantipassword');
        Route::post('utility/userpasswordupdate', [App\Http\Controllers\UtilityController::class, 'userpasswordupdate'])->name('utility.userpasswordupdate');
        Route::get('utility/userpassword', [App\Http\Controllers\UtilityController::class, 'userpassword'])->name('utility.userpassword');
        Route::get('utility/register', [App\Http\Controllers\UtilityController::class, 'register'])->name('utility.register');
        Route::post('utility/postregister', [App\Http\Controllers\UtilityController::class, 'postregister'])->name('utility.postregister');
        Route::delete('utility/userdelete/{id}', [App\Http\Controllers\UtilityController::class, 'userdelete'])->name('userdelete');

        Route::group(['prefix' => 'unit'], function () {
            Route::get('/', [App\Http\Controllers\UnitController::class, 'index'])->name('unit.index');
            Route::get('/create', [App\Http\Controllers\UnitController::class, 'create'])->name('unit.create');
            Route::post('/store', [App\Http\Controllers\UnitController::class, 'store'])->name('unit.store');
            Route::delete('/delete/{id}', [App\Http\Controllers\UnitController::class, 'destroy'])->name('unit.destroy');
            Route::get('/edit/{id}', [App\Http\Controllers\UnitController::class, 'edit'])->name('unit.edit');
            Route::put('/update/{id}', [App\Http\Controllers\UnitController::class, 'update'])->name('unit.update');
            Route::get('/show/{id}', [App\Http\Controllers\UnitController::class, 'show'])->name('unit.show');
            Route::get('/getunit', [App\Http\Controllers\UnitController::class, 'getunit'])->name('unit.getunit');
        });

        Route::group(['prefix' => 'driver'], function () {
            Route::get('/', [App\Http\Controllers\DriverController::class, 'index'])->name('driver.index');
            Route::get('/create', [App\Http\Controllers\DriverController::class, 'create'])->name('driver.create');
            Route::post('/store', [App\Http\Controllers\DriverController::class, 'store'])->name('driver.store');
            Route::delete('/delete/{id}', [App\Http\Controllers\DriverController::class, 'destroy'])->name('driver.destroy');
            Route::get('/edit/{id}', [App\Http\Controllers\DriverController::class, 'edit'])->name('driver.edit');
            Route::put('/update/{id}', [App\Http\Controllers\DriverController::class, 'update'])->name('driver.update');
            Route::get('/show/{id}', [App\Http\Controllers\DriverController::class, 'show'])->name('driver.show');
            Route::get('/getdriver', [App\Http\Controllers\DriverController::class, 'getdriver'])->name('driver.getdriver');
        });
        Route::group(['prefix' => 'sales'], function () {
            Route::get('/', [App\Http\Controllers\SalesController::class, 'index'])->name('sales.index');
            Route::get('/create', [App\Http\Controllers\SalesController::class, 'create'])->name('sales.create');
            Route::post('/store', [App\Http\Controllers\SalesController::class, 'store'])->name('sales.store');
            Route::delete('/delete/{id}', [App\Http\Controllers\SalesController::class, 'destroy'])->name('sales.destroy');
            Route::get('/edit/{id}', [App\Http\Controllers\SalesController::class, 'edit'])->name('sales.edit');
            Route::put('/update/{id}', [App\Http\Controllers\SalesController::class, 'update'])->name('sales.update');
            Route::get('/show/{id}', [App\Http\Controllers\SalesController::class, 'show'])->name('sales.show');
            Route::get('/getsales', [App\Http\Controllers\SalesController::class, 'getsales'])->name('sales.getsales');
        });
        Route::group(['prefix' => 'project'], function () {
            Route::get('/', [App\Http\Controllers\ProjectController::class, 'index'])->name('project.index');
            Route::get('/create', [App\Http\Controllers\ProjectController::class, 'create'])->name('project.create');
            Route::post('/store', [App\Http\Controllers\ProjectController::class, 'store'])->name('project.store');
            Route::delete('/delete/{id}', [App\Http\Controllers\ProjectController::class, 'destroy'])->name('project.destroy');
            Route::get('/edit/{id}', [App\Http\Controllers\ProjectController::class, 'edit'])->name('project.edit');
            Route::put('/update/{id}', [App\Http\Controllers\ProjectController::class, 'update'])->name('project.update');
            Route::get('/show/{id}', [App\Http\Controllers\ProjectController::class, 'show'])->name('project.show');
            Route::get('/getproject', [App\Http\Controllers\ProjectController::class, 'getproject'])->name('project.getproject');
        });
        Route::group(['prefix' => 'customer', 'roles'=>['finance']], function () {
            Route::get('/', [App\Http\Controllers\CustomerController::class, 'index'])->name('customer.index');
            Route::get('/create', [App\Http\Controllers\CustomerController::class, 'create'])->name('customer.create');
            Route::post('/store', [App\Http\Controllers\CustomerController::class, 'store'])->name('customer.store');
            Route::delete('/delete/{id}', [App\Http\Controllers\CustomerController::class, 'destroy'])->name('customer.destroy');
            Route::get('/edit/{id}', [App\Http\Controllers\CustomerController::class, 'edit'])->name('customer.edit');
            Route::put('/update/{id}', [App\Http\Controllers\CustomerController::class, 'update'])->name('customer.update');
            Route::get('/show/{id}', [App\Http\Controllers\CustomerController::class, 'show'])->name('customer.show');
            Route::get('/getcustomer', [App\Http\Controllers\CustomerController::class, 'getcustomer'])->name('customer.getcustomer');
        });
        Route::group(['prefix' => 'rate'], function () {
            Route::get('/', [App\Http\Controllers\RateController::class, 'index'])->name('rate.index');
            Route::get('/create', [App\Http\Controllers\RateController::class, 'create'])->name('rate.create');
            Route::post('/store', [App\Http\Controllers\RateController::class, 'store'])->name('rate.store');
            Route::delete('/delete/{id}', [App\Http\Controllers\RateController::class, 'destroy'])->name('rate.destroy');
            Route::get('/edit/{id}', [App\Http\Controllers\RateController::class, 'edit'])->name('rate.edit');
            Route::put('/update/{id}', [App\Http\Controllers\RateController::class, 'update'])->name('rate.update');
            Route::get('/show/{id}', [App\Http\Controllers\RateController::class, 'show'])->name('rate.show');
            Route::get('/getrate', [App\Http\Controllers\RateController::class, 'getrate'])->name('rate.getrate');
        });
        Route::group(['prefix' => 'typetruck'], function () {
            Route::get('/', [App\Http\Controllers\TypetruckController::class, 'index'])->name('typetruck.index');
            Route::get('/create', [App\Http\Controllers\TypetruckController::class, 'create'])->name('typetruck.create');
            Route::post('/store', [App\Http\Controllers\TypetruckController::class, 'store'])->name('typetruck.store');
            Route::delete('/delete/{id}', [App\Http\Controllers\TypetruckController::class, 'destroy'])->name('typetruck.destroy');
            Route::get('/edit/{id}', [App\Http\Controllers\TypetruckController::class, 'edit'])->name('typetruck.edit');
            Route::put('/update/{id}', [App\Http\Controllers\TypetruckController::class, 'update'])->name('typetruck.update');
            Route::get('/show/{id}', [App\Http\Controllers\TypetruckController::class, 'show'])->name('typetruck.show');
            Route::get('/gettypetruck', [App\Http\Controllers\TypetruckController::class, 'gettypetruck'])->name('typetruck.gettypetruck');
        });
        Route::group(['prefix' => 'rute'], function () {
            Route::get('/', [App\Http\Controllers\RuteController::class, 'index'])->name('rute.index');
            Route::get('/create', [App\Http\Controllers\RuteController::class, 'create'])->name('rute.create');
            Route::post('/store', [App\Http\Controllers\RuteController::class, 'store'])->name('rute.store');
            Route::delete('/delete/{id}', [App\Http\Controllers\RuteController::class, 'destroy'])->name('rute.destroy');
            Route::get('/edit/{id}', [App\Http\Controllers\RuteController::class, 'edit'])->name('rute.edit');
            Route::put('/update/{id}', [App\Http\Controllers\RuteController::class, 'update'])->name('rute.update');
            Route::get('/show/{id}', [App\Http\Controllers\RuteController::class, 'show'])->name('rute.show');
            Route::get('/getrute', [App\Http\Controllers\RuteController::class, 'getrute'])->name('rute.getrute');
            Route::get('/detail/{id}', [App\Http\Controllers\RuteController::class, 'detail'])->name('rute.detail');

        });
        Route::group(['prefix' => 'groupquotation'], function () {
            Route::get('/', [App\Http\Controllers\GroupquotationController::class, 'index'])->name('groupquotation.index');
            Route::get('/create', [App\Http\Controllers\GroupquotationController::class, 'create'])->name('groupquotation.create');
            Route::get('/tabelrute/{id}', [App\Http\Controllers\GroupquotationController::class, 'tabelrute'])->name('groupquotation.tabelrute');
            Route::post('/store', [App\Http\Controllers\GroupquotationController::class, 'store'])->name('groupquotation.store');
            Route::delete('/delete/{id}', [App\Http\Controllers\GroupquotationController::class, 'destroy'])->name('groupquotation.destroy');
            Route::get('/edit/{id}', [App\Http\Controllers\GroupquotationController::class, 'edit'])->name('groupquotation.edit');
            Route::put('/update/{id}', [App\Http\Controllers\GroupquotationController::class, 'update'])->name('groupquotation.update');

            Route::get('/docquotation/{id}', [App\Http\Controllers\GroupquotationController::class, 'docquotation'])->name('groupquotation.docquotation');
            Route::get('/pdfquotation/{id}', [App\Http\Controllers\GroupquotationController::class, 'pdfquotation'])->name('groupquotation.pdfquotation');
            Route::post('/accqts', [App\Http\Controllers\GroupquotationController::class, 'accqts'])->name('groupquotation.accqts');
            Route::post('/accso', [App\Http\Controllers\GroupquotationController::class, 'accso'])->name('groupquotation.accso');

            Route::get('/getquotation', [App\Http\Controllers\GroupquotationController::class, 'getquotation'])->name('groupquotation.getquotation');
            Route::get('/getroute', [App\Http\Controllers\GroupquotationController::class, 'getroute'])->name('groupquotation.getroute');
            Route::get('/getrouteall', [App\Http\Controllers\GroupquotationController::class, 'getrouteall'])->name('groupquotation.getrouteall');
            Route::post('/setroute', [App\Http\Controllers\GroupquotationController::class, 'setroute'])->name('groupquotation.setroute');


        });

        Route::group(['prefix' => 'quotation'], function () {
            Route::get('/', [App\Http\Controllers\QuotationController::class, 'index'])->name('quotation.index');
            Route::get('/create', [App\Http\Controllers\QuotationController::class, 'create'])->name('quotation.create');
            Route::get('/tabelrute', [App\Http\Controllers\QuotationController::class, 'tabelrute'])->name('quotation.tabelrute');
            Route::post('/store', [App\Http\Controllers\QuotationController::class, 'store'])->name('quotation.store');
            Route::delete('/delete/{id}', [App\Http\Controllers\QuotationController::class, 'destroy'])->name('quotation.destroy');
            Route::get('/edit/{id}', [App\Http\Controllers\QuotationController::class, 'edit'])->name('quotation.edit');
            Route::put('/update/{id}', [App\Http\Controllers\QuotationController::class, 'update'])->name('quotation.update');
            Route::get('/formincustomer', [App\Http\Controllers\QuotationController::class, 'formincustomer'])->name('quotation.formincustomer');
            Route::get('/forminsales', [App\Http\Controllers\QuotationController::class, 'forminsales'])->name('quotation.forminsales');
            Route::get('/forminproject', [App\Http\Controllers\QuotationController::class, 'forminproject'])->name('quotation.forminproject');
            Route::post('/customerstore', [App\Http\Controllers\QuotationController::class, 'customerstore'])->name('quotation.customerstore');
            Route::post('/salesstore', [App\Http\Controllers\QuotationController::class, 'salesstore'])->name('quotation.salesstore');
            Route::post('/projectstore', [App\Http\Controllers\QuotationController::class, 'projectstore'])->name('quotation.projectstore');

            //ujo quotation
            Route::get('/ujo', [App\Http\Controllers\QuotationController::class, 'ujo'])->name('quotation.ujo');
            Route::get('/inujo/{id}', [App\Http\Controllers\QuotationController::class, 'inujo'])->name('quotation.inujo');
            Route::post('/storeujo', [App\Http\Controllers\QuotationController::class, 'storeujo'])->name('quotation.storeujo');
            Route::get('/docquotation/{id}', [App\Http\Controllers\QuotationController::class, 'docquotation'])->name('quotation.docquotation');
            Route::post('/accqts', [App\Http\Controllers\QuotationController::class, 'accqts'])->name('quotation.accqts');
            Route::post('/accso', [App\Http\Controllers\QuotationController::class, 'accso'])->name('quotation.accso');
            Route::post('/requestujo', [App\Http\Controllers\QuotationController::class, 'requestujo'])->name('quotation.requestujo');
            Route::post('/accrequest', [App\Http\Controllers\QuotationController::class, 'accrequest'])->name('quotation.accrequest');

            Route::get('/getquotation', [App\Http\Controllers\QuotationController::class, 'getquotation'])->name('quotation.getquotation');

            Route::get('/pilihquotation', [App\Http\Controllers\QuotationController::class, 'pilihquotation'])->name('quotation.pilihquotation');


        });


        Route::group(['prefix' => 'shipment'], function () {
            Route::get('/', [App\Http\Controllers\ShipmentController::class, 'index'])->name('shipment.index');
            Route::get('/create', [App\Http\Controllers\ShipmentController::class, 'create'])->name('shipment.create');
            Route::post('/store', [App\Http\Controllers\ShipmentController::class, 'store'])->name('shipment.store');
            Route::delete('/delete/{id}', [App\Http\Controllers\ShipmentController::class, 'destroy'])->name('shipment.destroy');
            Route::get('/edit/{id}', [App\Http\Controllers\ShipmentController::class, 'edit'])->name('shipment.edit');
            Route::get('/formoperational', [App\Http\Controllers\ShipmentController::class, 'formoperational'])->name('shipment.formoperational');

            Route::put('/update/{id}', [App\Http\Controllers\ShipmentController::class, 'update'])->name('shipment.update');
            Route::get('/show/{id}', [App\Http\Controllers\ShipmentController::class, 'show'])->name('shipment.show');
            Route::get('/getshipment', [App\Http\Controllers\ShipmentController::class, 'getshipment'])->name('shipment.getshipment');
            Route::get('/detail/{id}', [App\Http\Controllers\ShipmentController::class, 'detail'])->name('shipment.detail');
            Route::get('/getrouteall', [App\Http\Controllers\ShipmentController::class, 'getrouteall'])->name('shipment.getrouteall');
            Route::get('/pilihrute', [App\Http\Controllers\ShipmentController::class, 'pilihrute'])->name('shipment.pilihrute');
            Route::get('/ujo', [App\Http\Controllers\ShipmentController::class, 'ujo'])->name('shipment.ujo');
            Route::get('/inujo/{id}', [App\Http\Controllers\ShipmentController::class, 'inujo'])->name('shipment.inujo');
            Route::post('/storeujo', [App\Http\Controllers\ShipmentController::class, 'storeujo'])->name('shipment.storeujo');
            Route::get('/inloadkgmrc/{id}', [App\Http\Controllers\ShipmentController::class, 'inloadkgmrc'])->name('shipment.inloadkgmrc');
            Route::post('/storeloadkgmrc', [App\Http\Controllers\ShipmentController::class, 'storeloadkgmrc'])->name('shipment.storeloadkgmrc');
            Route::get('/indrop/{id}', [App\Http\Controllers\ShipmentController::class, 'indrop'])->name('shipment.indrop');
            Route::post('/storedrop', [App\Http\Controllers\ShipmentController::class, 'storedrop'])->name('shipment.storedrop');
            Route::get('/inpickup/{id}', [App\Http\Controllers\ShipmentController::class, 'inpickup'])->name('shipment.inpickup');
            Route::post('/storepickup', [App\Http\Controllers\ShipmentController::class, 'storepickup'])->name('shipment.storepickup');

            Route::get('/inrevenue/{id}', [App\Http\Controllers\ShipmentController::class, 'inrevenue'])->name('shipment.inrevenue');
            Route::post('/storerevenue', [App\Http\Controllers\ShipmentController::class, 'storerevenue'])->name('shipment.storerevenue');
            Route::get('/getsalesorder', [App\Http\Controllers\ShipmentController::class, 'getsalesorder'])->name('shipment.getsalesorder');

            Route::get('/inrate/{id}', [App\Http\Controllers\ShipmentController::class, 'inrate'])->name('shipment.inrate');
            Route::post('/ratestore', [App\Http\Controllers\ShipmentController::class, 'ratestore'])->name('shipment.ratestore');
            Route::get('/inraterevenue/{id}', [App\Http\Controllers\ShipmentController::class, 'inraterevenue'])->name('shipment.inraterevenue');
            Route::post('/raterevenuestore', [App\Http\Controllers\ShipmentController::class, 'raterevenuestore'])->name('shipment.raterevenuestore');

            Route::get('/pilihquotation', [App\Http\Controllers\ShipmentController::class, 'pilihquotation'])->name('shipment.pilihquotation');
            Route::get('/unitactivity', [App\Http\Controllers\ShipmentController::class, 'unitactivity'])->name('shipment.unitactivity');
            Route::get('/driveractivity', [App\Http\Controllers\ShipmentController::class, 'driveractivity'])->name('shipment.driveractivity');
            Route::get('/getunit', [App\Http\Controllers\ShipmentController::class, 'getunit'])->name('shipment.getunit');
            Route::get('/getdriver', [App\Http\Controllers\ShipmentController::class, 'getdriver'])->name('shipment.getdriver');
            Route::get('/listpod/{id}', [App\Http\Controllers\ShipmentController::class, 'listpod'])->name('shipment.listpod');
            Route::get('/changeroute/{id}', [App\Http\Controllers\ShipmentController::class, 'changeroute'])->name('shipment.changeroute');
            Route::put('/updateroute/{id}', [App\Http\Controllers\ShipmentController::class, 'updateroute'])->name('shipment.updateroute');

        });
        Route::group(['prefix' => 'ujo'], function () {
            Route::get('/', [App\Http\Controllers\UjoController::class, 'index'])->name('ujo.index');
            Route::get('/create', [App\Http\Controllers\UjoController::class, 'create'])->name('ujo.create');
            Route::post('/store', [App\Http\Controllers\UjoController::class, 'store'])->name('ujo.store');
            Route::delete('/delete/{id}', [App\Http\Controllers\UjoController::class, 'destroy'])->name('ujo.destroy');
            Route::get('/edit/{id}', [App\Http\Controllers\UjoController::class, 'edit'])->name('ujo.edit');
            Route::put('/update/{id}', [App\Http\Controllers\UjoController::class, 'update'])->name('ujo.update');
            Route::get('/show/{id}', [App\Http\Controllers\UjoController::class, 'show'])->name('ujo.show');
            Route::get('/getsalesorder', [App\Http\Controllers\UjoController::class, 'getsalesorder'])->name('ujo.getsalesorder');
            Route::get('/formujo', [App\Http\Controllers\UjoController::class, 'formujo'])->name('ujo.formujo');
            Route::get('/inrate/{id}', [App\Http\Controllers\UjoController::class, 'inrate'])->name('ujo.inrate');
            Route::post('/ratestore', [App\Http\Controllers\UjoController::class, 'ratestore'])->name('ujo.ratestore');
            Route::get('/listujo', [App\Http\Controllers\UjoController::class, 'listujo'])->name('ujo.listujo');

        });
        Route::group(['prefix' => 'settlement'], function () {
            Route::get('/', [App\Http\Controllers\SettlementController::class, 'index'])->name('settlement.index');
            Route::get('/create', [App\Http\Controllers\SettlementController::class, 'create'])->name('settlement.create');
            Route::post('/store', [App\Http\Controllers\SettlementController::class, 'store'])->name('settlement.store');
            Route::delete('/delete/{id}', [App\Http\Controllers\SettlementController::class, 'destroy'])->name('settlement.destroy');
            Route::get('/edit/{id}', [App\Http\Controllers\SettlementController::class, 'edit'])->name('settlement.edit');
            Route::get('/formoperational', [App\Http\Controllers\SettlementController::class, 'formoperational'])->name('settlement.formoperational');

            Route::put('/update/{id}', [App\Http\Controllers\SettlementController::class, 'update'])->name('settlement.update');
            Route::get('/show/{id}', [App\Http\Controllers\SettlementController::class, 'show'])->name('settlement.show');
            Route::get('/getsettlement', [App\Http\Controllers\SettlementController::class, 'getsettlement'])->name('settlement.getsettlement');
            Route::get('/detail/{id}', [App\Http\Controllers\SettlementController::class, 'detail'])->name('settlement.detail');
            Route::get('/getrouteall', [App\Http\Controllers\SettlementController::class, 'getrouteall'])->name('settlement.getrouteall');
            Route::get('/pilihrute', [App\Http\Controllers\SettlementController::class, 'pilihrute'])->name('settlement.pilihrute');
            Route::get('/ujo', [App\Http\Controllers\SettlementController::class, 'ujo'])->name('settlement.ujo');
            Route::get('/inujo/{id}', [App\Http\Controllers\SettlementController::class, 'inujo'])->name('settlement.inujo');
            Route::post('/storeujo', [App\Http\Controllers\SettlementController::class, 'storeujo'])->name('settlement.storeujo');
            Route::get('/inrevenue/{id}', [App\Http\Controllers\SettlementController::class, 'inrevenue'])->name('settlement.inrevenue');
            Route::post('/storerevenue', [App\Http\Controllers\SettlementController::class, 'storerevenue'])->name('settlement.storerevenue');
            Route::get('/getsalesorder', [App\Http\Controllers\SettlementController::class, 'getsalesorder'])->name('settlement.getsalesorder');

            Route::get('/inrate/{id}', [App\Http\Controllers\SettlementController::class, 'inrate'])->name('settlement.inrate');
            Route::post('/ratestore', [App\Http\Controllers\SettlementController::class, 'ratestore'])->name('settlement.ratestore');
            Route::get('/inraterevenue/{id}', [App\Http\Controllers\SettlementController::class, 'inraterevenue'])->name('settlement.inraterevenue');
            Route::post('/raterevenuestore', [App\Http\Controllers\SettlementController::class, 'raterevenuestore'])->name('settlement.raterevenuestore');

            Route::get('/pilihquotation', [App\Http\Controllers\SettlementController::class, 'pilihquotation'])->name('settlement.pilihquotation');
            Route::post('/accsettle', [App\Http\Controllers\SettlementController::class, 'accsettle'])->name('settlement.accsettle');

        });
        Route::group(['prefix' => 'preinvoice','roles'=>['finance']], function () {
            Route::get('/', [App\Http\Controllers\PreinvoiceController::class, 'index'])->name('preinvoice.index');
            Route::get('/create', [App\Http\Controllers\PreinvoiceController::class, 'create'])->name('preinvoice.create');
            Route::post('/store', [App\Http\Controllers\PreinvoiceController::class, 'store'])->name('preinvoice.store');
            Route::delete('/delete/{id}', [App\Http\Controllers\PreinvoiceController::class, 'destroy'])->name('preinvoice.destroy');
            Route::get('/edit/{id}', [App\Http\Controllers\PreinvoiceController::class, 'edit'])->name('preinvoice.edit');
            Route::put('/update/{id}', [App\Http\Controllers\PreinvoiceController::class, 'update'])->name('preinvoice.update');
            Route::get('/show/{id}', [App\Http\Controllers\PreinvoiceController::class, 'show'])->name('preinvoice.show');
            Route::get('/getpreinvoice', [App\Http\Controllers\PreinvoiceController::class, 'getpreinvoice'])->name('preinvoice.getpreinvoice');
            Route::get('/getsalesorder', [App\Http\Controllers\PreinvoiceController::class, 'getsalesorder'])->name('preinvoice.getsalesorder');
            Route::get('/pdfpreinvoice/{id}', [App\Http\Controllers\PreinvoiceController::class, 'pdfpreinvoice'])->name('preinvoice.pdfpreinvoice');
            Route::delete('/delete/{id}', [App\Http\Controllers\PreinvoiceController::class, 'delete'])->name('preinvoice.delete');
        });
        Route::group(['prefix' => 'approve'], function () {
            Route::get('/', [App\Http\Controllers\ApproveController::class, 'index'])->name('approve.index');
            Route::get('/search', [App\Http\Controllers\ApproveController::class, 'search'])->name('approve.search');
            Route::get('/searchshipment', [App\Http\Controllers\ApproveController::class, 'searchshipment'])->name('approve.searchshipment');
            Route::get('/formapprove/{id}', [App\Http\Controllers\ApproveController::class, 'formapprove'])->name('approve.formapprove');
            Route::get('/resi/{id}', [App\Http\Controllers\ApproveController::class, 'resi'])->name('approve.resi');
            Route::put('/update/{id}', [App\Http\Controllers\ApproveController::class, 'update'])->name('approve.update');
        });
        Route::group(['prefix' => 'finance'], function () {
            Route::get('/', [App\Http\Controllers\FinanceController::class, 'index'])->name('finance.index');
        });

        Route::group(['prefix' => 'payout', 'roles'=>['finance']], function () {
            Route::get('/', [App\Http\Controllers\PayoutController::class, 'index'])->name('payout.index');
            Route::get('/forminvoice/{id}', [App\Http\Controllers\PayoutController::class, 'forminvoice'])->name('payout.forminvoice');
            Route::get('/invoice/{id}', [App\Http\Controllers\PayoutController::class, 'invoice'])->name('payout.invoice');
            Route::post('/store', [App\Http\Controllers\PayoutController::class, 'store'])->name('payout.store');
            Route::get('/listinvoice/{id}', [App\Http\Controllers\PayoutController::class, 'listinvoice'])->name('payout.listinvoice');


        });
        Route::group(['prefix' => 'bill'], function () {
            Route::get('/', [App\Http\Controllers\BillController::class, 'index'])->name('bill.index');
            Route::get('/search', [App\Http\Controllers\BillController::class, 'search'])->name('bill.search');
            Route::get('/searchshipment', [App\Http\Controllers\BillController::class, 'searchshipment'])->name('bill.searchshipment');
            Route::get('/formbill/{id}', [App\Http\Controllers\BillController::class, 'formbill'])->name('bill.formbill');
            Route::get('/bill/{id}', [App\Http\Controllers\BillController::class, 'bill'])->name('bill.bill');
            Route::post('/store', [App\Http\Controllers\BillController::class, 'store'])->name('bill.store');
            Route::get('/listbill/{id}', [App\Http\Controllers\BillController::class, 'listbill'])->name('bill.listbill');

        });
        Route::group(['prefix' => 'report','roles'=>['finance']], function () {
            Route::get('/rptshipment', [App\Http\Controllers\ReportController::class, 'rptshipment'])->name('report.rptshipment');
            Route::post('/shipment', [App\Http\Controllers\ReportController::class, 'shipment'])->name('report.shipment');
            Route::get('/rptincome', [App\Http\Controllers\ReportController::class, 'rptincome'])->name('report.rptincome');
            Route::get('/income', [App\Http\Controllers\ReportController::class, 'income'])->name('report.income');
            Route::get('/rptbill', [App\Http\Controllers\ReportController::class, 'rptbill'])->name('report.rptbill');
            Route::post('/bill', [App\Http\Controllers\ReportController::class, 'bill'])->name('report.bill');


        });
        Route::group(['prefix' => 'shiping'], function () {
            Route::get('/', [App\Http\Controllers\ShipingController::class, 'index'])->name('shiping.index');
            Route::get('/search', [App\Http\Controllers\ShipingController::class, 'search'])->name('shiping.search');
            Route::get('/searchshipment', [App\Http\Controllers\ShipingController::class, 'searchshipment'])->name('shiping.searchshipment');
            Route::get('/formapprove/{id}', [App\Http\Controllers\ShipingController::class, 'formapprove'])->name('shiping.formapprove');
            Route::get('/formloading/{id}', [App\Http\Controllers\ShipingController::class, 'formloading'])->name('shiping.formloading');
            Route::put('/update/{id}', [App\Http\Controllers\ShipingController::class, 'update'])->name('shiping.update');
        });
        Route::group(['prefix' => 'arrival'], function () {
            Route::get('/', [App\Http\Controllers\ArrivalController::class, 'index'])->name('arrival.index');
            Route::get('/search', [App\Http\Controllers\ArrivalController::class, 'search'])->name('arrival.search');
            Route::get('/searchshipment', [App\Http\Controllers\ArrivalController::class, 'searchshipment'])->name('arrival.searchshipment');
            Route::get('/formapprove/{id}', [App\Http\Controllers\ArrivalController::class, 'formapprove'])->name('arrival.formapprove');
            Route::put('/update/{id}', [App\Http\Controllers\ArrivalController::class, 'update'])->name('arrival.update');
        });
        Route::group(['prefix' => 'payment', 'roles'=>['finance']], function () {
            Route::get('/', [App\Http\Controllers\PaymentController::class, 'index'])->name('payment.index');
            Route::get('/invoice/{id}', [App\Http\Controllers\PaymentController::class, 'invoice'])->name('payment.invoice');
            Route::get('/formpay', [App\Http\Controllers\PaymentController::class, 'formpay'])->name('payment.formpay');
            Route::post('/store', [App\Http\Controllers\PaymentController::class, 'store'])->name('payment.store');
            Route::get('/historyujo', [App\Http\Controllers\PaymentController::class, 'historyujo'])->name('payment.historyujo');
            Route::get('/history', [App\Http\Controllers\PaymentController::class, 'history'])->name('payment.history');


        });
    });
});
