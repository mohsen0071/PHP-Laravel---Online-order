<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


// User

Route::get('/', function(){
  return redirect(route('login'));
});

Route::get('/rules', function(){
    return view('Admin.settings.rule');
});

Route::group(['middleware' => 'auth'] , function () {

    Route::group(['prefix' => 'user', 'middleware' => ['checkActive']] , function(){

        Route::get('/panel' , 'ClientController@index')->name('user.panel');
        Route::get('/order/{id}' , 'ClientController@showOrder')->name('user.showorder');
        Route::get('/edit  ' , 'ClientController@editUser')->name('user.edit');
        Route::post('/profile' , 'ClientController@clientUpdate')->name('user.clientUpdate');
        Route::get('/new-order' , 'ClientController@newOrder')->name('user.newOrder');
        Route::post('/new-order' , 'ClientController@storeNewOrder')->name('user.storeNewOrder');
        Route::get('/all-order' , 'ClientController@allOrder')->name('user.allOrder');
        Route::get('/transactions' , 'ClientController@transactions')->name('user.transactions');
        Route::get('/increase-balance' , 'ClientController@increaseBalance')->name('user.increaseBalance');
        Route::post('/increase-balance' , 'ClientController@increase')->name('user.increase');
        Route::get('/the-rules' , 'ClientController@theRules')->name('user.theRules');
        Route::get('/price-list' , 'ClientController@priceList')->name('user.priceList');
        Route::get('/notif/{id}' , 'ClientController@singleNotif')->name('user.singleNotif');
        Route::get('/pinquiries' , 'ClientController@pinquiries')->name('user.pinquiries');
        Route::get('/messinqus/{id}' , 'ClientController@showMessinqus')->name('user.showMessinqus');
        Route::post('/messinqus' , 'ClientController@addMessinqus')->name('user.addMessinqus');
        Route::delete('/pinquiries/{id}' , 'ClientController@removePinquiries')->name('user.removePinquiries');
        Route::get('/add-pinquiries' , 'ClientController@viewPinquiries')->name('user.viewPinquiries');
        Route::post('/add-pinquiries' , 'ClientController@addPinquiries')->name('user.addPinquiries');
        Route::get('/all-ship' , 'ClientController@allShip')->name('user.allShip');
        Route::get('/add-ship' , 'ClientController@addShip')->name('user.addShip');
        Route::post('/add-ship' , 'ClientController@addShipStore')->name('user.addShipStore');


        Route::post('/payment-pinq-account' , 'ClientController@paymentPinqAccount')->name('user.paymentPinqAccount');

        Route::post('/payment-pinq-online' , 'ClientController@paymentPinqOnline')->name('user.paymentPinqOnline');
        Route::get('/payment-pinq-online' , 'ClientController@paymentPinqOnlineCheck')->name('user.paymentPinqOnlineCheck');




        Route::post('/payment-account' , 'ClientController@paymentAccount')->name('user.paymentAccount');
        Route::post('/payment' , 'ClientController@payment')->name('user.payment');
        Route::get('/payment' , 'ClientController@checkPayment')->name('user.checkPayment');

        Route::post('/increase-payment' , 'ClientController@increasePayment')->name('user.increasePayment');
        Route::get('/increase-payment' , 'ClientController@checkIncreasePayment')->name('user.checkIncreasePayment');


    });
});


// Admin



Route::group(['namespace' => 'Admin' , 'middleware' => ['auth:web' , 'checkAdmin', 'checkActive'], 'prefix' => 'admin'],function (){

    Route::get('/panel' , 'PanelController@index');

    Route::resource('notifs' , 'NotifController');

    Route::post('/panel/upload-image' , 'PanelController@uploadImageSubject');

    Route::resource('roles' , 'RoleController');

    Route::resource('permissions' , 'PermissionController');

    Route::resource('users' , 'UserController');

    Route::get('profile' , 'UserController@profile');

    Route::post('profile' , 'UserController@employeeUpdate')->name('users.employeeUpdate');

    Route::resource('clients' , 'ClientController');

    Route::get('/clients/{id}/order' , 'ClientController@order')->name('clients.order');

    Route::resource('categories' , 'CategoriesController');

    Route::resource('product-service' , 'PserviceController');

    Route::resource('products' , 'ProductController');

    Route::resource('sheets' , 'SheetController');

    Route::get('/sheets-zip' , 'SheetController@sheetZip')->name('sheets.sheets-zip');

    Route::get('/sheet-move' , 'SheetController@move');

    Route::resource('orders' , 'OrderController');
    Route::get('order-files/{id}' , 'OrderController@editFiles')->name('orders.editFiles');
    Route::post('order-files' , 'OrderController@storeFiles')->name('orders.storeFiles');

    Route::get('/clients/{id}/client-order' , 'OrderController@client_order');


    Route::post('transactionsrecieve' , 'TransactionController@storeRecievePay')->name('transactionsrecieve.storeRecievePay');
    Route::resource('transactions' , 'TransactionController');
    Route::get('/transaction-cheques' , 'TransactionController@transactionsCheques');
    Route::get('/transaction-recieve-pay' , 'TransactionController@transactionRecievePay');

    Route::get('/clients/{id}/client-transactions' , 'TransactionController@client_transaction');
    Route::get('/clients/{id}/client-cheques' , 'TransactionController@client_cheques');

    Route::resource('discounts' , 'DiscountController');

    Route::resource('inquiries' , 'InquiryController');
    Route::resource('pinquiries' , 'PinquiryController');
    Route::resource('messinqus' , 'MessinquController');
    Route::resource('shippings' , 'ShippingController');
    Route::resource('settings' , 'SettingController');
    Route::resource('userlog' , 'UserlogController');

    Route::get('/print/{id}' , 'PrintController@order');


});

Route::get('cities/{province}', 'CitiesController@index');
Route::get('sheets/{sheet}', 'SheetController@index');
Route::post('sheets/move', 'SheetController@move');
Route::get('sheets/{sheet}/files', 'SheetController@files');
Route::get('products/{product}', 'ProductController@index');
Route::get('categories/{category}', 'ProductController@category');
Route::post('product-detail', 'ProductController@product');



Route::group(['namespace' => 'Auth'] , function (){
    // Authentication Routes...
    Route::get('login', 'LoginController@showLoginForm')->name('login');
    Route::post('login', 'LoginController@login');
    Route::get('logout', 'LoginController@logout')->name('logout');

    // Registration Routes...
    Route::get('register', 'RegisterController@showRegistrationForm')->name('register');
    Route::post('register', 'RegisterController@register');

    Route::get('reset-password', 'RegisterController@showMobileForm');
    Route::post('reset-password', 'RegisterController@resetMobile')->name('password.mobile');

});
